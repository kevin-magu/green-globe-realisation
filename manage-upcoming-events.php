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
    <title>Manage Events</title>
</head>
<body>
    <div class="admin-home-title">
        <p>GGR ADMIN PANEL</p>
    </div>
    <div class="admin-home-title">
        <p><u>MANAGE UPCOMING EVENTS</u></p>
    </div>
    <div class="form-container">
        <form action="manage-upcoming-events-processing.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Make new event  entry</legend>
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
                <input type="text" name="event_title" placeholder="Enter the title of the event" >
                <input type="text" name="place" placeholder="Enter where the event will occur" >
                <input type="text" name="datee" placeholder="Enter when the event will occur (date)" >
                <input type="text" name="timee" placeholder="Enter the time the event will occur" >
                <p style="font-size: 12px;"><b>Image related to the event. Below 2mb of size.</b><input type="file" name="photo" ></p>
                <button name="submit">UPLOAD</button>
            </fieldset>
        </form>
    </div>
    
</body>
</html>