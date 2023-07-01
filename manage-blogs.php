<?php 
session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="admin.css" />
    <link rel="stylesheet" href="manage-upcoming-events.css" />
    <link rel="stylesheet" href="manage-blogs.css" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Blog</title>
  </head>
  <body>
    <div class="admin-home-title">
      <p>GGR ADMIN PANEL</p>
    </div>
    <div class="admin-home-title">
      <p><u>MANAGE BLOG</u></p>
    </div>
    <div class="form-container">
      <form action="manage-blogs-processing.php" method="POST" enctype="multipart/form-data">
        <fieldset>
          <legend>Make a new blog entry</legend>
          <input type="text" name="blog_title" placeholder="Blog title">
          <textarea name="paragraph1" id="myTextarea" cols="30" rows="10" placeholder="introduction"></textarea>
          <textarea name="paragraph2" id="" cols="30" rows="10" placeholder="paragraph1"></textarea>
          <textarea name="paragraph3" id="" cols="30" rows="10" placeholder="paragraph2"></textarea>
          <textarea name="paragraph4" id="" cols="30" rows="10" placeholder="paragraph3"></textarea>
           <input name="author" type="text" placeholder="author">
          <p>Choose an image related to the blog.</p>
          <p>Image size should be below 2mb.</p>
          <p><b>Choose image 1 </b><input name="photo1" type="file" /></p>
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
          <button name="submit" type="submit">POST</button>
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
