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
    $stripeKey = getenv('STRIPE_SECRET_KEY');
    
    // If no real Stripe key is provided, mock the checkout for local testing
    if (!$stripeKey || strpos($stripeKey, 'sk_test_51Mock') !== false || $stripeKey === 'sk_test_123') {
        $mockSessionId = 'cs_test_mock_' . bin2hex(random_bytes(16));
        header("Location: checkout-success.php?session_id=" . $mockSessionId);
        exit();
    }
    
    require_once('../vendor/autoload.php');
    \Stripe\Stripe::setApiKey($stripeKey);
    $stmt = $conn->prepare("SELECT * FROM shoppingcart WHERE clientId = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $cart_result = $stmt->get_result();
    
    if ($cart_result->num_rows > 0) {
        $line_items = [];
        
        while ($item = $cart_result->fetch_assoc()) {
            $pStmt = $conn->prepare("SELECT Title FROM products WHERE ProductId = ?");
            $pStmt->bind_param("i", $item['ProductId']);
            $pStmt->execute();
            $title = $pStmt->get_result()->fetch_assoc()['Title'];
            
            $line_items[] = [
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => $title,
                    ],
                    'unit_amount' => $item['Price'] * 100,
                ],
                'quantity' => $item['Quantity'],
            ];
        }
        
        // Protocol and host
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $domain = "{$protocol}://{$_SERVER['HTTP_HOST']}";

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => $domain . '/src/pages/checkout-success.php?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $domain . '/src/pages/cart.php',
        ]);
        
        header("Location: " . $checkout_session->url);
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
