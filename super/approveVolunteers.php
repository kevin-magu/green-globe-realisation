<?php
require_once '../includes/connection.php';
$conn->set_charset("utf8mb4");

// Fetch pending volunteers
$sql = "SELECT id, first_name, last_name, imagePath, email, phone, address, city, skills, submitted_at FROM volunteer_approvals ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Volunteer Approvals</title>
  <link rel="stylesheet" href="./styles/approveVolunteers.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
 <?php require_once './includes/adminNav.php'; ?>
  <section class="container">
    <div class="section-header">
      <h2 class="section-title">Pending Volunteer Approvals</h2>
      <p class="section-subtitle">Review and approve incoming volunteer applications</p>
      <button class="btn btn-approve btn-approve-all" style="margin-top: 20px;">Approve All</button>
    </div>
    <div id="feedback" style="color: green; margin-top: 10px;"></div>
    <div class="card-grid">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="volunteer-card">
          <div class="card-image">
            <img src="<?= htmlspecialchars($row['imagePath']) ?>" alt="Volunteer Photo">
            <div class="card-badge">New</div>
          </div>
          <div class="card-content">
            <h3><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></h3>
            <div class="card-meta">
              <span><i class="fas fa-calendar-alt"></i> <?= date('M d, Y', strtotime($row['submitted_at'])) ?></span>
              <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($row['city']) ?></span>
            </div>
            
            <div class="card-details">
              <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']) ?></p>
              <p><i class="fas fa-phone"></i> <?= htmlspecialchars($row['phone']) ?></p>
              <div class="skills-container">
                <h4><i class="fas fa-tools"></i> Skills</h4>
                <p><?= nl2br(htmlspecialchars($row['skills'])) ?></p>
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
  <script src='./apis/approveVolunteer.js'></script>
</body>
</html>