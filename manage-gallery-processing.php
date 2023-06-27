<?php 
include 'includes.php';
ini_set('display_errors', 1);
if (isset($_POST['submit'])) {
    $image_title = $_POST['image_title'];
    $photo = $_FILES['photo'];


    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $max_size = 2 * 1024 * 1024; // 5MB
    $filename = $photo['name'];
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array(strtolower($file_ext), $allowed_types)) {
        die("Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
    }
    if (($photo['size']) < $max_size) {
        die("File size limit exceeded. Maximum file size is 2MB.");
    }

    // Save file
    $filename = uniqid().'.'.$file_ext;
    $destination = 'uploads/' .$filename;
    if (!move_uploaded_file($photo['tmp_name'], $destination)) {
        die("Failed to upload file.");
    }
    
    $query = "INSERT INTO gallery(image_title,photo)VALUES('$image_title', '$filename')";
    $exe = mysqli_query($connection,$query);
    if ($exe) {
        echo "FILED UPLOADED SUCCESSIFULLY";

    }else{
        echo "ERROR UPLOADING FILE";
    }
}
?>