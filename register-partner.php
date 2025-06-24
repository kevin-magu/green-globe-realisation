<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Registration | Green Globe Realisation</title>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/register-partner.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include './includes/navbar.php' ?>

<main class="partner-page">
    <section class="partner-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="section-title">Become a Partner</h1>
                <p class="section-subtitle">Join forces with us to create sustainable environmental solutions. Together we can achieve greater impact.</p>
            </div>
        </div>
    </section>

    <section class="partner-form-section">
        <div class="container">
            <div class="form-container">
                <h2>Partner Registration</h2>
                <p class="form-intro">Please fill out the form below to apply as a partner organization. We'll review your application and get back to you within 5-7 business days.</p>
                
                <form id="partnerForm" class="partner-form">
                    <div id="feedback" style="color: green; margin-top: 10px;"></div>
                    
                    <!-- Organization Logo Upload -->
                    <div class="form-group file-upload">
                        <label>Organization Logo</label>
                        <div class="upload-area">
                            <div class="drop-zone" id="dropZone">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <p>Drag & drop your logo or click to browse</p>
                                <input type="file" id="fileInput" name="organizationLogo" accept="image/*">
                            </div>
                            <div class="preview-container" id="previewContainer"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="organizationName">Organization Name*</label>
                            <input type="text" id="organizationName" name="organizationName" placeholder="e.g. Eco Solutions Ltd" required>
                        </div>
                    </div>

                    <div class="form-group two-columns">
                        <div class="form-field">
                            <label for="contactPerson">Contact Person*</label>
                            <input type="text" id="contactPerson" name="contactPerson" placeholder="Full name of primary contact" required>
                        </div>
                        <div class="form-field">
                            <label for="position">Position*</label>
                            <input type="text" id="position" name="position" placeholder="e.g. Sustainability Manager" required>
                        </div>
                    </div>

                    <div class="form-group two-columns">
                        <div class="form-field">
                            <label for="email">Email Address*</label>
                            <input type="email" id="email" name="email" placeholder="e.g. contact@example.com" required>
                        </div>
                        <div class="form-field">
                            <label for="phone">Phone Number*</label>
                            <input type="tel" id="phone" name="phone" placeholder="+254712345678" pattern="^\+\d{10,15}$" title="Include country code. e.g. +254712345678" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="organizationType">Organization Type*</label>
                            <select id="organizationType" name="organizationType" required>
                                <option value="">Select organization type</option>
                                <option value="NGO">Non-Profit Organization</option>
                                <option value="Corporate">Corporate/Business</option>
                                <option value="Government">Government Agency</option>
                                <option value="Educational">Educational Institution</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" placeholder="https://www.example.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="address">Organization Address*</label>
                            <input type="text" id="address" name="address" placeholder="Street address" required>
                        </div>
                    </div>

                    <div class="form-group two-columns">
                        <div class="form-field">
                            <label for="city">City*</label>
                            <input type="text" id="city" name="city" placeholder="e.g. Nairobi" required>
                        </div>
                        <div class="form-field">
                            <label for="country">Country*</label>
                            <input type="text" id="country" name="country" placeholder="e.g. Kenya" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="mission">Organization Mission</label>
                            <textarea id="mission" name="mission" rows="3" placeholder="Brief description of your organization's mission"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="partnershipInterest">Partnership Interest*</label>
                            <select id="partnershipInterest" name="partnershipInterest" required>
                                <option value="">Select area of interest</option>
                                <option value="Funding">Funding/Sponsorship</option>
                                <option value="Collaboration">Project Collaboration</option>
                                <option value="Resources">Resource Sharing</option>
                                <option value="Expertise">Knowledge/Expertise Exchange</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="partnershipDetails">Partnership Proposal*</label>
                            <textarea id="partnershipDetails" name="partnershipDetails" rows="4" placeholder="Describe how you would like to partner with us and what you can bring to the collaboration" required></textarea>
                        </div>
                    </div>

                  <!--  <div class="form-group">
                        <div class="form-field checkbox-field">
                            <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                            <label for="agreeTerms">I agree to the <a href="#">Terms of Partnership</a> and <a href="#">Privacy Policy</a>*</label>
                        </div>
                    </div> -->

                    <div class="g-recaptcha" data-sitekey="6LeQzGArAAAAADJxJ7QF3Xu936mWw3yNRQyUCGb2"></div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="partner-benefits">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Why Partner With Us</span>
                <h2 class="section-title">Benefits of Partnership</h2>
            </div>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Strategic Collaboration</h3>
                    <p>Combine resources and expertise to create greater environmental impact than either organization could achieve alone.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Enhanced Visibility</h3>
                    <p>Gain exposure through our networks and joint marketing initiatives showcasing your commitment to sustainability.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Shared Knowledge</h3>
                    <p>Access to our research, best practices, and environmental insights to strengthen your sustainability efforts.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Networking Opportunities</h3>
                    <p>Connect with other like-minded organizations and potential collaborators in our partner network.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Certification</h3>
                    <p>Receive recognition as an official Green Globe Realisation partner with certification for your sustainability efforts.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3>Innovation</h3>
                    <p>Collaborate on innovative solutions to environmental challenges through joint projects and initiatives.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include './includes/footer.php'; ?>
<script src='./apis/registerPartner.js'></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>