<?php
require('connection.php');
$query = "SELECT p.*, c.catagory_name FROM product p 
          LEFT JOIN catagory_icatagory c ON p.product_catagory = c.catagory_id 
          ORDER BY p.product_entry_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <?php require('banner.php'); ?>
    <h2 class="mb-4 text-center">📦 Manage Products</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Code</th>
                <th>Location</th>
                <th>Quantity</th>
                <th>Purchase Price</th>
                <th>Selling Price</th>
                <th>Entry Date</th>
                <th>Production Date</th>
                <th>Expiry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td>
                    <?php
                    $imgPath = "user_vew/imgs/" . htmlspecialchars($row['product_image']);
                    echo file_exists($imgPath) ? "<img src='$imgPath' width='60'>" : "<span class='text-danger'>No image</span>";
                    ?>
                </td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td><?= htmlspecialchars($row['catagory_name'] ?? 'Unknown') ?></td>
                <td><?= htmlspecialchars($row['product_code']) ?></td>
                <td><?= htmlspecialchars($row['product_location']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td>৳<?= htmlspecialchars($row['purchase_price']) ?></td>
                <td>৳<?= htmlspecialchars($row['selling_price']) ?></td>
                <td><?= htmlspecialchars($row['product_entry_date']) ?></td>
                <td><?= htmlspecialchars($row['product_production_date']) ?></td>
                <td><?= htmlspecialchars($row['product_date_over_date']) ?></td>
                <td>
                    <a href="edit_product.php?product_id=<?= $row['product_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
