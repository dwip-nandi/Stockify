<?php
require __DIR__ . '/../connection.php';

$id = $_GET['id'];

// Optional: delete image file
$getImage = $conn->prepare("SELECT image FROM feature_products WHERE id = ?");
$getImage->bind_param("i", $id);
$getImage->execute();
$imageResult = $getImage->get_result()->fetch_assoc();
$getImage->close();

if ($imageResult && file_exists($imageResult['image'])) {
    unlink($imageResult['image']);
}

// Delete from DB
$stmt = $conn->prepare("DELETE FROM feature_products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

echo "<script>alert('Product deleted!'); window.location='manage_feature_products.php';</script>";
?>
