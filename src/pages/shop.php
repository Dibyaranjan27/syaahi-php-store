<?php
session_start();
require_once('../includes/db.php');

$categoryId = isset($_GET['CategoryID']) ? (int)$_GET['CategoryID'] : 0;

$pageTitle = 'Shop';
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <h1 class="section-title fade-in-on-scroll">Browse Our Collection 📚</h1>

    <!-- Category Filter Pills -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5 fade-in-on-scroll">
        <a href="shop.php" class="btn <?php echo !$categoryId ? 'btn-lavender' : 'btn-outline-lavender'; ?> btn-pill btn-sm">All</a>
        <?php
        $catStmt = mysqli_prepare($conn, "SELECT * FROM categories ORDER BY CategoryName");
        mysqli_stmt_execute($catStmt);
        $catResult = mysqli_stmt_get_result($catStmt);
        while ($cat = mysqli_fetch_assoc($catResult)):
        ?>
            <a href="shop.php?CategoryID=<?php echo $cat['CategoryID']; ?>"
               class="btn <?php echo ($categoryId == $cat['CategoryID']) ? 'btn-lavender' : 'btn-outline-lavender'; ?> btn-pill btn-sm">
                <?php echo htmlspecialchars($cat['CategoryName']); ?>
            </a>
        <?php endwhile; ?>
    </div>

    <!-- Products Grid -->
    <div class="manga-grid">
        <?php
        // Pagination logic
        $limit = 12;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // Get total records
        if ($categoryId > 0) {
            $countStmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM products WHERE CategoryID = ? AND IsAvailable = 'AVAILABLE'");
            mysqli_stmt_bind_param($countStmt, "i", $categoryId);
        } else {
            $countStmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM products WHERE IsAvailable = 'AVAILABLE'");
        }
        mysqli_stmt_execute($countStmt);
        $countResult = mysqli_stmt_get_result($countStmt);
        $totalRows = mysqli_fetch_assoc($countResult)['total'];
        $totalPages = ceil($totalRows / $limit);

        // Fetch products
        if ($categoryId > 0) {
            $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE CategoryID = ? AND IsAvailable = 'AVAILABLE' LIMIT ? OFFSET ?");
            mysqli_stmt_bind_param($stmt, "iii", $categoryId, $limit, $offset);
        } else {
            $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE IsAvailable = 'AVAILABLE' LIMIT ? OFFSET ?");
            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
        }
        mysqli_stmt_execute($stmt);
        $products = mysqli_stmt_get_result($stmt);
        $idx = 0;

        while ($row = mysqli_fetch_assoc($products)):
            $idx++;
        ?>
        <div class="fade-in-on-scroll">
            <div class="product-card">
                <div class="position-relative">
                    <img src="<?php echo htmlspecialchars($row['ImgPath']); ?>"
                         class="card-img-top product-card-img"
                         alt="<?php echo htmlspecialchars($row['Title']); ?>">
                    <?php if ($row['Rating'] >= 5): ?>
                        <span class="badge-kawaii badge-bestseller position-absolute" style="top:12px;right:12px;">⭐ Bestseller</span>
                    <?php elseif ($idx <= 3): ?>
                        <span class="badge-kawaii badge-new position-absolute" style="top:12px;right:12px;">New! ✨</span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="product-detail.php?productId=<?php echo $row['ProductId']; ?>">
                            <?php echo htmlspecialchars($row['Title']); ?>
                        </a>
                    </h5>
                    <div class="star-rating mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="fa fa-star <?php echo ($i <= $row['Rating']) ? 'checked' : ''; ?>"></span>
                        <?php endfor; ?>
                    </div>
                    <p class="product-price mb-3">₹<?php echo $row['Price']; ?></p>
                    <div class="d-flex gap-2">
                        <a href="product-detail.php?productId=<?php echo $row['ProductId']; ?>" class="btn btn-lavender btn-pill flex-grow-1">View</a>
                        <a href="../api/wishlist-handler.php?productId=<?php echo $row['ProductId']; ?>&action=add" class="btn btn-outline-sakura btn-pill" title="Wishlist"><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <nav class="mt-5 fade-in-on-scroll">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $categoryId ? '&CategoryID='.$categoryId : ''; ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?><?php echo $categoryId ? '&CategoryID='.$categoryId : ''; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $categoryId ? '&CategoryID='.$categoryId : ''; ?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
    
    <!-- Empty State -->
    <?php if ($totalRows === 0): ?>
    <div class="text-center w-100 py-5">
        <div class="speech-bubble d-inline-block">
            No products found in this category! 🔍
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
