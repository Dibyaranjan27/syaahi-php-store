<?php
session_start();
require_once("../connection/conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ProductId'])) {
    $productId = mysqli_real_escape_string($conShop, $_POST['ProductId']);

    $sql = "DELETE FROM products WHERE ProductId = ?";
    $stmt = $conShop->prepare($sql);
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        header('Location: addproduct.php'); // Redirect after delete
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
}
