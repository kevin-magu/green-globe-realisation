<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: same-origin");

require_once '../../includes/connection.php'; 
$conn->set_charset("utf8mb4");

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 

// === Compress function ===
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

// === Required fields validation ===
$requiredFields = ['programName', 'programTagline', 'programSymbol', 'programDescription','programObj1','programObj2','programObj3','programObj4'];
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

$programName = trim($_POST['programName']);
$programSymbol = trim($_POST['programSymbol']);
$programDescription = trim($_POST['programDescription']);
$programTagline = trim($_POST['programTagline']);
$programObj1 = trim($_POST['programObj1']);
$programObj2 = trim($_POST['programObj2']);
$programObj3 = trim($_POST['programObj3']);
$programObj4 = trim($_POST['programObj4']);


if (mb_strlen($programSymbol, 'UTF-8') > 2) {
    echo json_encode([
        'success' => false,
        'message' => 'Program symbol must be 1 or 2 characters max.'
    ]);
    exit;
}

if (mb_strlen($programName, 'UTF-8') > 255) {
    echo json_encode([
        'success' => false,
        'message' => 'Program name exceeds maximum length of 255 characters.'
    ]);
    exit;
}

// === Handle image upload ===
$imagePath = null;

if (isset($_FILES['projectImages']) && isset($_FILES['projectImages']['error'][0]) && $_FILES['projectImages']['error'][0] === UPLOAD_ERR_OK) {
    $image = $_FILES['projectImages'];
    $tmpName = $image['tmp_name'][0];
    $originalName = basename($image['name'][0]);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($ext, $allowed)) {
        echo json_encode([
            'success' => false,
            'message' => 'Unsupported image format. Only JPG, PNG, and WEBP allowed.'
        ]);
        exit;
    }

    // Define upload directory and ensure it exists
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/green-globe-realisation/uploads/programImages/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create upload directory.',
                'directory' => $uploadDir
            ]);
            exit;
        }
    }

    // Check if directory is writable
    if (!is_writable($uploadDir)) {
        echo json_encode([
            'success' => false,
            'message' => 'Upload directory is not writable.',
            'directory' => $uploadDir
        ]);
        exit;
    }

    // Unique filename
    $newName = 'program_' . time() . '_' . uniqid('', true) . '.' . $ext;
    $destination = $uploadDir . $newName;

    // Compress and move image
    if (!compressImageIfLargerThan($tmpName, $destination, 800)) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to process uploaded image.',
            'destination' => $destination
        ]);
        exit;
    }

    // Confirm image is saved
    if (!file_exists($destination)) {
        echo json_encode([
            'success' => false,
            'message' => 'Image compression succeeded, but file was not saved to destination.',
            'destination' => $destination
        ]);
        exit;
    }

    // Relative path for DB (consistent with expected path)
    $imagePath = '/green-globe-realisation/uploads/programImages/' . $newName;
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Image not provided or failed to upload.',
        'error' => isset($_FILES['projectImages']['error'][0]) ? $_FILES['projectImages']['error'][0] : 'Unknown'
    ]);
    exit;
}

// === Insert into DB ===
$stmt = $conn->prepare("INSERT INTO programs (programName, programTagline,programSbl, programDesc,programObj1, programObj2, programObj3, programObj4, programImagePath, created_at) VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, NOW())");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database prepare() failed.',
        'error' => $conn->error
    ]);
    exit;
}

$stmt->bind_param("sssssssss", $programName, $programTagline, $programSymbol, $programDescription, $programObj1, $programObj2, $programObj3, $programObj4,$imagePath);

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

// ✅ Success
echo json_encode([
    'success' => true,
    'message' => 'Program uploaded successfully.',
    'imagePath' => $imagePath
]);

$stmt->close();
$conn->close();
?>
