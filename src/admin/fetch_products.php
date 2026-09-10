<?php
include 'connection/conn.php'; // Adjust path as necessary

$sql = "SELECT * FROM products";
$result = mysqli_query($con, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
echo json_encode($products);
?>