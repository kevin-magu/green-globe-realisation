<?php
header("Content-Type: application/json");
require_once '../../includes/connection.php';
$conn->set_charset("utf8mb4");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';

$data = json_decode(file_get_contents("php://input"), true);
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

// ✅ FETCH ORGANIZATION
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

$logoPath = $org['logo_path'];
$fullPath = '../../' . $logoPath;
$email = $org['email'];
$name = $org['organization_name'];

// ✅ ACTION: APPROVE
if ($action === 'approve') {
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
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = "RE: ORGANIZATION PARTNERSHIP APPLICATION";

        $mail->Body = '
        <h2 style="font-family: Arial, sans-serif; color: #2e7d32;">Dear ' . htmlspecialchars($name) . ',</h2>
        <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
        <strong>Subject:</strong> Partnership Application Approval.</p>
        <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
        We are pleased to inform you that your organization\'s application to partner with <strong>Green Globe Realisation</strong> has been <strong>approved</strong>.</p>
        <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
        Our team will contact you shortly with the next steps. We are excited about the opportunities this partnership can create for sustainable impact.</p>
        <hr style="margin: 30px 0;">
        <p style="font-family: Arial, sans-serif; font-size: 14px; color: #555;">
        Warm regards,<br>
        <strong>Green Globe Realisation</strong><br>
        📍 Kileleshwa, Mwingi Rd<br>
        📞 +254 208 000 117<br>
        🌐 <a href="https://greengloberealisation.org" style="color: #2e7d32;">greengloberealisation.org</a></p>';

        $mail->AltBody = "Hi {$name}, your organization's application has been approved. - Green Globe Realisation";
        $mail->send();
    } catch (Exception $e) {
        // Silently fail or log
    }
}

// ✅ ACTION: REJECT
if ($action === 'reject') {
    if (!empty($logoPath) && file_exists($fullPath)) {
        unlink($fullPath);
    }

    // ✅ Send rejection email
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
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = "RE: ORGANIZATION PARTNERSHIP APPLICATION";

        $mail->Body = '
        <h2 style="font-family: Arial, sans-serif; color: #b71c1c;">Dear ' . htmlspecialchars($name) . ',</h2>
        <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
        <strong>Subject:</strong> Partnership Application Rejected.</p>
        <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
        Thank you for expressing interest in partnering with <strong>Green Globe Realisation</strong>. After careful consideration, we regret to inform you that your application has not been approved at this time.</p>
        <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
        We appreciate your commitment to sustainable development and encourage you to explore future opportunities with us.</p>
        <hr style="margin: 30px 0;">
        <p style="font-family: Arial, sans-serif; font-size: 14px; color: #555;">
        Kind regards,<br>
        <strong>Green Globe Realisation</strong><br>
        📍 Kileleshwa, Mwingi Rd<br>
        📞 +254 208 000 117<br>
        🌐 <a href="https://greengloberealisation.org" style="color: #b71c1c;">greengloberealisation.org</a></p>';

        $mail->AltBody = "Hi {$name}, your organization's application has been rejected. - Green Globe Realisation";
        $mail->send();
    } catch (Exception $e) {
        // Silently fail or log
    }
}

// ✅ DELETE FROM APPROVALS
$delete = $conn->prepare("DELETE FROM organization_approvals WHERE id = ?");
$delete->bind_param("i", $id);
$delete->execute();
$delete->close();

// ✅ RESPONSE
echo json_encode([
    'success' => true,
    'message' => "Organization {$action}d successfully."
]);
