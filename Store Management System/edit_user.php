<?php
require('connection.php');
session_start();

$user_first_name = $_SESSION['user_first_name'] ?? null;
$user_last_name  = $_SESSION['user_last_name'] ?? null;

if (!empty($user_first_name) && !empty($user_last_name)) {
    // Initialize variables
    $edit_user_id = $_GET['id'] ?? null;
    $data2 = [];

    // Fetch existing user data
    if ($edit_user_id) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $edit_user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data2 = $result->fetch_assoc();
        $stmt->close();
    }

    // Handle update
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
        $new_user_id      = $_POST['user_id'];
        $new_first_name   = $_POST['user_first_name'];
        $new_last_name    = $_POST['user_last_name'];
        $new_user_email   = $_POST['user_email'];
        $new_user_password = $_POST['user_password'];

        $sql3 = "UPDATE users SET 
                    user_first_name = ?, 
                    user_last_name  = ?, 
                    user_email      = ?, 
                    user_password   = ? 
                 WHERE user_id = ?";
        $stmt = $conn->prepare($sql3);
        $stmt->bind_param("ssssi", $new_first_name, $new_last_name, $new_user_email, $new_user_password, $new_user_id);

        if ($stmt->execute()) {
            echo "<p style='color:green; font-weight:bold;'>✅ User updated successfully.</p>";
        } else {
            echo "<p style='color:red; font-weight:bold;'>❌ Failed to update user.</p>";
        }
        $stmt->close();
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Edit Users</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                padding: 40px;
                background-color: #f0f2f5;
            }

            .form-box {
                max-width: 500px;
                background: white;
                margin: auto;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
            }

            h2 {
                color: #007bff;
                text-align: center;
            }

            label {
                font-weight: bold;
                display: block;
                margin-top: 10px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                width: 100%;
                padding: 10px;
                margin-top: 4px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .btn-update {
                margin-top: 20px;
                background-color: #28a745;
                color: white;
                padding: 10px;
                width: 100%;
                border: none;
                font-weight: bold;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-update:hover {
                background-color: #218838;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php require('D:\Ampps\www\Store Management System\banner.php'); ?>

            <div class="form-box">
                <h2>Edit User</h2>
                <form method="POST" action="">
                    <label>First Name:</label>
                    <input type="text" name="user_first_name" value="<?php echo htmlspecialchars($data2['user_first_name'] ?? '') ?>" required>

                    <label>Last Name:</label>
                    <input type="text" name="user_last_name" value="<?php echo htmlspecialchars($data2['user_last_name'] ?? '') ?>" required>

                    <label>Email:</label>
                    <input type="email" name="user_email" value="<?php echo htmlspecialchars($data2['user_email'] ?? '') ?>" required>

                    <label>Password:</label>
                    <input type="password" name="user_password" value="<?php echo htmlspecialchars($data2['user_password'] ?? '') ?>" required>

                    <input type="hidden" name="user_id" value="<?php echo $data2['user_id'] ?? '' ?>">
                    <button type="submit" name="update_user" class="btn-update">Update</button>
                </form>
            </div>
        </div>
    </body>

    </html>

<?php
} else {
    header("Location: login_system.php");
    exit();
}
?>