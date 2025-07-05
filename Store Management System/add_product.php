<?php
require('connection.php');
session_start();

$user_first_name = $_SESSION['user_first_name'] ?? null;
$user_last_name = $_SESSION['user_last_name'] ?? null;

if (!empty($user_first_name) && !empty($user_last_name)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validate and fetch form data
        $product_name = $_POST['product_name'] ?? null;
        $product_catagory = $_POST['product_catagory'] ?? null;
        $product_code = $_POST['product_code'] ?? null;
        $product_location = $_POST['product_location'] ?? null;
        $quantity = $_POST['quantity'] ?? null;
        $purchase_price = $_POST['purchase_price'] ?? null;
        $selling_price = $_POST['selling_price'] ?? null;
        $product_entry_date = $_POST['product_entry_date'] ?? null;
        $product_production_date = $_POST['product_production_date'] ?? null;
        $product_date_over_date = $_POST['product_date_over_date'] ?? null;

        $product_image = "default.png";
        $upload_error = "";

        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
            $file_tmp = $_FILES["product_image"]["tmp_name"];
            $file_name = basename($_FILES["product_image"]["name"]);
            $target_dir = "user_vew/imgs/";
            $target_file = $target_dir . $file_name;

            // Validate file type using mime_content_type
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $actual_type = mime_content_type($file_tmp);
            if (!in_array($actual_type, $allowed_types)) {
                $upload_error = "⚠️ Invalid file type!";
            }

            // Validate file size
            $max_size = 2 * 1024 * 1024; // 2MB
            if ($_FILES['product_image']['size'] > $max_size) {
                $upload_error = "⚠️ File too large!";
            }

            // If validations passed
            if (empty($upload_error)) {
                // Ensure folder exists
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                if (move_uploaded_file($file_tmp, $target_file)) {
                    $product_image = $file_name;
                } else {
                    $upload_error = "⚠️ Failed to move uploaded file!";
                }
            }
        }

        if ($product_name && $product_catagory && $product_code && $quantity && $purchase_price && $selling_price && $product_entry_date && $product_production_date && $product_date_over_date) {
            $sql = "INSERT INTO product (
                        product_name, product_catagory, product_code, product_location, 
                        quantity, purchase_price, selling_price, product_entry_date, 
                        product_production_date, product_date_over_date, product_image
                    )
                    VALUES (
                        '$product_name', '$product_catagory', '$product_code', '$product_location',
                        '$quantity', '$purchase_price', '$selling_price', '$product_entry_date',
                        '$product_production_date', '$product_date_over_date', '$product_image'
                    )";


            if ($conn->query($sql) === TRUE) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "<div class='error-message'>❌ Database Error: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='error-message'>⚠️ Please fill out all fields.</div>";
        }

        if (!empty($upload_error)) {
            echo "<div class='error-message'>$upload_error</div>";
        }
    }

    // Fetch categories for dropdown
    $sql = "SELECT * FROM catagory_icatagory";
    $query = $conn->query($sql);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Add Product</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: hsla(0, 38.80%, 76.30%, 0.27);
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .containerx {
                background-color: white;
                padding: 50px;
                box-shadow: 0px 0px 10px hsla(0, 38.10%, 67.10%, 0.20);
                border-radius: 10px;
                /* max-width: 600px; */
                width: 100%;
            }

            h2 {
                text-align: center;
                color: #333;
            }

            label {
                font-weight: bold;
            }

            input,
            select {
                width: 100%;
                padding: 8px;
                margin: 5px 0;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            .submit-button {
                background-color: rgba(94, 92, 203, 0.85);
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
                width: 100%;
                font-size: 16px;
                border-radius: 5px;
            }

            .submit-button:hover {
                background-color: hsla(237, 50.90%, 65.70%, 0.72);
            }

            .error-message {
                color: red;
                text-align: center;
                font-weight: bold;
                margin-bottom: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php require('D:\Ampps\www\Store Management System\banner.php'); ?>
            <div class="containerx">
                <h2>Add Product</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <label>Product Name:</label>
                    <input type="text" name="product_name" required>

                    <label>Product Category:</label>
                    <select name="product_catagory" required>
                        <?php while ($data = mysqli_fetch_assoc($query)) {
                            echo "<option value='{$data['catagory_id']}'>{$data['catagory_name']}</option>";
                        } ?>
                    </select>

                    <label>Product Code:</label>
                    <input type="text" name="product_code" required>

                    <label>Product Location:</label>
                    <input type="text" name="product_location" required>

                    <label>Product Quantity:</label>
                    <input type="number" name="quantity" required>

                    <label>Purchase Price:</label>
                    <input type="number" name="purchase_price" required>

                    <label>Selling Price:</label>
                    <input type="number" name="selling_price" required>

                    <label>Product Entry Date:</label>
                    <input type="date" name="product_entry_date" required>

                    <label>Product Production Date:</label>
                    <input type="date" name="product_production_date" required>

                    <label>Product Expiry Date:</label>
                    <input type="date" name="product_date_over_date" required>

                    <label>Product Image:</label>
                    <input type="file" name="product_image">

                    <input type="submit" value="Submit" class="submit-button">
                </form>
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