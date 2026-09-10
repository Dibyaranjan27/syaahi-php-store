<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['loggedInUserId'])) {
    header('Location: ../pages/login.php');
    exit;
}

$clientId = (int) $_SESSION['loggedInUserId'];
$productId = isset($_POST['ProductId']) ? (int) $_POST['ProductId'] : (isset($_POST['productId']) ? (int) $_POST['productId'] : (isset($_GET['productId']) ? (int) $_GET['productId'] : 0));
$quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : (isset($_GET['quantity']) ? (int) $_GET['quantity'] : 0);

if ($productId > 0 && $quantity > 0) {
    // Fetch product unit price
    $prodStmt = mysqli_prepare($conn, "SELECT Price FROM products WHERE ProductId = ?");
    mysqli_stmt_bind_param($prodStmt, "i", $productId);
    mysqli_stmt_execute($prodStmt);
    $prodResult = mysqli_stmt_get_result($prodStmt);

    if ($product = mysqli_fetch_assoc($prodResult)) {
        $unitPrice = (int) $product['Price'];
        $totalPrice = $unitPrice * $quantity;

        // Check if item exists in shopping cart
        $checkStmt = mysqli_prepare($conn, "SELECT ShoppingCartId FROM shoppingcart WHERE ProductId = ? AND clientId = ?");
        mysqli_stmt_bind_param($checkStmt, "ii", $productId, $clientId);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);

        if (mysqli_num_rows($checkResult) > 0) {
            $updateStmt = mysqli_prepare($conn, "UPDATE shoppingcart SET Quantity = ?, Price = ? WHERE ProductId = ? AND clientId = ?");
            mysqli_stmt_bind_param($updateStmt, "iiii", $quantity, $totalPrice, $productId, $clientId);
            mysqli_stmt_execute($updateStmt);
        } else {
            $insertStmt = mysqli_prepare($conn, "INSERT INTO shoppingcart (ProductId, Quantity, Price, clientId) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($insertStmt, "iiii", $productId, $quantity, $totalPrice, $clientId);
            mysqli_stmt_execute($insertStmt);
        }
    }
} elseif ($productId > 0 && $quantity <= 0) {
    // Remove item if quantity is zero or less
    $deleteStmt = mysqli_prepare($conn, "DELETE FROM shoppingcart WHERE ProductId = ? AND clientId = ?");
    mysqli_stmt_bind_param($deleteStmt, "ii", $productId, $clientId);
    mysqli_stmt_execute($deleteStmt);
}

header('Location: ../pages/cart.php');
exit;
