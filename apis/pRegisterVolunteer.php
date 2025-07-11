<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: same-origin");

require_once '../includes/connection.php';
$conn->set_charset("utf8mb4");

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// === Compress Uploaded Image If Large ===
function compressImageIfLargerThan($tmpPath, $destinationPath, $maxSizeKB = 800) {
    $info = getimagesize($tmpPath);
    $mime = $info['mime'];
    $fileSizeKB = filesize($tmpPath) / 1024;

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($tmpPath);
            break;
        case 'image/png':
            $image = imagecreatefrompng($tmpPath);
            break;
        case 'image/webp':
            $image = imagecreatefromwebp($tmpPath);
            break;
        default:
            return false;
    }

    $quality = ($fileSizeKB > $maxSizeKB) ? 75 : 90;

    if ($mime === 'image/jpeg') {
        imagejpeg($image, $destinationPath, $quality);
    } elseif ($mime === 'image/png') {
        $compression = ($fileSizeKB > $maxSizeKB) ? 6 : 3;
        imagepng($image, $destinationPath, $compression);
    } elseif ($mime === 'image/webp') {
        imagewebp($image, $destinationPath, $quality);
    }

    imagedestroy($image);
    return true;
}

// === Required Fields Validation ===
$requiredFields = ['firstName', 'lastName', 'email', 'g-recaptcha-response'];
$missingFields = [];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing or empty required fields :'. $field,
        'fields' => $missingFields
    ]);
    exit;
}

// === Sanitize Inputs ===
$firstName = trim($_POST['firstName']);
$lastName  = trim($_POST['lastName']);
$email     = trim($_POST['email']);
$phone     = trim($_POST['phone'] ?? '');
$address   = trim($_POST['address'] ?? '');
$city      = trim($_POST['city'] ?? '');
$skills    = trim($_POST['skills'] ?? '');
$recaptcha = $_POST['g-recaptcha-response'] ?? '';

//verify captcha
if (empty($recaptcha)) {
    echo json_encode([
        'success' => false,
        'message' => 'CAPTCHA not completed.'
    ]);
    exit;
}

$secretKey = '6LeQzGArAAAAAJ6IRjKzflWUnMEeURS27zA49ok5'; // Replace with your actual secret key
$verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
$response = file_get_contents("$verifyUrl?secret=$secretKey&response=$recaptcha");
$responseData = json_decode($response, true);

if (!$responseData["success"]) {
    echo json_encode([
        'success' => false,
        'message' => 'CAPTCHA verification failed.'
    ]);
    exit;
}


// === Check if email already exists in volunteers ===
$checkVolunteers = $conn->prepare("SELECT 1 FROM volunteers WHERE email = ? LIMIT 1");
$checkVolunteers->bind_param("s", $email);
$checkVolunteers->execute();
$checkVolunteers->store_result();

if ($checkVolunteers->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'message' => "You're already a member."
    ]);
    $checkVolunteers->close();
    exit;
}
$checkVolunteers->close();

// === Check if email is already pending approval ===
$checkApprovals = $conn->prepare("SELECT 1 FROM volunteer_approvals WHERE email = ? LIMIT 1");
$checkApprovals->bind_param("s", $email);
$checkApprovals->execute();
$checkApprovals->store_result();

if ($checkApprovals->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'message' => "Your account is waiting approval."
    ]);
    $checkApprovals->close();
    exit;
}
$checkApprovals->close();


// === Handle Image Upload ===
$imagePath = null;

if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['profilePicture']['tmp_name'];
    $originalName = basename($_FILES['profilePicture']['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($ext, $allowed)) {
        echo json_encode([
            'success' => false,
            'message' => 'Unsupported image format. Only JPG, PNG, or WEBP allowed.'
        ]);
        exit;
    }

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/volunteers/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create upload directory.',
                'directory' => $uploadDir
            ]);
            exit;
        }
    }

    if (!is_writable($uploadDir)) {
        echo json_encode([
            'success' => false,
            'message' => 'Upload directory is not writable.',
            'directory' => $uploadDir
        ]);
        exit;
    }

    $newName = 'volunteer_' . time() . '_' . uniqid('', true) . '.' . $ext;
    $destination = $uploadDir . $newName;

    if (!compressImageIfLargerThan($tmpName, $destination, 800)) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to process uploaded image.'
        ]);
        exit;
    }

    if (!file_exists($destination)) {
        echo json_encode([
            'success' => false,
            'message' => 'Image compression succeeded, but file not saved.'
        ]);
        exit;
    }

    $imagePath = '/uploads/volunteers/' . $newName;
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Profile picture is required.'
    ]);
    exit;
}

