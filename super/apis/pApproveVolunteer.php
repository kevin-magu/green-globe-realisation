<?php
header("Content-Type: application/json");
require_once '../../includes/connection.php';
$conn->set_charset("utf8mb4");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';

// Read JSON input
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

/* ✅ APPROVE ALL
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

    echo json_encode([
        'success' => empty($errors),
        'message' => empty($errors) ? 'All volunteers approved successfully.' : 'Some approvals failed.',
        'errors' => $errors
    ]);
    exit;
} */

// ✅ HANDLE SINGLE APPROVE/REJECT
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

$firstName = $volunteer['first_name'];
$email = $volunteer['email'];
$imagePath = $volunteer['imagePath'];
$fullPath = '../../../'.$imagePath;

// ✅ ACTION: APPROVE
if ($action === 'approve') {
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

    // ✅ Send approval email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.greengloberealisation.org';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@greengloberealisation.org';
        $mail->Password   = 'Green2030!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('info@greengloberealisation.org', 'Green Globe Realisation');
        $mail->addAddress($email, $firstName);
        $mail->isHTML(true);
        $mail->Subject = "RE: VOLUNTEER APPLICATION";

        $mail->Body = '
            <h2 style="font-family: Arial, sans-serif; color: #2e7d32;">Dear ' . htmlspecialchars($firstName) . ',</h2>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            <strong>Subject:</strong> Volunteer Application Approval</p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            We are pleased to inform you that your volunteer application to <strong>Green Globe Realisation</strong> has been <strong>approved</strong>.</p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            Your passion and commitment to contributing towards sustainable development align perfectly with our mission, and we are excited to welcome you aboard.</p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            Our team will be reaching out shortly with further details and onboarding instructions. In the meantime, feel free to explore more about our work on our website.</p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            Thank you once again for stepping forward to make a difference. Together, we can build a greener, more equitable world.</p>
            <hr style="margin: 30px 0;">
            <p style="font-family: Arial, sans-serif; font-size: 14px; color: #555;">
            Warm regards,<br>
            <strong>Green Globe Realisation</strong><br>
            📍 Kileleshwa, Mwingi Rd<br>
            📞 +254 208 000 117<br>
            🌐 <a href="https://greengloberealisation.org" style="color: #2e7d32;">greengloberealisation.org</a></p>
        ';
        $mail->AltBody = "Hi {$firstName}, your application has been approved. - Green Globe Realisation";

        $mail->send();
    } catch (Exception $e) {
        // silently fail email
    }
}

// ✅ ACTION: REJECT
if ($action === 'reject') {
    // Delete image file if exists
    if(!empty($imagePath) && file_exists($fullPath)) {
        $deleteImage = unlink($fullPath);
    }else{
        echo json_encode([
            'success' => false,
            'message' => 'Image could not be deleted from folder .',
           // 'error' => $deleteImage->error
        ]);
        exit;
    }
}

// ✅ Delete from approvals
$delete = $conn->prepare("DELETE FROM volunteer_approvals WHERE id = ?");
$delete->bind_param("i", $id);

if (!$delete->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Volunteer record could not be deleted.',
        'error' => $delete->error
    ]);
    $delete->close();
    exit;
}
$delete->close();

// ✅ Send Rejection email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.greengloberealisation.org';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@greengloberealisation.org';
        $mail->Password   = 'Green2030!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('info@greengloberealisation.org', 'Green Globe Realisation');
        $mail->addAddress($email, $firstName);
        $mail->isHTML(true);
        $mail->Subject = "RE: VOLUNTEER APPLICATION";

        $mail->Body = '
    <h2 style="font-family: Arial, sans-serif; color: #b71c1c;">Dear ' . htmlspecialchars($firstName) . ',</h2>

    <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
    <strong>Subject:</strong> Volunteer Application Decision.
    </p>

    <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
    Thank you for taking the time to apply to volunteer with <strong>Green Globe Realisation</strong>. We truly appreciate your interest in supporting our mission toward sustainable development.
    </p>

    <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
    After careful review of your application, we regret to inform you that we will not be moving forward with your candidacy at this time.
    </p>

    <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
    This decision does not reflect on your potential or the value of your contributions, but rather on our current program alignment and volunteer requirements. We encourage you to explore future opportunities with us as they arise.
    </p>

    <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
    Once again, we thank you for your willingness to contribute, and we wish you all the best in your continued efforts to make a positive impact.
    </p>

    <hr style="margin: 30px 0;">

    <p style="font-family: Arial, sans-serif; font-size: 14px; color: #555; line-height: 1.5;">
    Kind regards,<br>
    <strong>Green Globe Realisation</strong><br>
    📍 Kileleshwa, Mwingi Rd<br>
    📞 +254 208 000 117<br>
    🌐 <a href="https://greengloberealisation.org" style="color: #b71c1c;">greengloberealisation.org</a>
    </p>
';

        $mail->AltBody = "Hi {$firstName}, your application has been rejected. - Green Globe Realisation";

        $mail->send();
    } catch (Exception $e) {
        // silently fail email
    }

echo json_encode([
    'success' => true,
    'message' => "Volunteer {$action}d successfully."
]);
