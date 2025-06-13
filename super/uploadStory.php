<?php
ini_set('display_errors', 1); 
include '../includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGR | Story</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/uploadStory.css">
</head>
<body>
    <?php include './includes/adminNav.php' ?>

    <section class="story-upload-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Share Your Experience</span>
                <h2 class="section-title">Upload Your Conservation Story</h2>
                <p class="section-subtitle">Inspire others by sharing your environmental journey and impact.</p>
            </div>

            <form class="story-upload-form" method="POST" action="uploadStoryHandler.php" enctype="multipart/form-data">
                <div id="feedback" style="color: green; margin-top: 10px;"></div>
                <!-- Image Upload -->
                <div class="form-group file-upload">
                    <label>Upload Story Images</label>
                    <div class="upload-area">
                        <div class="drop-zone" id="dropZone">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p>Drag & drop images here or click to browse</p>
                            <input type="file" id="fileInput" name="storyImages[]" accept="image/*" multiple required>
                        </div>
                        <div class="preview-container" id="previewContainer"></div>
                    </div>
                </div>

                <!-- Program Name -->
                <div class="form-group">
                    <label for="programName">Program Name</label>
                    <select id="programName" name="programName" required>
                        <option value="" disabled selected>Select program</option>
                        <?php
                        $sql = "SELECT programId, programName FROM programs ORDER BY programId ASC";
                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $programId = htmlspecialchars($row['programId']);
                                $programName = htmlspecialchars($row['programName']);
                                echo "<option value=\"$programName\">$programName</option>";
                            }
                        } else {
                            echo "<option disabled>No programs available</option>";
                        }
                        ?>
                    </select>
                    <i class="fas fa-chevron-down select-icon"></i>
                </div>

                <!-- Story Title -->
                <div class="form-group">
                    <label for="storyTitle">Story Title</label>
                    <input type="text" id="storyTitle" name="storyTitle" placeholder="e.g., How We Restored the Local Forest" required>
                </div>

                <!-- Location -->
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="e.g., Nairobi, Kenya" required>
                    <i class="fas fa-map-marker-alt input-icon"></i>
                </div>

                <!-- Story Description -->
                <div class="form-group">
                    <label for="storyDescription">Your Story</label>
                    <textarea id="storyDescription" name="storyDescription" rows="8" placeholder="Tell us about your experience, the challenges you faced, and the impact you made..." required></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <i class="fas fa-share"></i> Upload
                </button>
            </form>
        </div>
    </section>

    <footer class="upload-footer">
        <div class="container">
            <p>© <?php echo date('Y'); ?> Green Globe Realisation. All rights reserved.</p>
        </div>
    </footer>
<script src='./apis/uploadStory.js'></script>
</body>
</html>
