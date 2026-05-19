<?php
require __DIR__ . '/../connection.php';

$month = $_GET['month'] ?? date('Y-m');

// Query daily profit data for selected month
$sql = "SELECT DATE(sell_date) AS date, SUM(profit_item) AS total_profit 
        FROM profit 
        WHERE DATE_FORMAT(sell_date, '%Y-%m') = ?
        GROUP BY DATE(sell_date)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $month);
$stmt->execute();
$result = $stmt->get_result();

$data = [
    'daily' => [],
    'monthly_total' => 0
];

while ($row = $result->fetch_assoc()) {
    $profit = floatval($row['total_profit']);
    $data['daily'][] = [
        'date' => $row['date'],
        'profit' => $profit
    ];
    $data['monthly_total'] += $profit;
}

$stmt->close();
header('Content-Type: application/json');
echo json_encode($data);
?>
