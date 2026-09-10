<!-- Syaahi Manga Navbar -->
<nav class="navbar navbar-expand-lg navbar-light syaahi-navbar sticky-top">
    <div class="container">

        <a class="navbar-brand syaahi-logo" href="<?php echo SITE_URL; ?>">
            <span class="logo-icon"><i class="fas fa-pen-nib"></i></span>
            <span class="logo-text"><?php echo SITE_NAME; ?></span>
        </a>

        <button class="navbar-toggler border-0 syaahi-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#syaahi_nav" aria-controls="syaahi_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="syaahi_nav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>">
                        <i class="fas fa-home nav-icon"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>pages/shop.php">
                        <i class="fas fa-store nav-icon"></i> Shop
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>pages/about.php">
                        <i class="fas fa-heart nav-icon"></i> About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>pages/blog-listing.php">
                        <i class="fas fa-book-open nav-icon"></i> Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>pages/contact.php">
                        <i class="fas fa-envelope nav-icon"></i> Contact
                    </a>
                </li>
            </ul>

            <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 mt-3 mt-lg-0 nav-auth-buttons">
                <?php if (!isset($_SESSION['usernamelogin'])): ?>
                    <a class="btn btn-outline-lavender btn-pill px-4" href="<?php echo SITE_URL; ?>pages/login.php">Login</a>
                    <a class="btn btn-sakura btn-pill px-4" href="<?php echo SITE_URL; ?>pages/register.php">Sign Up ✨</a>
                <?php else: ?>
                    <span class="nav-welcome mb-2 mb-lg-0 text-center text-lg-start">Hi, <?php echo htmlspecialchars($_SESSION['usernamelogin']); ?>! 👋</span>
                    <a class="btn btn-outline-lavender btn-pill btn-sm px-4" href="<?php echo SITE_URL; ?>pages/profile.php">
                        <i class="fas fa-user nav-icon"></i> Profile
                    </a>
                    <a class="btn btn-outline-sakura btn-pill btn-sm px-4" href="<?php echo SITE_URL; ?>pages/logout.php">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
