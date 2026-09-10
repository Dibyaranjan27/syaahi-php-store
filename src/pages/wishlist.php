<?php
session_start();
require_once('../includes/db.php');
if (!isset($_SESSION['loggedInUserId'])) {
    header("Location: login.php");
    exit();
}
$pageTitle = 'My Wishlist';
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <h2 class="section-title text-center mb-5">My Wishlist 💖</h2>
    
    <?php
    $userId = $_SESSION['loggedInUserId'];
    $stmt = $conn->prepare("SELECT w.*, p.Title, p.ImgPath, p.Price, p.Rating, p.ProductId FROM wishlist w JOIN products p ON w.product_id = p.ProductId WHERE w.user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0):
    ?>
    <div class="manga-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card product-card h-100 fade-in-on-scroll">
            <img src="<?php echo htmlspecialchars($row['ImgPath']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['Title']); ?>" style="height:250px; object-fit:cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?php echo htmlspecialchars($row['Title']); ?></h5>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="product-price fw-bold">₹<?php echo number_format($row['Price'], 2); ?></span>
                    <span class="star-rating">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <span class="fa fa-star <?php echo ($i <= $row['Rating']) ? 'checked' : ''; ?>"></span>
                        <?php endfor; ?>
                    </span>
                </div>
                <div class="mt-auto d-flex gap-2">
                    <a href="product-detail.php?productId=<?php echo $row['ProductId']; ?>" class="btn btn-lavender btn-pill btn-sm flex-grow-1">View</a>
                    <a href="../api/wishlist-handler.php?productId=<?php echo $row['ProductId']; ?>&action=remove" class="btn btn-outline-sakura btn-pill btn-sm px-3">
                        <i class="fas fa-trash-alt nav-icon"></i> Remove
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php else: ?>
    <div class="text-center">
        <div class="speech-bubble d-inline-block">Your wishlist is empty! ✨</div>
    </div>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
