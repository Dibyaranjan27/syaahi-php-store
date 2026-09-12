<?php
session_start();
require_once('../includes/db.php');
if (!isset($_SESSION['loggedInUserId'])) {
    header("Location: login.php");
    exit();
}
$pageTitle = 'Shopping Cart';
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <h2 class="section-title text-center mb-5">Your Cart</h2>
    
    <?php
    $userId = $_SESSION['loggedInUserId'];
    $stmt = $conn->prepare("SELECT sc.*, p.Title, p.ImgPath, p.Price as UnitPrice FROM shoppingcart sc JOIN products p ON sc.ProductId = p.ProductId WHERE sc.clientId = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;
    
    if ($result->num_rows > 0):
    ?>
    <div class="table-responsive">
        <table class="table syaahi-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): 
                    $subtotal = $row['UnitPrice'] * $row['Quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td data-label="Product" class="mobile-full-width">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?php echo htmlspecialchars($row['ImgPath']); ?>" alt="<?php echo htmlspecialchars($row['Title']); ?>" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                            <span style="white-space: normal;"><?php echo htmlspecialchars($row['Title']); ?></span>
                        </div>
                    </td>
                    <td data-label="Price">₹<?php echo number_format($row['UnitPrice'], 2); ?></td>
                    <td data-label="Quantity">
                        <form action="../api/order-update.php" method="POST" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="ProductId" value="<?php echo $row['ProductId']; ?>">
                            <input type="number" name="quantity" value="<?php echo $row['Quantity']; ?>" min="1" class="form-control" style="width: 80px;">
                            <button type="submit" class="btn btn-sm btn-lavender btn-pill px-3">Update</button>
                        </form>
                    </td>
                    <td data-label="Total">₹<?php echo number_format($subtotal, 2); ?></td>
                    <td data-label="Action">
                        <a href="../api/order-delete.php?productId=<?php echo $row['ProductId']; ?>" class="btn btn-sm btn-outline-sakura btn-pill px-3">
                            <i class="fas fa-trash-alt nav-icon"></i> Remove
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <div class="d-flex flex-column flex-md-row justify-content-md-end align-items-md-center gap-3 mt-4 text-center text-md-start">
        <h4 class="mb-0">Grand Total:<br class="d-block d-md-none"> ₹<?php echo number_format($total, 2); ?></h4>
        <a href="checkout.php" class="btn btn-sakura btn-pill px-4">
            <i class="fas fa-credit-card nav-icon"></i> Checkout
        </a>
    </div>
    
    <?php else: ?>
    <div class="text-center">
        <div class="speech-bubble d-inline-block">Your cart is empty! 🛒</div>
        <div class="mt-4"><a href="search.php" class="btn btn-lavender btn-pill">Continue Shopping</a></div>
    </div>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
