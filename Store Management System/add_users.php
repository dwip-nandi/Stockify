<?php
require('connection.php');
session_start();
$user_first_name = $_SESSION['user_first_name'] ?? null;
$user_last_name = $_SESSION['user_last_name'] ?? null;

if (!empty($user_first_name) && !empty($user_last_name)) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .form-container h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .btn-submit {
            width: 100%;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php require('banner.php'); ?>
    <div class="form-container">
        <h2><i class="fa-solid fa-user-plus"></i> Add New User</h2>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_first_name'])) {
            $user_first_name = $_GET['user_first_name'];
            $user_last_name = $_GET['user_last_name'];
            $user_email = $_GET['user_email'];
            $user_password = $_GET['user_password'];

            $sql = "INSERT INTO users (user_first_name, user_last_name, user_email, user_password)
                    VALUES ('$user_first_name', '$user_last_name', '$user_email', '$user_password')";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='alert alert-success'><i class='fa-solid fa-check-circle'></i> New user created successfully!</p>";
            } else {
                echo "<p class='alert alert-danger'><i class='fa-solid fa-exclamation-triangle'></i> Error: " . $conn->error . "</p>";
            }
        }
        ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <label>User First Name:</label>
            <input type="text" name="user_first_name" required>

            <label>User Last Name:</label>
            <input type="text" name="user_last_name" required>

            <label>User Email:</label>
            <input type="email" name="user_email" required>

            <label>User Password:</label>
            <input type="password" name="user_password" id="user_password" required>
            <div class="form-check mt-2 mb-3">
                <input type="checkbox" class="form-check-input" onclick="togglePassword()" id="showPassword">
                <label class="form-check-label" for="showPassword">Show Password</label>
            </div>

            <button type="submit" class="btn-submit"><i class="fa-solid fa-user-check"></i> Submit</button>
        </form>
    </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById("user_password");
            pwd.type = pwd.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>

<?php
} else {
    header('location:login_system.php');
    exit();
}
?>
