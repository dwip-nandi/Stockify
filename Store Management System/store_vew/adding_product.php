<?php
require __DIR__ . '/../connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_id = $_POST['product_id'];
    $add_quantity = $_POST['add_quantity'];

    //uptae product for reporting system
    $sql_report = "INSERT INTO report (product_id, adding_product, product_type, adding_date) VALUES (?, ?, '2', NOW())";
    $stmt_report = $conn->prepare($sql_report);
    $stmt_report->bind_param("ii", $product_id, $add_quantity);
    $stmt_report->execute();
    $stmt_report->close();

    // Fetch current quantity securely
    $sql_fetch = "SELECT quantity FROM product WHERE product_id = $product_id";
    $result = $conn->query($sql_fetch);
    $row = $result->fetch_assoc();
    $current_quantity = $row['quantity'];

    $new_quantity = $current_quantity + $add_quantity;

    $sql_update = "UPDATE product SET quantity = $new_quantity WHERE product_id = $product_id";
    $conn->query($sql_update);

    header("Location: " . $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET));
    exit();
}
