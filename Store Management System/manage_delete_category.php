<?php
require('connection.php');
$query = "SELECT * FROM catagory_icatagory ORDER BY catagory_entry_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <?php require('banner.php'); ?>
    <h2 class="mb-4 text-center">📂 Manage Categories</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>Category Name</th>
                <th>Entry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['catagory_name']) ?></td>
                <td><?= htmlspecialchars($row['catagory_entry_date']) ?></td>
                <td>
                    <a href="delete_category.php?catagory_id=<?= $row['catagory_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
