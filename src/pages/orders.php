<?php
session_start();
require_once('../includes/db.php');
if (!isset($_SESSION['loggedInUserId'])) {
    header("Location: login.php");
    exit();
}
$pageTitle = 'Order History';
include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <h2 class="section-title text-center mb-5">Order History 📦</h2>
    
    <?php
    $userId = $_SESSION['loggedInUserId'];
    $stmt = $conn->prepare("SELECT o.*, p.Title, p.ImgPath FROM orders o JOIN products p ON o.ProductId = p.ProductId WHERE o.clientId = ? ORDER BY o.DateOfOrder DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0):
    ?>
    <div class="table-responsive">
        <table class="table syaahi-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td data-label="Order ID">#<?php echo htmlspecialchars($row['orderId']); ?></td>
                    <td data-label="Product" class="mobile-full-width">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo htmlspecialchars($row['ImgPath']); ?>" alt="<?php echo htmlspecialchars($row['Title']); ?>" style="width: 50px; height: 50px; object-fit: cover;" class="mr-3 rounded">
                            <span style="white-space: normal;"><?php echo htmlspecialchars($row['Title']); ?></span>
                        </div>
                    </td>
                    <td data-label="Date"><?php echo htmlspecialchars($row['DateOfOrder']); ?></td>
                    <td data-label="Quantity"><?php echo htmlspecialchars($row['Quantity']); ?></td>
                    <td data-label="Total Price">₹<?php echo number_format($row['Price'] * $row['Quantity'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="text-center">
        <div class="speech-bubble d-inline-block">You haven't placed any orders yet! 🌸</div>
    </div>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
