<?php
require __DIR__ . '/../connection.php';

$event_id = $_GET['event_id'];
$stmt = $conn->prepare("DELETE FROM sales_events_calander WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->close();

echo "<script>alert('Event deleted!'); window.location='manage_events.php';</script>";
?>
