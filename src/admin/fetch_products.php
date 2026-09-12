<?php
require_once("../includes/db.php"); // Adjust path as necessary

$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($products);
?>