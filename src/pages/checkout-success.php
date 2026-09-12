<?php
session_start();
require_once('../includes/db.php');
require_once('../includes/EmailService.php');

if (!isset($_SESSION['loggedInUserId'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_GET['session_id'])) {
    header("Location: ../index.php");
    exit();
}

$userId = $_SESSION['loggedInUserId'];

// Create Order from Cart
$stmt = $conn->prepare("SELECT * FROM shoppingcart WHERE clientId = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$cart_result = $stmt->get_result();

$totalAmount = 0;
if ($cart_result->num_rows > 0) {
    $orderId = uniqid('ORD-');
    $date = date('Y-m-d H:i:s');
    
    while ($item = $cart_result->fetch_assoc()) {
        $insert_order = $conn->prepare("INSERT INTO orders (orderId, ProductId, Price, Quantity, DateOfOrder, clientId) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_order->bind_param("siiisi", $orderId, $item['ProductId'], $item['Price'], $item['Quantity'], $date, $userId);
        $insert_order->execute();
        $totalAmount += ($item['Price'] * $item['Quantity']);
    }
    
    // Clear Cart
    $clear_cart = $conn->prepare("DELETE FROM shoppingcart WHERE clientId = ?");
    $clear_cart->bind_param("i", $userId);
    $clear_cart->execute();
    
    // Send Confirmation Email
    $emailService = new EmailService();
    $emailService->sendOrderConfirmation($_SESSION['SESSION_EMAIL'], $orderId, $totalAmount);
    
    header("Location: orders.php?success=1");
    exit();
} else {
    header("Location: orders.php");
    exit();
}
