<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styles/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> 
    <title>GGR | Home</title>
</head>
<body>
<?php include './includes/navbar.php' ?>

<main class="home-page">
    <!-- Hero Swiper Section -->
    <section class="hero-swiper">
        <div class="swiper hero-swiper-container">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide slide-1">
                    <div class="slide-content">
                        <h1>Protecting Kenya's Natural Heritage</h1>
                        <p>Join our mission to conserve ecosystems and empower communities</p>
                        <a href="./program.php?programId=21" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide slide-2">
                    <div class="slide-content">
                        <h1>5 Million Trees Planted</h1>
                        <p>Help us reach our goal of 10 million trees by 2030</p>
                        <a href="./donate.php" class="btn btn-primary">Support Reforestation</a>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide slide-3">
                    <div class="slide-content">
                        <h1>Ecosystems Conservation</h1>
                        <p>Protecting endangered species and their habitats</p>
                        <a href="./program.php?programId=24" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    
    </section>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Who We Are</span>
                <h2 class="section-title">Green Globe Realisation</h2>
                <p class="section-subtitle">Leading environmental conservation in Kenya since 2021</p>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p>Founded in 2021, Green Globe Realisation has grown from a small community initiative to one of Kenya's most impactful environmental organizations. We combine scientific expertise with community knowledge to create sustainable solutions for Kenya's most pressing environmental challenges.</p>
                    <div class="mission-vision">
                        <div class="mv-card">
                            <h3>Our Mission</h3>
                            <p>Our mission is to protect and conserve the environment in North Eastern Kenya by implementing sustainable solutions that promote biodiversity, preserve natural resources, and empower local communities.</p>
                        </div>
                        <div class="mv-card">
                            <h3>Our Vision</h3>
                            <p>Our vision is to create a world where arid areas thrive through the adoption of sustainable environmental practices, leading to healthy ecosystems, increased economic prosperity, and social well-being for all.</p>
                        </div>
                    </div>
                    <a href="./about-us.php" class="btn btn-secondary">Learn More About Us</a>
                </div>
                <div class="about-image">
                    <div class="image-placeholder"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Programs Section -->
    <section class="programs-section" id="ggr-programs">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Our Work</span>
                <h2 class="section-title">Core Programs</h2>
                <p class="section-subtitle">Integrated approaches to environmental conservation</p>
            </div>
            <div class="programs-grid">
<?php
require_once './includes/connection.php';
$conn->set_charset("utf8mb4");

$query = "SELECT programId, programName, programSbl, programDesc FROM programs";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $programId = (int) $row['programId'];
        $name = htmlspecialchars($row['programName']);
        $symbol = htmlspecialchars($row['programSbl']);
        $desc = htmlspecialchars($row['programDesc']);

        // Truncate description to 20 words
        $words = explode(' ', $desc);
        $shortDesc = implode(' ', array_slice($words, 0, 20)) . (count($words) > 20 ? '...' : '');

        echo <<<HTML
        <div class="program-card">
            <div class="program-icon">{$symbol}</div>
            <h3>{$name}</h3>
            <p>{$shortDesc}</p>
            <a href="./program.php?programId={$programId}" class="program-link">Read More →</a>   
        </div>
        HTML;
    }
} else {
    echo '<p>No programs found.</p>';
}

$conn->close();
?>

</div>

        </div>
    </section>

  <!-- Featured Projects Section -->
