<?php
include './includes/connection.php';

// Fetch project details and images
$project = null;
$projectImages = [];

if (isset($_GET['projectId'])) {
    $projectId = intval($_GET['projectId']);

    // Fetch project data
    $projectQuery = "SELECT * FROM projects WHERE projectId = $projectId LIMIT 1";
    $projectResult = mysqli_query($conn, $projectQuery);
    if ($projectResult && mysqli_num_rows($projectResult) > 0) {
        $project = mysqli_fetch_assoc($projectResult);

        // Fetch project images
        $imagesQuery = "SELECT projectImagePath FROM projectImages WHERE projectId = $projectId";
        $imagesResult = mysqli_query($conn, $imagesQuery);
        while ($row = mysqli_fetch_assoc($imagesResult)) {
            $projectImages[] = $row['projectImagePath'];
        }
    }
}

// Get first image for hero section
$heroImage = !empty($projectImages) ? $projectImages[2] : './images/default-hero.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $project ? htmlspecialchars($project['projectTitle']) : 'Project Details'; ?> | Green Globe Realisation</title>
    <link rel="stylesheet" href="./styles/project.css">
     <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
<?php include './includes/navbar.php' ?>

<main class="project-page">
    <!-- Project Hero Section -->
    <section class="project-hero" style="background-image: url('<?php echo $heroImage; ?>')">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="project-hero-content">
                <div class="hero-text">
                <div class="breadcrumb">
                    <a href="./">Home</a> / <span><?php echo htmlspecialchars($project['projectTitle']); ?></span>
                </div>
                <h1><?php echo htmlspecialchars($project['projectTitle']); ?></h1>
                <div class="project-meta">
                    <span class="status <?php echo strtolower($project['projectStatus']); ?>"><?php echo htmlspecialchars($project['projectStatus']); ?></span>
                </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Overview -->
    <section class="project-overview">
        <div class="container">
            <div class="overview-content">
                <div class="overview-text">
                    <h2>Project Details</h2>
                    <p><?php echo htmlspecialchars($project['projectDesc']); ?></p>
                    <div class="project-stats">
                        <div class="stat-item">
                            <span class="number"><?php echo htmlspecialchars($project['impactValue1']); ?></span>
                            <span class="label"><?php echo htmlspecialchars($project['impactLabel1']); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="number"><?php echo htmlspecialchars($project['impactValue2']); ?></span>
                            <span class="label"><?php echo htmlspecialchars($project['impactLabel2']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Gallery -->
    <section class="project-gallery">
        <div class="container">
            <h2>Project Gallery</h2>
            <div class="gallery-grid">
                <?php foreach ($projectImages as $imagePath): ?>
                    <div class="gallery-item">
                        <img src="<?php echo $imagePath; ?>" alt="Project photo">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php include './includes/footer.php' ?>
</body>
</html>