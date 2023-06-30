<?php
session_start();
// Include the file with database connection details
include 'includes.php';
ini_set('display_errors', 1);

// Function to validate username and password
function validateCredentials($connection, $username, $password) {
    // Prepare the SQL statement with placeholders
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");

    // Bind the parameter values
    $stmt->bind_param('s', $username);

    // Execute the query
    $stmt->execute();

    // Fetch the user record
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Username and password are valid
        return true;
    }

    // Invalid username or password
    return false;
}

// Handle form submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the credentials
    if (validateCredentials($connection, $username, $password)) {
        // Successful login
        header("location: admin.php");
        $_SESSION['username']= $_POST['username'];
        // Redirect to admin dashboard or perform necessary actions
    } else {
        // Invalid username or password
        $_SESSION['error'] ="Invalid username or password";   
        header("location: admin-login.php");
        exit();
}
}
?>
