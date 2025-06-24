<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance | Green Globe Realisation</title>
     <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/register-volunteer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include './includes/navbar.php' ?>

<main class="volunteer-page">
    <section class="volunteer-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="section-title">Become a Volunteer</h1>
                <p class="section-subtitle">Help us make a difference in environmental conservation. Your time and skills can contribute to meaningful change.</p>
            </div>
        </div>
    </section>

    <section class="volunteer-form-section">
        <div class="container">
            <div class="form-container">
                <h2>Volunteer Registration</h2>
                <p class="form-intro">Please fill out the form below to apply as a volunteer. We'll get back to you within 3-5 business days.</p>
                
                <form id="volunteerForm" class="volunteer-form">
                    <div id="feedback" style="color: green; margin-top: 10px;"></div>
                    <!-- Profile Picture Upload -->
                <div class="form-group file-upload">
                    <label>Profile Picture</label>
                    <div class="upload-area">
                        <div class="drop-zone" id="dropZone">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p>Drag & drop profile photo or click to browse</p>
                            <input type="file" id="fileInput" name="profilePicture" accept="image/*" required>
                        </div>
                        <div class="preview-container" id="previewContainer"></div>
                    </div>
                </div>
        <div class="form-group two-columns">
          <div class="form-field">
            <label for="firstName">First Name*</label>
            <input type="text" id="firstName" name="firstName" placeholder="e.g. Jane" required>
          </div>
          <div class="form-field">
            <label for="lastName">Last Name*</label>
            <input type="text" id="lastName" name="lastName" placeholder="e.g. Doe" required>
          </div>
        </div>

        <div class="form-group">
          <div class="form-field">
            <label for="email">Email Address*</label>
            <input type="email" id="email" name="email" placeholder="e.g. jane.doe@example.com" required>
          </div>
        </div>

        <div class="form-group">
          <div class="form-field">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="+254712345678" pattern="^\+\d{10,15}$" title="Include country code. e.g. +254712345678">
          </div>
        </div>

        <div class="form-group">
          <div class="form-field">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="e.g. 123 Green Street">
          </div>
        </div>

        <div class="form-group">
          <div class="form-field">
            <label for="city">City</label>
            <input type="text" id="city" name="city" placeholder="e.g. Nairobi">
          </div>
        </div>

        <div class="form-group">
          <div class="form-field">
            <label for="skills">Skills & Expertise</label>
            <textarea id="skills" name="skills" rows="3" placeholder="Please describe your skills, experience, or areas of expertise"></textarea>
          </div>
        </div>
        <div class="g-recaptcha" data-sitekey="6LeQzGArAAAAADJxJ7QF3Xu936mWw3yNRQyUCGb2"></div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Submit Application</button>
        </div>
      </form>
            </div>
        </div>
    </section>

    <section class="volunteer-benefits">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Why Volunteer With Us</span>
                <h2 class="section-title">Benefits of Volunteering</h2>
            </div>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="var(--primary)">
                            <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3zm-1.06 13.54L7.4 12l1.41-1.41 2.12 2.12 4.24-4.24 1.41 1.41-5.64 5.66z"/>
                        </svg>
                    </div>
                    <h3>Make a Difference</h3>
                    <p>Contribute directly to environmental conservation efforts and see the impact of your work.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="var(--primary)">
                            <path d="M12 3L1 9l11 6 9-4.91V17h2V9M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                        </svg>
                    </div>
                    <h3>Learn New Skills</h3>
                    <p>Gain valuable experience and training in environmental work and nonprofit operations.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="var(--primary)">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                        </svg>
                    </div>
                    <h3>Build Community</h3>
                    <p>Connect with like-minded individuals passionate about environmental sustainability.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include './includes/footer.php'; ?>
<script src='./apis/registerVolunteer.js'></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>