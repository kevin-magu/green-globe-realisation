<?php
// nav.php - Navigation bar for Green Globe Realisation
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/adminNav.css">
</head>
<body>
    <header class="nav-header">
        <div class="container">
            <div class="nav-content">
                <div class="logo">
                    <a href="index.php"><h1>Green Globe Realisation</h1></a>
                </div>
                <button class="nav-toggle" aria-label="Toggle navigation">
                    <span class="hamburger"></span>
                </button>
                <nav class="nav-menu">
                    <ul>
                        <li><a href="index.php">Dashboard</a></li>
                        <li><a href="./projects.php">Projects</a></li>
                        <li><a href="./uploadProject.php" >Add Project</a></li>
                        <li><a href="./uploadProgram.php" >Add Program</a></li>
                        <li><a href="./uploadStory.php">Add Story</a></li>
                        <li><a href="./addExecutive.php">Add Executive</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <script>
        // Toggle mobile menu
        const navToggle = document.querySelector('.nav-toggle');
        const navMenu = document.querySelector('.nav-menu');

        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
        });
    </script>
</body>
</html>