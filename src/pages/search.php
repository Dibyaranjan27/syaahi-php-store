<?php
session_start();
require_once('../includes/db.php');
$pageTitle = 'Search Products';
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <h2 class="section-title text-center mb-4">Search Syaahi 🔍</h2>
    
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <form method="GET" action="search.php" class="d-flex">
                <input type="text" name="q" class="form-control me-2" placeholder="Search for books or stickers..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" required>
                <button type="submit" class="btn btn-lavender btn-pill px-4">Search</button>
            </form>
        </div>
    </div>
    
    <?php if(isset($_GET['q'])): 
        $search = '%' . $_GET['q'] . '%';
        $stmt = $conn->prepare("SELECT * FROM products WHERE Title LIKE ? AND IsAvailable = 'AVAILABLE'");
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();
    ?>
    
        <h4 class="mb-4 text-center">Results for "<?php echo htmlspecialchars($_GET['q']); ?>"</h4>
        
        <?php if($result->num_rows > 0): ?>
            <div class="manga-grid">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="card product-card h-100 fade-in-on-scroll">
                        <img src="<?php echo htmlspecialchars($row['ImgPath']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['Title']); ?>" style="height:250px; object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['Title']); ?></h5>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="product-price fw-bold">₹<?php echo number_format($row['Price'], 2); ?></span>
                                <span class="star-rating text-warning">
                                    <?php for($i=0; $i<$row['Rating']; $i++) echo '★'; ?>
                                    <?php for($i=$row['Rating']; $i<5; $i++) echo '☆'; ?>
                                </span>
                            </div>
                            <a href="product-details.php?id=<?php echo $row['ProductId']; ?>" class="btn btn-outline-lavender btn-sm mt-auto">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center">
                <div class="speech-bubble d-inline-block">No items found matching your search. 🥺</div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
