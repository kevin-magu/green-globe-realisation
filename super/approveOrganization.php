<?php
require_once '../includes/connection.php';
$conn->set_charset("utf8mb4");

// Fetch pending organization approvals
$sql = "SELECT id, organization_name, organization_type, contact_person, contact_position, email, phone, website, address, city, country, mission, focus_areas, other_focus, collaboration_interest, logo_path, agree_terms FROM organization_approvals ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Organization Approvals</title>
  <link rel="stylesheet" href="./styles/approveVolunteers.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
 <?php require_once './includes/adminNav.php'; ?>
  <section class="container">
    <div class="section-header">
      <h2 class="section-title">Pending Organization Approvals</h2>
      <p class="section-subtitle">Review and approve incoming organization applications</p>
      <button class='btn btn-approve' style='margin-top: 20px;'>Approve All</button>
    </div>

    <div class="card-grid">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="organization-card">
          <div class="card-image">
            <img src="<?= htmlspecialchars($row['logo_path'] ?? 'default_organization_logo.png') ?>" alt="Organization Logo">
            <div class="card-badge">New</div>
          </div>
          <div class="card-content">
            <h3><?= htmlspecialchars($row['organization_name']) ?></h3>
            <div class="card-meta">
              <span><i class="fas fa-building"></i> <?= htmlspecialchars($row['organization_type']) ?></span>
              <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($row['city'] . ', ' . $row['country']) ?></span>
            </div>

            <div class="possible-scroll">
            <div class="card-details">
              <h4><i class="fas fa-id-card"></i> Contact Information</h4>
              <p><strong>Contact Person:</strong> <?= htmlspecialchars($row['contact_person'] . ' (' . $row['contact_position'] . ')') ?></p>
              <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']) ?></p>
              <p><i class="fas fa-phone"></i> <?= htmlspecialchars($row['phone']) ?></p>
              <p><i class="fas fa-globe"></i> <a href="<?= htmlspecialchars($row['website']) ?>" target="_blank"><?= htmlspecialchars($row['website']) ?></a></p>
              <p><i class="fas fa-map-pin"></i> <?= htmlspecialchars($row['address']) ?></p>
              
              <h4><i class="fas fa-bullseye"></i> Mission Statement</h4>
              <p><?= nl2br(htmlspecialchars($row['mission'])) ?></p>
              
              <h4><i class="fas fa-crosshairs"></i> Focus Areas</h4>
              <p><?= nl2br(htmlspecialchars($row['focus_areas'])) ?></p>
              
              <?php if (!empty($row['other_focus'])): ?>
              <h4><i class="fas fa-plus-circle"></i> Other Focus Areas</h4>
              <p><?= nl2br(htmlspecialchars($row['other_focus'])) ?></p>
              <?php endif; ?>
              
              <h4><i class="fas fa-handshake"></i> Collaboration Interest</h4>
              <p><?= nl2br(htmlspecialchars($row['collaboration_interest'])) ?></p>
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

  <script>
    // You can add JavaScript functionality here for approval/rejection
  </script>
</body>
</html>