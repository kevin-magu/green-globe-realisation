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

// === Required Fields Validation ===
$requiredFields = ['executiveName', 'position', 'description'];
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

$executiveName = trim($_POST['executiveName']);
$position      = trim($_POST['position']);
$description   = trim($_POST['description']);
$linkedin      = trim($_POST['linkedin'] ?? '');
$twitter       = trim($_POST['twitter'] ?? '');

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
            'message' => 'Unsupported image format. Only JPG, PNG, and WEBP allowed.'
        ]);
        exit;
    }

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/green-globe-realisation/uploads/executiveImages/';
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

    $newName = 'executive_' . time() . '_' . uniqid('', true) . '.' . $ext;
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

    $imagePath = '/green-globe-realisation/uploads/executiveImages/' . $newName;
}

// === Insert Into Database ===
$stmt = $conn->prepare("INSERT INTO executives (executiveName, position, description, profilePicture, linkedin, twitter) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database prepare() failed.',
        'error' => $conn->error
    ]);
    exit;
}

$stmt->bind_param("ssssss", $executiveName, $position, $description, $imagePath, $linkedin, $twitter);

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
    'message' => 'Executive uploaded successfully.',
    'imagePath' => $imagePath
]);

$stmt->close();
$conn->close();
