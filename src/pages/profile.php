<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['loggedInUserId'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = 'My Profile';
$userId = $_SESSION['loggedInUserId'];

$stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get stats
$orderCount = 0;
$wishlistCount = 0;
$blogCount = 0;

$oStmt = $conn->prepare("SELECT COUNT(*) as cnt FROM orders WHERE clientId = ?");
$oStmt->bind_param("i", $userId);
$oStmt->execute();
$orderCount = $oStmt->get_result()->fetch_assoc()['cnt'];

$wStmt = $conn->prepare("SELECT COUNT(*) as cnt FROM wishlist WHERE user_id = ?");
$wStmt->bind_param("i", $userId);
$wStmt->execute();
$wishlistCount = $wStmt->get_result()->fetch_assoc()['cnt'];

$bStmt = $conn->prepare("SELECT COUNT(*) as cnt FROM blog_posts WHERE author_id = ?");
$bStmt->bind_param("i", $userId);
$bStmt->execute();
$blogCount = $bStmt->get_result()->fetch_assoc()['cnt'];

include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <!-- Profile Header Card -->
            <div class="syaahi-form-card text-center mb-4 fade-in-on-scroll" style="padding: 50px 40px;">
                <!-- Avatar -->
                <div class="mb-4">
                    <div class="profile-avatar">
                        <?php echo strtoupper(substr($user['UserName'], 0, 1)); ?>
                    </div>
                </div>

                <h2 style="color: var(--dark-purple); font-family: 'Quicksand', sans-serif; font-weight: 700;">
                    <?php echo htmlspecialchars($user['UserName']); ?>
                </h2>
                <p class="text-muted mb-0">Member of Syaahi ✨</p>
            </div>

            <!-- Stats Row -->
            <div class="row mb-4">
                <div class="col-12 col-md-4 mb-3 mb-md-0 fade-in-on-scroll">
                    <a href="orders.php" class="text-decoration-none">
                        <div class="profile-stat-card">
                            <span class="profile-stat-icon">📦</span>
                            <span class="profile-stat-number"><?php echo $orderCount; ?></span>
                            <span class="profile-stat-label">Orders</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-4 mb-3 mb-md-0 fade-in-on-scroll">
                    <a href="wishlist.php" class="text-decoration-none">
                        <div class="profile-stat-card">
                            <span class="profile-stat-icon">💜</span>
                            <span class="profile-stat-number"><?php echo $wishlistCount; ?></span>
                            <span class="profile-stat-label">Wishlist</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-4 fade-in-on-scroll">
                    <a href="blog-manage.php" class="text-decoration-none">
                        <div class="profile-stat-card">
                            <span class="profile-stat-icon">✍️</span>
                            <span class="profile-stat-number"><?php echo $blogCount; ?></span>
                            <span class="profile-stat-label">Blog Posts</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Info Card -->
            <div class="syaahi-form-card mb-4 fade-in-on-scroll">
                <h5 class="form-title" style="font-size: 1.15rem;">Account Details</h5>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="form-label text-muted mb-1" style="font-size: 0.85rem;">Email Address</label>
                        <p class="fw-bold mb-0" style="color: var(--dark-purple);">
                            <i class="fas fa-envelope nav-icon" style="color: var(--lavender);"></i>
                            <?php echo htmlspecialchars($user['Email']); ?>
                        </p>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="form-label text-muted mb-1" style="font-size: 0.85rem;">Phone Number</label>
                        <p class="fw-bold mb-0" style="color: var(--dark-purple);">
                            <i class="fas fa-phone nav-icon" style="color: var(--lavender);"></i>
                            <?php echo htmlspecialchars($user['Phone']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="syaahi-form-card fade-in-on-scroll">
                <h5 class="form-title" style="font-size: 1.15rem;">Quick Actions</h5>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <a href="orders.php" class="btn btn-lavender btn-pill w-100">
                        <i class="fas fa-box-open nav-icon"></i> My Orders
                    </a>
                    <a href="wishlist.php" class="btn btn-sakura btn-pill w-100">
                        <i class="fas fa-heart nav-icon"></i> My Wishlist
                    </a>
                    <a href="blog-manage.php" class="btn btn-mint btn-pill w-100">
                        <i class="fas fa-pen-nib nav-icon"></i> My Blog Posts
                    </a>
                    <a href="shop.php" class="btn btn-outline-lavender btn-pill w-100">
                        <i class="fas fa-store nav-icon"></i> Browse Shop
                    </a>
                </div>
                <hr style="border-color: var(--lavender-light); margin: 24px 0;">
                <div class="d-flex justify-content-center gap-3">
                    <a href="change-password.php" class="btn btn-outline-lavender btn-pill px-4">
                        <i class="fas fa-key nav-icon"></i> Change Password
                    </a>
                    <a href="../api/logout.php" class="btn btn-outline-sakura btn-pill px-4">
                        <i class="fas fa-sign-out-alt nav-icon"></i> Logout
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
