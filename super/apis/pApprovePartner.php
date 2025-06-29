<?php
header("Content-Type: application/json");
require_once '../../includes/connection.php';
$conn->set_charset("utf8mb4");

// Get input
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$action = $data['action'] ?? '';

// Validate input
if (!$id || !in_array($action, ['approve', 'reject'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid ID or action.'
    ]);
    exit;
}

// ======================================
// ✅ MASS APPROVAL — APPROVE ALL
// ======================================
if ($id === "all" && $action === "approve") {
    $result = $conn->query("SELECT * FROM partner_approvals");

    if (!$result || $result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'No partners to approve.'
        ]);
        exit;
    }

    $insertStmt = $conn->prepare("
        INSERT INTO partners 
        (logoPath, organization_name, contact_person, position, email, phone, organization_type, website, address, city, country, mission, partnership_interest, partnership_details, submitted_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $deleteStmt = $conn->prepare("DELETE FROM partner_approvals WHERE id = ?");
    $errors = [];

    while ($row = $result->fetch_assoc()) {
        $insertStmt->bind_param(
            "sssssssssssssss",
            $row['logoPath'],
            $row['organization_name'],
            $row['contact_person'],
            $row['position'],
            $row['email'],
            $row['phone'],
            $row['organization_type'],
            $row['website'],
            $row['address'],
            $row['city'],
            $row['country'],
            $row['mission'],
            $row['partnership_interest'],
            $row['partnership_details'],
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
            'message' => 'All partners approved successfully.'
        ]);
    }

    exit;
}

// ======================================
// ✅ SINGLE APPROVAL or REJECTION
// ======================================
$stmt = $conn->prepare("SELECT * FROM partner_approvals WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Partner not found.'
    ]);
    $stmt->close();
    exit;
}

$partner = $result->fetch_assoc();
$stmt->close();

// Insert to partners (on both approve or reject — you can change this logic if needed)
$insert = $conn->prepare("
    INSERT INTO partners 
    (logoPath, organization_name, contact_person, position, email, phone, organization_type, website, address, city, country, mission, partnership_interest, partnership_details, submitted_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$insert->bind_param(
    "sssssssssssssss",
    $partner['logoPath'],
    $partner['organization_name'],
    $partner['contact_person'],
    $partner['position'],
    $partner['email'],
    $partner['phone'],
    $partner['organization_type'],
    $partner['website'],
    $partner['address'],
    $partner['city'],
    $partner['country'],
    $partner['mission'],
    $partner['partnership_interest'],
    $partner['partnership_details'],
    $partner['submitted_at']
);

if (!$insert->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to insert into partners.',
        'error' => $insert->error
    ]);
    $insert->close();
    exit;
}
$insert->close();

// Delete from approvals
$delete = $conn->prepare("DELETE FROM partner_approvals WHERE id = ?");
$delete->bind_param("i", $id);

if (!$delete->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Inserted but failed to delete from approvals.',
        'error' => $delete->error
    ]);
    $delete->close();
    exit;
}
$delete->close();

// ✅ Final Success
echo json_encode([
    'success' => true,
    'message' => "Partner {$action}d successfully."
]);
