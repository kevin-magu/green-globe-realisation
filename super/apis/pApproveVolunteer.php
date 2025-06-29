<?php
header("Content-Type: application/json");
require_once '../../includes/connection.php';
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

// ==========================
// ✅ HANDLE "APPROVE ALL"
// ==========================
if ($id === "all" && $action === "approve") {
    $result = $conn->query("SELECT * FROM volunteer_approvals");

    if ($result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'No volunteers to approve.'
        ]);
        exit;
    }

    $insertStmt = $conn->prepare("
        INSERT INTO volunteers (first_name, last_name, imagePath, email, phone, address, city, skills, submitted_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $deleteStmt = $conn->prepare("DELETE FROM volunteer_approvals WHERE id = ?");

    $errors = [];
    while ($row = $result->fetch_assoc()) {
        $insertStmt->bind_param(
            "sssssssss",
            $row['first_name'],
            $row['last_name'],
            $row['imagePath'],
            $row['email'],
            $row['phone'],
            $row['address'],
            $row['city'],
            $row['skills'],
            $row['submitted_at']
        );

        if (!$insertStmt->execute()) {
            $errors[] = "Insert failed for ID {$row['id']}: " . $insertStmt->error;
            continue;
        }

        $deleteStmt->bind_param("i", $row['id']);
        if (!$deleteStmt->execute()) {
            $errors[] = "Delete failed for ID {$row['id']}: " . $deleteStmt->error;
        }
    }

    $insertStmt->close();
    $deleteStmt->close();

    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'message' => 'Some approvals failed.',
            'errors' => $errors
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'message' => 'All volunteers approved successfully.'
        ]);
    }

    exit;
}

// ==========================
// ✅ HANDLE SINGLE APPROVE/REJECT
// ==========================
$stmt = $conn->prepare("SELECT * FROM volunteer_approvals WHERE id = ?");
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

// Insert into volunteers table regardless of action
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

// Delete from approvals
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

echo json_encode([
    'success' => true,
    'message' => "Volunteer {$action}d successfully."
]);
