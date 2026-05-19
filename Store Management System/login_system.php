<?php
ob_start(); 
session_start();
require('connection.php');
require('banner.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $sql = "SELECT * FROM `users` WHERE user_email='$user_email' AND user_password='$user_password'";
    $query = $conn->query($sql);

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $_SESSION['user_first_name'] = $data['user_first_name'];
        $_SESSION['user_last_name'] = $data['user_last_name'];
        header('Location: index1.php');
        exit();
    } else {
        $login_error = "<p class='error-message'><i class='fa-solid fa-exclamation-circle'></i> Incorrect login credentials. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 60px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
            text-align: center;
        }
        .login-container h2 {
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
        .btn-login {
            width: 100%;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2><i class="fa-solid fa-user-lock"></i> User Login</h2>

    <?php if (!empty($login_error)) echo $login_error; ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="email">User Email:</label>
        <input type="email" name="user_email" required>

        <label for="password">User Password:</label>
        <input type="password" name="user_password" required>

        <button type="submit" class="btn-login"><i class="fa-solid fa-sign-in-alt"></i> Login</button>
    </form>
</div>

</body>
</html>

<?php
ob_end_flush(); // End buffering and flush output
?>
