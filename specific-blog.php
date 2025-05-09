<?php 
ini_set('display_errors', 1);
include 'includes.php';
if (isset($_POST['read-more'])) {
  $blog_id = $_POST['id'];
  $query = "SELECT * FROM blogs WHERE id= $blog_id";
  $query_exe = mysqli_query($connection,$query);
  $row = mysqli_fetch_assoc($query_exe);
}else{
  header("location: blog-cards.php");
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
  <style>
      @import url("https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Genos:ital,wght@1,300&family=Mate+SC&family=Roboto+Flex:wght@500&display=swap");
    </style>
    <script
    src="https://kit.fontawesome.com/e4c074505f.js"
    crossorigin="anonymous"
  ></script>
    <link rel="stylesheet" href="index.css" />
    <link rel="stylesheet" href="specific-blog.css" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $row['blog_title'] ?></title>
  </head>
  <body>
    <nav class="nav1">
      <ul>
      <a href="index.php"><li><i class="fa-solid fa-house"></i>Home</li></a>
      <a href="index.php#aboutus"><li><i class="fa-solid fa-circle-info"></i> About Us</li></a>
      <a href="upcoming-events.php"><li><i class="fa-solid fa-calendar-days"></i> Events</li></a>
      <a href="gallery.php"><li><i class="fa-solid fa-camera"></i> Gallery</li></a>
      <a href="blog-cards.php"><li><i class="fa-solid fa-blog"></i> Blogs</li></a>
      <a href="#contacts"><li><i class="fa-solid fa-circle-dollar-to-slot"></i> Donate</li></a>
      <a href="#contacts"><li><i class="fa-solid fa-phone"></i>Contacts</li></a>
      </ul>
    </nav>
    
    <nav class="nav2">
      <ul>
      <a href="index.php"><li><i class="fa-solid fa-house"></i>  Home</li></a>
      <a href="index.php#aboutus"><li><i class="fa-solid fa-circle-info"></i> About Us</li></a>
      <a href="upcoming-events.php"><li><i class="fa-solid fa-calendar-days"></i> Events</li></a>
      <a href="gallery.php"><li><i class="fa-solid fa-camera"></i> Gallery</li></a>
      <a href="blog-cards.php"><li><i class="fa-solid fa-blog"></i> Blogs</li></a>
      <a href="#contacts"><li><i class="fa-solid fa-circle-dollar-to-slot"></i> Donate</li></a>
      <a href="#contacts"><li><i class="fa-solid fa-phone"></i> Contacts</li></a>
      </ul>
      <p>Plant For The Planet</p>
    </nav>
    <div class="menu-div">
      <i class="fa-solid fa-bars menu-bars" style="margin-top: 40px; color:"></i>
    </div>
    <div class="menu-div">
      <i class="fa-solid fa-xmark cancel-bars" style="margin-top: 40px;"></i>
    </div>

    <div class="blog-header">
      <div class="overlay"></div>
      <p><?php echo $row['blog_title']  ?></p> <span></span>
      <p><h4 style="color: white; z-index: 1;
      position: absolute;
      top: 0; left: 0;
      ">GGR BLOGS</h4></p>
    </div>
    <div class="blog-container">
      <div class="blog-text-content">
      <div class="blog-introduction">
        <p>
          <?php echo $row['paragraph1']; 
          ?>
        </p>
      </div>
      <div class="blog-conclusion">
        <p>
        <?php echo $row['paragraph2'];?>
        </p>
      </div>
      <div class="blog-conclusion">
        <p>
        <?php echo $row['paragraph3'];?>
        </p>
      </div>

      <p class="author"><b>Author: <i><?php echo $row['author'] ?></i></b></p>
      <p><a href="blog-cards.php">Read More blogs</a></p>
      </div>
      <div class="specific-blog-pictures">
        <div class="blog-picture-card blog-picture-card1" style="background-image: url('uploads/<?php echo $row['photo1']; ?>');
        background-repeat: no-repeat;
           background-position: center;
        "></div>
        
      </div>
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

          <div class="contacts" id="contacts">
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
    <script>
      // Function to handle the screen resize event
  function handleResize() {
  var screenWidth = window.innerWidth || document.documentElement.clientWidth;
  var menuBars = document.querySelector('.menu-bars');
  var menuBars2 = document.querySelector('.cancel-bars');
  var menuBars3 = document.querySelector('.menu-div');
  var nav2 = document.querySelector('.nav2');

  if (screenWidth > 1180) {
    // Hide the .menu-bars class
    menuBars.style.display = 'none';
    menuBars2.style.display = 'none';
  } else{
    // Show the .menu-bars class
    menuBars.style.display='block';
    menuBars2.style.display='none';
    nav2.style.display='none';
  }
}

// Add event listener for the resize event
window.addEventListener('resize', handleResize);
    </script>
    <script src="app.js"></script>
  </body>
</html>
