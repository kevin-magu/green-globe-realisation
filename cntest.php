<?php
ini_set('display_errors', 1);
$server = 'localhost';
$username = 'root';
$password = 'Zulu2003mysql';
$database = 'ggr'; 

$connection = mysqli_connect($server,$username,$password,$database);

echo 'Hello world';
if($connection){
    echo 'Connection 200';
}else{
    echo  'connection 500';
}
?>