<?php 
session_start();
ini_set('display_errors', 1);

include 'includes.php';

if (isset($_POST['submit'])) {
    $blog_title = $_POST['blog_title'];
    $paragraph1 = $_POST['paragraph1']; 
    $paragraph2 = $_POST['paragraph2'];
    $paragraph3 = $_POST['paragraph3'];
    $author = $_POST['author'];
    $photo1 = $_FILES['photo1'];

     $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
     $max_size = 2 * 1024 * 1024; // 5MB

     $filename_1 = $photo1['name'];
     $file_ext_1 = pathinfo($filename_1, PATHINFO_EXTENSION);
     if ((!in_array(strtolower($file_ext_1), $allowed_types))) {
        $_SESSION['file_type']='Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed';
        header("location: manage-blogs.php");
        die();
     }

     if (($photo1['size'] > $max_size)) {
        $_SESSION['file_size']='File size should be below 2mb.';
        header("location: manage-blogs.php");
        die();
     }
     // Save file
     $filename_1 = uniqid().'.'.$file_ext_1;
     $destination = 'uploads/' .$filename_1;

    if ((!move_uploaded_file($photo1['tmp_name'], $destination))) {
        $_SESSION['file_error']='There was a Problem uploading the file';
        header("location: manage-blogs.php");
        die();
     }

    $query = "INSERT INTO blogs(blog_title,paragraph1,paragraph2,paragraph3,photo1,author) VALUES('$blog_title','$paragraph1','$paragraph2','$paragraph3','$filename_1','$author')";
    $query_exe = mysqli_query($connection,$query);

    if ($query_exe) {
        $_SESSION['file_success_upload']='Event uploaded successfuly.';
        header("location: manage-blogs.php");
    }else{
        "THERE WAS A PROBLEM IN UPLOADING YOUR BLOG.";
    }
}
else {
    echo "PRESS SUBMIT ON THE ADD BLOGPAGE";
}
?>