<?php 
ini_set ('display_errors', 1);
include 'includes.php';
$query = "SELECT * FROM blogs";
$query_exe = mysqli_query($connection,$query);

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <script
      src="https://kit.fontawesome.com/e4c074505f.js"
      crossorigin="anonymous"
    ></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Genos:ital,wght@1,300&display=swap");
    </style>
    <link rel="stylesheet" href="blog-cards.css"/>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BLOGS</title>
  </head>
  <body>
    <nav class="nav1">
      <ul>
        <a href=""><li>Home</li></a>
        <a href="#aboutus"><li>About Us</li></a>
        <a href="#events"><li>Events</li></a>
        <a href=""><li>Blog</li></a>
        <a href=""><li>Donate</li></a>
        <a href=""><li>Contacts</li></a>
      </ul>
    </nav>
    
    <nav class="nav2">
      <ul>
        <a href=""><li>Home</li></a>
        <a href="#aboutus"><li>About Us</li></a>
        <a href="#events"><li>Events</li></a>
        <a href=""><li>Blog</li></a>
        <a href=""><li>Donate</li></a>
        <a href=""><li>Contacts</li></a>
      </ul>
      <p>Plant For The Planet</p>
    </nav>
    <div class="menu-div">
      <i class="fa-solid fa-bars menu-bars" id="black-icon"></i>
    </div>
    <div class="menu-div">
      <i class="fa-solid fa-xmark cancel-bars" id="black-icon"></i>
    </div>
    <div class="gallery-description-title  page-title">
      <p>Blogs</p>
    </div>
    <div class="blogs-container">
      <?php if ($query_exe && mysqli_num_rows($query_exe) > 0) { ?>
        <?php while ($row = mysqli_fetch_assoc($query_exe)) { ?>
        <?php $wordsToRetrieve_title = 46;
        $paragraph = $row['paragraph1'];
        $wordArray = str_word_count($paragraph, 1); // Split paragraph into an array of words
        $teaser_title = implode(' ', array_slice($wordArray, 0, $wordsToRetrieve_title)); // Join the first 30 words
         ?>
      <div class="blog-brief-card">
        <div class="blog-brief-card-picture" style="background-image: url('uploads/<?php echo $row['photo1']; ?>'">
          <div class="blog-brief-card-overlay">
            <div class="blog-brief-card-picture-section-content">
              <p> <?php echo $row['blog_title']?></p>
            </div>
          </div>
        </div>
        <div class="blog-brief-card-description">
          <p>
          <?php echo $teaser_title ?> ...
          </p>
          <form action="">
            <input type="hidden" value="<?php echo $row['id'] ?>">
            <p><a href="#">Read More</a></p>
          </form>
        </div>
      </div>

      <?php }?> 

      <?php  } else{
        echo "THERE ARE NO BLOGS YET";
      } ?>
    </div>
    <footer>
      <div class="footer-upper-column">
        <div class="upper-column-section1">
          <form action="">
            <p class="footer-title">Leave us a Message</p>
            <input type="text" />
            <textarea name="" id="" cols="30" rows="10"></textarea>
            <button type="submit">Send</button>
          </form>

          <div class="contacts">
            <p class="footer-title">Contacts</p>
            <p class="footer-content">
              <i class="fa-solid fa-envelope"></i>
              info@greengloberealisation.org
            </p>
            <p class="footer-content">
              <i class="fa-solid fa-phone"></i> 0722465663
            </p>
            <p class="footer-content">
              <i class="fa-brands fa-whatsapp"></i> 0722465663
            </p>
            <p class="footer-content">
              <i class="fa-sharp fa-solid fa-location-dot"></i> 680 Hotel,
              Kenyatta Avenue
            </p>
          </div>
        </div>
        <div class="upper-column-section2">
          <div class="quick-links">
            <p class="footer-title">Quick Links</p>
            <p class="footer-content"><a href="">Back to top</a></p>
            <p class="footer-content"><a href="">Blogs</a></p>
            <p class="footer-content"><a href="">Gallery</a></p>
            <p class="footer-content"><a href="">About Us</a></p>
          </div>
          <div class="donate">
            <p class="footer-title">Donate</p>
            <p class="footer-content">
              <i class="fa-solid fa-dollar-sign"></i> Mpesa
            </p>
            <p class="footer-content">
              <i class="fa-brands fa-paypal"></i> PayPal
            </p>
          </div>
          <div class="patners">
            <p class="footer-title">
              <i class="fa-solid fa-handshake"></i> Patners
            </p>
            <a
              href="https://climateconnect.earth/organizations/GlobalEnvironmentalandClimateConservationInitiative(GECCI)224"
              >GECCI</a
            >
          </div>
        </div>
      </div>
      <div class="footer-line">
        <hr />
      </div>
      <div class="footer-lower-column">
        <div class="social-links">
          <ul>
            <li>
              <a href=""><i class="fa-brands fa-twitter"></i></a>
            </li>
            <li>
              <a href=""><i class="fa-brands fa-linkedin"></i></a>
            </li>
            <li>
              <a href=""><i class="fa-brands fa-facebook"></i></a>
            </li>
            <li>
              <a href=""><i class="fa-brands fa-instagram"></i></a>
            </li>
            <li>
              <a href=""><i class="fa-brands fa-whatsapp"></i></a>
            </li>
          </ul>
        </div>
        <div class="copyrignt">
          <p>&copy; 2023 Green Globe Realisation | All rignts reserved</p>
        </div>
      </div>
    </footer>
    <script src="app.js"></script>
  </body>
</html>
