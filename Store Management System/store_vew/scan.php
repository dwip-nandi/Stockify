<?php
require __DIR__ . '/../connection.php';
require __DIR__ . '/../auth.php';
date_default_timezone_set('Asia/Dhaka');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_code'])) {
    $code = $_POST['product_code'];

    // Try atomic quantity decrement if quantity > 0
    $update = $conn->prepare("UPDATE product SET quantity = quantity - 1 WHERE product_code = ? AND quantity > 0");
    $update->bind_param("s", $code);
    $update->execute();

    if ($update->affected_rows > 0) {
        // Fetch updated product info
        $stmt = $conn->prepare("SELECT * FROM product WHERE product_code = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        // Prepare profit data
        $productId   = $product['product_id'];
        $productCode = $product['product_code'];
        $quantity    = 1;
        $profit      = $product['selling_price'] - $product['purchase_price'];
        $sellDate    = date('Y-m-d');

        // Insert into profit table
        $log = $conn->prepare("INSERT INTO profit (product_id, product_code, quantity, profit_item, sell_date) VALUES (?, ?, ?, ?, ?)");
        $log->bind_param("isids", $productId, $productCode, $quantity, $profit, $sellDate);
        $log->execute();

        echo "<div style='color: green; font-weight: bold;'>✅ {$product['product_name']} scanned successfully. Profit: {$profit} TK</div>";

        // 🚨 Alert if quantity has dropped to zero
        if ((int)$product['quantity'] === 0) {
            echo "<div style='color: orange; font-weight: bold;'>⚠️ {$product['product_name']} is now OUT OF STOCK!</div>";
        }
    } else {
        echo "<div style='color: red; font-weight: bold;'>❌ Product not found or already out of stock.</div>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dynamic Product Scanner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 80px;
        }

        .container {
            text-align: -webkit-center;
        }

        .scanner-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 18px;
            width: 100%;
            box-sizing: border-box;
            margin-top: 10px;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            font-size: 16px;
        }

        #scan-result {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php require __DIR__ . '/../banner.php';?>
        <div class="scanner-box">
            <h2>📦 Scan Product Code</h2>
            <form id="scan-form">
                <img src="../img/barcode.png" alt="Scan Here" width="200">
                <input type="text" name="product_code" placeholder="Scan product code" autofocus required>
                <button type="submit">Scan</button>
            </form>
            <div id="scan-result"></div>
        </div>
    </div>

    <script>
        document.getElementById('scan-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch('scan.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(response => {
                    document.getElementById('scan-result').innerHTML = response;
                    form.reset();
                    form.product_code.focus();
                })
                .catch(() => {
                    document.getElementById('scan-result').innerHTML = "<div style='color:red;'>❌ Error processing scan.</div>";
                });
        });
    </script>

</body>

</html>