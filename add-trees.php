<?php
include 'includes.php';

if(isset($_POST['add-tree'])){
    //take the POST request
//get no of trees in the db
$get_trees = "SELECT * FROM trees";
$get_trees_exe = mysqli_query($connection,$get_trees);
$row = mysqli_fetch_assoc($get_trees_exe);


$no_of_trees = $_POST['no_of_trees'] + $row['no_of_trees'];
echo $no_of_trees;

$query = "UPDATE trees SET no_of_trees = '$no_of_trees'";
$query_exe = mysqli_query($connection, $query_exe);

if($query_exe){
    header("Location: admin.php");
}

}else{
    header("Location: admin.php");
}

?>