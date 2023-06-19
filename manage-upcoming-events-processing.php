<?php 
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
    $event_description = mysqli_real_escape_string($connection,$_POST['event_description']);
    $photo = $_FILES['photo'];

    // Validate file
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $max_size = 5 * 1024 * 1024; // 5MB
    $filename = $photo['name'];
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array(strtolower($file_ext), $allowed_types)) {
        die("Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
    }
    if ($photo['size'] > $max_size) {
        die("File size limit exceeded. Maximum file size is 5MB.");
    }

    // Save file
    $filename = uniqid().'.'.$file_ext;
    $destination = 'uploads/' .$filename;
    if (!move_uploaded_file($photo['tmp_name'], $destination)) {
        die("Failed to upload file.");
    }
    

    $sql = "INSERT INTO upcoming_events(event_title, place, datee, timee, event_description, photo) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $event_title, $place, $date, $time, $event_description, $filename);
                
    // Execute prepared statement
    if (mysqli_stmt_execute($stmt)) {
        header("location: manage-upcoming-events.html");
    } else {
        echo "Failed to upload data to database.";
    }
    // Close prepared statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    
}
    ?>
?>