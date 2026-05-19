<?php
require __DIR__ . '/../connection.php';
require __DIR__ . '/../auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $event_name = htmlspecialchars($_POST['event_name']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = htmlspecialchars($_POST['description']);

    // Validate dates
    if (strtotime($start_date) > strtotime($end_date)) {
        echo "Error: Start Date cannot be after End Date.";
        exit();
    }

    // Check for duplicates
    $stmt = $conn->prepare("SELECT COUNT(*) FROM sales_events_calander WHERE event_name = ? AND start_date = ? AND end_date = ?");
    $stmt->bind_param("sss", $event_name, $start_date, $end_date);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    if ($count > 0) {
        echo "Error: An event with the same name and date range already exists.";
        exit();
    }
    $stmt->close();

    // Insert event into the database
    $stmt = $conn->prepare("INSERT INTO sales_events_calander (event_name, start_date, end_date, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $event_name, $start_date, $end_date, $description);

    if ($stmt->execute()) {
        header('Location: sales_calendar.php?status=success');
        exit();
    } else {
        echo "Error adding event: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Event</title>
    <style>
        form {
            max-width: 400px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        input,
        textarea,
        button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php require __DIR__ . '/../banner.php'; ?>
        <form action="add_event.php" method="POST">
            Event Name: <input type="text" name="event_name" required><br>
            Start Date: <input type="date" name="start_date" required><br>
            End Date: <input type="date" name="end_date" required><br>
            Description: <textarea name="description"></textarea><br>
            <button type="submit">Add Event</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: 'fetch_events.php',
                eventsSet: function(events) {
                    console.log(events);
                }
            });

            calendar.render();
        });
    </script>
</body>

</html>