<?php 
if (isset($_POST['login'])) {
    

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
        <p>You're welcome <span>Admin Farah</span></p>
    </div>

    <div class="admin-page-cards-container">
        <div class="admin-page-card admin-page-card1">
            <p><b>MANAGE EVENTS</b></p>
        </div>
        <div class="admin-page-card admin-page-card2">
            <p><b>MANAGE GALLERY</b></p>
        </div>
        <div class="admin-page-card admin-page-card3">
            <p><b>MANAGE BLOGS</b></p>
        </div>
    </div>
<div class="main-links">
    <p><b>Quick Links</b></p>
    <ul>
        <a href="#"><li>MAIN WEBSITE</li></a>
        <a href="#"><li>BLOGS</li></a>
        <a href="#"><li>GALLERY</li></a>
    </ul>
</div>
<?php }else{
    header("location: admin-login.php");
    }?>
</body>
</html>