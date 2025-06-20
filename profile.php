<?php
require_once './includes/connection.php';
$conn->set_charset("utf8mb4");

// Validate and sanitize the `id` from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing executive ID.");
}

$executiveId = (int) $_GET['id'];

// Query the executive based on ID
$stmt = $conn->prepare("SELECT executiveName, position, description, profilePicture, linkedin, twitter FROM executives WHERE executiveId = ?");
$stmt->bind_param("i", $executiveId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $executive = $result->fetch_assoc();
} else {
    die("Executive not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($executive['executiveName']); ?> | Executive Profile</title>
     <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include './includes/navbar.php'; ?>

    <main class="profile-main">
        <div class="container">
            <div class="profile-card">
                <div class="profile-image-container">
                    <img src="<?php echo htmlspecialchars($executive['profilePicture']); ?>" alt="<?php echo htmlspecialchars($executive['executiveName']); ?>" class="profile-image">
                    <div class="social-links">
                        <?php if (!empty($executive['linkedin'])): ?>
                            <a href="<?php echo htmlspecialchars($executive['linkedin']); ?>" target="_blank" class="social-link linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($executive['twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($executive['twitter']); ?>" target="_blank" class="social-link twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="profile-content">
                    <h1 class="profile-name"><?php echo htmlspecialchars($executive['executiveName']); ?></h1>
                    <h2 class="profile-position"><?php echo htmlspecialchars($executive['position']); ?></h2>
                    
                    <div class="profile-bio">
                        <h3 class="bio-title">Biography</h3>
                        <p><?php echo nl2br(htmlspecialchars($executive['description'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include './includes/footer.php'; ?>
</body>
</html>
