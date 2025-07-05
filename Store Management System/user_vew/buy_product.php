<?php
$productId = $_POST['productId'];
$userId = $_POST['userId'];

// Update sales record
$conn = new mysqli('localhost', 'username', 'password', 'store_db');
$query = "INSERT INTO sales (user_id, product_id, date) VALUES ('$userId', '$productId', NOW())";
if ($conn->query($query) === TRUE) {
    echo json_encode(['message' => 'Purchase successful!']);
} else {
    echo json_encode(['message' => 'Error processing purchase.']);
}
$conn->close();
?>
