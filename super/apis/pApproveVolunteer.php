<?php
header("Content-Type: application/json");
require_once '../includes/connection.php';
$conn->set_charset("utf8mb4");

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$action = $data['action'] ?? '';

// Validate input
if (!$id || !in_array($action, ['approve', 'reject'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid ID or action'
    ]);
    exit;
}

// Fetch volunteer data from volunteer_approvals
$stmt = $conn->prepare("SELECT id, first_name, last_name, imagePath, email, phone, address, city, skills, submitted_at FROM volunteer_approvals WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Volunteer not found.'
    ]);
    $stmt->close();
    exit;
}

$volunteer = $result->fetch_assoc();
$stmt->close();

// Insert into volunteers
$insert = $conn->prepare("
    INSERT INTO volunteers (first_name, last_name, imagePath, email, phone, address, city, skills, submitted_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$insert->bind_param(
    "sssssssss",
    $volunteer['first_name'],
    $volunteer['last_name'],
    $volunteer['imagePath'],
    $volunteer['email'],
    $volunteer['phone'],
    $volunteer['address'],
    $volunteer['city'],
    $volunteer['skills'],
    $volunteer['submitted_at']
);

if (!$insert->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to insert into volunteers.',
        'error' => $insert->error
    ]);
    $insert->close();
    exit;
}
$insert->close();

// Delete from volunteer_approvals
$delete = $conn->prepare("DELETE FROM volunteer_approvals WHERE id = ?");
$delete->bind_param("i", $id);

if (!$delete->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Volunteer inserted but failed to remove from approvals.',
        'error' => $delete->error
    ]);
    $delete->close();
    exit;
}
$delete->close();

// ✅ Final success response
echo json_encode([
    'success' => true,
    'message' => "Volunteer {$action}d and moved successfully."
]);
