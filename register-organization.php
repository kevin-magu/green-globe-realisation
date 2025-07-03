<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Organization | GGR</title>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/register-organization.css">
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

<main class="organization-page">
    <section class="organization-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="section-title">Register Your Organization</h1>
                <p class="section-subtitle">Join our network of environmental organizations working together for a sustainable future.</p>
            </div>
        </div>
    </section>

    <section class="organization-form-section">
        <div class="container">
            <div class="form-container">
                <h2>Organization Registration</h2>
                <p class="form-intro">Please complete this form to register your organization with Green Globe Realisation. Our team will review your application within 3-5 business days.</p>
                
                <form id="organizationForm" class="organization-form">
                    <div id="feedback" style="color: green; margin-top: 10px;"></div>
                    
                    <!-- Organization Logo Upload -->
                    <div class="form-group file-upload">
                        <label>Organization Logo*</label>
                        <div class="upload-area">
                            <div class="drop-zone" id="dropZone">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <p>Drag & drop your logo or click to browse</p>
                                <input type="file" id="fileInput" name="organizationLogo" accept="image/*" required>
                            </div>
                            <div class="preview-container" id="previewContainer"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="organizationName">Organization Name*</label>
                            <input type="text" id="organizationName" name="organizationName" placeholder="e.g. Eco Warriors Foundation" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="organizationType">Organization Type*</label>
                            <select id="organizationType" name="organizationType" required>
                                <option value="">Select your organization type</option>
                                <option value="NGO">Non-Governmental Organization (NGO)</option>
                                <option value="CBO">Community-Based Organization (CBO)</option>
                                <option value="NonProfit">Non-Profit Organization</option>
                                <option value="Research">Research Institution</option>
                                <option value="Educational">Educational Institution</option>
                                <option value="Government">Government Agency</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                   
                    <div class="form-group two-columns">
                        <div class="form-field">
                            <label for="contactPerson">Primary Contact Person*</label>
                            <input type="text" id="contactPerson" name="contactPerson" placeholder="Full name" required>
                        </div>
                        <div class="form-field">
                            <label for="contactPosition">Position*</label>
                            <input type="text" id="contactPosition" name="contactPosition" placeholder="e.g. Executive Director" required>
                        </div>
                    </div>

                    <div class="form-group two-columns">
                        <div class="form-field">
                            <label for="email">Email Address*</label>
                            <input type="email" id="email" name="email" placeholder="e.g. contact@organization.org" required>
                        </div>
                        <div class="form-field">
                            <label for="phone">Phone Number*</label>
                            <input type="tel" id="phone" name="phone" placeholder="+254712345678" pattern="^\+\d{10,15}$" title="Include country code. e.g. +254712345678" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" placeholder="https://www.organization.org">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="address">Physical Address*</label>
                            <input type="text" id="address" name="address" placeholder="Street address, building" required>
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
                            <label for="mission">Mission Statement*</label>
                            <textarea id="mission" name="mission" rows="3" placeholder="Brief description of your organization's mission and objectives" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="focusAreas">Primary Focus Areas*</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="conservation" name="focusAreas[]" value="Conservation">
                                    <label for="conservation">Conservation</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="climate" name="focusAreas[]" value="Climate Change">
                                    <label for="climate">Climate Change</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="education" name="focusAreas[]" value="Environmental Education">
                                    <label for="education">Environmental Education</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="waste" name="focusAreas[]" value="Waste Management">
                                    <label for="waste">Waste Management</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="water" name="focusAreas[]" value="Water Resources">
                                    <label for="water">Water Resources</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="other" name="focusAreas[]" value="Other">
                                    <label for="other">Other (specify below)</label>
                                </div>
                            </div>
                            <textarea id="otherFocus" name="otherFocus" rows="2" placeholder="If you selected 'Other', please specify" class="mt-1"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="collaborationInterest">Collaboration Interest*</label>
                            <textarea id="collaborationInterest" name="collaborationInterest" rows="3" placeholder="Describe how you'd like to collaborate with our network" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field checkbox-field">
                            <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                            <label for="agreeTerms">I confirm that the information provided is accurate and agree to the <a href="#">Terms of Membership</a> and <a href="#">Privacy Policy</a>*</label>
                        </div>
                    </div>

                    <div class="g-recaptcha" data-sitekey="6LeQzGArAAAAADJxJ7QF3Xu936mWw3yNRQyUCGb2"></div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id='submit-button'>Submit Registration</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="organization-benefits">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Why Join Our Network</span>
                <h2 class="section-title">Benefits for Organizations</h2>
            </div>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Network Access</h3>
                    <p>Connect with hundreds of environmental organizations working towards similar goals across the region.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Capacity Building</h3>
                    <p>Access training programs, workshops and resources to strengthen your organization's capabilities.</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Collaboration Opportunities</h3>
                    <p>Find partners for joint projects, funding opportunities and knowledge exchange.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Visibility & Recognition</h3>
                    <p>Showcase your work through our platforms and gain recognition in the environmental community.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>Resource Sharing</h3>
                    <p>Access our library of research, tools and best practices for environmental organizations.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>Funding Opportunities</h3>
                    <p>Get notified about grants, funding opportunities and donor connections.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include './includes/footer.php'; ?>
<script src='./apis/registerOrganization.js'></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>