<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report By Stockify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            text-align: center; /* Center text in the page */
            padding: 20px;
        }
        .btn-custom {
            margin: 10px; /* Add space between buttons */
        }
        .print-btn {
            position: fixed;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body class="bg-light">

    <h1 class="mb-4 text-center">📊 Report By Stockify</h1>

    <!-- Daily Report -->
    <a href="daily_report.php" class="btn btn-success btn-custom">📅 Daily Report</a>

    <!-- Print Button -->
    <button class="btn btn-primary print-btn" onclick="window.print()">🖨️ Print Report</button>

    <!-- Monthly Report -->
    <a href="monthly_repert.php" class="btn btn-info btn-custom">📆 Monthly Report</a>

</body>
</html>
