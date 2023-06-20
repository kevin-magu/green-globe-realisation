<?php 
include 'includes.php';

//take push to past events 

if (isset($_POST['submit'])) {
$eventID = $_POST['event_id'];
$first_query = "SELECT * FROM upcoming_events WHERE id = $eventID";
$result = mysqli_query($connection,$first_query);

$row = mysqli_fetch_assoc($result);
$event_title= $row['event_title'];
$place= $row['place'];
$date= $row['datee'];
$time  = $row['timee'];
$photo = $row['photo'];
$sql = "INSERT INTO past_events(event_title,place,datee,timee,photo), VALUES('$event_title','$place','$date','$time','$photo')";
$exe  = mysqli_query($connection,$sql);  

if ($exe) {
    echo "PUSHED SUCCESSFULLY";
}else{
    echo "ERROR PUSHING DATA";
}
}
?>