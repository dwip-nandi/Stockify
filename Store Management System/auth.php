<?php
require('connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_first_name']) || !isset($_SESSION['user_last_name'])) {
    header("Location: /Store%20Management%20System/login_system.php");
    exit();
}
?>
