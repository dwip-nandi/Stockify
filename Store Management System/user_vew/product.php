<?php
require('D:\Ampps\www\Store Management System\connection.php');
session_start();

if (!isset($_SESSION['user_first_name']) || !isset($_SESSION['user_last_name'])) {
    header('location:login_system.php');
    exit();
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch categories
$sql1 = "SELECT * FROM `catagory_icatagory`";
$query1 = $conn->query($sql1);
$data_list = [];

while ($data1 = mysqli_fetch_assoc($query1)) {
    $catagory_id = $data1['catagory_id'];
    $catagory_name = $data1['catagory_name'];
    $data_list[$catagory_id] = $catagory_name;
}

// Search and pagination
$search_name = $_GET['search_name'] ?? '';
$search_category = $_GET['search_category'] ?? '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$conditions = [];

if (!empty($search_name)) {
    $search_name_safe = $conn->real_escape_string($search_name);
    $conditions[] = "product_name LIKE '%$search_name_safe%'";
}

if (!empty($search_category)) {
    $search_category_safe = intval($search_category);
    $conditions[] = "product_catagory = $search_category_safe";
}

$where_clause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

// Total count
$count_sql = "SELECT COUNT(*) as total FROM `product` $where_clause";
$count_result = $conn->query($count_sql);
$total_products = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $limit);

// Paginated query
$sql = "SELECT * FROM `product` $where_clause ORDER BY product_id DESC LIMIT $limit OFFSET $offset";
$query = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <title>Product List</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        select {
            padding: 8px 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 200px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 14px 12px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        th {
            background: #007BFF;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .product_img img {
            max-width: 80px;
            max-height: 80px;
            border-radius: 6px;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a,
        .pagination strong {
            margin: 0 5px;
            padding: 6px 12px;
            text-decoration: none;
            border: 1px solid #007BFF;
            border-radius: 4px;
            color: #007BFF;
        }

        .pagination strong {
            background-color: #007BFF;
            color: white;
        }

        .pagination a:hover {
            background-color: #e6f0ff;
        }

        @media (max-width: 768px) {
            form {
                flex-direction: column;
                align-items: center;
            }

            input[type="text"],
            select {
                width: 100%;
                max-width: 300px;
            }
        }

        .feature_slider {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container"><?php require('D:\Ampps\www\Store Management System\banner.php'); ?>
        <h2>Product List</h2>

        <form method='GET' action=''>
            <div>
                <label for='search_name'>Product Name:</label><br>
                <input type='text' name='search_name' id='search_name' value='<?= htmlspecialchars($search_name) ?>'>
            </div>

            <div>
                <label for='search_category'>Category:</label><br>
                <select name='search_category' id='search_category'>
                    <option value=''>-- All Categories --</option>
                    <?php
                    foreach ($data_list as $id => $name) {
                        $selected = ($search_category == $id) ? 'selected' : '';
                        echo "<option value='$id' $selected>$name</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <br>
                <input type='submit' value='Search'>
            </div>
        </form>

        <table>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Image</th>
                <th>Category</th>
                <th>Location</th>
                <th>Price</th>
                <th>Expiry Date</th>
                <th>Status</th>
            </tr>

            <?php
            $counter = $offset + 1;
            while ($data = mysqli_fetch_assoc($query)) {
                $product_name = htmlspecialchars($data['product_name']);
                $product_catagory = $data['product_catagory'];
                $product_location = htmlspecialchars($data['product_location']);
                $selling_price = htmlspecialchars($data['selling_price']);
                $product_date_over_date = htmlspecialchars($data['product_date_over_date']);
                $product_image = htmlspecialchars($data['product_image']);

                try {
                    $current_date = new DateTime();
                    $expiration_date = new DateTime($product_date_over_date);
                    $days_remaining = ($current_date > $expiration_date)
                        ? "<span style='color: red; font-weight: bold;'>Expired</span>"
                        : "<span style='color: green;'>" . $current_date->diff($expiration_date)->days . " days left</span>";
                } catch (Exception $e) {
                    $days_remaining = "<span style='color: orange;'>Invalid date</span>";
                }

                $category_name = $data_list[$product_catagory] ?? 'Unknown';

                $image_path = "imgs/" . $product_image;
                $img_tag = (file_exists($image_path) && !empty($product_image))
                    ? "<img src='$image_path' alt='Product Image'>"
                    : "<img  src='imgs/default.png' alt='Default Image'>";

                echo "<tr>
            <td>$counter</td>
            <td>$product_name</td>
            <td class='product_img'>$img_tag</td>
            <td>$category_name</td>
            <td>$product_location</td>
            <td>$selling_price.00 TK</td>
            <td>$product_date_over_date</td>
            <td>$days_remaining</td>
        </tr>";

                $counter++;
            }
            ?>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?search_name=<?= urlencode($search_name) ?>&search_category=<?= $search_category ?>&page=<?= $page - 1 ?>">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <strong><?= $i ?></strong>
                <?php else: ?>
                    <a href="?search_name=<?= urlencode($search_name) ?>&search_category=<?= $search_category ?>&page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?search_name=<?= urlencode($search_name) ?>&search_category=<?= $search_category ?>&page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>

    </div>
</body>

</html>