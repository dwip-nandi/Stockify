<?php
require('D:\\Ampps\\www\\Store Management System\\connection.php');
session_start();

$user_first_name = $_SESSION['user_first_name'];
$user_last_name = $_SESSION['user_last_name'];

if (!empty($user_first_name) && !empty($user_last_name)) {
    // Fetch categories
    $sql1 = "SELECT * FROM `catagory_icatagory`";
    $query1 = $conn->query($sql1);
    $data_list = [];

    while ($data1 = mysqli_fetch_assoc($query1)) {
        $catagory_id = $data1['catagory_id'];
        $catagory_name = $data1['catagory_name'];
        $data_list[$catagory_id] = $catagory_name;
    }

    // Handle Adding Products
    require('D:\\Ampps\\www\\Store Management System\\store_vew\\adding_product.php');

    // Handle Selling Products
    require('D:\\Ampps\\www\\Store Management System\\store_vew\\selling_product.php');
    // Handle Search Filters
    $search_name = $_GET['search_name'] ?? '';
    $search_category = $_GET['search_category'] ?? '';

    // Pagination Setup
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max($page, 1);
    $offset = ($page - 1) * $limit;

    $where = "WHERE 1";
    if (!empty($search_name)) {
        $safe_name = $conn->real_escape_string($search_name);
        $where .= " AND product_name LIKE '%$safe_name%'";
    }
    if (!empty($search_category)) {
        $safe_cat = (int)$search_category;
        $where .= " AND product_catagory = $safe_cat";
    }

    $count_sql = "SELECT COUNT(*) AS total FROM product $where";
    $count_result = $conn->query($count_sql);
    $total_products = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_products / $limit);

    $sql = "SELECT * FROM product $where LIMIT $limit OFFSET $offset";
    $query = $conn->query($sql);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Product List</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #fafafa;
                margin: 0;
                padding: 20px;
                color: #333;
            }

            h1 {
                text-align: center;
                color: #444;
                margin-bottom: 20px;
                font-weight: 700;
                letter-spacing: 1px;
            }

            /* Search/filter form */
            form.search-form {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
                margin-bottom: 30px;
                background: #fff;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
                max-width: 900px;
                margin-left: auto;
                margin-right: auto;
            }

            form.search-form label {
                align-self: center;
                font-weight: 600;
                min-width: 110px;
                color: #555;
            }

            form.search-form input[type="text"],
            form.search-form select {
                padding: 8px 12px;
                border-radius: 6px;
                border: 1px solid #ccc;
                min-width: 200px;
                font-size: 1rem;
                transition: border-color 0.3s ease;
            }

            form.search-form input[type="text"]:focus,
            form.search-form select:focus {
                border-color: #007bff;
                outline: none;
            }

            form.search-form input[type="submit"] {
                background-color: #007bff;
                border: none;
                color: white;
                font-weight: 600;
                padding: 10px 25px;
                border-radius: 6px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                min-width: 120px;
            }

            form.search-form input[type="submit"]:hover {
                background-color: #0056b3;
            }

            /* Table */
            table {
                width: 100%;
                border-collapse: collapse;
                max-width: 1700px;
                margin: 0 auto 30px auto;
                background: #fff;
                box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
                border-radius: 8px;
                overflow: hidden;
            }

            thead tr {
                background-color: #007bff;
                color: #fff;
                font-weight: 700;
                text-align: center;
            }

            thead th {
                padding: 12px 10px;
                font-size: 14px;
            }

            tbody tr {
                text-align: center;
                border-bottom: 1px solid #e3e3e3;
                transition: background-color 0.2s ease;
            }

            tbody tr:hover {
                background-color: #e9f0fb;
            }

            tbody td {
                padding: 10px;
                font-size: 13px;
            }

            tbody tr.low-stock {
                background-color: #ffefef !important;
            }

            tbody tr.low-stock td.stock-status p {
                color: #d9534f;
                font-weight: 700;
            }

            /* Forms inside table for add/sell */
            form.inline-form {
                display: flex;
                justify-content: center;
                gap: 8px;
                align-items: center;
            }

            form.inline-form input[type="number"] {
                width: 70px;
                padding: 5px 8px;
                border-radius: 5px;
                border: 1px solid #ccc;
                font-size: 13px;
                text-align: center;
                transition: border-color 0.3s ease;
            }

            form.inline-form input[type="number"]:focus {
                border-color: #007bff;
                outline: none;
            }

            form.inline-form input[type="submit"] {
                padding: 6px 12px;
                background-color: #28a745;
                color: #fff;
                border: none;
                border-radius: 5px;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.3s ease;
                font-size: 13px;
            }

            form.inline-form input[type="submit"]:hover {
                background-color: #218838;
            }

            form.inline-form.sell-product input[type="submit"] {
                background-color: #dc3545;
            }

            form.inline-form.sell-product input[type="submit"]:hover {
                background-color: #c82333;
            }

            /* Pagination */
            .pagination {
                /* text-align: center; */
                justify-content: center;
                margin-bottom: 30px;
                user-select: none;
            }

            .pagination a,
            .pagination strong {
                display: inline-block;
                margin: 0 5px;
                padding: 8px 14px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: 600;
                font-size: 14px;
                color: #007bff;
                border: 1px solid transparent;
                transition: background-color 0.3s ease, border-color 0.3s ease;
            }

            .pagination a:hover {
                background-color: #e7f1ff;
                border-color: #007bff;
            }

            .pagination strong {
                background-color: #007bff;
                color: white;
                border-color: #0056b3;
                cursor: default;
            }

            /* Responsive */
            @media (max-width: 1100px) {

                table,
                thead tr,
                tbody tr,
                tbody td,
                thead th {
                    font-size: 11px;
                }

                form.search-form {
                    flex-direction: column;
                    align-items: stretch;
                }

                form.search-form label,
                form.search-form input[type="text"],
                form.search-form select,
                form.search-form input[type="submit"] {
                    min-width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?php require('D:\Ampps\www\Store Management System\banner.php'); ?>
        </div>
            <h1>Product List</h1>
            <form method="GET" action="" class="search-form" autocomplete="off">
                <label for="search_name">Product Name:</label>
                <input type="text" name="search_name" id="search_name" placeholder="Enter product name" value="<?php echo htmlspecialchars($search_name); ?>" />

                <label for="search_category">Category:</label>
                <select name="search_category" id="search_category">
                    <option value="">-- All Categories --</option>
                    <?php
                    foreach ($data_list as $id => $name) {
                        $selected = ($search_category == $id) ? 'selected' : '';
                        echo "<option value='$id' $selected>$name</option>";
                    }
                    ?>
                </select>

                <input type="submit" value="Search" />
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Product Code</th>
                        <th>Location</th>
                        <th>Quantity</th>
                        <th>Selling Price</th>
                        <th>Purchase Price</th>
                        <th>Production Date</th>
                        <th>Expiry Date</th>
                        <th>Date Left</th>
                        <th>Stock Status</th>
                        <th>Add Products</th>
                        <th>Sell Products</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = ($page - 1) * $limit + 1;
                    while ($data = mysqli_fetch_assoc($query)) {
                        $category_name = $data_list[$data['product_catagory']] ?? 'Unknown';
                        $production_date = new DateTime($data['product_production_date']);
                        $date_over_date = new DateTime($data['product_date_over_date']);
                        $current_date = new DateTime();

                        if ($current_date > $date_over_date) {
                            $date_left = "Date Expired";
                        } else {
                            $diff = $current_date->diff($date_over_date);
                            $date_left = $diff->days . " days remaining";
                        }

                        $lowStockClass = ($data['quantity'] < 20) ? "low-stock" : "";
                        echo "<tr class='$lowStockClass'>
                    <td>$counter</td>
                    <td>" . htmlspecialchars($data['product_name']) . "</td>
                    <td>" . htmlspecialchars($category_name) . "</td>
                    <td>" . htmlspecialchars($data['product_code']) . "</td>
                    <td>" . htmlspecialchars($data['product_location']) . "</td>
                    <td>" . (int)$data['quantity'] . "</td>
                    <td>" . number_format((float)$data['selling_price'], 2) . "</td>
                    <td>" . number_format((float)$data['purchase_price'], 2) . "</td>
                    <td>" . htmlspecialchars($data['product_production_date']) . "</td>
                    <td>" . htmlspecialchars($data['product_date_over_date']) . "</td>
                    <td>$date_left</td>
                    <td class='stock-status'>";
                        if ($data['quantity'] < 20) {
                            echo "<p>⚠️ Warning: Low Stock! Only " . (int)$data['quantity'] . " left.</p>";
                        } else {
                            echo "Stock OK";
                        }
                        echo "</td>
                    <td>
                        <form action='' method='POST' class='inline-form'>
                            <input type='hidden' name='product_id' value='{$data['product_id']}'>
                            <input type='number' name='add_quantity' min='1' placeholder='Qty' required>
                            <input type='submit' name='add_product' value='Add'>
                        </form>
                    </td>
                    <td>
                        <form action='' method='POST' class='inline-form sell-product'>
                            <input type='hidden' name='product_id' value='{$data['product_id']}'>
                            <input type='number' name='sold_quantity' min='1' placeholder='Qty' required>
                            <input type='submit' name='sell_product' value='Sell'>
                        </form>
                    </td>
                </tr>";
                        $counter++;
                    }
                    ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php
                $base_url = strtok($_SERVER["REQUEST_URI"], '?') . '?';
                $params = $_GET;
                unset($params['page']);
                $base_url .= http_build_query($params);
                $base_url .= (count($params) > 0 ? '&' : '');

                if ($page > 1) {
                    echo "<a href='{$base_url}page=" . ($page - 1) . "'>&laquo; Previous</a>";
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo "<strong>$i</strong>";
                    } else {
                        echo "<a href='{$base_url}page=$i'>$i</a>";
                    }
                }

                if ($page < $total_pages) {
                    echo "<a href='{$base_url}page=" . ($page + 1) . "'>Next &raquo;</a>";
                }
                ?>
            </div>
        
    </body>

    </html>
<?php
} else {
    header('location:login_system.php');
    exit();
}
?>