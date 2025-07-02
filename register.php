<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGR | Membership</title>
    <link rel="stylesheet" href="./styles/register.css">
     <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-RKXH6ENQNG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-RKXH6ENQNG');
</script>
<body>
<?php include './includes/navbar.php' ?>

<main class="membership-selection">
    <!-- Hero Section -->
    <section class="membership-hero">
        <div class="container">
            <div class="hero-content">
                <h1>Join Our Community</h1>
                <p class="hero-text">Choose the membership that aligns with your goals and help us protect Kenya's environment</p>
            </div>
        </div>
    </section>

    <!-- Membership Options -->
    <section class="membership-options">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Get Involved</span>
                <h2 class="section-title">Select Your Membership Type</h2>
                <p class="section-subtitle">Become part of our growing network of conservation champions</p>
            </div>

            <div class="membership-grid">
                <!-- Executive Membership -->
                <div class="membership-card executive">
                    <div class="card-header">
                        <div class="membership-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>Executive</h3>
                        <p class="price">By Invitation</p>
                    </div>
                    <div class="card-body">
                        <ul class="benefits-list">
                            <li><i class="fas fa-check"></i> Exclusive decision-making role</li>
                            <li><i class="fas fa-check"></i> Direct impact on strategic direction</li>
                            <li><i class="fas fa-check"></i> VIP event invitations</li>
                            <li><i class="fas fa-check"></i> Premium recognition</li>
                        </ul>
                        <div class="card-footer">
                            <a href="./contact-us.php">
                            <button class="btn-membership executive">
                                Contact Us <i class="fas fa-arrow-right"></i>
                            </button>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Volunteer Membership -->
                <div class="membership-card volunteer">
                    <div class="card-header">
                        <div class="membership-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>Volunteer</h3>
                        <p class="price">Free</p>
                    </div>
                    <div class="card-body">
                        <ul class="benefits-list">
                            <li><i class="fas fa-check"></i> Hands-on conservation work</li>
                            <li><i class="fas fa-check"></i> Training & skill development</li>
                            <li><i class="fas fa-check"></i> Community engagement</li>
                            <li><i class="fas fa-check"></i> Event participation</li>
                        </ul>
                        <div class="card-footer">
                            <a href="./register-volunteer.php" class="btn-membership volunteer">
                                Join Now <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Partner Membership -->
                <div class="membership-card partner">
                    <div class="card-header">
                        <div class="membership-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>Partner</h3>
                        <p class="price">Free</p>
                    </div>
                    <div class="card-body">
                        <ul class="benefits-list">
                            <li><i class="fas fa-check"></i> Collaborative projects</li>
                            <li><i class="fas fa-check"></i> Brand visibility</li>
                            <li><i class="fas fa-check"></i> Shared resources</li>
                            <li><i class="fas fa-check"></i> Joint initiatives</li>
                        </ul>
                        <div class="card-footer">
                            <a href="./register-partner.php" class="btn-membership partner">
                                Explore <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Organization Membership -->
                <div class="membership-card organization">
                    <div class="card-header">
                        <div class="membership-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Organization</h3>
                        <p class="price">Free</p>
                    </div>
                    <div class="card-body">
                        <ul class="benefits-list">
                            <li><i class="fas fa-check"></i> Corporate sustainability</li>
                            <li><i class="fas fa-check"></i> Employee engagement</li>
                            <li><i class="fas fa-check"></i> CSR opportunities</li>
                            <li><i class="fas fa-check"></i> Impact reporting</li>
                        </ul>
                        <div class="card-footer">
                            <a href="./register-organization.php" class="btn-membership organization">
                                Learn More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership CTA -->
    <section class="membership-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Need Help Choosing?</h2>
                <p>Our team is ready to guide you to the membership that best fits your goals</p>
                <a href="./contact-us.php" class="btn-cta">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
            </div>
        </div>
    </section>
</main>

<?php include './includes/footer.php' ?>

<script>
    function contactForExecutive() {
        window.location.href = "mailto:info@greengloberealisation.org?subject=Executive Membership Inquiry";
    }
</script>
</body>
</html>