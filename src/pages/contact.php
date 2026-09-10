<?php
session_start();
require_once('../includes/db.php');

$pageTitle = 'Contact Us';
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <h1 class="section-title text-center fade-in-on-scroll">Get in Touch 💌</h1>
    <p class="text-center text-muted mb-5 fade-in-on-scroll">We'd love to hear from you! Whether it's about books, stickers, or just a hello.</p>

    <!-- Contact Info Cards -->
    <div class="row mb-5">
        <div class="col-md-4 mb-3 fade-in-on-scroll">
            <div class="contact-info-card h-100">
                <i class="fas fa-envelope"></i>
                <h5>Email</h5>
                <p class="text-muted mb-0">hello@syaahi.com</p>
            </div>
        </div>
        <div class="col-md-4 mb-3 fade-in-on-scroll">
            <div class="contact-info-card h-100">
                <i class="fas fa-phone"></i>
                <h5>Phone</h5>
                <p class="text-muted mb-0">+91 98765 43210</p>
            </div>
        </div>
        <div class="col-md-4 mb-3 fade-in-on-scroll">
            <div class="contact-info-card h-100">
                <i class="fas fa-map-marker-alt"></i>
                <h5>Address</h5>
                <p class="text-muted mb-0">New Delhi, India</p>
            </div>
        </div>
    </div>

    <!-- Feedback Form -->
    <div id="feedback" class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 mx-auto fade-in-on-scroll">
            <div class="syaahi-form-card">
                <h3 class="form-title">Send us a Message ✨</h3>

                <?php if (isset($_GET['success'])): ?>
                    <div class="speech-bubble success mb-4">
                        <i class="fas fa-check-circle me-2"></i>Thank you! Your message has been sent. 💜
                    </div>
                <?php elseif (isset($_GET['error'])): ?>
                    <div class="speech-bubble error mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i>Please fill in all required fields.
                    </div>
                <?php endif; ?>

                <form action="../api/contact-handler.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">First Name *</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Your first name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Your last name">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email_address" class="form-label">Email Address *</label>
                        <input type="email" name="email_address" id="email_address" class="form-control" placeholder="your@email.com" required>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="form-label">Message *</label>
                        <textarea name="comment" id="comment" class="form-control" rows="5" placeholder="Tell us what's on your mind..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-sakura btn-pill px-5">
                        Send Message 💌
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
