<?php
include 'includes.php';

// Function to validate username and password
function validateCredentials($username, $password) {
    // Prepare the SQL statement with placeholders
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");

    // Bind the parameter values
    $stmt->bindParam(':username', $username);

    // Execute the query
    $stmt->execute();

    // Fetch the user record
    $user = $stmt->fetch();

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Username and password are valid
        return true;
    }

    // Invalid username or password
    return false;
}

// Example usage
$username = $_POST['username'];
$password = $_POST['password'];

// Validate the credentials
if (validateCredentials($username, $password)) {
    echo "Login successful!";
} else {
    echo "Invalid username or password.";
}
?>
