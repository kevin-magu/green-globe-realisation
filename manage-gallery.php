<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="manage-upcoming-events.css">
    <link rel="stylesheet" href="admin.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery</title>
</head>
<body>
    <div class="admin-home-title">
        <p>GGR ADMIN PANEL</p>
    </div>
    <div class="admin-home-title">
        <p><u>MANAGE GALLERY</u></p>
    </div>
    <div class="form-container">
        <form action="manage-gallery-processing.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Make a new image entry</legend>
                <?php 
                if(isset($_SESSION['file_type'])){
                    echo $_SESSION['file_type'];
                }elseif (isset($_SESSION['file_size'])) {
                    echo $_SESSION['file_size'];
                }elseif (isset($_SESSION['file_error'])) {
                    echo $_SESSION['file_error'];
                }elseif (isset($_SESSION['file_success_upload'])) { 
                    echo $_SESSION['file_success_upload'];
                }
                session_unset();
                ?>
                <input type="text" name="image_title" placeholder="Enter the image title. eg 'planting trees at huruma estate'">

                <p><b>Choose an image below 2mb of size</b><input name='photo' type="file"></p>
                <button name='submit' type="submit">UPLOAD</button>
            </fieldset>
        </form>
    </div>

    <div class="main-links">
        <p><b>Quick Links</b></p>
        <ul>
            <a href="#"><li>ADMIN HOME</li></a>
            <a href="#"><li>MANAGE EVENTS</li></a>
            <a href="#"><li>ADD NEW BLOG</li></a>
            <a href="#"><li>MAIN WEBSITE</li></a>
            <a href="#"><li>BLOGS</li></a>
            <a href="#"><li>GALLERY</li></a>
        </ul>
    </div>
</body>
</html>