<?php 
include 'includes.php';

ini_set('display_errors', 1);

//take push to past events 

if (isset($_POST['submit'])) {
$eventID = $_POST['event_id'];
$first_query = "SELECT * FROM upcoming_events WHERE id=$eventID";
$first_query_exe=mysqli_query($connection,$first_query);
$row = mysqli_fetch_assoc($first_query_exe);

$event_title = $row['event_title'];
$place = $row['place'];
$date = $row['datee'];
$time = $row['timee'];
$photo = $row['photo'];

$sql = "INSERT INTO past_events(event_title,place,datee,timee,photo) VALUES('$event_title','$place','$date','$time','$photo')";
$exe  = mysqli_query($connection,$sql);  

//delete from upcoming events
$delete_query = "DELETE FROM upcoming_events WHERE id=$eventID";
$delete_exe = mysqli_query($connection,$delete_query);
if ($exe) {
    echo "PUSHED SUCCESSFULLY";
}else{
    echo "ERROR PUSHING DATA";
}
if ($delete_exe) {
    echo "DELETED SUCCESSFULLY";
}else{
    echo "ERROR DELETING DATA";
}
header ("location: upcoming-events.php");
}
?>