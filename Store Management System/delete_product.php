<?php
require('connection.php');

$product_id = $_GET['product_id'];
$stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->close();

echo "<script>alert('Product deleted!'); window.location='manage_delete_product.php';</script>";
?>
