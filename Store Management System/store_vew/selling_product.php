<?php
require __DIR__ . '/../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sell_product'])) {
    $product_id = $_POST['product_id'];
    $sold_quantity = $_POST['sold_quantity'];

    // Securely fetch all required product info
    $sql_fetch = "SELECT quantity, selling_price, purchase_price, product_code FROM product WHERE product_id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $product_id);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result();
    $row = $result->fetch_assoc();
    $stmt_fetch->close();

    if (!$row) {
        echo "<script>alert('⚠️ Product not found!');</script>";
        exit();
    }

    $current_quantity = $row['quantity'];
    $selling_price = $row['selling_price'];
    $purchase_price = $row['purchase_price'];
    $product_code = $row['product_code'];

    if ($current_quantity >= $sold_quantity) {
        $new_quantity = $current_quantity - $sold_quantity;
        $profit = ($selling_price - $purchase_price) * $sold_quantity;

        // Update product quantity
        $sql_update = "UPDATE product SET quantity = ? WHERE product_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $new_quantity, $product_id);
        $stmt_update->execute();
        $stmt_update->close();

        // Log sale in profit table with product_code
        $sql_log = "INSERT INTO profit (product_id, product_code, quantity, profit_item, sell_date) VALUES (?, ?, ?, ?, NOW())";
        $stmt_log = $conn->prepare($sql_log);
        $stmt_log->bind_param("isid", $product_id, $product_code, $sold_quantity, $profit);
        $stmt_log->execute();
        $stmt_log->close();

        // Redirect to the same page to refresh
        header("Location: " . $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET));
        exit();
    } else {
        echo "<script>alert('⚠️ Not enough stock available!');</script>";
    }
}
?>
