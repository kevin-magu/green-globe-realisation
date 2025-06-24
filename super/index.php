<?php
require_once '../includes/connection.php';
$conn->set_charset("utf8mb4");

// Query to count total rows
$sql = "SELECT COUNT(*) AS total FROM volunteer_approvals";
$result = $conn->query($sql);

if ($result) {
    $volunteerApptovalRow = $result->fetch_assoc();
   
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGR - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body>
     <?php include  './includes/adminNav.php'?>

    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Overview</span>
                <h2 class="section-title">Environmental Impact Dashboard</h2>
                <p class="section-subtitle">Track our progress in creating a sustainable future.</p>
            </div>

            <div class="metrics-grid">
                <div class="metric-card">
                    <h3><?php echo $volunteerApptovalRow['total']; ?></h3>
                    <p>Volunteers to approve</p>
                </div>
                <a href="./approveVolunteers.php">
                    <div class="metric-card">
                    <h3><?php echo $volunteerApptovalRow['total']; ?></h3>
                    <p>Partners to approve</p>
                    </div>
                </a>
                <div class="metric-card">
                    <h3><?php echo 2; ?></h3>
                    <p>Carbon Reduced</p>
                </div>
                <div class="metric-card">
                    <h3><?php echo 2; ?></h3>
                    <p>Trees Planted</p>
                </div>
            </div>
        </div>
    </section>


    <footer class="dashboard-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Green Globe Realisation. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>