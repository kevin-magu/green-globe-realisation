<?php 
session_start();
//if (isset($_SESSION['username'])) {

    include 'includes.php';
    $query = "SELECT * FROM trees;";
    $query_exe = mysqli_query($connection,$query);

    $row = mysqli_fetch_assoc($query_exe);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <div class="admin-home-title">
        <p>GGR ADMIN PANEL</p>
    </div>
    <div class="welcome-message">
        <p>Welcome Admin <span><?php echo $_SESSION['username'] ?></span></p>
        <p>System is under maintenance.</p>
        <?php 
        
        ?>
    </div>

    <div class="admin-page-cards-container">
        <div class="admin-page-card admin-page-card1">
            <p><b><a href="manage-upcoming-events.php" target="_blank">MANAGE EVENTS</a></b></p>
        </div>
        <div class="admin-page-card admin-page-card2">
            <p><b><a href="manage-gallery.php" target="_blank">MANAGE GALLERY</a></b></p>
        </div>
        <div class="admin-page-card admin-page-card3">
            <p><b><a href="manage-blogs.php" target="_blank">MANAGE BLOGS</a></b></p>
        </div>

        <h4>NUMBER OF TREES PLANTED</h4>
        <p class="no-of-trees"><?php echo $row['no_of_trees'] ?></p>


        <form action="add-trees.php" method='POST' id="add-trees">
            <input type="text" name='no_of_trees' placeholder="input no of trees you want to add"> <button class="add-trees-button" name='add-tree'>Add Trees</button>
        </form>

    </div>
<div class="main-links">
    <p><b>Quick Links</b></p>
    <ul style="font-size: 12px;">
        <a href="index.html"><li>MAIN WEBSITE</li></a>
        <a href="blog-cards.php"><li>BLOGS</li></a>
        <a href="gallery.php"><li>GALLERY</li></a>
        <a href="admin-new-user.php"><li>Create User</li></a>
    </ul>
</div>
 
</body>
</html>