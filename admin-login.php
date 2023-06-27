<?php  
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin-login.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Login</title>
</head>
<body>
    <form action="admin-login-processing.php" method="post" enctype="multipart/form-data">
        <p>GGR LOGIN </p>
      
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="password" placeholder="Password" required>
        <button name="login" type="submit">Login</button>
    </form>
    <?php if (isset($_SESSION['error'])) {?>
            <p id="error-message"><?php echo $_SESSION['error'] ?></p>
      <?php  } ?>
</body>
</html>