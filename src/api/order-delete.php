<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['loggedInUserId'])) {
    header('Location: ../pages/login.php');
    exit;
}

$clientId = (int) $_SESSION['loggedInUserId'];
$productId = isset($_POST['ProductId']) ? (int) $_POST['ProductId'] : (isset($_POST['productId']) ? (int) $_POST['productId'] : (isset($_GET['productId']) ? (int) $_GET['productId'] : 0));
$orderId = isset($_POST['orderId']) ? trim($_POST['orderId']) : (isset($_GET['orderId']) ? trim($_GET['orderId']) : '');

if ($productId > 0) {
    // Delete item from shopping cart
    $stmt = mysqli_prepare($conn, "DELETE FROM shoppingcart WHERE ProductId = ? AND clientId = ?");
    mysqli_stmt_bind_param($stmt, "ii", $productId, $clientId);
    mysqli_stmt_execute($stmt);
} elseif (!empty($orderId)) {
    // Delete order from orders table
    $stmt = mysqli_prepare($conn, "DELETE FROM orders WHERE orderId = ? AND clientId = ?");
    mysqli_stmt_bind_param($stmt, "si", $orderId, $clientId);
    mysqli_stmt_execute($stmt);
}

header('Location: ../pages/cart.php');
exit;
