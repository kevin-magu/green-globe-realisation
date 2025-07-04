<?php
header("Content-Type: application/json");
require_once '../../includes/connection.php';
$conn->set_charset("utf8mb4");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';

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

// ===============================
// ✅ FETCH SINGLE PARTNER DATA
// ===============================
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

$email = $partner['email'];
$orgName = $partner['organization_name'];
$logoPath = $partner['logoPath'];
$fullLogoPath = '../../' . $logoPath;

// ✅ ACTION: APPROVE
if ($action === 'approve') {
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
        $mail->addAddress($email, $orgName);
        $mail->isHTML(true);
        $mail->Subject = "RE: PARTNERSHIP APPLICATION";

        $mail->Body = '
            <h2 style="font-family: Arial, sans-serif; color: #2e7d32;">Dear ' . htmlspecialchars($orgName) . ',</h2>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            <strong>Subject:</strong> Partnership Application Approval</p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            We are pleased to inform you that your application to partner with <strong>Green Globe Realisation</strong> has been <strong>approved</strong>.</p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            We appreciate your commitment to supporting sustainable development, and we look forward to working with your organization.</p>
            <hr style="margin: 30px 0;">
            <p style="font-family: Arial, sans-serif; font-size: 14px; color: #555;">
            Warm regards,<br>
            <strong>Green Globe Realisation</strong><br>
            📍 Kileleshwa, Mwingi Rd<br>
            📞 +254 208 000 117<br>
            🌐 <a href="https://greengloberealisation.org" style="color: #2e7d32;">greengloberealisation.org</a></p>
        ';
        $mail->AltBody = "Hi {$orgName}, your partnership application has been approved. - Green Globe Realisation";

        $mail->send();
    } catch (Exception $e) {
        // silently fail email
    }
}

// ✅ ACTION: REJECT
if ($action === 'reject') {
    if (!empty($logoPath) && file_exists($fullLogoPath)) {
        unlink($fullLogoPath);
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
        $mail->addAddress($email, $orgName);
        $mail->isHTML(true);
        $mail->Subject = "RE: PARTNERSHIP APPLICATION";

        $mail->Body = '
            <h2 style="font-family: Arial, sans-serif; color: #b71c1c;">Dear ' . htmlspecialchars($orgName) . ',</h2>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            <strong>Subject:</strong> Partnership Application Decision</p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            Thank you for expressing interest in partnering with <strong>Green Globe Realisation</strong>.</p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            After careful review, we regret to inform you that we will not be moving forward with your partnership request at this time.</p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
            We truly value your initiative and encourage future engagement opportunities as they arise.</p>
            <hr style="margin: 30px 0;">
            <p style="font-family: Arial, sans-serif; font-size: 14px; color: #555;">
            Kind regards,<br>
            <strong>Green Globe Realisation</strong><br>
            📍 Kileleshwa, Mwingi Rd<br>
            📞 +254 208 000 117<br>
            🌐 <a href="https://greengloberealisation.org" style="color: #b71c1c;">greengloberealisation.org</a></p>
        ';
        $mail->AltBody = "Hi {$orgName}, your partnership application has been rejected. - Green Globe Realisation";

        $mail->send();
    } catch (Exception $e) {
        // silently fail email
    }
}

// ✅ DELETE from approvals
$delete = $conn->prepare("DELETE FROM partner_approvals WHERE id = ?");
$delete->bind_param("i", $id);

if (!$delete->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Partner record could not be deleted.',
        'error' => $delete->error
    ]);
    $delete->close();
    exit;
}
$delete->close();

// ✅ Final Success Response
echo json_encode([
    'success' => true,
    'message' => "Partner {$action}d successfully."
]);
