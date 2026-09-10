<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['loggedInUserId'])) {
    header('Location: ../pages/login.php');
    exit;
}

$userId = (int) $_SESSION['loggedInUserId'];
$productId = isset($_GET['productId']) ? (int) $_GET['productId'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : 'add';

if ($productId > 0) {
    if ($action === 'remove') {
        $stmt = mysqli_prepare($conn, "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $userId, $productId);
        mysqli_stmt_execute($stmt);
    } else {
        // Add (ignore duplicate via INSERT IGNORE)
        $stmt = mysqli_prepare($conn, "INSERT IGNORE INTO wishlist (user_id, product_id) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ii", $userId, $productId);
        mysqli_stmt_execute($stmt);
    }
}

header('Location: ../pages/wishlist.php');
exit;
