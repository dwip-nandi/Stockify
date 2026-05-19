<?php
require('connection.php');
session_start();

$user_first_name = $_SESSION['user_first_name'] ?? '';
$user_last_name = $_SESSION['user_last_name'] ?? '';

if (!empty($user_first_name) && !empty($user_last_name)) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Categories</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f4f4f4;
                margin: 0;
                padding: 20px;
                text-align: center;
            }

            h1 {
                color: #333;
            }

            .container_div {
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                max-width: 400px;
                margin: auto;
            }

            input[type="text"],
            input[type="date"] {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 16px;
            }

            input[type="submit"] {
                background: #007BFF;
                color: white;
                padding: 10px 20px;
                border: none;
                font-size: 16px;
                border-radius: 6px;
                cursor: pointer;
                transition: background 0.3s;
            }

            input[type="submit"]:hover {
                background: #0056b3;
            }

            .message {
                font-weight: bold;
                color: green;
            }

            .error {
                font-weight: bold;
                color: red;
            }
        </style>
    </head>

    <body>


        <div class="container">
            <?php require('banner.php'); ?>
            <h1 style="text-align: center;">Add a New Category</h1>
            <div class="container_div">
                
                <?php
                if (isset($_GET['catagory_name']) && isset($_GET['catagory_entry_date'])) {
                    $catagory_name = htmlspecialchars($_GET['catagory_name']);
                    $catagory_entry_date = htmlspecialchars($_GET['catagory_entry_date']);

                    $sql = "INSERT INTO catagory_icatagory (catagory_name, catagory_entry_date) VALUES ('$catagory_name', '$catagory_entry_date')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<p class='message'>New category added successfully!</p>";
                    } else {
                        echo "<p class='error'>Error: " . $conn->error . "</p>";
                    }
                }
                ?>

                <form action="add_catagory.php" method="GET">
                    <label for="catagory_name">Category Name:</label>
                    <input type="text" name="catagory_name" id="catagory_name" required>

                    <label for="catagory_entry_date">Entry Date:</label>
                    <input type="date" name="catagory_entry_date" id="catagory_entry_date" required>

                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>

    </body>

    </html>

<?php
} else {
    header('Location: login_system.php');
    exit();
}
?>