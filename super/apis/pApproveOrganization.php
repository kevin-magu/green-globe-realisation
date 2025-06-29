<?php
header("Content-Type: application/json");
require_once '../../includes/connection.php';
$conn->set_charset("utf8mb4");

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$action = $data['action'] ?? '';

// Validation
if (!$id || !in_array($action, ['approve', 'reject'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid ID or action.'
    ]);
    exit;
}

// ✅ APPROVE ALL
if ($id === "all" && $action === "approve") {
    $result = $conn->query("SELECT * FROM organization_approvals");
    if (!$result || $result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'No organizations to approve.'
        ]);
        exit;
    }

    $insert = $conn->prepare("
        INSERT INTO organizations (
            organization_name, organization_type, contact_person, contact_position,
            email, phone, website, address, city, country, mission,
            focus_areas, other_focus, collaboration_interest, logo_path, agree_terms, status, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'approved', NOW())
    ");
    $delete = $conn->prepare("DELETE FROM organization_approvals WHERE id = ?");
    $errors = [];

    while ($org = $result->fetch_assoc()) {
        $insert->bind_param(
            "ssssssssssssssss",
            $org['organization_name'],
            $org['organization_type'],
            $org['contact_person'],
            $org['contact_position'],
            $org['email'],
            $org['phone'],
            $org['website'],
            $org['address'],
            $org['city'],
            $org['country'],
            $org['mission'],
            $org['focus_areas'],
            $org['other_focus'],
            $org['collaboration_interest'],
            $org['logo_path'],
            $org['agree_terms']
        );

        if (!$insert->execute()) {
            $errors[] = "Insert failed for ID {$org['id']}";
            continue;
        }

        $delete->bind_param("i", $org['id']);
        if (!$delete->execute()) {
            $errors[] = "Delete failed for ID {$org['id']}";
        }
    }

    $insert->close();
    $delete->close();

    echo json_encode([
        'success' => empty($errors),
        'message' => empty($errors) ? "All organizations approved." : "Some errors occurred.",
        'errors' => $errors
    ]);
    exit;
}

// ✅ SINGLE APPROVE or REJECT
$stmt = $conn->prepare("SELECT * FROM organization_approvals WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Organization not found.'
    ]);
    exit;
}

$org = $result->fetch_assoc();
$stmt->close();

$insert = $conn->prepare("
    INSERT INTO organizations (
        organization_name, organization_type, contact_person, contact_position,
        email, phone, website, address, city, country, mission,
        focus_areas, other_focus, collaboration_interest, logo_path, agree_terms, status, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'approved', NOW())
");

$insert->bind_param(
    "ssssssssssssssss",
    $org['organization_name'],
    $org['organization_type'],
    $org['contact_person'],
    $org['contact_position'],
    $org['email'],
    $org['phone'],
    $org['website'],
    $org['address'],
    $org['city'],
    $org['country'],
    $org['mission'],
    $org['focus_areas'],
    $org['other_focus'],
    $org['collaboration_interest'],
    $org['logo_path'],
    $org['agree_terms']
);

if (!$insert->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Insert into organizations failed.',
        'error' => $insert->error
    ]);
    exit;
}
$insert->close();

$delete = $conn->prepare("DELETE FROM organization_approvals WHERE id = ?");
$delete->bind_param("i", $id);
$delete->execute();
$delete->close();

echo json_encode([
    'success' => true,
    'message' => "Organization {$action}d successfully."
]);
