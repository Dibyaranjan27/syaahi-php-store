<?php
include 'connection/conn.php'; // Adjust path as necessary

$sql = "SELECT * FROM products";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($products);
?>