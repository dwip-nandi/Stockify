<?php
require('connection.php');

$catagory_id = $_GET['catagory_id'];
$stmt = $conn->prepare("SELECT * FROM catagory_icatagory WHERE catagory_id = ?");
$stmt->bind_param("i", $catagory_id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['catagory_name'];
    $date = $_POST['catagory_entry_date'];

    $stmt = $conn->prepare("UPDATE catagory_icatagory SET catagory_name=?, catagory_entry_date=? WHERE catagory_id=?");
    $stmt->bind_param("ssi", $name, $date, $catagory_id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Category updated!'); window.location='manage_categories.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Category</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="catagory_name" class="form-control" value="<?= htmlspecialchars($category['catagory_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Entry Date</label>
            <input type="date" name="catagory_entry_date" class="form-control" value="<?= $category['catagory_entry_date'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>
</body>
</html>
