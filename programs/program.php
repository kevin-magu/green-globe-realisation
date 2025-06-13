<?php
// Connect to DB (adjust path if needed)
include '../includes/connection.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

if (!$slug) {
    echo "No program specified.";
    exit;
}

// Prepare and execute query to get programName and programDesc using the slug
$stmt = $conn->prepare("SELECT programName, programTagline, programDesc, programObj1, programObj2, programObj3, programObj4, programImagePath FROM programs WHERE LOWER(REPLACE(programName, ' ', '-')) = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Program not found.";
    exit;
}

$program = $result->fetch_assoc();
$programName = $program['programName'];
$programDesc = $program['programDesc'];
$programTagline = $program['programTagline'];
$programObj1 = $program['programObj1'];
$programObj2 = $program['programObj2'];
$programObj3 = $program['programObj3'];
$programObj4 = $program['programObj4'];
$imagePath = $program['programImagePath'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reforestation Program | Green Globe Realisation</title>
    <link rel="stylesheet" href="../styles/program.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include '../includes/navbar.php' ?>

<main class="program-simple">
    <!-- Program Header -->
    <section class="program-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="">Home</a> / <a><?= htmlspecialchars($programName) ?></a>
            </div>
            <h1><?= htmlspecialchars($programName) ?></h1>
            <p class="program-subtitle"><?= htmlspecialchars($programTagline) ?></p>
        </div>
    </section>

    <!-- Program Description -->
    <section class="program-description">
        <div class="container">
            <div class="description-content">
                <div class="description-text">
                    <h2>About the Program</h2>
                    <p><?= htmlspecialchars($programDesc) ?></p>
                </div>
                <div class="description-image">
                    <img src="<?php echo $imagePath; ?>" alt="Program Image" alt="Community tree planting">
                </div>
            </div>
        </div>
    </section>

    <!-- Program Objectives -->
    <section class="program-objectives">
        <div class="container">
            <h2>Program Objectives</h2>
            <div class="objectives-grid">
                <div class="objective-card">
                    <p><?= htmlspecialchars($programObj1) ?></p>
                </div>
                <div class="objective-card">    
                    <p><?= htmlspecialchars($programObj2) ?></p>
                </div>
                <div class="objective-card">             
                    <p><?= htmlspecialchars($programObj3) ?></p>
                </div>
                <div class="objective-card">                 
                    <p><?= htmlspecialchars($programObj4) ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Projects -->
    <section class="related-projects">
        <div class="container">
            <h2>Projects under this program.</h2>
            <div class="projects-grid">
                <?php
// Get slug from URL (e.g., biomedical-waste-management)
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

if (!$slug) {
    echo "No program specified.";
    exit;
}

// Convert slug back to original program name
$programNameFromSlug = str_replace('-', ' ', $slug);

// Get the matching programId
$progStmt = $conn->prepare("SELECT programId FROM programs WHERE LOWER(programName) = LOWER(?)");
$progStmt->bind_param("s", $programNameFromSlug);
$progStmt->execute();
$progResult = $progStmt->get_result();

if ($progResult->num_rows === 0) {
    echo "<p>Program not found.</p>";
    exit;
}

$programId = $progResult->fetch_assoc()['programId'];

// Fetch projects under this program
$projStmt = $conn->prepare("SELECT projectId, projectTitle, projectDesc FROM projects WHERE programId = ?");
$projStmt->bind_param("i", $programId);
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
        $bgImage = $imgRow ? $imgRow['projectImagePath'] : 'hello';

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
</main>

<?php include '../includes/footer.php' ?>
</body>
</html>