<?php
// Connect to DB first (assuming $conn is available globally)
include '../includes/connection.php';

$programs = [];
$sql = "SELECT programName FROM programs";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $programs[] = $row['programName'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGR - Upload Project</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/uploadProject.css">
</head>
<body>
    <?php include './includes/adminNav.php' ?>

    <section class="upload-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">New Project</span>
                <h2 class="section-title">Upload Project Details</h2>
                <p class="section-subtitle">Share your environmental initiative to inspire and track progress.</p>
            </div>

            <form enctype="multipart/form-data" class="upload-form">
                <div id="feedback" style="color: green; margin-top: 10px;"></div>
                <!-- File Upload -->
                <div class="form-group file-upload">
                    <label for="projectImages">Upload Project Images</label>
                    <div class="drop-zone" id="dropZone">
                        <p>Drag & Drop images here or click to upload</p>
                        <input type="file" id="fileInput" name="projectImages[]" accept="image/*" multiple>
                    </div>
                    <div class="preview-container" id="previewContainer"></div>
                </div>

                <!-- Program Name (dropdown) -->
                <div class="form-group">
                    <label for="programName">Program</label>
                    <select id="programName" name="programName" required>
                        <option value="" disabled selected>Select program</option>
                        <?php foreach ($programs as $program): ?>
                            <option value="<?php echo htmlspecialchars($program); ?>">
                                <?php echo htmlspecialchars($program); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Project Title -->
                <div class="form-group">
                    <label for="projectTitle">Project Title</label>
                    <input type="text" id="projectTitle" name="projectTitle" placeholder="e.g., City Park Restoration" required>
                </div>

                <!-- Project Status -->
                <div class="form-group">
                    <label for="projectStatus">Project Status</label>
                    <select id="projectStatus" name="projectStatus" required>
                        <option value="" disabled selected>Select status</option>
                        <option value="active">Active</option>
                        <option value="complete">Complete</option>
                        <option value="new">Upcoming</option>
                    </select>
                </div>

                <!-- Impact Value and Label 1 -->
                <div class="form-group">
                    <label for="impactValue1">Impact Value 1</label>
                    <input type="text" id="impactValue1" name="impactValue1" placeholder="e.g., 3000+" required>
                </div>

                <div class="form-group">
                    <label for="impactLabel1">Impact Label 1</label>
                    <input type="text" id="impactLabel1" name="impactLabel1" placeholder="e.g., Trees Planted" required>
                </div>

                <!-- Impact Value and Label 2 -->
                <div class="form-group">
                    <label for="impactValue2">Impact Value 2</label>
                    <input type="text" id="impactValue2" name="impactValue2" placeholder="e.g., 20+" required>
                </div>

                <div class="form-group">
                    <label for="impactLabel2">Impact Label 2</label>
                    <input type="text" id="impactLabel2" name="impactLabel2" placeholder="e.g., Communities Helped" required>
                </div>

                <!-- Project Description -->
                <div class="form-group">
                    <label for="projectDescription">Project Description</label>
                    <textarea id="projectDescription" name="projectDescription" rows="6" placeholder="Describe the project goals and impact..." required></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" id='submitBtn' class="btn btn-primary">Submit Project</button>
            </form>
        </div>
    </section>

    <footer class="upload-footer">
        <div class="container">
            <p>© <?php echo date('Y'); ?> Green Globe Realisation. All rights reserved.</p>
        </div>
    </footer>

    <script src='./apis/uploadProject.js'></script>
</body>
</html>
