<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/stories.css">
    <title>GGR | Impact</title>
</head>
<body>
 <?php
 include './includes/navbar.php'; 
include './includes/connection.php'; 

$sql = "
    SELECT 
        s.storyId,
        s.storyTitle,
        s.storyDescription,
        s.location,
        p.programName,
        (
            SELECT imagePath 
            FROM storyImages 
            WHERE storyId = s.storyId 
            ORDER BY storyId ASC LIMIT 1
        ) AS firstImage
    FROM stories s
    INNER JOIN programs p ON s.programId = p.programId
    ORDER BY s.created_at DESC
";

$result = $conn->query($sql);
?>

<!-- Impact Stories Section -->
<section class="impact-stories-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Stories</span>
            <h2 class="section-title">Creating Lasting Change</h2>
            <p class="section-subtitle">How our work is transforming communities and ecosystems</p>
        </div>
        <div class="stories-grid">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="story-card">
                    <div class="story-image" style="background-image: url('<?php echo htmlspecialchars($row['firstImage'] ?: './default.jpg'); ?>');"></div>
                    <div class="story-content">
                        <span class="story-category"><?php echo htmlspecialchars($row['storyTitle']); ?></span>
                        <h3><?php echo htmlspecialchars($row['programName']); ?></h3>
                        <p>
                        <?php
                            $words = explode(' ', strip_tags($row['storyDescription']));
                            $shortDesc = implode(' ', array_slice($words, 0, 14));
                            echo htmlspecialchars($shortDesc) . (count($words) > 14 ? '...' : '');
                            ?>
                        </p>

                        <div class="story-meta">
                            <span class="location"><?php echo htmlspecialchars($row['location']); ?></span>
                
                        </div>
                        <?php echo '<a href="story.php?storyId=' . $row['storyId'] . '" class="story-link">Read Story →</a>'; ?>
                        
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php include './includes/footer.php';  ?>
</body>
</html>