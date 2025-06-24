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
$requiredFields = ['organizationName', 'contactPerson', 'position', 'email', 'phone', 'organizationType', 'address', 'city', 'country', 'partnershipInterest', 'partnershipDetails', 'g-recaptcha-response'];
$missingFields = [];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing or empty required fields.',
        'fields' => $missingFields
    ]);
    exit;
}

// === Sanitize Inputs ===
$orgName     = trim($_POST['organizationName']);
$contact     = trim($_POST['contactPerson']);
$position    = trim($_POST['position']);
$email       = trim($_POST['email']);
$phone       = trim($_POST['phone']);
$type        = trim($_POST['organizationType']);
$website     = trim($_POST['website'] ?? '');
$address     = trim($_POST['address']);
$city        = trim($_POST['city']);
$country     = trim($_POST['country']);
$mission     = trim($_POST['mission'] ?? '');
$interest    = trim($_POST['partnershipInterest']);
$details     = trim($_POST['partnershipDetails']);
$recaptcha   = $_POST['g-recaptcha-response'] ?? '';

// === Verify reCAPTCHA ===
if (empty($recaptcha)) {
    echo json_encode(['success' => false, 'message' => 'CAPTCHA not completed.']);
    exit;
}

$secretKey = '6LeQzGArAAAAAJ6IRjKzflWUnMEeURS27zA49ok5';
$verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
$response = file_get_contents("$verifyUrl?secret=$secretKey&response=$recaptcha");
$responseData = json_decode($response, true);

if (!$responseData["success"]) {
    echo json_encode(['success' => false, 'message' => 'CAPTCHA verification failed.']);
    exit;
}

// === Check if email already exists ===
$checkExisting = $conn->prepare("SELECT 1 FROM partner_approvals WHERE email = ? LIMIT 1");
$checkExisting->bind_param("s", $email);
$checkExisting->execute();
$checkExisting->store_result();

if ($checkExisting->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => "Your partnership request is already under review."]);
    $checkExisting->close();
    exit;
}
$checkExisting->close();

// === Handle Logo Upload ===
$imagePath = null;

if (isset($_FILES['organizationLogo']) && $_FILES['organizationLogo']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['organizationLogo']['tmp_name'];
    $originalName = basename($_FILES['organizationLogo']['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Unsupported image format. Only JPG, PNG, or WEBP allowed.']);
        exit;
    }

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/green-globe-realisation/uploads/partners/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            echo json_encode(['success' => false, 'message' => 'Failed to create upload directory.', 'directory' => $uploadDir]);
            exit;
        }
    }

    if (!is_writable($uploadDir)) {
        echo json_encode(['success' => false, 'message' => 'Upload directory is not writable.', 'directory' => $uploadDir]);
        exit;
    }

    $newName = 'partner_' . time() . '_' . uniqid('', true) . '.' . $ext;
    $destination = $uploadDir . $newName;

    if (!compressImageIfLargerThan($tmpName, $destination, 800)) {
        echo json_encode(['success' => false, 'message' => 'Failed to process uploaded image.']);
        exit;
    }

    if (!file_exists($destination)) {
        echo json_encode(['success' => false, 'message' => 'Image compression succeeded, but file not saved.']);
        exit;
    }

    $imagePath = '/green-globe-realisation/uploads/partners/' . $newName;
} else {
    echo json_encode(['success' => false, 'message' => 'Organization logo is required.']);
    exit;
}

// === Insert Into partner_approvals Table ===
$stmt = $conn->prepare("INSERT INTO partner_approvals (organization_name, contact_person, position, email, phone, organization_type, website, address, city, country, mission, partnership_interest, partnership_details, logoPath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database prepare() failed.', 'error' => $conn->error]);
    exit;
}

$stmt->bind_param("ssssssssssssss", $orgName, $contact, $position, $email, $phone, $type, $website, $address, $city, $country, $mission, $interest, $details, $imagePath);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Database execute() failed.', 'error' => $stmt->error]);
    $stmt->close();
    $conn->close();
    exit;
}

// ✅ Success
echo json_encode(['success' => true, 'message' => 'Partner registration submitted successfully.', 'logoPath' => $imagePath]);

$stmt->close();
$conn->close();
