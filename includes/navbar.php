<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Globe Realisation</title>
   
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <a href="./">
                <div class="logo-container">
                <div class="navbar-logo">
                    <img src="./images2/logos/ggr-logo-green.png" alt="Green Globe Realisation" class="logo-img">
                </div>
                    <span class="logo-text">Green Globe Realisation</span>
                </div>
            </a>
            <button class="navbar-toggler" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
            </button>
        </div>

        <div class="navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="./about-us.php" class="nav-link">About <i class="fas fa-chevron-down dropdown-icon"></i></a>
                    <div class="dropdown-menu">
                        <a href="./about-us.php#ggr-mission" class="dropdown-item">Our Mission</a>
                        <a href="./about-us.php#ggr-team" class="dropdown-item">Our Team</a>
                        <a href="./partners.php" class="dropdown-item">Partners</a>
                    </div>
                </li>
                
                <li class="nav-item dropdown">
                    <a href=".#ggr-programs" class="nav-link">Programs <i class="fas fa-chevron-down dropdown-icon"></i></a>
                    <div class="dropdown-menu">
                        <a href="./program.php?programId=21" class="dropdown-item">Reforestation</a>
                        <a href="./program.php?programId=23" class="dropdown-item">Biomedical Waste management</a>
                        <a href="./program.php?programId=24" class="dropdown-item">Ecosystems Conservation</a>
                        <a href="./program.php?programId=25" class="dropdown-item">Clean Energy</a>
                        <a href="./program.php?programId=26" class="dropdown-item">Sustainable Agriculture</a>
                        <a href="./program.php?programId=27" class="dropdown-item">Environmental Education</a>
                    </div>
                </li>
                <li class="nav-item"><a href="./projects.php" class="nav-link">Projects</a></li>
                <li class="nav-item"><a href="./register.php" class="nav-link">Membeship</a></li>
                <li class="nav-item"><a href="./news.php" class="nav-link">News</a></li>
                <li class="nav-item"><a href="./advocacy.php" class="nav-link">Advocacy</a></li>
                <li class="nav-item"><a href="./contact-us.php" class="nav-link">Contacts</a></li>
            </ul>

            <div class="navbar-actions">
                <a href="./donate.php" class="btn-volunteer" >Donate <i class="fas fa-heart" style="margin-left: 5px;"></i></a>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    // Toggle mobile menu
    toggler.addEventListener('click', function() {
        navbarCollapse.classList.toggle('show');
        toggler.classList.toggle('open');
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
            document.querySelectorAll('.dropdown-icon').forEach(icon => {
                icon.classList.remove('rotate');
            });
        }
    });
    
    // Handle dropdown menus
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        const link = dropdown.querySelector('.nav-link');
        const menu = dropdown.querySelector('.dropdown-menu');
        const icon = dropdown.querySelector('.dropdown-icon');
        
        link.addEventListener('click', function(e) {
            if (window.innerWidth < 992) {
                e.preventDefault();
                menu.classList.toggle('show');
                icon.classList.toggle('rotate');
                
                // Close other open dropdowns
                document.querySelectorAll('.dropdown-menu').forEach(otherMenu => {
                    if (otherMenu !== menu) {
                        otherMenu.classList.remove('show');
                    }
                });
                document.querySelectorAll('.dropdown-icon').forEach(otherIcon => {
                    if (otherIcon !== icon) {
                        otherIcon.classList.remove('rotate');
                    }
                });
            }
        });
    });
    
    // Update active link based on current page
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
});
</script>
</body>
</html>