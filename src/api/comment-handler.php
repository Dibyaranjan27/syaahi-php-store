<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['loggedInUserId'])) {
    header('Location: ../pages/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['details']) && !empty($_POST['productId'])) {
    $userId = (int) $_SESSION['loggedInUserId'];
    $productId = (int) $_POST['productId'];
    $details = trim($_POST['details']);
    $date = date('Y-m-d');

    $stmt = mysqli_prepare($conn, "INSERT INTO comments (Date, Status, Details, UserID, ProductId) VALUES (?, 1, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssii", $date, $details, $userId, $productId);
    mysqli_stmt_execute($stmt);

    header('Location: ../pages/product-detail.php?productId=' . $productId);
    exit;
}

header('Location: ../index.php');
exit;
