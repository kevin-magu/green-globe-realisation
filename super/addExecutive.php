<?php
ini_set('display_errors', 1); 
include '../includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGR | Add Executive</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/addExecutive.css">
</head>
<body>
    <?php include './includes/adminNav.php' ?>

    <section class="executive-add-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Team Management</span>
                <h2 class="section-title">Add New Executive</h2>
                <p class="section-subtitle">Add a new team member to the executive board.</p>
            </div>

            <form class="executive-add-form" method="POST" action="addExecutiveHandler.php" enctype="multipart/form-data">
                <div id="feedback" style="color: green; margin-top: 10px;"></div>
                
                <!-- Profile Picture Upload -->
                <div class="form-group file-upload">
                    <label>Profile Picture</label>
                    <div class="upload-area">
                        <div class="drop-zone" id="dropZone">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p>Drag & drop profile photo or click to browse</p>
                            <input type="file" id="fileInput" name="profilePicture" accept="image/*" required>
                        </div>
                        <div class="preview-container" id="previewContainer"></div>
                    </div>
                </div>

                <!-- Executive Name -->
                <div class="form-group">
                    <label for="executiveName">Full Name</label>
                    <input type="text" id="executiveName" name="executiveName" placeholder="e.g., John Doe" required>
                </div>

                <!-- Position -->
                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="text" id="position" name="linkedin" placeholder="Eg Team leader">
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Bio/Description</label>
                    <textarea id="description" name="description" rows="6" placeholder="Brief description about the executive..." required></textarea>
                </div>

                <!-- Social Media Links -->
                <div class="form-group">
                    <label for="linkedin">LinkedIn (optional)</label>
                    <input type="url" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/username">
                    <i class="fab fa-linkedin input-icon"></i>
                </div>

                <div class="form-group">
                    <label for="twitter">Twitter (optional)</label>
                    <input type="url" id="twitter" name="twitter" placeholder="https://twitter.com/username">
                    <i class="fab fa-twitter input-icon"></i>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i> Add Executive
                </button>
            </form>
        </div>
    </section>

    <footer class="upload-footer">
        <div class="container">
            <p>© <?php echo date('Y'); ?> Green Globe Realisation. All rights reserved.</p>
        </div>
    </footer>
    <script src='./apis/addExecutive.js'></script>
</body>
</html>