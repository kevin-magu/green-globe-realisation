<?php
// Sample data for dashboard metrics and projects
$metrics = [
    'projects' => 45,
    'volunteers' => 1200,
    'carbon_reduced' => '15,000 tons',
    'trees_planted' => 5000
];

$projects = [
    ['name' => 'Urban Green Initiative', 'status' => 'Active', 'progress' => 75],
    ['name' => 'River Cleanup Project', 'status' => 'Ongoing', 'progress' => 60],
    ['name' => 'Reforestation Campaign', 'status' => 'Completed', 'progress' => 100],
];
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
                    <h3><?php echo $metrics['projects']; ?></h3>
                    <p>Active Projects</p>
                </div>
                <div class="metric-card">
                    <h3><?php echo $metrics['volunteers']; ?></h3>
                    <p>Volunteers Engaged</p>
                </div>
                <div class="metric-card">
                    <h3><?php echo $metrics['carbon_reduced']; ?></h3>
                    <p>Carbon Reduced</p>
                </div>
                <div class="metric-card">
                    <h3><?php echo $metrics['trees_planted']; ?></h3>
                    <p>Trees Planted</p>
                </div>
            </div>
        </div>
    </section>

    <section id="projects" class="projects">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Projects</span>
                <h2 class="section-title">Our Initiatives</h2>
                <p class="section-subtitle">Explore our ongoing and completed environmental projects.</p>
            </div>

            <div class="projects-grid">
                <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <h3><?php echo htmlspecialchars($project['name']); ?></h3>
                        <p>Status: <span class="status-<?php echo strtolower($project['status']); ?>"><?php echo htmlspecialchars($project['status']); ?></span></p>
                        <div class="progress-bar">
                            <div class="progress" style="width: <?php echo $project['progress']; ?>%"></div>
                        </div>
                        <p>Progress: <?php echo $project['progress']; ?>%</p>
                        <a href="#" class="btn btn-secondary">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer class="dashboard-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Eco Guardians. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>