<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: same-origin");

require_once '../../includes/connection.php'; 
$conn->set_charset("utf8mb4");

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 

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

    switch ($mime) {
        case 'image/jpeg':
            imagejpeg($image, $destinationPath, $quality);
            break;
        case 'image/png':
            $compression = ($fileSizeKB > $maxSizeKB) ? 6 : 3;
            imagepng($image, $destinationPath, $compression);
            break;
        case 'image/webp':
            imagewebp($image, $destinationPath, $quality);
            break;
    }

    imagedestroy($image);
    return true;
}

// === Required fields ===
$requiredFields = ['programName', 'storyTitle', 'location', 'storyDescription'];
$missingFields = [];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    echo json_encode(['success' => false, 'message' => 'Missing or empty required fields.', 'fields' => $missingFields]);
    exit;
}

$programName    = trim($_POST['programName']);
$storyTitle     = trim($_POST['storyTitle']);
$location       = trim($_POST['location']);
$storyDesc      = trim($_POST['storyDescription']);

// === Get programId by programName ===
$stmt = $conn->prepare("SELECT programId FROM programs WHERE LOWER(programName) = LOWER(?)");
$stmt->bind_param("s", $programName);
$stmt->execute();
$stmt->bind_result($programId);
$stmt->fetch();
$stmt->close();

if (!$programId) {
    echo json_encode(['success' => false, 'message' => 'Program not found for the provided name.']);
    exit;
}

// === Insert into stories ===
$stmt = $conn->prepare("INSERT INTO stories (programId, storyTitle, location, storyDescription, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("isss", $programId, $storyTitle, $location, $storyDesc);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Failed to insert story.', 'error' => $stmt->error]);
    $stmt->close();
    $conn->close();
    exit;
}

$storyId = $stmt->insert_id;
$stmt->close();

// === Handle image uploads ===
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/storyImages/';
$relativeDir = '/uploads/storyImages/';
$uploadedPaths = [];

if (isset($_FILES['storyImages'])) {
    foreach ($_FILES['storyImages']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['storyImages']['error'][$index] === UPLOAD_ERR_OK) {
            $originalName = basename($_FILES['storyImages']['name'][$index]);
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $allowed)) {
                continue; // skip unsupported formats
            }

            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $newName = 'story_' . time() . '_' . uniqid('', true) . '.' . $ext;
            $destination = $uploadDir . $newName;
            $relativePath = $relativeDir . $newName;

            if (compressImageIfLargerThan($tmpName, $destination, 800)) {
                $stmt = $conn->prepare("INSERT INTO storyImages (storyId, imagePath, created_at) VALUES (?, ?, NOW())");
                $stmt->bind_param("is", $storyId, $relativePath);
                $stmt->execute();
                $stmt->close();
                $uploadedPaths[] = $relativePath;
            }
        }
    }
}

// === Done ===
echo json_encode([
    'success' => true,
    'message' => 'Story and images uploaded successfully.',
    'storyId' => $storyId,
    'uploadedImages' => $uploadedPaths
]);

$conn->close();
?>
