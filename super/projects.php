<?php
    include '../includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/projects.css">
    <title>Projects | Admin</title>
</head>
<body>
   <?php include './includes/adminNav.php'; ?>
   <!-- All Projects -->
<section class="related-projects">
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
                     echo '    <a href="../project.php?projectId=' . urlencode($project['projectId']) . '" class="btn btn-secondary">View Project</a>';
                    // Assume $conn is available and $projectId is defined in a loop
                    $checkFeatured = $conn->prepare("SELECT featuredId FROM featuredProjects WHERE projectId = ?");
                    $checkFeatured->bind_param("i", $projectId);
                    $checkFeatured->execute();
$isFeatured = $checkFeatured->get_result()->num_rows > 0;

$buttonText = $isFeatured ? "Remove from featured" : "Feature this project";
$buttonClass = $isFeatured ? "btn-danger" : "btn-secondary";

echo '<button class="btn ' . $buttonClass . ' feature-btn" data-project-id="' . htmlspecialchars($projectId) . '" data-featured="' . ($isFeatured ? '1' : '0') . '">' . $buttonText . '</button>';

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

 <script>
document.addEventListener('DOMContentLoaded', function () {
  const feedback = document.getElementById('feedback');

  document.querySelectorAll('.feature-btn').forEach(button => {
    button.addEventListener('click', async function () {
      const btn = this;
      const projectId = btn.getAttribute('data-project-id');
      const isFeatured = btn.getAttribute('data-featured') === '1';

      try {
        const response = await fetch('./pFeatureProject.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          credentials: 'same-origin',
          body: JSON.stringify({
            projectId,
            action: isFeatured ? 'unfeature' : 'feature'
          })
        });

        const text = await response.text();

        if (!response.ok) {
          console.error('Server error:', response.status, text);
          showFeedback(`Server error (${response.status})`, 'error');
          return;
        }

        let result;
        try {
          result = JSON.parse(text);
        } catch (e) {
          console.error("Bad JSON:", text);
          showFeedback("Unexpected server response. Check console.", 'error');
          return;
        }

        if (!result.success) {
          showFeedback(result.message, 'error');
        } else {
          // ✅ Update UI
          const nowFeatured = !isFeatured;
          btn.setAttribute('data-featured', nowFeatured ? '1' : '0');
          btn.textContent = nowFeatured ? 'Remove from featured' : 'Feature this project';
          btn.classList.remove(nowFeatured ? 'btn-secondary' : 'btn-danger');
          btn.classList.add(nowFeatured ? 'btn-danger' : 'btn-secondary');

          showFeedback(result.message, 'success');
        }

      } catch (error) {
        console.error('Fetch error:', error);
        showFeedback("Network error. Try again.", 'error');
      }
    });
  });

  function showFeedback(msg, type) {
    const fb = document.getElementById('feedback');
    fb.textContent = msg;
    fb.classList.remove('success', 'error');
    fb.classList.add(type);
    fb.style.display = 'block';
    requestAnimationFrame(() => fb.style.opacity = 1);

    setTimeout(() => {
      fb.style.opacity = 0;
      setTimeout(() => {
        fb.style.display = 'none';
      }, 300);
    }, 5000);
  }
});
</script>



</body>
</html>