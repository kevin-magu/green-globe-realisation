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
$requiredFields = ['projectTitle', 'programName', 'projectStatus', 'impactValue1', 'impactLabel1', 'impactValue2', 'impactLabel2', 'projectDesc'];
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

$projectTitle   = trim($_POST['projectTitle']);
$programName    = trim($_POST['programName']);
$projectStatus  = trim($_POST['projectStatus']);
$impactValue1   = trim($_POST['impactValue1']);
$impactLabel1   = trim($_POST['impactLabel1']);
$impactValue2   = trim($_POST['impactValue2']);
$impactLabel2   = trim($_POST['impactLabel2']);
$projectDesc    = trim($_POST['projectDesc']);

// === Get programId by programName ===
$stmt = $conn->prepare("SELECT programId FROM programs WHERE programName = ?");
$stmt->bind_param("s", $programName);
$stmt->execute();
$stmt->bind_result($programId);
$stmt->fetch();
$stmt->close();

if (!$programId) {
    echo json_encode(['success' => false, 'message' => 'Program not found for the provided name.']);
    exit;
}

// === Insert into projects ===
$stmt = $conn->prepare("INSERT INTO projects (programId, projectTitle, programTitle, projectStatus, impactValue1, impactLabel1, impactValue2, impactLabel2, projectDesc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssissss", $programId, $projectTitle, $programName, $projectStatus, $impactValue1, $impactLabel1, $impactValue2, $impactLabel2, $projectDesc);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Failed to insert project.', 'error' => $stmt->error]);
    $stmt->close();
    $conn->close();
    exit;
}

$projectId = $stmt->insert_id;
$stmt->close();

// === Handle image uploads ===
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/green-globe-realisation/uploads/projectImages/';
$relativeDir = '/green-globe-realisation/uploads/projectImages/';
$uploadedPaths = [];

if (isset($_FILES['projectImages'])) {
    foreach ($_FILES['projectImages']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['projectImages']['error'][$index] === UPLOAD_ERR_OK) {
            $originalName = basename($_FILES['projectImages']['name'][$index]);
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $allowed)) {
                continue; // skip unsupported formats
            }

            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $newName = 'project_' . time() . '_' . uniqid('', true) . '.' . $ext;
            $destination = $uploadDir . $newName;
            $relativePath = $relativeDir . $newName;

            if (compressImageIfLargerThan($tmpName, $destination, 800)) {
                $stmt = $conn->prepare("INSERT INTO projectImages (projectId, projectImagePath, created_at) VALUES (?, ?, NOW())");
                $stmt->bind_param("is", $projectId, $relativePath);
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
    'message' => 'Project and images uploaded successfully.',
    'projectId' => $projectId,
    'uploadedImages' => $uploadedPaths
]);

$conn->close();
?>
