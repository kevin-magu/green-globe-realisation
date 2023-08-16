<?php 
session_start();
ini_set('display_errors', 1);

include 'includes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $blog_title = $_POST['blog_title'];
        $paragraph1 = $_POST['paragraph1']; 
        $paragraph2 = $_POST['paragraph2'];
        $paragraph3 = $_POST['paragraph3'];
        $author = $_POST['author'];
        $photo1 = $_FILES['photo1'];

        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $max_size = 2 * 1024 * 1024; // 2MB

        $filename_1 = $photo1['name'];
        $file_ext_1 = pathinfo($filename_1, PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_ext_1), $allowed_types)) {
            $_SESSION['file_type'] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed';
            header("Location: manage-blogs.php");
            die();
        }

        if ($photo1['size'] > $max_size) {
            $_SESSION['file_size'] = 'File size should be below 2MB.';
            header("Location: manage-blogs.php");
            die();
        }
        
        // Save file with unique name
        $filename_1 = uniqid().'.'.$file_ext_1;
        $destination = 'uploads/' .$filename_1;

        if (!move_uploaded_file($photo1['tmp_name'], $destination)) {
            $_SESSION['file_error'] = 'There was a problem uploading the file';
            header("Location: manage-blogs.php");
            die();
        }

        // Assuming $connection is established correctly
        $query = "INSERT INTO blogs (blog_title, paragraph1, paragraph2, paragraph3, photo1, author) VALUES ('$blog_title', '$paragraph1', '$paragraph2', '$paragraph3', '$filename_1', '$author')";
        $query_exe = mysqli_query($connection, $query);

        if ($query_exe) {
            $_SESSION['file_success_upload'] = 'Blog uploaded successfully.';
            header("Location: manage-blogs.php");
        } else {
            $_SESSION['file_error'] = 'There was a problem in uploading your blog.';
            header("Location: manage-blogs.php");
        }
    } else {
        echo "PRESS SUBMIT ON THE ADD BLOG PAGE";
    }
} else {
    echo "Invalid request method.";
}
?>
