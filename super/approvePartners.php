<?php
require_once '../includes/connection.php';
$conn->set_charset("utf8mb4");

// Fetch pending partners
$sql = "SELECT id, logoPath, organization_name, contact_person, position, email, phone, organization_type, website, address, city, country, mission, partnership_interest, partnership_details, submitted_at FROM partner_approvals ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Partner Approvals</title>
  <link rel="stylesheet" href="./styles/approveVolunteers.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
 <?php require_once './includes/adminNav.php'; ?>
  <section class="container">
    <div class="section-header">
      <h2 class="section-title">Pending Partner Approvals</h2>
      <p class="section-subtitle">Review and approve incoming partnership applications</p>
      <button class='btn btn-approve' style='margin-top: 20px;'>Approve All</button>
    </div>
<div id="feedback" style="color: green; margin-top: 10px;"></div>
    <div class="card-grid">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="partner-card">
          <div class="card-image">
            <img src="<?= htmlspecialchars($row['logoPath']) ?>" alt="Organization Logo">
            <div class="card-badge">New</div>
          </div>
          <div class="card-content">
            <h3><?= htmlspecialchars($row['organization_name']) ?></h3>
            <div class="card-meta">
              <span><i class="fas fa-calendar-alt"></i> <?= date('M d, Y', strtotime($row['submitted_at'])) ?></span>
              <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($row['city'] . ', ' . $row['country']) ?></span>
              <span><i class="fas fa-building"></i> <?= htmlspecialchars($row['organization_type']) ?></span>
            </div>
            <div class="possible-scroll">
            <div class="card-details">
        
              <h4>Contact Information</h4>
              <p><i class="fas fa-user"></i> <?= htmlspecialchars($row['contact_person'] . ' (' . $row['position'] . ')') ?></p>
              <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']) ?></p>
              <p><i class="fas fa-phone"></i> <?= htmlspecialchars($row['phone']) ?></p>
              <p><i class="fas fa-globe"></i> <a href="<?= htmlspecialchars($row['website']) ?>" target="_blank"><?= htmlspecialchars($row['website']) ?></a></p>
              
              <h4><i class="fas fa-bullseye"></i> Mission</h4>
              <p><?= nl2br(htmlspecialchars($row['mission'])) ?></p>
              
              <h4><i class="fas fa-handshake"></i> Partnership Interest</h4>
              <p><?= nl2br(htmlspecialchars($row['partnership_interest'])) ?></p>
              
              <h4><i class="fas fa-info-circle"></i> Partnership Details</h4>
              <p><?= nl2br(htmlspecialchars($row['partnership_details'])) ?></p>
            </div>
            </div>
            
            <div class="card-actions">
              <button class="btn btn-approve" data-id="<?= $row['id'] ?>">
                <i class="fas fa-check"></i> Approve
              </button>
              <button class="btn btn-reject" data-id="<?= $row['id'] ?>">
                <i class="fas fa-times"></i> Reject
              </button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

<script src='./apis/approvePartner.js'></script>
</body>
</html>