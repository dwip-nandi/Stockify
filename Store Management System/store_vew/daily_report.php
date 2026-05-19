<?php
require __DIR__ . '/../connection.php';
require __DIR__ . '/../auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <title>Daily Report</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
                @media print {
                        .print-button {
                                display: none;
                        }

                        .card {
                                border: none;
                        }
                }
        </style>
</head>

<body class="bg-light">
        <div class="container py-5">
                <?php require __DIR__ . '/../banner.php';?>
                <h1 class="mb-4 text-center">📊 Daily Report -Stockify</h1>
                <h1 class="mb-4 text-center"><?php echo date("l, F jS, Y"); ?>;</h1>

                <!-- 1. New Products -->
                <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                                <h4 class="mb-0">Today's New Products</h4>
                        </div>
                        <div class="card-body">
                                <?php
                                $sql1 = "SELECT * FROM product WHERE DATE(product_entry_date) = CURDATE()";
                                $new_product_result = $conn->query($sql1);

                                if ($new_product_result->num_rows > 0) {
                                        echo "<div class='table-responsive'><table class='table table-bordered table-hover'>
                            <thead class='table-light'>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Purchase Price</th>
                                    <th>Selling Price</th>
                                </tr>
                            </thead><tbody>";
                                        $counter = 1;
                                        while ($row = $new_product_result->fetch_assoc()) {
                                                $catagory_id = $row['product_catagory'];
                                                $catagory = 'Unknown';
                                                $sql_catagory = "SELECT catagory_name FROM catagory_icatagory WHERE catagory_id = $catagory_id";
                                                $catagory_result = $conn->query($sql_catagory);
                                                if ($catagory_result->num_rows > 0) {
                                                        $catagory_row = $catagory_result->fetch_assoc();
                                                        $catagory = $catagory_row['catagory_name'];
                                                }

                                                echo "<tr>
                                <td>$counter</td>
                                <td>{$row['product_name']}</td>
                                <td>{$catagory}</td>
                                <td>{$row['quantity']}</td>
                                <td>{$row['purchase_price']}</td>
                                <td>{$row['selling_price']}</td>
                              </tr>";
                                                $counter++;
                                        }
                                        echo "</tbody></table></div>";
                                } else {
                                        echo "<p class='text-muted'>No new products added today.</p>";
                                }
                                ?>
                        </div>
                </div>

                <!-- 2. Updated Products -->
                <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                                <h4 class="mb-0">Updated/Restocked Products</h4>
                        </div>
                        <div class="card-body">
                                <?php
                                $sql2 = "SELECT * FROM report WHERE DATE(adding_date) = CURDATE()";
                                $result_report = $conn->query($sql2);

                                if ($result_report->num_rows > 0) {
                                        echo "<div class='table-responsive'><table class='table table-bordered table-hover'>
                            <thead class='table-light'>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Quantity Added</th>
                                    <th>Purchase Price</th>
                                    <th>Selling Price</th>
                                </tr>
                            </thead><tbody>";
                                        $counter = 1;
                                        while ($row = $result_report->fetch_assoc()) {
                                                $product_id = $row['product_id'];
                                                $product_name = 'Unknown';
                                                $catagory = 'Unknown';
                                                $purchase_price = '-';
                                                $selling_price = '-';

                                                $sql_product = "SELECT * FROM product WHERE product_id = $product_id";
                                                $product_result = $conn->query($sql_product);
                                                if ($product_result->num_rows > 0) {
                                                        $product_row = $product_result->fetch_assoc();
                                                        $product_name = $product_row['product_name'];
                                                        $catagory_id = $product_row['product_catagory'];
                                                        $purchase_price = $product_row['purchase_price'];
                                                        $selling_price = $product_row['selling_price'];

                                                        $sql_catagory = "SELECT catagory_name FROM catagory_icatagory WHERE catagory_id = $catagory_id";
                                                        $catagory_result = $conn->query($sql_catagory);
                                                        if ($catagory_result->num_rows > 0) {
                                                                $catagory_row = $catagory_result->fetch_assoc();
                                                                $catagory = $catagory_row['catagory_name'];
                                                        }
                                                }

                                                echo "<tr>
                                <td>$counter</td>
                                <td>{$product_name}</td>
                                <td>{$catagory}</td>
                                <td>{$row['adding_product']}</td>
                                <td>{$purchase_price}</td>
                                <td>{$selling_price}</td>
                              </tr>";
                                                $counter++;
                                        }
                                        echo "</tbody></table></div>";
                                } else {
                                        echo "<p class='text-muted'>No products updated today.</p>";
                                }
                                ?>
                        </div>
                </div>

                <!-- 3. Sold Products -->
                <div class="card mb-4">
                        <div class="card-header bg-danger text-white">
                                <h4 class="mb-0">Today's Sold Products</h4>
                        </div>
                        <div class="card-body">
                                <?php
                                $sql3 = "SELECT product_id, SUM(quantity) AS total_quantity, SUM(profit_item) AS total_profit 
                 FROM profit 
                 WHERE DATE(sell_date) = CURDATE() 
                 GROUP BY product_id";
                                $result_profit = $conn->query($sql3);
                                $total_profit = 0;

                                if ($result_profit->num_rows > 0) {
                                        echo "<div class='table-responsive'><table class='table table-bordered table-hover'>
                <thead class='table-light'>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Sold Quantity</th>
                        <th>Total Profit</th>
                    </tr>
                </thead><tbody>";
                                        $counter = 1;

                                        while ($row = $result_profit->fetch_assoc()) {
                                                $product_name = 'Unknown';
                                                $product_id = $row['product_id'];
                                                $sql_product = "SELECT product_name FROM product WHERE product_id = $product_id";
                                                $product_result = $conn->query($sql_product);
                                                if ($product_result->num_rows > 0) {
                                                        $product_row = $product_result->fetch_assoc();
                                                        $product_name = $product_row['product_name'];
                                                }

                                                $total_profit += $row['total_profit'];

                                                echo "<tr>
                    <td>$counter</td>
                    <td>{$product_name}</td>
                    <td>{$row['total_quantity']}</td>
                    <td>{$row['total_profit']} TK</td>
                </tr>";
                                                $counter++;
                                        }

                                        echo "</tbody></table></div>";
                                        echo "<p class='fw-bold'>Total Profit Today: {$total_profit} TK</p>";
                                } else {
                                        echo "<p class='text-muted'>No products sold today.</p>";
                                }
                                ?>
                        </div>
                </div>

                <div class="d-flex justify-content-center">
                        <button class="btn btn-primary print-button mb-3" onclick="window.print()">🖨️ Print Report</button>
                </div>

        </div>
</body>

</html>

<?php $conn->close(); ?>