<section class="featured-projects">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Impact</span>
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-subtitle">Our current flagship initiatives making a difference</p>
        </div>
        <div class="projects-swiper">
            <div class="swiper featured-projects-swiper">
                <div class="swiper-wrapper">
                    <?php
                    include './includes/connection.php';

                    // Get up to 3 featured project IDs
                    $result = $conn->query("SELECT projectId FROM featuredProjects ORDER BY created_at DESC LIMIT 3");

                    while ($row = $result->fetch_assoc()) {
                        $projectId = $row['projectId'];

                        // Get full project details from `projects`
                        $stmt = $conn->prepare("SELECT projectId, projectTitle, projectDesc, projectStatus, impactValue1, impactLabel1, impactValue2, impactLabel2 FROM projects WHERE projectId = ?");
                        $stmt->bind_param("i", $projectId);
                        $stmt->execute();
                        $project = $stmt->get_result()->fetch_assoc();

                        if (!$project) continue;

                        // Get the first image for this project from `projectImages`
                        $imgStmt = $conn->prepare("SELECT projectImagePath FROM projectImages WHERE projectId = ? ORDER BY imageId ASC LIMIT 1");
                        $imgStmt->bind_param("i", $projectId);
                        $imgStmt->execute();
                        $imgResult = $imgStmt->get_result()->fetch_assoc();

                        $imageUrl = $imgResult ? htmlspecialchars($imgResult['projectImagePath']) : 'uploads/default.jpg'; // fallback image

                        // Trim description to 14 words
                        $descWords = explode(" ", strip_tags($project['projectDesc']));
                        $descPreview = implode(" ", array_slice($descWords, 0, 14)) . (count($descWords) > 14 ? "..." : "");

                        echo '
                        <div class="swiper-slide project-slide">
                            <div class="project-image" style="background-image: url(\'' . $imageUrl . '\');"></div>
                            <div class="project-content">
                                <span class="project-status">' . htmlspecialchars($project['projectStatus']) . '</span>
                                <h3>' . htmlspecialchars($project['projectTitle']) . '</h3>
                                <p>' . htmlspecialchars($descPreview) . '</p>
                                <div class="project-stats">
                                    <div class="stat">
                                        <span class="number">' . htmlspecialchars($project['impactValue1']) . '</span>
                                        <span class="label">' . htmlspecialchars($project['impactLabel1']) . '</span>
                                    </div>
                                    <div class="stat">
                                        <span class="number">' . htmlspecialchars($project['impactValue2']) . '</span>
                                        <span class="label">' . htmlspecialchars($project['impactLabel2']) . '</span>
                                    </div>
                                </div>
                                <a href="project.php?projectId=' . urlencode($project['projectId']) . '" class="btn btn-secondary">Project Details</a>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="section-cta">
            <a href="./projects.php" class="btn btn-primary">View All Projects</a>
        </div>
    </div>
</section>


   <?php
include './includes/connection.php'; // Update path if needed

$sql = "
    SELECT 
        s.storyId,
        s.storyTitle,
        s.storyDescription,
        s.location,
        p.programName,
        (
            SELECT imagePath 
            FROM storyImages 
            WHERE storyId = s.storyId 
            ORDER BY storyId ASC LIMIT 1
        ) AS firstImage
    FROM stories s
    INNER JOIN programs p ON s.programId = p.programId
    ORDER BY s.created_at DESC
    LIMIT 3
";

$result = $conn->query($sql);
?>

<!-- Impact Stories Section -->
<section class="impact-stories-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Stories</span>
            <h2 class="section-title">Creating Lasting Change</h2>
            <p class="section-subtitle">How our work is transforming communities and ecosystems</p>
        </div>
        <div class="stories-grid">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="story-card">
                    <div class="story-image" style="background-image: url('<?php echo htmlspecialchars($row['firstImage'] ?: './default.jpg'); ?>');"></div>
                    <div class="story-content">
                        <span class="story-category"><?php echo htmlspecialchars($row['storyTitle']); ?></span>
                        <h3><?php echo htmlspecialchars($row['programName']); ?></h3>
                        <p>
                        <?php
                            $words = explode(' ', strip_tags($row['storyDescription']));
                            $shortDesc = implode(' ', array_slice($words, 0, 14));
                            echo htmlspecialchars($shortDesc) . (count($words) > 14 ? '...' : '');
                            ?>
                        </p>

                        <div class="story-meta">
                            <span class="location"><?php echo htmlspecialchars($row['location']); ?></span>
                
                        </div>
                        <?php echo '<a href="story.php?storyId=' . $row['storyId'] . '" class="story-link">Read Story →</a>'; ?>
                        
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="section-cta">
            <a href="./stories.php" class="btn btn-secondary">More Success Stories</a>
        </div>
    </div>
</section>




    <!-- Partners Section -->
    <section class="partners-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Collaboration</span>
                <h2 class="section-title">Our Trusted Partners</h2>
                <p class="section-subtitle">Working together for greater impact</p>
            </div>
            <div class="partners-logos">
                <div class="partner-logo"></div>
                <div class="partner-logo"></div>
                <div class="partner-logo"></div>
                <div class="partner-logo"></div>
                <div class="partner-logo"></div>
                <div class="partner-logo"></div>
                <div class="partner-logo"></div>
                <div class="partner-logo"></div>
                <div class="partner-logo"></div>
                <div class="partner-logo"></div>
                <a href="./partners.php" class="btn btn-secondary">Read More</a>
            </div>
        </div>
    </section>

    <!-- Volunteer Section -->
    <section class="volunteer-section">
        <div class="container">
            <div class="volunteer-content">
                <div class="volunteer-text">
                    <span class="section-tag">Get Involved</span>
                    <h2 class="section-title">Become a Conservation Volunteer</h2>
                    <p>Join our team of dedicated volunteers working hands-on to protect Kenya's environment. Whether you can give a few hours or make a long-term commitment, your time and skills can make a real difference.</p>
                    <ul class="volunteer-benefits">
                        <li>Tree planting and nursery management</li>
                        <li>Wildlife monitoring and conservation</li>
                        <li>Community education and outreach</li>
                        <li>Research and data collection</li>
                    </ul>
                    <a href="/register" class="btn btn-primary">Volunteer With Us</a>
                </div>
                <div class="volunteer-image">
                    <div class="image-placeholder"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Section -->
    <section class="donation-section">
        <div class="container">
            <div class="donation-content">
                <div class="donation-text">
                    <span class="section-tag">Support Us</span>
                    <h2 class="section-title">Your Donation Makes an Impact</h2>
                    <p>Every contribution helps us protect Kenya's environment and support local communities. See how your donation can make a difference:</p>
                    <div class="donation-options">
                        <div class="option">
                            <span class="amount">$25</span>
                            <span class="description">Plants 5 native trees</span>
                        </div>
                        <div class="option">
                            <span class="amount">$50</span>
                            <span class="description">Supports wildlife monitoring</span>
                        </div>
                        <div class="option">
                            <span class="amount">$100</span>
                            <span class="description">Trains a conservation educator</span>
                        </div>
                    </div>
                    <a href="./donate.php" class="btn btn-primary">Make a Donation</a>
                </div>
                <div class="donation-image">
                    <div class="image-placeholder"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- News & Updates Section -->
    <section class="news-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Latest</span>
                <h2 class="section-title">News & Updates</h2>
                <p class="section-subtitle">Stay informed about our conservation work</p>
            </div>
            <h6 style="display: flex; justify-content: center;">news are being updated. come back later.</h6>
            <div class="news-grid">
                
              <!--  <div class="news-card">
                    <div class="news-image"></div>
                    <div class="news-content">
                        <span class="news-date">Aug 15, 2025</span>
                        <h3>New Partnership Launches Coastal Conservation Program</h3>
                        <p>We've teamed up with local fishermen to protect marine ecosystems along Kenya's coast.</p>
                        <a href="/news/coastal-program" class="news-link">Read More →</a>
                    </div>
                </div>-->
               
            </div>
            <div class="section-cta">
                <a href="./news.php" class="btn btn-secondary">View All News</a>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="events-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Participate</span>
                <h2 class="section-title">Upcoming Events</h2>
                <p class="section-subtitle">Join us for conservation activities and educational programs</p>
            </div>
            <div class="events-list">
                <h6 style="display: flex; justify-content: center;">No upcoming event found</h6>
               <!-- <div class="event-card">
                    <div class="event-date">
                        <span class="day">15</span>
                        <span class="month">Jul</span>
                    </div>
                    <div class="event-details">
                        <h3>Community Tree Planting - Nairobi</h3>
                        <p class="event-info">
                            <span class="location">Karura Forest, Nairobi</span>
                            <span class="time">8:00 AM - 12:00 PM</span>
                        </p>
                        <a href="/events/nairobi-planting" class="event-link">Register Now</a>
                    </div>
                </div>-->
            </div>
            <div class="section-cta">
                <a href="./events.php" class="btn btn-secondary">View All Events</a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <div class="newsletter-text">
                    <h2>Stay Updated</h2>
                    <p>Subscribe to our newsletter for the latest conservation news, events, and ways to get involved.</p>
                </div>
                <form class="newsletter-form">
                    <input type="email" placeholder="Your email address" required>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="final-cta">
        <div class="container">
            <h2>Ready to Make a Difference?</h2>
            <p>Join us in protecting Kenya's environment for future generations</p>
            <div class="cta-buttons">
                <a href="./donate.php" class="btn btn-primary">Donate Now</a>
                <a href="./register.php" class="btn btn-secondary">Become a Volunteer</a>
                <a href="./contact-us.php" class="btn btn-secondary">Contact Us</a>
            </div>
        </div>
    </section>
</main>
<?php include './includes/footer.php' ?>

<!-- Initialize Swipers -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Hero Swiper
    const heroSwiper = new Swiper('.hero-swiper-container', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // Projects Swiper
    const projectsSwiper = new Swiper('.featured-projects-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            }
        }
    });
</script>
</body>
</html>