// === Insert Into volunteer_approvals Table ===
$stmt = $conn->prepare("
    INSERT INTO volunteer_approvals 
    (first_name, last_name, imagePath, email, phone, address, city, skills)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database prepare() failed.',
        'error' => $conn->error
    ]);
    exit;
}

$stmt->bind_param("ssssssss", $firstName, $lastName, $imagePath, $email, $phone, $address, $city, $skills);

if (!$stmt->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Database execute() failed.',
        'error' => $stmt->error
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

//send an email to the user
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Adjust path if necessary
$mail = new PHPMAILER(true);

    // SMTP Settings
    $mail->isSMTP();
    $mail->Host       = 'mail.greengloberealisation.org';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@greengloberealisation.org';
    $mail->Password   = 'Green2030!'; // 🔒 Consider moving to environment variables later

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Recipients
    $mail->setFrom('info@greengloberealisation.org', 'Green Globe Realisation');
    $mail->addAddress($email, $firstName);

    // Email Content
    $mail->isHTML(true);
    $mail->Subject = "RE: VOLUNTEER APPLICATION";
  $mail->Body = '
<h2 style="font-family: Arial, sans-serif; color: #2e6c80;">Dear ' . htmlspecialchars($firstName) . ',</h2>

<p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
<strong>Subject:</strong> Volunteer Application Acknowledgement
</p>

<p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
Thank you for your interest in joining <strong>Green Globe Realisation</strong>. We have successfully received your volunteer application and our team is currently reviewing your submission.
</p>

<p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
Should your profile align with our current initiatives, one of our team members will be in touch with you shortly to discuss the next steps.
</p>

<p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
We sincerely appreciate your desire to contribute to meaningful change, and we look forward to the possibility of working together to drive sustainable impact.
</p>

<hr style="margin: 30px 0;">

<p style="font-family: Arial, sans-serif; font-size: 14px; color: #555; line-height: 1.5;">
Kind regards,<br>
<strong>Green Globe Realisation</strong><br>
📍 Kileleshwa, Mwingi Rd<br>
📞 +254 208 000 117<br>
🌐 <a href="https://greengloberealisation.org" style="color: #2e6c80; text-decoration: none;">greengloberealisation.org</a>
</p>
';

    $mail->AltBody = "Hi {$firstName},\n\nYour application is being reviewed. We will get back to you shortly.\n\n{$message}";

    // Send
    $mail->send();
    if(!$mail){
        echo json_encode([
        'success' => false,
        'message' => 'Email not sent', 
        ]);
        exit;
    }
// end

// send an email to the admin

$mail2 = new PHPMAILER(true);

    // SMTP Settings
    $mail2->isSMTP();
    $mail2->Host       = 'mail.greengloberealisation.org';
    $mail2->SMTPAuth   = true;
    $mail2->Username   = 'info@greengloberealisation.org';
    $mail2->Password   = 'Green2030!'; // 🔒 Consider moving to environment variables later

    $mail2->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail2->Port       = 465;

    // Recipients
    $mail2->setFrom('info@greengloberealisation.org', 'Green Globe Realisation');
    $mail2->addAddress('info@greengloberealisation.org', 'Green Globe Realisation');

    // Email Content
    $mail2->isHTML(true);
    $mail2->Subject = "RE: VOLUNTEER APPLICATION";
$mail2->Body = '
<h2 style="font-family: Arial, sans-serif; color: green;">Hello Kevin,</h2>

<p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
<strong>Subject:</strong> Volunteer Application Pending Approval
</p>

<p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
A new volunteer application has been submitted by <strong>' . htmlspecialchars($firstName) . '</strong>. Please log in to the administrator dashboard to review and take the appropriate action.
</p>

<p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
Timely review of volunteer submissions ensures an efficient onboarding process and helps us maintain a strong and responsive team.
</p>

<hr style="margin: 30px 0;">

<p style="font-family: Arial, sans-serif; font-size: 14px; color: #555; line-height: 1.5;">
Kind regards,<br>
<strong>Green Globe Realisation</strong><br>
📍 Kileleshwa, Mwingi Rd<br>
📞 +254 208 000 117<br>
🌐 <a href="https://greengloberealisation.org" style="color: green; text-decoration: none;">greengloberealisation.org</a>
</p>
';

    $mail2->AltBody = "Hi {$firstName},\n\nReview submitted application.\n\n{$message}";

    // Send
    $mail2->send();
    if(!$mail2){
        echo json_encode([
        'success' => false,
        'message' => 'Email to admin not sent', 
        ]);
        exit;
    }
//end 
// ✅ Success
echo json_encode([
    'success' => true,
    'message' => 'Volunteer registered successfully.',
    'imagePath' => $imagePath
]);

$stmt->close();
$conn->close();
