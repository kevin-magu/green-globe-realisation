<?php 
include 'includes.php';
init_set('display_errors', 1);
//take push to past events 

if (isset($_POST['submit'])) {
$eventID = $_POST['event_id'];
$event_title = $_POST['event_title'];
$place = $_POST['place'];
$time = $_POST['timee'];
$date = $_POST['datee'];
$time = $_POST['photo'];

$sql = "INSERT INTO past_events(event_title,place,datee,timee,photo), VALUES('$event_title','$place','$date','$time','$photo')";
$exe  = mysqli_query($connection,$sql);  

if ($exe) {
    echo "PUSHED SUCCESSFULLY";
}else{
    echo "ERROR PUSHING DATA";
}
}
?>