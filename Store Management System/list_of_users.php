<?php
require('connection.php');
session_start();
$user_first_name = $_SESSION['user_first_name'] ?? null;
$user_last_name = $_SESSION['user_last_name'] ?? null;

if (!empty($user_first_name) && !empty($user_last_name)) {
    // Delete action
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
        $user_id_to_delete = $_POST['user_id'];
        $delete_stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $delete_stmt->bind_param("i", $user_id_to_delete);
        if ($delete_stmt->execute()) {
            echo "<p style='color:crimson; font-weight:bold; text-align:center;'>🗑️ User deleted successfully.</p>";
        } else {
            echo "<p style='color:red; font-weight:bold; text-align:center;'>❌ Failed to delete user.</p>";
        }
        $delete_stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .table-container {
            max-width: 950px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .table-title {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 2px solid #ddd;
        }

        th {
            background-color: rgb(62, 110, 161);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn-edit,
        .btn-delete {
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #28a745;
            color: white;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        hr {
            border: 1px solid #ddd;
            margin: 0;
        }

        form.delete-form {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php require('banner.php'); ?>
        <div class="table-container">
            <h2 class="table-title"><i class="fa-solid fa-users"></i> List of Users</h2>

            <?php
            $sql = "SELECT * FROM `users`";
            $query = $conn->query($sql);

            echo "<table class='table'>";
            echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th><th>Actions</th></tr>";

            while ($data = mysqli_fetch_assoc($query)) {
                $user_id = $data['user_id'];
                echo "<tr>
                    <td>{$data['user_id']}</td>
                    <td>{$data['user_first_name']}</td>
                    <td>{$data['user_last_name']}</td>
                    <td>{$data['user_email']}</td>
                    <td>{$data['user_password']}</td>
                    <td>
                        <a href='edit_user.php?id=$user_id' class='btn-edit'><i class='fa-solid fa-edit'></i> Edit</a>
                        <form method='POST' class='delete-form' onsubmit=\"return confirm('Are you sure you want to delete this user?');\">
                            <input type='hidden' name='user_id' value='$user_id'>
                            <button type='submit' name='delete_user' class='btn-delete'><i class='fa-solid fa-trash'></i> Delete</button>
                        </form>
                    </td>
                </tr>";
                echo "<tr><td colspan='6'><hr></td></tr>";
            }

            echo "</table>";
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
