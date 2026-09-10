<?php
session_start();
require_once('includes/db.php');
$pageTitle = 'Home';
include('includes/head.php');
?>

<?php include('includes/navbar.php'); ?>

<!-- Hero Section -->
<section class="syaahi-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="hero-title">Discover Your<br>Next Story ✨</h1>
                <p class="hero-subtitle mt-3">Books, manga, and beautiful stickers — all in one cozy place.</p>
                <div class="hero-speech-bubble">
                    📚 New arrivals every week!
                </div>
                <br>
                <a href="pages/shop.php" class="hero-btn">Browse Shop →</a>
            </div>
            <div class="col-lg-6 text-center mt-4 mt-lg-0">
                <div id="syaahi-hero-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $featuredStmt = mysqli_prepare($conn, "SELECT * FROM products WHERE IsAvailable = 'AVAILABLE' ORDER BY Rating DESC LIMIT 5");
                        mysqli_stmt_execute($featuredStmt);
                        $featuredResult = mysqli_stmt_get_result($featuredStmt);
                        $first = true;
                        while ($item = mysqli_fetch_assoc($featuredResult)):
                        ?>
                        <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                            <div class="px-5 py-4">
                                <div class="product-card mx-auto" style="max-width:300px;">
                                    <img src="<?php echo htmlspecialchars($item['ImgPath']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['Title']); ?>" style="height:250px; object-fit:cover;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?php echo htmlspecialchars($item['Title']); ?></h5>
                                        <p class="product-price">₹<?php echo $item['Price']; ?></p>
                                        <a href="pages/product-detail.php?productId=<?php echo $item['ProductId']; ?>" class="btn btn-lavender btn-pill btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $first = false; endwhile; ?>
                    </div>
                    <a class="carousel-control-prev" href="#syaahi-hero-carousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#syaahi-hero-carousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Wavy Divider -->
<div class="wave-divider">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
        <path fill="#FFF8F0" d="M0,40 C360,100 1080,0 1440,60 L1440,100 L0,100 Z"></path>
    </svg>
</div>

<!-- Shop Section -->
<section class="container py-5">
    <div class="row">
        <div class="col-12">
            <?php if (isset($_SESSION['loggedInUserId'])): ?>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 fade-in-on-scroll">
                <h2 class="section-title mb-3 mb-md-0">Welcome back, <?php echo htmlspecialchars($_SESSION['usernamelogin']); ?>! 👋</h2>
                <div class="d-flex flex-wrap gap-3">
                    <a href="pages/cart.php" class="btn btn-outline-lavender btn-pill btn-sm px-3"><i class="fas fa-shopping-cart nav-icon"></i> My Cart</a>
                    <a href="pages/orders.php" class="btn btn-outline-sakura btn-pill btn-sm px-3"><i class="fas fa-box nav-icon"></i> Orders</a>
                    <a href="pages/wishlist.php" class="btn btn-outline-lavender btn-pill btn-sm px-3"><i class="fas fa-heart nav-icon"></i> Wishlist</a>
                </div>
            </div>
            <?php endif; ?>

            <h2 class="section-title fade-in-on-scroll">Our Collection 📖</h2>

            <!-- Category Filter Pills -->
            <div class="mb-4 fade-in-on-scroll">
                <a href="/" class="btn btn-lavender btn-pill btn-sm mb-2 me-2 px-3">All</a>
                <?php
                $catStmt = mysqli_prepare($conn, "SELECT * FROM categories ORDER BY CategoryName");
                mysqli_stmt_execute($catStmt);
                $catResult = mysqli_stmt_get_result($catStmt);
                while ($cat = mysqli_fetch_assoc($catResult)):
                ?>
                <a href="/?CategoryID=<?php echo $cat['CategoryID']; ?>" class="btn btn-outline-lavender btn-pill btn-sm mb-2 me-2 px-3">
                    <?php echo htmlspecialchars($cat['CategoryName']); ?>
                </a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="manga-grid">
        <?php
        if (isset($_GET['CategoryID'])) {
            $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE CategoryID = ? AND IsAvailable = 'AVAILABLE'");
            mysqli_stmt_bind_param($stmt, "i", $_GET['CategoryID']);
        } elseif (isset($_GET['Brand'])) {
            $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE Brand = ? AND IsAvailable = 'AVAILABLE'");
            mysqli_stmt_bind_param($stmt, "s", $_GET['Brand']);
        } else {
            $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE IsAvailable = 'AVAILABLE'");
        }
        mysqli_stmt_execute($stmt);
        $products = mysqli_stmt_get_result($stmt);
        $productIndex = 0;

        while ($row = mysqli_fetch_array($products)):
            $rating = $row['Rating'];
            $productIndex++;
        ?>
        <div class="fade-in-on-scroll">
            <div class="product-card">
                <div class="position-relative">
                    <img src="<?php echo htmlspecialchars($row['ImgPath']); ?>" class="card-img-top product-card-img" alt="<?php echo htmlspecialchars($row['Title']); ?>">
                    <?php if ($productIndex <= 2): ?>
                        <span class="badge-kawaii badge-new position-absolute" style="top:15px;right:15px;">New! ✨</span>
                    <?php elseif ($rating >= 4): ?>
                        <span class="badge-kawaii badge-bestseller position-absolute" style="top:15px;right:15px;">⭐ Bestseller</span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="pages/product-detail.php?productId=<?php echo $row['ProductId']; ?>">
                            <?php echo htmlspecialchars($row['Title']); ?>
                        </a>
                    </h5>
                    <div class="star-rating mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="fa fa-star <?php echo ($i <= $rating) ? 'checked' : ''; ?>"></span>
                        <?php endfor; ?>
                    </div>
                    <p class="product-price mb-3">₹<?php echo $row['Price']; ?></p>
                    <div class="d-flex gap-2">
                        <a href="pages/product-detail.php?productId=<?php echo $row['ProductId']; ?>" class="btn btn-lavender btn-pill flex-grow-1">View</a>
                        <a href="pages/product-detail.php?productId=<?php echo $row['ProductId']; ?>" class="btn btn-outline-sakura btn-pill" title="Wishlist"><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include('includes/footer.php'); ?>
<?php include('includes/scripts.php'); ?>
