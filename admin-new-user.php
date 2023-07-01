<?php
session_start();
// Include the file with database connection details
include 'includes.php';
ini_set('display_errors', 1);

// Function to create a new user
function createUser($connection, $username, $password) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement with placeholders
    $stmt = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

    // Bind the parameter values
    $stmt->bind_param('ss', $username, $hashedPassword);

    // Execute the query
    if ($stmt->execute()) {
        // User created successfully
        return true;
    } else {
        // Error in user creation
        return false;
    }
}

// Handle form submission
if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create the user
    if (createUser($connection, $username, $password)) {
        // User created successfully
        $_SESSION['create-user'] = "user created successfuly";
        header("location: admin.php");
        
    } else {
        // Error in user creation
        $_SESSION['create-user-error'] = "Error creating user";
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin-login.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New admin</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
        <p>GGR. CREATE A NEW ADMIN USER</p>
        <?php 
        if (isset($_SESSION['create-user-error'])) {
            echo $_SESSION['create-user-error'];
        }
        ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="create" type="submit">Register</button>
    </form>
</body>
</html>
