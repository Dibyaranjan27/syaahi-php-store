<!-- Wavy Top Divider -->
<div class="wave-divider wave-divider-footer">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
        <path fill="#4A3F6B" d="M0,40 C360,100 1080,0 1440,60 L1440,100 L0,100 Z"></path>
    </svg>
</div>

<!-- Syaahi Manga Footer -->
<footer class="syaahi-footer">
    <div class="container">
        <div class="row py-5">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 fade-in-on-scroll">
                <h5 class="footer-brand">
                    <i class="fas fa-pen-nib" style="color: var(--lavender-light);"></i> <?php echo SITE_NAME; ?>
                </h5>
                <p class="footer-tagline"><?php echo SITE_TAGLINE; ?></p>
                <p class="footer-desc">Your cozy corner for books, manga, and beautiful stickers. Made with 💜</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 fade-in-on-scroll">
                <h5 class="footer-heading">Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo SITE_URL; ?>"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                    <li><a href="<?php echo SITE_URL; ?>pages/shop.php"><i class="fas fa-chevron-right me-2"></i>Shop</a></li>
                    <li><a href="<?php echo SITE_URL; ?>pages/blog-listing.php"><i class="fas fa-chevron-right me-2"></i>Blog</a></li>
                    <li><a href="<?php echo SITE_URL; ?>pages/contact.php"><i class="fas fa-chevron-right me-2"></i>Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-12 fade-in-on-scroll">
                <h5 class="footer-heading">Connect With Us</h5>
                <div class="social-icons">
                    <a href="#" class="social-icon social-facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon social-twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon social-instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon social-pinterest"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="footer-copyright">
                    &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> &mdash; Made with 💜 &amp; ✒️
                </p>
            </div>
        </div>
    </div>
</footer>
