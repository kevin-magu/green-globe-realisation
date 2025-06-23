<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <link rel="icon" href="./favicon.ico" type="image/x-icon">
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
                        <h1>Protecting our wetlands</h1>
                        <p>Our North Eastern Kenya projects are helping communities & surrounding ecosystems</p>
                        <a href="./program.php?programId=24" class="btn btn-primary">Learn More</a>
                    </div>
                </div> 
                <!-- Slide 3 -->
                <div class="swiper-slide slide-3">
                    <div class="slide-content">
                        <h1>Biomedical Waste</h1>
                        <p>Sustainable Biomedical Waste Solutions for Kenya</p>
                        <a href="./program.php?programId=23" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
                <!-- Slide 4 -->
                <div class="swiper-slide slide-4">
                    <div class="slide-content">
                        <h1>Seed to Sequoia</h1>
                        <p>We grow tree seedlings in nurseries then plant them in degraded areas</p>
                        <a href="./program.php?programId=21" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
                
                <!-- Slide 5 -->
                <div class="swiper-slide slide-5">
                    <div class="slide-content">
                        <h1>Involving the Youth</h1>
                        <p>How we are involving the youth in conservation efforts</p>
                        <a href="./program.php?programId=21" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
              
                <!-- Slide 8 -->
                <div class="swiper-slide slide-8">
                    <div class="slide-content">
                        <h1>Creating a lasting change everywhere we go</h1>
                        <p>Our goal is to regreen Kenya & empowering the society</p>
                        <a href="./program.php?programId=21" class="btn btn-primary">Learn More</a>
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
<section class="programs-section" id="programs">
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

            $sql = "SELECT programId, programName, programSbl, programDesc FROM programs";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $programId = (int) $row['programId'];
                    $name = htmlspecialchars($row['programName']);
                    $symbol = htmlspecialchars($row['programSbl']);
                    $desc = htmlspecialchars($row['programDesc']);

                    // Truncate to 20 words
                    $descWords = explode(' ', $desc);
                    $shortDesc = implode(' ', array_slice($descWords, 0, 20));
                    if (count($descWords) > 20) {
                        $shortDesc .= '...';
                    }
            ?>
                    <div class="program-card">
                        <div class="program-icon"><?= $symbol ?></div>
                        <h3><?= $name ?></h3>
                        <p><?= $shortDesc ?></p>
                        <a href="./program.php?programId=<?= $programId ?>" class="program-link">Read More →</a>
                    </div>
            <?php
                }
            } else {
                echo '<p>No programs found.</p>';
            }

            //$conn->close();
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
                    <?php
                    try {
                        require_once './includes/connection.php';
                        
                        $featuredQuery = "SELECT p.projectId, p.projectTitle, p.projectDesc, p.projectStatus, 
                                        p.impactValue1, p.impactLabel1, p.impactValue2, p.impactLabel2
                                        FROM projects p
                                        INNER JOIN featuredProjects fp ON p.projectId = fp.projectId
                                        ORDER BY fp.created_at DESC LIMIT 3";
                        
                        $featuredResult = $conn->query($featuredQuery);
                        
                        if ($featuredResult && $featuredResult->num_rows > 0) {
                            echo '<div class="swiper featured-projects-swiper"><div class="swiper-wrapper">';
                            
                            while ($project = $featuredResult->fetch_assoc()) {
                                $imageQuery = "SELECT projectImagePath FROM projectImages 
                                             WHERE projectId = ? ORDER BY imageId ASC LIMIT 1";
                                $stmt = $conn->prepare($imageQuery);
                                $stmt->bind_param("i", $project['projectId']);
                                $stmt->execute();
                                $imageResult = $stmt->get_result()->fetch_assoc();
                                
                                $imageUrl = $imageResult ? 
                                    htmlspecialchars($imageResult['projectImagePath']) : 
                                    'assets/images/default-project.jpg';
                                
                                $descWords = explode(" ", strip_tags($project['projectDesc']));
                                $descPreview = implode(" ", array_slice($descWords, 0, 14)) . 
                                    (count($descWords) > 14 ? "..." : "");
                                
                                echo '<div class="swiper-slide project-slide">';
                                echo '<div class="project-image" style="background-image: url(\'' . $imageUrl . '\');"></div>';
                                echo '<div class="project-content">';
                                echo '<span class="project-status">' . htmlspecialchars($project['projectStatus']) . '</span>';
                                echo '<h3>' . htmlspecialchars($project['projectTitle']) . '</h3>';
                                echo '<p>' . htmlspecialchars($descPreview) . '</p>';
                                
                                echo '<div class="project-stats">';
                                echo '<div class="stat">';
                                echo '<span class="number">' . htmlspecialchars($project['impactValue1']) . '</span>';
                                echo '<span class="label">' . htmlspecialchars($project['impactLabel1']) . '</span>';
                                echo '</div>';
                                
                                echo '<div class="stat">';
                                echo '<span class="number">' . htmlspecialchars($project['impactValue2']) . '</span>';
                                echo '<span class="label">' . htmlspecialchars($project['impactLabel2']) . '</span>';
                                echo '</div>';
                                echo '</div>';
                                
                                echo '<a href="project.php?projectId=' . urlencode($project['projectId']) . '" class="btn btn-secondary">Project Details</a>';
                                echo '</div></div>';
                            }
                            
                            echo '</div><div class="swiper-pagination"></div></div>';
                        } else {
                            echo '<p class="no-projects">No featured projects at this time.</p>';
                        }
                        
                        
                    } catch (Exception $e) {
                        error_log("Projects error: " . $e->getMessage());
                        echo '<p class="error-message">Unable to load featured projects.</p>';
                    }
                    ?>
                </div>
                <div class="section-cta">
                    <a href="./projects.php" class="btn btn-primary">View All Projects</a>
                </div>
            </div>
        </section>


 <!-- Impact Stories Section -->
        <section class="impact-stories-section">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">Stories</span>
                    <h2 class="section-title">Creating Lasting Change</h2>
                    <p class="section-subtitle">How our work is transforming communities and ecosystems</p>
                </div>
                <div class="stories-grid">
                    <?php
                    try {
                        require_once './includes/connection.php';
                        
                        $storiesQuery = "SELECT s.storyId, s.storyTitle, s.storyDescription, s.location,
                                        p.programName, 
                                        (SELECT imagePath FROM storyImages WHERE storyId = s.storyId LIMIT 1) AS firstImage
                                        FROM stories s
                                        INNER JOIN programs p ON s.programId = p.programId
                                        ORDER BY s.created_at DESC LIMIT 3";
                        
                        $storiesResult = $conn->query($storiesQuery);
                        
                        if ($storiesResult && $storiesResult->num_rows > 0) {
                            while ($story = $storiesResult->fetch_assoc()) {
                                $imageUrl = $story['firstImage'] ? 
                                    htmlspecialchars($story['firstImage']) : 
                                    'assets/images/default-story.jpg';
                                
                                $words = explode(' ', strip_tags($story['storyDescription']));
                                $shortDesc = implode(' ', array_slice($words, 0, 14)) . 
                                    (count($words) > 14 ? '...' : '');
                                
                                echo '<div class="story-card">';
                                echo '<div class="story-image" style="background-image: url(\'' . $imageUrl . '\');"></div>';
                                echo '<div class="story-content">';
                                echo '<span class="story-category">' . htmlspecialchars($story['programName']) . '</span>';
                                echo '<h3>' . htmlspecialchars($story['storyTitle']) . '</h3>';
                                echo '<p>' . htmlspecialchars($shortDesc) . '</p>';
                                
                                echo '<div class="story-meta">';
                                echo '<span class="location">' . htmlspecialchars($story['location']) . '</span>';
                                echo '</div>';
                                
                                echo '<a href="story.php?storyId=' . $story['storyId'] . '" class="story-link">Read Story →</a>';
                                echo '</div></div>';
                            }
                        } else {
                            echo '<p class="no-stories">No impact stories available at this time.</p>';
                        }
                        
                    
                    } catch (Exception $e) {
                        error_log("Stories error: " . $e->getMessage());
                        echo '<p class="error-message">Unable to load impact stories.</p>';
                    }
                    ?>
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
                    <a href="./register.php" class="btn btn-primary">Volunteer With Us</a>
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
            <form class="newsletter-form" action="subscribe.php" method="POST">
                <div id="feedback" style="color: white; margin-top: 4px; font-size: 12px;"></div>
                <input type="email" name="email" placeholder="Your email address" required>
                
                <!-- Google reCAPTCHA -->
                <div class="g-recaptcha" data-sitekey="6LeQzGArAAAAADJxJ7QF3Xu936mWw3yNRQyUCGb2"></div>

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

    <!-- green hospitals Section -->
    <section class="green-hospitals">
        <div class="green-hospital-img"></div>
    </section>

</main>
<?php include './includes/footer.php' ?>

<!-- Initialize Swipers -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src='./apis/uploadMailingList.js'></script>
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