<?php
/**
 * Green Globe Realisation - Home Page
 * 
 * @package GGR
 * @version 1.0
 */

// Initialize PHP settings
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set default timezone
date_default_timezone_set('Africa/Nairobi');

// Start output buffering
ob_start();

// Define absolute path for includes
define('BASE_PATH', dirname(__FILE__));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGR | Home</title>
    
    <!-- CSS Assets -->
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>/styles/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="<?php echo BASE_PATH; ?>/includes/navbar.php" as="fetch">
    <link rel="preload" href="<?php echo BASE_PATH; ?>/includes/footer.php" as="fetch">
</head>
<body>
    <?php include BASE_PATH . '/includes/navbar.php'; ?>

    <main class="home-page">
        <!-- Hero Swiper Section -->
        <section class="hero-swiper">
            <div class="swiper hero-swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    $heroSlides = [
                        [
                            'image' => 'slide-1',
                            'title' => 'Protecting Kenya\'s Natural Heritage',
                            'text' => 'Join our mission to conserve ecosystems and empower communities',
                            'link' => '/get-involved',
                            'btn_text' => 'Take Action'
                        ],
                        [
                            'image' => 'slide-2',
                            'title' => '5 Million Trees Planted',
                            'text' => 'Help us reach our goal of 10 million trees by 2030',
                            'link' => '/donate',
                            'btn_text' => 'Support Reforestation'
                        ],
                        [
                            'image' => 'slide-3',
                            'title' => 'Ecosystems Conservation',
                            'text' => 'Protecting endangered species and their habitats',
                            'link' => '/wildlife',
                            'btn_text' => 'Learn More'
                        ]
                    ];

                    foreach ($heroSlides as $slide) {
                        echo <<<SLIDE
                        <div class="swiper-slide {$slide['image']}">
                            <div class="slide-content">
                                <h1>{$slide['title']}</h1>
                                <p>{$slide['text']}</p>
                                <a href="{$slide['link']}" class="btn btn-primary">{$slide['btn_text']}</a>
                            </div>
                        </div>
                        SLIDE;
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
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
                        <a href="/about" class="btn btn-secondary">Learn More About Us</a>
                    </div>
                    <div class="about-image">
                        <div class="image-placeholder"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Programs Section -->
        <section class="programs-section">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">Our Work</span>
                    <h2 class="section-title">Core Programs</h2>
                    <p class="section-subtitle">Integrated approaches to environmental conservation</p>
                </div>
                <div class="programs-grid">
                    <?php
                    try {
                        require_once BASE_PATH . '/includes/connection.php';
                        
                        // Set charset for security
                        $conn->set_charset("utf8mb4");
                        
                        $query = "SELECT programId, programName, programSbl, programDesc FROM programs";
                        $result = $conn->query($query);
                        
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $name = htmlspecialchars($row['programName'], ENT_QUOTES, 'UTF-8');
                                $symbol = htmlspecialchars($row['programSbl'], ENT_QUOTES, 'UTF-8');
                                $desc = htmlspecialchars($row['programDesc'], ENT_QUOTES, 'UTF-8');
                                $programId = (int)$row['programId'];
                                
                                // Create slug for the link
                                $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
                                $words = explode(' ', $desc);
                                $shortDesc = implode(' ', array_slice($words, 0, 20)) . (count($words) > 20 ? '...' : '');
                                
                                echo '<div class="program-card">';
                                echo '<div class="program-icon">' . $symbol . '</div>';
                                echo '<h3>' . $name . '</h3>';
                                echo '<p>' . $shortDesc . '</p>';
                                echo '<a href="/programs/' . $slug . '" class="program-link">Read More →</a>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="no-programs">No programs currently available. Please check back later.</p>';
                        }
                        
                        $conn->close();
                    } catch (Exception $e) {
                        error_log("Database error: " . $e->getMessage());
                        echo '<p class="error-message">We\'re experiencing technical difficulties. Please try again later.</p>';
                    }
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
                        require_once BASE_PATH . '/includes/connection.php';
                        
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
                                
                                echo '<a href="/project/' . (int)$project['projectId'] . '" class="btn btn-secondary">Project Details</a>';
                                echo '</div></div>';
                            }
                            
                            echo '</div><div class="swiper-pagination"></div></div>';
                        } else {
                            echo '<p class="no-projects">No featured projects at this time.</p>';
                        }
                        
                        $conn->close();
                    } catch (Exception $e) {
                        error_log("Projects error: " . $e->getMessage());
                        echo '<p class="error-message">Unable to load featured projects.</p>';
                    }
                    ?>
                </div>
                <div class="section-cta">
                    <a href="/projects" class="btn btn-primary">View All Projects</a>
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
                        require_once BASE_PATH . '/includes/connection.php';
                        
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
                                
                                echo '<a href="/story/' . (int)$story['storyId'] . '" class="story-link">Read Story →</a>';
                                echo '</div></div>';
                            }
                        } else {
                            echo '<p class="no-stories">No impact stories available at this time.</p>';
                        }
                        
                        $conn->close();
                    } catch (Exception $e) {
                        error_log("Stories error: " . $e->getMessage());
                        echo '<p class="error-message">Unable to load impact stories.</p>';
                    }
                    ?>
                </div>
                <div class="section-cta">
                    <a href="/stories" class="btn btn-secondary">More Success Stories</a>
                </div>
            </div>
        </section>

        <!-- [Rest of your sections...] -->

    </main>

    <?php include BASE_PATH . '/includes/footer.php'; ?>

    <!-- JavaScript Assets -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swipers
        document.addEventListener('DOMContentLoaded', function() {
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
            if (document.querySelector('.featured-projects-swiper')) {
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
            }
        });
    </script>
</body>
</html>
<?php
// Flush output buffer
ob_end_flush();
?>