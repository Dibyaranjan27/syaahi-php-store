<?php
session_start();
require_once('../includes/db.php');

// Get product
$productId = isset($_GET['productId']) ? (int)$_GET['productId'] : 0;
$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE ProductId = ?");
mysqli_stmt_bind_param($stmt, "i", $productId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header('Location: shop.php');
    exit;
}

$pageTitle = $product['Title'];
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-5 mb-4 fade-in-on-scroll">
            <div class="product-card p-3">
                <img src="<?php echo htmlspecialchars($product['ImgPath']); ?>"
                     class="img-fluid w-100"
                     style="border-radius: var(--radius-md); max-height: 500px; object-fit: cover;"
                     alt="<?php echo htmlspecialchars($product['Title']); ?>">
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-7 fade-in-on-scroll">
            <h1 class="section-title"><?php echo htmlspecialchars($product['Title']); ?></h1>

            <div class="star-rating mb-3">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="fa fa-star <?php echo ($i <= $product['Rating']) ? 'checked' : ''; ?>" style="font-size:1.3rem;"></span>
                <?php endfor; ?>
                <span class="ms-2 text-muted">(<?php echo $product['Rating']; ?>/5)</span>
            </div>

            <p class="product-price" style="font-size: 2rem;">₹<?php echo $product['Price']; ?></p>

            <p class="mt-3 mb-4" style="font-size: 1.05rem; line-height: 1.7;">
                <?php echo htmlspecialchars($product['Description']); ?>
            </p>

            <div class="d-flex flex-wrap gap-3 mb-4">
                <?php if (!empty($product['Brand'])): ?>
                <div class="badge-kawaii" style="font-size: 0.9rem; padding: 8px 16px;">
                    <strong>Brand:</strong> <?php echo htmlspecialchars($product['Brand']); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($product['Size'])): ?>
                <div class="badge-kawaii" style="font-size: 0.9rem; padding: 8px 16px;">
                    <strong>Format:</strong> <?php echo htmlspecialchars($product['Size']); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($product['Specification'])): ?>
                <div class="badge-kawaii" style="font-size: 0.9rem; padding: 8px 16px;">
                    <strong>Type:</strong> <?php echo htmlspecialchars($product['Specification']); ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Add to Cart -->
            <form action="../api/add-to-cart.php" method="POST" class="d-flex flex-wrap gap-3 align-items-end mt-4 mb-4">
                <input type="hidden" name="productId" value="<?php echo $product['ProductId']; ?>">
                <input type="hidden" name="price" value="<?php echo $product['Price']; ?>">
                <div>
                    <label class="form-label fw-bold">Quantity</label>
                    <input type="number" name="quantity" value="1" min="1" max="10" class="form-control" style="width:80px; border-radius: var(--radius-sm);">
                </div>
                <button type="submit" class="btn btn-sakura btn-pill px-4 py-2">
                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                </button>
            </form>

            <a href="../api/wishlist-handler.php?productId=<?php echo $product['ProductId']; ?>&action=add"
               class="btn btn-outline-lavender btn-pill px-4">
                <i class="far fa-heart me-2"></i>Add to Wishlist 💜
            </a>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="section-title fade-in-on-scroll">Reviews 💬</h3>

            <?php
            $commentStmt = mysqli_prepare($conn, "SELECT c.*, u.UserName FROM comments c JOIN users u ON c.UserID = u.UserID WHERE c.ProductId = ? AND c.Status = 1 ORDER BY c.Date DESC");
            mysqli_stmt_bind_param($commentStmt, "i", $productId);
            mysqli_stmt_execute($commentStmt);
            $comments = mysqli_stmt_get_result($commentStmt);
            $hasComments = false;

            while ($comment = mysqli_fetch_assoc($comments)):
                $hasComments = true;
            ?>
            <div class="speech-bubble mb-3 fade-in-on-scroll">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong style="color: var(--lavender-dark);" class="d-flex align-items-center gap-2">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($comment['UserName']); ?></span>
                    </strong>
                    <small class="text-muted"><?php echo $comment['Date']; ?></small>
                </div>
                <p class="mb-0"><?php echo htmlspecialchars($comment['Details']); ?></p>
            </div>
            <?php endwhile; ?>

            <?php if (!$hasComments): ?>
            <div class="speech-bubble mb-4 px-4 py-3">
                <span class="me-2">No reviews yet. Be the first!</span> ✍️
            </div>
            <?php endif; ?>

            <!-- Add Review Form -->
            <?php if (isset($_SESSION['loggedInUserId'])): ?>
            <div class="syaahi-form-card mt-4 fade-in-on-scroll" style="max-width: 600px; width: 100%;">
                <h5 class="form-title" style="font-size: 1.2rem;">Write a Review ✨</h5>
                <form action="../api/comment-handler.php" method="POST">
                    <input type="hidden" name="productId" value="<?php echo $product['ProductId']; ?>">
                    <div class="mb-4">
                        <textarea name="details" class="form-control" rows="4" placeholder="Share your thoughts..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-lavender btn-pill px-4">Submit Review</button>
                </form>
            </div>
            <?php else: ?>
            <p class="text-muted mt-2"><a href="login.php">Login</a> to write a review.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
