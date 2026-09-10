<?php
session_start();
require_once('../includes/db.php');
if (!isset($_SESSION['loggedInUserId'])) {
    header("Location: login.php");
    exit();
}
$pageTitle = 'Checkout';
$userId = $_SESSION['loggedInUserId'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("SELECT * FROM shoppingcart WHERE clientId = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $cart_result = $stmt->get_result();
    
    if ($cart_result->num_rows > 0) {
        $orderId = uniqid('ORD-');
        $date = date('Y-m-d H:i:s');
        
        while ($item = $cart_result->fetch_assoc()) {
            $insert_order = $conn->prepare("INSERT INTO orders (orderId, ProductId, Price, Quantity, DateOfOrder, clientId) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_order->bind_param("siiisi", $orderId, $item['ProductId'], $item['Price'], $item['Quantity'], $date, $userId);
            $insert_order->execute();
        }
        
        $clear_cart = $conn->prepare("DELETE FROM shoppingcart WHERE clientId = ?");
        $clear_cart->bind_param("i", $userId);
        $clear_cart->execute();
        
        header("Location: orders.php?success=1");
        exit();
    }
}

include('../includes/head.php');
?>
<?php include('../includes/navbar.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="syaahi-form-card shadow-sm p-4 rounded bg-white">
                <h2 class="section-title text-center mb-4">Checkout 🛍️</h2>
                
                <?php
                $stmt = $conn->prepare("SELECT sc.*, p.Title, p.Price as UnitPrice FROM shoppingcart sc JOIN products p ON sc.ProductId = p.ProductId WHERE sc.clientId = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $total = 0;
                
                if ($result->num_rows > 0):
                ?>
                <div class="table-responsive mb-4">
                    <table class="table syaahi-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): 
                                $subtotal = $row['UnitPrice'] * $row['Quantity'];
                                $total += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Title']); ?></td>
                                <td><?php echo htmlspecialchars($row['Quantity']); ?></td>
                                <td class="text-end">₹<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end fw-bold">Total:</th>
                                <th class="text-end fw-bold">₹<?php echo number_format($total, 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <form method="POST" class="text-center">
                    <button type="submit" class="btn btn-sakura btn-pill px-5 py-2 fs-5">Confirm Order</button>
                </form>
                
                <?php else: ?>
                <div class="text-center">
                    <div class="speech-bubble d-inline-block">Your cart is empty! Cannot checkout.</div>
                    <div class="mt-3"><a href="search.php" class="btn btn-lavender btn-pill">Shop Now</a></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php include('../includes/scripts.php'); ?>
