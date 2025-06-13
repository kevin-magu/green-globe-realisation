<?php
include './includes/navbar.php';
include './includes/connection.php';

$storyId = isset($_GET['storyId']) ? intval($_GET['storyId']) : 0;

// Fetch story
$storyQuery = $conn->prepare("SELECT s.*, p.programName FROM stories s JOIN programs p ON s.programId = p.programId WHERE s.storyId = ?");
$storyQuery->bind_param("i", $storyId);
$storyQuery->execute();
$storyResult = $storyQuery->get_result();
$story = $storyResult->fetch_assoc();

if (!$story) {
    echo "<p>Story not found.</p>";
    exit;
}

// Fetch story images
$imgQuery = $conn->prepare("SELECT imagePath FROM storyImages WHERE storyId = ?");
$imgQuery->bind_param("i", $storyId);
$imgQuery->execute();
$imgResult = $imgQuery->get_result();
$storyImages = [];
while ($img = $imgResult->fetch_assoc()) {
    $storyImages[] = $img['imagePath'];
}

// First image for hero background
$heroImage = !empty($storyImages) ? $storyImages[0] : 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=1950&q=80';

// Fetch related stories and their first image
$relatedQuery = $conn->prepare("SELECT s.storyId, s.storyTitle, (SELECT imagePath FROM storyImages si WHERE si.storyId = s.storyId LIMIT 1) AS imagePath FROM stories s WHERE s.storyId != ? ORDER BY RAND() LIMIT 2");
$relatedQuery->bind_param("i", $storyId);
$relatedQuery->execute();
$relatedResult = $relatedQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Story | Green Globe Realisation</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/story.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<main class="story-page">
    <!-- Story Hero Section -->
    <section class="story-hero" style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo htmlspecialchars($heroImage); ?>')">
        <div class="container">
            <div class="hero-content">
                <div class="breadcrumb">
                    <a href="/">Home</a> / <a href="/stories">Stories</a> / <span><?php echo htmlspecialchars($story['storyTitle'] ?? ''); ?></span>
                </div>
                <h1><?php echo htmlspecialchars($story['storyTitle'] ?? ''); ?></h1>
                <div class="story-meta">
                    <span class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($story['location'] ?? ''); ?></span>
                    <span class="date"><i class="fas fa-calendar-alt"></i> Published: <?php echo htmlspecialchars(date('F j, Y', strtotime($story['created_at'] ?? ''))); ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Content -->
    <section class="story-content">
        <div class="container">
            <div class="content-grid">
                <div class="story-text">
                    <div class="program-badge">
                        <i class="fas fa-tree"></i> <?php echo htmlspecialchars($story['programName'] ?? ''); ?>
                    </div>

                    <h2><?php echo htmlspecialchars($story['storyTitle'] ?? ''); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($story['storyDescription'] ?? '')); ?></p>
                </div>

                <div class="related-stories">
                    <h3>More Success Stories</h3>
                    <?php while ($related = $relatedResult->fetch_assoc()): ?>
                    <div class="story-card">
                        <div class="story-image" style="background-image: url('<?php echo htmlspecialchars($related['imagePath'] ?? '/uploads/storyImages/default.jpg'); ?>')"></div>
                        <h4><?php echo htmlspecialchars($related['storyTitle'] ?? ''); ?></h4>
                        <a href="/story.php?storyId=<?php echo urlencode($related['storyId']); ?>" class="story-link">Read Story →</a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Gallery -->
    <section class="story-gallery">
        <div class="container">
            <h2>Project Gallery</h2>
            <div class="gallery-grid">
                <?php foreach ($storyImages as $image): ?>
                <div class="gallery-item">
                    <img src="<?php echo htmlspecialchars($image); ?>" alt="Story Image">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Story CTA 
    <section class="story-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Inspired by this story?</h2>
                <p>Join our community of changemakers working to restore Kenya's environment.</p>
                <div class="cta-buttons">
                    <a href="/get-involved" class="btn-primary">Get Involved</a>
                    <a href="/share-your-story" class="btn-secondary">Share Your Story</a>
                </div>
            </div>
        </div>
    </section> -->
</main>

<?php include './includes/footer.php'; ?>
</body>
</html>
