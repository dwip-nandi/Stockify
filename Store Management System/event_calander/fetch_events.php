<?php
require __DIR__ . '/../connection.php';

// Fetch events from the database, including description
$sql = "SELECT event_name AS title, start_date AS start, end_date AS end, description FROM sales_events_calander";
$result = $conn->query($sql);

$events = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($events);
?>
