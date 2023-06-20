<?php 
include 'includes.php';

$query = "SELECT id,event_title,place,datee,timee,photo FROM upcoming_events";
$result = mysqli_query($connection,$query);
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
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="upcoming-events.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
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
    <i class="fa-solid fa-bars menu-bars"></i>
  </div>
  <div class="menu-div">
    <i class="fa-solid fa-xmark cancel-bars"></i>
  </div>

      <div class="upcoming-events-title">
        Upcoming Events
      </div>
      <div class="upcoming-events-container">
        <?php while($row=mysqli_fetch_assoc($result)) {?>
        <div class="event-card">
            <div class="event-description-pic" style="background-image: url('uploads/<?php echo $row['photo']; ?>');">
                <div class="event-card-overlay"></div>
                <div class="event-card-title"><?php echo $row['event_title']; ?></div>
            </div>
            <div class="event-description">
                <p id="where"><b>WHERE: </b> <?php echo $row['place'];?></p>
                <p id="when"><b>WHEN: </b><?php echo $row['datee']; ?></p>
                <p id="time"><b>TIME: </b><?php echo $row['timee']; ?></p>
                <button class="enqure-more">Enquire more via email</button>
                <form action="push-to-past-events.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="timee" value="<?php echo $row['datee'];?>">
                  <input type="hidden"name="timee" value="<?php echo $row['timee'];?>">
                  <input type="hidden" name="place" value="<?php echo $row['place'];?>">
                  <input type="hidden"name="event_title" value="<?php echo $row['event_title'];?>">
                  <input type="hidden"name="photo" value="<?php echo $row['photo'];?>">
                  <input type="text" name="event_id"  value="<?php echo $row['id']; ?>">
                  <button name="submit" class="mark-as-done enqure-more" >Mark as done</button>
                </form>
            </div>
        </div>
        <?php } ?>
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
