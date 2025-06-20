<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Green Globe Realisation</title>
     <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/aboutus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include './includes/navbar.php' ?>

<main class="about-page">
    <!-- Hero Section -->
    <section class="about-hero" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('./images2/contact-us-hero.jpg')">
        <div class="container">
            <div class="hero-content">
                <h1>Our Story</h1>
                <p class="hero-text">From humble beginnings to environmental leadership in North Eastern Kenya</p>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-content" >
        <div class="container">
            <div class="content-grid">
                <div class="about-text" id="ggr-mission">
                    <h2>Who We Are</h2>
                    <p>Founded in 2021, Green Globe Realisation has grown from a small community initiative to one of Kenya's most impactful environmental organizations. We combine scientific expertise with community knowledge to create sustainable solutions for Kenya's most pressing environmental challenges.</p>
                    
                    <div class="mission-vision">
                        <div class="mv-card mission">
                            <div class="mv-icon"><i class="fas fa-bullseye"></i></div>
                            <h3>Our Mission</h3>
                            <p>Our mission is to protect and conserve the environment in North Eastern Kenya by implementing sustainable solutions that promote biodiversity, preserve natural resources, and empower local communities.</p>
                        </div>
                        <div class="mv-card vision">
                            <div class="mv-icon"><i class="fas fa-eye"></i></div>
                            <h3>Our Vision</h3>
                            <p>Our vision is to create a world where arid areas thrive through the adoption of sustainable environmental practices, leading to healthy ecosystems, increased economic prosperity, and social well-being for all.</p>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="./images2/ggr-cover2.jpeg" alt="Green Globe Realisation team">
                    <div class="image-caption">Our team working with local community in North Eastern Kenya</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="values-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Our Foundation</span>
                <h2 class="section-title">Core Values</h2>
                <p class="section-subtitle">The principles that guide our work every day</p>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-hands-helping"></i></div>
                    <h3>Community First</h3>
                    <p>We believe lasting change comes from empowering local communities to be stewards of their environment.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-leaf"></i></div>
                    <h3>Sustainability</h3>
                    <p>Our solutions are designed to create long-term environmental and economic benefits.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-flask"></i></div>
                    <h3>Science-Based</h3>
                    <p>We combine traditional knowledge with cutting-edge environmental science.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-handshake"></i></div>
                    <h3>Collaboration</h3>
                    <p>We work in partnership with communities, governments, and other organizations.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section" id="ggr-team">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Our People</span>
                <h2 class="section-title">Meet The Team</h2>
                <p class="section-subtitle">Dedicated professionals driving our mission forward</p>
            </div>
            <div class="team-grid">
<?php
include './includes/connection.php';
$conn->set_charset("utf8mb4");

$query = "SELECT executiveId, executiveName, position, description, profilePicture FROM executives";
//ORDER BY executiveId DESC
$result = $conn->query($query);


if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $name = htmlspecialchars($row['executiveName']);
        $position = htmlspecialchars($row['position']);
        $bio = htmlspecialchars($row['description']);
        $execId = $row['executiveId'];
        $image = $row['profilePicture'] ?: 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80'; // fallback
?>
    <div class="team-card">
        <div class="team-image" style="background-image: url('<?= $image ?>')"></div>
        <div class="team-info">
            <h3><?= $name ?></h3>
            <p class="position"><?= $position ?></p>
            <?php $shortBio = implode(' ', array_slice(explode(' ', $bio), 0, 20)) . '...'; ?>
            <p class="bio"><?= $shortBio ?></p>
           <?php echo ' <a href="./profile.php?id=' . urlencode($row['executiveId']) . '" class="story-link">View Bio →</a> '?>
        </div>
    </div>
<?php
    endwhile;
else:
?>
    <p>No executives found.</p>
<?php endif; ?>
</div>

        </div>
    </section>

</main>

<?php include './includes/footer.php' ?>
</body>
</html>