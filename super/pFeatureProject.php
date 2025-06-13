<?php
header('Content-Type: application/json');
include '../includes/connection.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['projectId']) || !is_numeric($data['projectId'])) {
        throw new Exception("Invalid project ID.");
    }

    $projectId = intval($data['projectId']);
    $action = $data['action'] ?? '';

    if ($action === 'feature') {
        // Check if already featured
        $check = $conn->prepare("SELECT featuredId FROM featuredProjects WHERE projectId = ?");
        $check->bind_param("i", $projectId);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            throw new Exception("Project is already featured.");
        }

        // Insert
        $stmt = $conn->prepare("INSERT INTO featuredProjects (projectId, created_at) VALUES (?, NOW())");
        $stmt->bind_param("i", $projectId);
        if (!$stmt->execute()) {
            throw new Exception("Database error: " . $stmt->error);
        }

        echo json_encode(['success' => true, 'message' => 'Project featured successfully.']);
    } elseif ($action === 'unfeature') {
        // Delete
        $stmt = $conn->prepare("DELETE FROM featuredProjects WHERE projectId = ?");
        $stmt->bind_param("i", $projectId);
        if (!$stmt->execute()) {
            throw new Exception("Database error: " . $stmt->error);
        }

        echo json_encode(['success' => true, 'message' => 'Project removed from featured.']);
    } else {
        throw new Exception("Invalid action specified.");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
