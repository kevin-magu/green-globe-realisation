<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: same-origin");

require_once '../includes/connection.php'; 
$conn->set_charset("utf8mb4");

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 

// === Validate required fields ===
if (!isset($_POST['email']) || trim($_POST['email']) === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Email is required.'
    ]);
    exit;
}

$email = trim($_POST['email']);
$recaptcha = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptcha)) {
    echo json_encode([
        'success' => false,
        'message' => 'CAPTCHA not completed.'
    ]);
    exit;
}

// === Verify CAPTCHA ===
$secretKey = '6LeQzGArAAAAAJ6IRjKzflWUnMEeURS27zA49ok5'; // Replace this with your actual reCAPTCHA secret key
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

// === Check for duplicates ===
$stmt = $conn->prepare("SELECT id FROM mailingList WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'message' => 'You are already subscribed.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// === Insert new subscription ===
$stmt = $conn->prepare("INSERT INTO mailingList (email, subscribed_at) VALUES (?, NOW())");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database prepare() failed.',
        'error' => $conn->error
    ]);
    exit;
}

$stmt->bind_param("s", $email);

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
    'message' => 'Successfully subscribed to the newsletter.'
]);

$stmt->close();
$conn->close();
?>
