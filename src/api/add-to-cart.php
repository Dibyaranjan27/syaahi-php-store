<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['loggedInUserId'])) {
    header('Location: ../pages/login.php');
    exit;
}

if (isset($_POST['productId']) && isset($_POST['quantity']) && isset($_POST['price'])) {
    $productId = (int) $_POST['productId'];
    $quantity = (int) $_POST['quantity'];
    $price = (int) $_POST['price'];
    $clientId = (int) $_SESSION['loggedInUserId'];
    $totalPrice = $price * $quantity;

    // Check if product already in cart
    $checkStmt = mysqli_prepare($conn, "SELECT ShoppingCartId, Quantity FROM shoppingcart WHERE ProductId = ? AND clientId = ?");
    mysqli_stmt_bind_param($checkStmt, "ii", $productId, $clientId);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($checkResult) > 0) {
        $existing = mysqli_fetch_assoc($checkResult);
        $newQty = $existing['Quantity'] + $quantity;
        $newPrice = $price * $newQty;
        $updateStmt = mysqli_prepare($conn, "UPDATE shoppingcart SET Quantity = ?, Price = ? WHERE ShoppingCartId = ?");
        mysqli_stmt_bind_param($updateStmt, "iii", $newQty, $newPrice, $existing['ShoppingCartId']);
        mysqli_stmt_execute($updateStmt);
    } else {
        $insertStmt = mysqli_prepare($conn, "INSERT INTO shoppingcart (ProductId, Quantity, Price, clientId) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($insertStmt, "iiii", $productId, $quantity, $totalPrice, $clientId);
        mysqli_stmt_execute($insertStmt);
    }
}

header('Location: ../pages/cart.php');
exit;
