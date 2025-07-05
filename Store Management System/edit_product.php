<?php
require('D:\\Ampps\\www\\Store Management System\\connection.php');
session_start();

$user_first_name = $_SESSION['user_first_name'];
$user_last_name = $_SESSION['user_last_name'];

if (!empty($user_first_name) && !empty($user_last_name)) {
    $sql1 = "SELECT * FROM `catagory_icatagory`";
    $query1 = $conn->query($sql1);
    $data_list = [];

    while ($data1 = mysqli_fetch_assoc($query1)) {
        $data_list[$data1['catagory_id']] = $data1['catagory_name'];
    }

    require('D:\\Ampps\\www\\Store Management System\\store_vew\\adding_product.php');
    require('D:\\Ampps\\www\\Store Management System\\store_vew\\selling_product.php');

    $search_name = $_GET['search_name'] ?? '';
    $search_category = $_GET['search_category'] ?? '';

    $limit = 10;
    $page = max((int)($_GET['page'] ?? 1), 1);
    $offset = ($page - 1) * $limit;

    $where = "WHERE 1";
    if (!empty($search_name)) {
        $safe_name = $conn->real_escape_string($search_name);
        $where .= " AND product_name LIKE '%$safe_name%'";
    }
    if (!empty($search_category)) {
        $where .= " AND product_catagory = " . (int)$search_category;
    }

    $total_products = $conn->query("SELECT COUNT(*) AS total FROM product $where")->fetch_assoc()['total'];
    $total_pages = ceil($total_products / $limit);

    $query = $conn->query("SELECT * FROM product $where LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        h1 { text-align: center; margin: 30px 0; font-weight: bold; color: #343a40; animation: slideText 3s linear infinite; }
        @keyframes slideText { 0% { transform: translateX(0); } 50% { transform: translateX(30px); } 100% { transform: translateX(0); } }
        .search-form { display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; margin-bottom: 30px; }
        .search-form input[type="text"], .search-form select { padding: 8px; border: 1px solid #ced4da; border-radius: 5px; width: 200px; }
        .search-form input[type="submit"] { background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
        table { width: 100%; background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        thead { background-color: #007bff; color: #fff; }
        th, td { padding: 10px; text-align: center; font-size: 14px; }
        tbody tr:hover { background-color: #f1f1f1; }
        .low-stock { background-color: #ffecec; }
        .inline-form input[type="number"] { width: 70px; padding: 5px; margin-right: 5px; }
        .inline-form input[type="submit"] { padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
        .inline-form input[name="add_product"] { background-color: #28a745; color: white; }
        .inline-form input[name="sell_product"] { background-color: #dc3545; color: white; }
        .edit-button { background-color: #ffc107; color: white; padding: 5px 10px; border: none; border-radius: 5px; text-decoration: none; }
        .edit-button:hover { background-color: #e0a800; }
        .pagination { text-align: center; margin-top: 30px; }
        .pagination a, .pagination strong { margin: 0 5px; padding: 8px 12px; text-decoration: none; border-radius: 4px; }
        .pagination a { background-color: #e9ecef; color: #007bff; }
        .pagination strong { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <?php require('D:\\Ampps\\www\\Store Management System\\banner.php'); ?>
        <h1>Product List</h1>

        <form method="GET" class="search-form">
            <input type="text" name="search_name" placeholder="Search Name" value="<?= htmlspecialchars($search_name) ?>">
            <select name="search_category">
                <option value="">All Categories</option>
                <?php foreach ($data_list as $id => $name): ?>
                    <option value="<?= $id ?>" <?= $search_category == $id ? 'selected' : '' ?>><?= htmlspecialchars($name) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Search">
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Code</th>
                    <th>Quantity</th>
                    <th>Sell Price</th>
                    <th>Purchase Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $query->fetch_assoc()): ?>
                    <tr class="<?= $row['quantity'] < 20 ? 'low-stock' : '' ?>">
                        <td><?= $row['product_id'] ?></td>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= htmlspecialchars($data_list[$row['product_catagory']] ?? 'Unknown') ?></td>
                        <td><?= htmlspecialchars($row['product_code']) ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td><?= $row['selling_price'] ?></td>
                        <td><?= $row['purchase_price'] ?></td>
                        <td>
                            <a class="edit-button" href="edit_product.php?id=<?= $row['product_id'] ?>">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
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
                echo "<a href='{$base_url}page=" . ($page - 1) . "'>&laquo; Prev</a>";
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
    </div>
</body>
</html>
<?php
} else {
    header('location:login_system.php');
    exit();
}
?>
