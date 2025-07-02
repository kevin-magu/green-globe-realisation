<?php
    include './includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/projects.css">
    <title>GGR | Projects</title>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-RKXH6ENQNG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-RKXH6ENQNG');
</script>
<body>
   <?php include './includes/navbar.php'; ?>
   <!-- All Projects -->
<section class="related-projects" style="margin-top: 80px">
    <div id="feedback" style="color: green; margin-top: 10px;"></div>
    <div class="container">
        <h2>All Projects</h2>
        <div class="projects-grid">
            <?php
            // Fetch all projects
            $projStmt = $conn->prepare("SELECT projectId, projectTitle, projectDesc FROM projects");
            $projStmt->execute();
            $projects = $projStmt->get_result();

            if ($projects->num_rows > 0) {
                while ($project = $projects->fetch_assoc()) {
                    $projectId = $project['projectId'];
                    $projectTitle = $project['projectTitle'];
                    $projectDesc = $project['projectDesc'];

                    // Get the first project image
                    $imgStmt = $conn->prepare("SELECT projectImagePath FROM projectImages WHERE projectId = ? ORDER BY created_at ASC LIMIT 1");
                    $imgStmt->bind_param("i", $projectId);
                    $imgStmt->execute();
                    $imgResult = $imgStmt->get_result();
                    $imgRow = $imgResult->fetch_assoc();
                    $bgImage = $imgRow ? $imgRow['projectImagePath'] : 'https://via.placeholder.com/600x400?text=No+Image';

                    // Create slug for project URL
                    $projectSlug = strtolower(str_replace(' ', '-', $projectTitle));

                    // Truncate description to first 14 words
                    $descWords = explode(' ', strip_tags($projectDesc));
                    $shortDesc = implode(' ', array_slice($descWords, 0, 14)) . (count($descWords) > 14 ? '...' : '');

                    // Output HTML
                    echo '<div class="project-card">';
                    echo '  <div class="project-image" style="background-image: url(\'' . htmlspecialchars($bgImage) . '\')"></div>';
                    echo '  <div class="project-content">';
                    echo '    <h3>' . htmlspecialchars($projectTitle) . '</h3>';
                    echo '    <p>' . htmlspecialchars($shortDesc) . '</p>';
                    echo '    <a href="project.php?projectId=' . urlencode($project['projectId']) . '" class="btn btn-secondary">View Project</a>';
                    echo '  </div>';
                    echo '</div>';
                }
            } else {
                echo "<p>Projects will be updated soon.</p>";
            }
            ?>
        </div>
    </div>
</section>


<?php include './includes/footer.php'; ?>
</body>
</html>