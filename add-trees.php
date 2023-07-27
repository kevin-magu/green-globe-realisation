<?php
session_start();
include 'includes.php';
ini_set('display_errors', 1);

//take the POST request
if(isset($_POST['add-tree'])){
    
//get no of trees in the db
$get_trees = "SELECT * FROM trees";
$get_trees_exe = mysqli_query($connection,$get_trees);
$row = mysqli_fetch_assoc($get_trees_exe);

//add no of trees
$no_of_trees = $_POST['no_of_trees'] + $row['no_of_trees'];

$query = "UPDATE trees SET no_of_trees = '$no_of_trees' WHERE id=1";

$query_exe = mysqli_query($connection, $query);

if($query_exe){
    $_SESSION['tree_added'] = "Trees Added Successfully";
    header("Location: admin.php#add-trees");
}

}else{
    header("Location: admin.php");
}

?>