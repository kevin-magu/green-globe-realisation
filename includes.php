<?php 
$server = "localhost";
$username = "root";
$password = "root";
$database = "ggr_test";

$connection = mysqli_connect($server,$username,$password,$database);
if(!$connection){
    die("Database connection failed" . mysqli_connect_error());
}
?>

