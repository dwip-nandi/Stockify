<?php
require __DIR__ . '/../connection.php';
require __DIR__ . '/../auth.php';
// Set timezone (important for accurate date)
date_default_timezone_set('Asia/Dhaka');

$today = date('Y-m-d');
$month = date('Y-m');

// --- DAILY PROFIT CALCULATION ---
$sql_daily = "SELECT SUM(profit_item) AS daily_profit FROM profit WHERE DATE(sell_date) = ?";
$stmt_daily = $conn->prepare($sql_daily);
$stmt_daily->bind_param("s", $today);
$stmt_daily->execute();
$result_daily = $stmt_daily->get_result();
$row_daily = $result_daily->fetch_assoc();

// If null or missing, default to 0
$daily_profit = number_format($row_daily['daily_profit'] ?? 0, 2);
$stmt_daily->close();

// Debug: Uncomment this to see raw results
// echo "<pre>"; print_r($row_daily); echo "</pre>";


// --- MONTHLY PROFIT CALCULATION ---
$sql_monthly = "SELECT SUM(profit_item) AS monthly_profit FROM profit WHERE DATE_FORMAT(sell_date, '%Y-%m') = ?";
$stmt_monthly = $conn->prepare($sql_monthly);
$stmt_monthly->bind_param("s", $month);
$stmt_monthly->execute();
$result_monthly = $stmt_monthly->get_result();
$row_monthly = $result_monthly->fetch_assoc();
$monthly_profit = number_format($row_monthly['monthly_profit'] ?? 0, 2);
$stmt_monthly->close();


// --- DISPLAY TABLE ---
echo "<table border='1' cellpadding='10' cellspacing='0' style='margin: 20px auto; text-align: center;'>
        <tr style='background-color: #f2f2f2;'>
            <th>Date</th>
            <th>Profit</th>
        </tr>
        <tr>
            <td>Today ($today)</td>
            <td>$daily_profit TK</td>
        </tr>
        <tr>
            <td>This Month ($month)</td>
            <td>$monthly_profit TK</td>
        </tr>
      </table>";
?>
