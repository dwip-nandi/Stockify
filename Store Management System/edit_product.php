<?php
require('connection.php');
session_start();

// Validate product_id
if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    echo "<script>alert('Invalid product ID.'); window.location='manage_products.php';</script>";
    exit();
}

$product_id = $_GET['product_id'];

// Fetch product data
$stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    echo "<script>alert('Product not found.'); window.location='manage_products.php';</script>";
    exit();
}

// Fetch categories
$categories = mysqli_query($conn, "SELECT * FROM catagory_icatagory");

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $cat = $_POST['product_catagory'];
    $code = $_POST['product_code'];
    $loc = $_POST['product_location'];
    $qty = $_POST['quantity'];
    $buy = $_POST['purchase_price'];
    $sell = $_POST['selling_price'];
    $entry = $_POST['product_entry_date'];
    $prod = $_POST['product_production_date'];
    $exp = $_POST['product_date_over_date'];
    $image = $product['product_image'];

    // Handle image upload
    if (!empty($_FILES['product_image']['name'])) {
        $target_dir = "user_vew/imgs/";
        $file_name = basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_tmp = $_FILES["product_image"]["tmp_name"];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $actual_type = mime_content_type($file_tmp);
        $max_size = 2 * 1024 * 1024;

        if (in_array($actual_type, $allowed_types) && $_FILES['product_image']['size'] <= $max_size) {
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            if (move_uploaded_file($file_tmp, $target_file)) {
                $image = $file_name;
            }
        }
    }

    // Update query
    $stmt = $conn->prepare("UPDATE product SET product_name=?, product_catagory=?, product_code=?, product_location=?, quantity=?, purchase_price=?, selling_price=?, product_entry_date=?, product_production_date=?, product_date_over_date=?, product_image=? WHERE product_id=?");
    $stmt->bind_param("sissiddssssi", $name, $cat, $code, $loc, $qty, $buy, $sell, $entry, $prod, $exp, $image, $product_id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Product updated successfully!'); window.location='manage_products.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Product Category</label>
            <select name="product_catagory" class="form-control" required>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= $cat['catagory_id'] ?>" <?= $cat['catagory_id'] == $product['product_catagory'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['catagory_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Product Code</label>
            <input type="text" name="product_code" class="form-control" value="<?= htmlspecialchars($product['product_code']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Product Location</label>
            <input type="text" name="product_location" class="form-control" value="<?= htmlspecialchars($product['product_location']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($product['quantity']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Purchase Price</label>
            <input type="number" name="purchase_price" class="form-control" value="<?= htmlspecialchars($product['purchase_price']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Selling Price</label>
            <input type="number" name="selling_price" class="form-control" value="<?= htmlspecialchars($product['selling_price']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Entry Date</label>
            <input type="date" name="product_entry_date" class="form-control" value="<?= $product['product_entry_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Production Date</label>
            <input type="date" name="product_production_date" class="form-control" value="<?= $product['product_production_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Expiry Date</label>
            <input type="date" name="product_date_over_date" class="form-control" value="<?= $product['product_date_over_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="user_vew/imgs/<?= htmlspecialchars($product['product_image']) ?>" width="100"><br><br>
            <input type="file" name="product_image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
</body>
</html>
