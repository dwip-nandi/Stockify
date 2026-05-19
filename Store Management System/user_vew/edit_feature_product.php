<?php
require __DIR__ . '/../connection.php';

$id = $_GET['id'];
$query = "SELECT * FROM feature_products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $desc = $_POST['product_description'];
    $image_path = $product['image'];

    if (!empty($_FILES['product_image']['name'])) {
        $target_dir = "user_vew/imgs/";
        $image_path = $target_dir . basename($_FILES['product_image']['name']);
        move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path);
    }

    $update = "UPDATE feature_products SET name = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssi", $name, $desc, $image_path, $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Product updated!'); window.location='manage_feature_products.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Featured Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Featured Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <input type="text" name="product_description" class="form-control" value="<?= htmlspecialchars($product['description']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="../<?= htmlspecialchars($product['image']) ?>" width="150"><br><br>
            <input type="file" name="product_image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
</body>
</html>
