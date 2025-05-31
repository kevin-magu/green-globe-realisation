<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styles/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> 
    <title>Home</title>
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
                        <a href="/get-involved" class="btn btn-primary">Take Action</a>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide slide-2">
                    <div class="slide-content">
                        <h1>5 Million Trees Planted</h1>
                        <p>Help us reach our goal of 10 million trees by 2030</p>
                        <a href="/donate" class="btn btn-primary">Support Reforestation</a>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide slide-3">
                    <div class="slide-content">
                        <h1>Ecosystems Conservation</h1>
                        <p>Protecting endangered species and their habitats</p>
                        <a href="/wildlife" class="btn btn-primary">Learn More</a>
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
                <div class="program-card">
                    <div class="program-icon">🌳</div>
                    <h3>Reforestation</h3>
                    <p>Restoring degraded landscapes through native tree planting and sustainable land management</p>
                    <a href="/programs/reforestation" class="program-link">Explore →</a>
                </div>
                <div class="program-card">
                    <div class="program-icon">♻️</div>
                    <h3>Biomedical Waste management</h3>
                    <p>Promoting safe disposal of medical waste to protect public health and the environment</p>
                    <a href="/programs/wildlife" class="program-link">Explore →</a>
                </div>
                <div class="program-card">
                    <div class="program-icon">🌿</div>
                    <h3>Ecosystems Conservation</h3>
                    <p>Protecting Kenya's forests, wetlands, and wildlife habitats from degradation.</p>
                    <a href="/programs/water" class="program-link">Explore →</a>
                </div>
                <div class="program-card">
                    <div class="program-icon">🔋</div>
                    <h3>Clean Energy</h3>
                    <p>Advancing renewable energy solutions for rural communities</p>
                    <a href="/programs/energy" class="program-link">Explore →</a>
                </div>
                <div class="program-card">
                    <div class="program-icon">👩‍🌾</div>
                    <h3>Sustainable Agriculture</h3>
                    <p>Promoting climate-smart farming techniques that protect ecosystems</p>
                    <a href="/programs/agriculture" class="program-link">Explore →</a>
                </div>
                <div class="program-card">
                    <div class="program-icon">🏫</div>
                    <h3>Environmental Education</h3>
                    <p>Empowering future generations through conservation education</p>
                    <a href="/programs/education" class="program-link">Explore →</a>
                </div>
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
                        <!-- Project 1 -->
                        <div class="swiper-slide project-slide">
                            <div class="project-image"></div>
                            <div class="project-content">
                                <span class="project-status">Active</span>
                                <h3>Northern Kenya Reforestation Initiative</h3>
                                <p>Restoring 10,000 hectares of degraded land through community-led tree planting in Kenya's arid regions.</p>
                                <div class="project-stats">
                                    <div class="stat">
                                        <span class="number">450,000</span>
                                        <span class="label">Trees Planted</span>
                                    </div>
                                    <div class="stat">
                                        <span class="number">32</span>
                                        <span class="label">Communities</span>
                                    </div>
                                </div>
                                <a href="/projects/northern-kenya" class="btn btn-secondary">Project Details</a>
                            </div>
                        </div>
                        <!-- Project 2 -->
                        <div class="swiper-slide project-slide">
                            <div class="project-image"></div>
                            <div class="project-content">
                                <span class="project-status highlight">New</span>
                                <h3>Coastal Mangrove Restoration</h3>
                                <p>Protecting vital mangrove ecosystems along Kenya's Indian Ocean coast through restoration and education.</p>
                                <div class="project-stats">
                                    <div class="stat">
                                        <span class="number">120</span>
                                        <span class="label">Hectares</span>
                                    </div>
                                    <div class="stat">
                                        <span class="number">800+</span>
                                        <span class="label">Fisherfolk</span>
                                    </div>
                                </div>
                                <a href="/projects/mangrove" class="btn btn-secondary">Project Details</a>
                            </div>
                        </div>
                        <!-- Project 3 -->
                        <div class="swiper-slide project-slide">
                            <div class="project-image"></div>
                            <div class="project-content">
                                <span class="project-status">Active</span>
                                <h3>Schools Greening Program</h3>
                                <p>Creating green spaces in Nairobi's informal settlements to improve air quality and community wellbeing.</p>
                                <div class="project-stats">
                                    <div class="stat">
                                        <span class="number">15</span>
                                        <span class="label">Schools</span>
                                    </div>
                                    <div class="stat">
                                        <span class="number">25,000</span>
                                        <span class="label">Trees Planted</span>
                                    </div>
                                </div>
                                <a href="/projects/urban-greening" class="btn btn-secondary">Project Details</a>
                            </div>
                        </div>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
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
                <div class="story-card">
                    <div class="story-image"></div>
                    <div class="story-content">
                        <span class="story-category">Reforestation</span>
                        <h3>Regreening Northern Kenya</h3>
                        <p>How we have involved the Northern Kenya communities in reforestation.</p>
                        <div class="story-meta">
                            <span class="location">Wajir County</span>
                            <span class="date">2022-Present</span>
                        </div>
                        <a href="/stories/rift-valley" class="story-link">Read Story →</a>
                    </div>
                </div>
                <div class="story-card">
                    <div class="story-image"></div>
                    <div class="story-content">
                        <span class="story-category">Women Empowerment</span>
                        <h3>Women Leading Conservation</h3>
                        <p>Empowering women's groups in Wajir to combat desertification through innovative water harvesting.</p>
                        <div class="story-meta">
                            <span class="location">Wajir County</span>
                            <span class="date">Ongoing</span>
                        </div>
                        <a href="/stories/women-conservation" class="story-link">Read Story →</a>
                    </div>
                </div>
                <div class="story-card">
                    <div class="story-image"></div>
                    <div class="story-content">
                        <span class="story-category">Empowerment</span>
                        <h3>Engaging the youth</h3>
                        <p>Engaging Kenya's youth in environmental stewardship through our nationwide network of school clubs.</p>
                        <div class="story-meta">
                            <span class="location">Wajir</span>
                            <span class="date">Since 2022</span>
                        </div>
                        <a href="/stories/green-clubs" class="story-link">Read Story →</a>
                    </div>
                </div>
            </div>
            <div class="section-cta">
                <a href="/stories" class="btn btn-secondary">More Success Stories</a>
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
                <a href="/wildlife" class="btn btn-primary">Read More</a>
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
                    <a href="/donate" class="btn btn-primary">Make a Donation</a>
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
            <div class="news-grid">
                <div class="news-card">
                    <div class="news-image"></div>
                    <div class="news-content">
                        <span class="news-date">June 15, 2023</span>
                        <h3>New Partnership Launches Coastal Conservation Program</h3>
                        <p>We've teamed up with local fishermen to protect marine ecosystems along Kenya's coast.</p>
                        <a href="/news/coastal-program" class="news-link">Read More →</a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image"></div>
                    <div class="news-content">
                        <span class="news-date">May 28, 2023</span>
                        <h3>Annual Tree Planting Day Breaks Records</h3>
                        <p>Over 10,000 volunteers planted 250,000 trees in a single day across 15 counties.</p>
                        <a href="/news/tree-planting" class="news-link">Read More →</a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image"></div>
                    <div class="news-content">
                        <span class="news-date">April 12, 2023</span>
                        <h3>Women's Conservation Group Wins National Award</h3>
                        <p>Our Kitui women's group recognized for innovative water conservation techniques.</p>
                        <a href="/news/women-award" class="news-link">Read More →</a>
                    </div>
                </div>
            </div>
            <div class="section-cta">
                <a href="/news" class="btn btn-secondary">View All News</a>
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
                <div class="event-card">
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
                </div>
                <div class="event-card">
                    <div class="event-date">
                        <span class="day">22</span>
                        <span class="month">Jul</span>
                    </div>
                    <div class="event-details">
                        <h3>Wildlife Conservation Workshop</h3>
                        <p class="event-info">
                            <span class="location">Online Webinar</span>
                            <span class="time">2:00 PM - 4:00 PM</span>
                        </p>
                        <a href="/events/wildlife-workshop" class="event-link">Register Now</a>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-date">
                        <span class="day">05</span>
                        <span class="month">Aug</span>
                    </div>
                    <div class="event-details">
                        <h3>Coastal Cleanup Day - Mombasa</h3>
                        <p class="event-info">
                            <span class="location">Nyali Beach, Mombasa</span>
                            <span class="time">7:00 AM - 11:00 AM</span>
                        </p>
                        <a href="/events/coastal-cleanup" class="event-link">Register Now</a>
                    </div>
                </div>
            </div>
            <div class="section-cta">
                <a href="/events" class="btn btn-secondary">View All Events</a>
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
                <a href="/donate" class="btn btn-primary">Donate Now</a>
                <a href="/volunteer" class="btn btn-secondary">Become a Volunteer</a>
                <a href="/contact" class="btn btn-secondary">Contact Us</a>
            </div>
        </div>
    </section>
</main>


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