<?php
include '../connection.php';

// Monthly sales data for chart
$chartQuery = "
    SELECT MONTH(sell_date) AS month, SUM(profit_item) AS total_profit
    FROM profit
    WHERE sell_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY MONTH(sell_date)
    ORDER BY MONTH(sell_date)
";
$chartResult = $conn->query($chartQuery);
$labels = [];
$values = [];

while ($row = $chartResult->fetch_assoc()) {
    $labels[] = "Month " . $row['month'];
    $values[] = $row['total_profit'];
}

// Month with highest sales
$topMonthQuery = "
    SELECT MONTH(sell_date) AS month, YEAR(sell_date) AS year, SUM(profit_item) AS total_profit
    FROM profit
    GROUP BY YEAR(sell_date), MONTH(sell_date)
    ORDER BY total_profit DESC
    LIMIT 1
";
$topMonth = $conn->query($topMonthQuery)->fetch_assoc();

// Target for next month
$targetQuery = "
    SELECT AVG(monthly_profit) AS avg_profit
    FROM (
        SELECT SUM(profit_item) AS monthly_profit
        FROM profit
        WHERE sell_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
        GROUP BY MONTH(sell_date)
    ) AS sub
";
$target = $conn->query($targetQuery)->fetch_assoc();

// Compare previous two months
$compareQuery = "
    SELECT MONTH(sell_date) AS month, SUM(profit_item) AS total_profit
    FROM profit
    WHERE sell_date >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH)
    GROUP BY MONTH(sell_date)
    ORDER BY MONTH(sell_date)
";
$compareResult = $conn->query($compareQuery);
$months = [];
while ($row = $compareResult->fetch_assoc()) {
    $months[] = $row;
}

// Sales change calculation
$change = null;
$percent = null;
if (count($months) == 2) {
    $change = $months[1]['total_profit'] - $months[0]['total_profit'];
    $percent = ($change / $months[0]['total_profit']) * 100;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Sales Analysis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f4f6f9;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .card-header {
            font-size: 1.2rem;
        }
        .increase {
            color: green;
            font-weight: bold;
        }
        .decrease {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="text-center mb-5">📊 Monthly Sales Analysis</h1>

    <!-- Chart Section -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">📈 Monthly Profit Trend (Last 6 Months)</div>
        <div class="card-body">
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>

    <!-- Highest Sales Month -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">📅 Month with Highest Sales</div>
        <div class="card-body">
            <p><strong>Month:</strong> <?= $topMonth['month'] ?> / <?= $topMonth['year'] ?></p>
            <p><strong>Total Profit:</strong> ৳<?= number_format($topMonth['total_profit'], 2) ?></p>
        </div>
    </div>

    <!-- Target for Next Month -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">🎯 Target for Next Month</div>
        <div class="card-body">
            <p><strong>Average of Last 3 Months:</strong> ৳<?= number_format($target['avg_profit'], 2) ?></p>
            <p><strong>Suggested Target (+10%):</strong> ৳<?= number_format($target['avg_profit'] * 1.10, 2) ?></p>
        </div>
    </div>

    <!-- Previous Month Comparison -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">🔄 Previous Month Comparison</div>
        <div class="card-body">
            <?php foreach ($months as $m): ?>
                <p><strong>Month <?= $m['month'] ?>:</strong> ৳<?= number_format($m['total_profit'], 2) ?></p>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Sales Change -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">📉 Sales Change</div>
        <div class="card-body">
            <?php if ($change !== null): ?>
                <p><strong>Change:</strong> ৳<?= number_format($change, 2) ?></p>
                <p><strong>Percentage:</strong> <?= number_format($percent, 2) ?>%</p>
                <p class="<?= ($change > 0) ? 'increase' : 'decrease' ?>">
                    <?= ($change > 0) ? '✅ Sales Increased' : '⚠️ Sales Decreased' ?>
                </p>
            <?php else: ?>
                <p>Not enough data to compare.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Total Profit (৳)',
            data: <?= json_encode($values) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        animation: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '৳' + value;
                    }
                }
            }
        }
    }
});
</script>
</body>
</html>
