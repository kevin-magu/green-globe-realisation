<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: same-origin");

require_once '../includes/connection.php'; 
$conn->set_charset("utf8mb4");

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 

// === Validate required fields ===
$requiredFields = ['name', 'email', 'message'];
$missingFields = [];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required fields.',
        'fields' => $missingFields
    ]);
    exit;
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message']);
$recaptcha = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptcha)) {
    echo json_encode([
        'success' => false,
        'message' => 'CAPTCHA not completed.'
    ]);
    exit;
}

// === Verify CAPTCHA ===
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

// === Validate email format ===
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid email format.'
    ]);
    exit;
}

// === Insert message into database ===
$stmt = $conn->prepare("INSERT INTO contactMessages (name, email, subject, message, sent_at) VALUES (?, ?, ?, ?, NOW())");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database prepare() failed.',
        'error' => $conn->error
    ]);
    exit;
}

$stmt->bind_param("ssss", $name, $email, $subject, $message);

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
    'message' => 'Message sent successfully!'
]);

$stmt->close();
$conn->close();
?>
