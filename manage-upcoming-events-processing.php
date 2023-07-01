<?php 
session_start();
include 'includes.php';
ini_set('display_errors', 1);

 if (isset($_POST['submit'])) {
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //take form data
    $event_title = mysqli_real_escape_string($connection,$_POST['event_title']);
    $place = mysqli_real_escape_string($connection,$_POST['place']);
    $date= mysqli_real_escape_string($connection,$_POST['datee']);
    $time = mysqli_real_escape_string($connection,$_POST['timee']);
    $photo = $_FILES['photo'];

    // Validate file
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $max_size = 5 * 1024 * 1024; // 5MB
    $filename = $photo['name'];
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array(strtolower($file_ext), $allowed_types)) {
        die();
        $_SESSION['file_type']='Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed';
        header("location: manage-upcoming-events.php");
    }
    if ($photo['size'] > $max_size) {
        die("File size limit exceeded. Maximum file size is 2MB.");
        $_SESSION['file_size']='Maximum file size is 2MB.';
        header("location: manage-upcoming-events.php");
    }

    // Save file
    $filename = uniqid().'.'.$file_ext;
    $destination = 'uploads/' .$filename;
    if (!move_uploaded_file($photo['tmp_name'], $destination)) {
        $_SESSION['file_error']='File should be an image.';
        $_SESSION['file_size']='File size should be below 2mb.';
        header("location: manage-upcoming-events.php");
    }
    

    $sql = "INSERT INTO upcoming_events(event_title, place, datee, timee, photo) VALUES (?,?,?,?,?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $event_title, $place, $date, $time, $filename);
                
    // Execute prepared statement
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['file_success_upload']='File uploaded successfuly.';
        header("location: manage-upcoming-events.php");
    } else {
        echo "Failed to upload data to database.";
    }
    // Close prepared statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    
}
    ?>
?>