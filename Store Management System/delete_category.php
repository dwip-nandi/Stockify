<?php
require('connection.php');

$catagory_id = $_GET['catagory_id'];
$stmt = $conn->prepare("DELETE FROM catagory_icatagory WHERE catagory_id = ?");
$stmt->bind_param("i", $catagory_id);
$stmt->execute();
$stmt->close();

echo "<script>alert('Category deleted!'); window.location='manage_delete_category.php';</script>";
?>
