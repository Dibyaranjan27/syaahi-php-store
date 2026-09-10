<?php
session_start();
require_once("../connection/conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ProductId'])) {
    $productId = mysqli_real_escape_string($conShop, $_POST['ProductId']);

    $sql = "DELETE FROM products WHERE ProductId = '$productId'";
    if (mysqli_query($conShop, $sql)) {
        header('Location: addproduct.php'); // Redirect after delete
    } else {
        echo "Error deleting record: " . mysqli_error($conShop);
    }
}
