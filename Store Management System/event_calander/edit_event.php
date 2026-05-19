<?php
require __DIR__ . '/../connection.php';
$event_id = $_GET['event_id'];
$stmt = $conn->prepare("SELECT * FROM sales_events_calander WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['event_name'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $desc = $_POST['description'];

    $stmt = $conn->prepare("UPDATE sales_events_calander SET event_name=?, start_date=?, end_date=?, description=? WHERE event_id=?");
    $stmt->bind_param("ssssi", $name, $start, $end, $desc, $event_id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Event updated!'); window.location='manage_events.php';</script>";
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Event</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Event Name</label>
            <input type="text" name="event_name" class="form-control" value="<?= htmlspecialchars($event['event_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?= $event['start_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= $event['end_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($event['description']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>
</body>
</html>
