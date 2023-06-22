<?php 
ini_set('display_errors', 1);

include 'includes.php';

if (isset($_POST['submit'])) {
    $blog_title = $_POST['blog_title'];
    $paragraph1 = $_POST['paragraph1']; 
    $paragraph2 = $_POST['paragraph2'];
    $paragraph3 = $_POST['paragraph3'];
    $author = $_POST['author'];
    $photo1 = $_FILES['photo1'];
    $photo2 = $_FILES['photo2'];
    $photo3 = $_FILES['photo3'];
    
     $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
     $max_size = 5 * 1024 * 1024; // 5MB

     $filename_1 = $photo1['name'];
     $filename_2 = $photo2['name'];
     $filename_3 = $photo3['name'];
     $file_ext_1 = pathinfo($filename_1, PATHINFO_EXTENSION);
     $file_ext_2= pathinfo($filename_2, PATHINFO_EXTENSION);
     $file_ext_3 = pathinfo($filename_3, PATHINFO_EXTENSION);
     if ((!in_array(strtolower($file_ext_1), $allowed_types)) || (!in_array(strtolower($file_ext_2), $allowed_types)) || (!in_array(strtolower($file_ext_3), $allowed_types))) {
         die("Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
     }

     if (($photo1['size'] > $max_size) || ($photo2['size'] > $max_size) || ($photo3['size'] > $max_size)) {
         die("File size limit exceeded. Maximum file size is 5MB.");
     }
     // Save file
     $filename_1 = uniqid().'.'.$file_ext_1;
     $destination = 'uploads/' .$filename_1;

     $filename_2 = uniqid().'.'.$file_ext_2;
     $destination = 'uploads/' .$filename_2;
     
     $filename_3 = uniqid().'.'.$file_ext_3;
     $destination = 'uploads/' .$filename_3;

    if ((!move_uploaded_file($photo1['tmp_name'], $destination)) || (!move_uploaded_file($photo2['tmp_name'], $destination)) || (!move_uploaded_file($photo3['tmp_name'], $destination))) {
     die("Failed to upload file.");
     }

    $query = "INSERT INTO blogs(blog_title,paragraph1,paragraph2,paragraph3,photo1,photo2,photo3,author) VALUES('$blog_title','$paragraph1','$paragraph2','$paragraph3','$filename_1','$filename_2','$filename_3','$author')";
    $query_exe = mysqli_query($connection,$query);

    if ($query_exe) {
        echo "UPLOAD WAS SUCCESSFUL";
    }else{
        "THERE WAS A PROBLEM IN UPLOADING YOUR BLOG.";
    }
}
else {
    echo "PRESS SUBMIT ON THE ADD BLOGPAGE";
}
?>