<?php

require __DIR__ . '/../connection.php';
require __DIR__ . '/../auth.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];

    // Handle image upload
    $image_path = '';
    if (!empty($_FILES['product_image']['name'])) {
        $target_dir = "imgs/";
        $image_path = $target_dir . basename($_FILES['product_image']['name']);
        move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path);
    }

    // Insert into DB (example table `products`)
    $query = "INSERT INTO feature_products (name, description, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $product_name, $product_description, $image_path);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Product added successfully!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add Featured Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .container_f {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-button {
            margin-top: 25px;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php require __DIR__ . '/../banner.php'; ?>
        <div class="container_f">
            <h2>Add Featured Product</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <label>Product Name:</label>
                <input type="text" name="product_name" required>

                <label>Description:</label>
                <input type="text" name="product_description" required>

                <label>Product Image:</label>
                <input type="file" name="product_image">

                <input type="submit" value="Submit" class="submit-button">
            </form>
        </div>
    </div>
</body>

</html>