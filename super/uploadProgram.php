

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGR</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/uploadProgram.css">
</head>
<body>
    <?php include  './includes/adminNav.php'?>
    <section class="upload-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">New Program</span>
                <h2 class="section-title">Upload Program Details</h2>
                <p class="section-subtitle">Add a new environmental program to inspire action and track impact.</p>
            </div>

            <form id='uploadProgramForm' class="upload-form" enctype="multipart/form-data">
                <div id="feedback" style="color: green; margin-top: 10px;"></div>
                 <!-- File Upload -->
                <div class="form-group file-upload">
                    
                    <label for="projectImages">Upload Project Images</label>
                    <div class="drop-zone" id="dropZone">
                        <p>click here or drag and drop ONE image that represents your program.</p>
                        <input type="file" id="programImages" name="projectImages[]" accept="image/*">
                    </div>
                    <div class="preview-container" id="previewContainer"></div>
                </div>

                <!-- Program Name -->
                <div class="form-group">
                    <label for="programName">Program Name</label>
                    <input type="text" id="programName" name="programName" placeholder="e.g., Green Cities Initiative" required>
                </div>

                 <!-- Program Tagline -->
                <div class="form-group">
                    <label for="programName">Program Tagline</label>
                    <input type="text" id="programTagline" name="programTagline" placeholder="e.g., Restoring Kenya's forests through community-led tree planting initiatives" required>
                </div>

                <!-- Program Symbol (Emoji or Letter) -->
                <div class="form-group">
                    <label for="programSymbol">Program Symbol (Emoji or Letter)</label>
                    <input type="text" id="programSymbol" name="programSymbol" placeholder="e.g., 🌳 or G" maxlength="2" required>
                    <p class="form-hint">Enter a single emoji or letter to represent the program.</p>
                </div>

                <!-- Program Description -->
                <div class="form-group">
                    <label for="programDescription">Program Description</label>
                    <textarea id="programDescription" name="programDescription" rows="6" placeholder="Describe the program's goals and impact..." required></textarea>
                </div>
                <!-- Program Objectives -->
                <div class="form-group">
                    <label for="programObj1">Program first objective</label>
                    <input id="programObj1" name="programObj1" placeholder="eg Replant native tree species to restore biodiversity and ecological functions in degraded areas" required></input>
                </div>

                <div class="form-group">
                    <label for="programObj2">Program second objective</label>
                    <input id="programObj2" name="programObj2" placeholder="eg Improve water catchment capacity in critical river source areas" required></input>
                </div>
                <div class="form-group">
                    <label for="programObj3">Program third objective</label>
                    <input id="programObj3" name="programObj3" placeholder="eg Create sustainable livelihoods through forest-related enterprises" required></input>
                </div>

                <div class="form-group">
                    <label for="programObj4">Program fourth objective</label>
                    <input id="programObj4" name="programObj4" placeholder="eg Enhance carbon sequestration and local climate regulation" required></input>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit Program</button>
            </form>
        </div>
    </section>

    <footer class="upload-footer">
        <div class="container">
            <p>© <?php echo date('Y'); ?> Green Globe Realisation. All rights reserved.</p>
        </div>
    </footer>
<script src="./apis/uploadProgram.js"></script>
</body>
</html>