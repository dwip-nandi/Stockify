<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Profit Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        #monthly-summary {
            font-size: 18px;
            font-weight: bold;
            color: beige;
            margin-bottom: 15px;
        }

        #calendar {
            max-width: 900px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php require('D:\Ampps\www\Store Management System\banner.php'); ?>
        <h1 style="text-align: center;">Profit Calendar</h1>

        <?php require('D:\Ampps\www\Store Management System\store_vew/profit_clc.php'); ?>


        <div id="monthly-summary" style=" text-align: center;">Loading monthly profit...</div>
        <div id="calendar"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const summaryEl = document.getElementById('monthly-summary');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                datesSet: function(info) {
                    console.log("Calendar View Updated:", info);

                    const date = new Date(info.view.currentStart);
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const formattedMonth = `${year}-${month}`;
                    console.log("Correct Month Extracted:", formattedMonth);

                    const url = `get_profit_data.php?month=${formattedMonth}`;
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            console.log("Fetched data:", data);

                            calendar.removeAllEvents();

                            // Show daily profit events (if any)
                            if (Array.isArray(data.daily)) {
                                data.daily.forEach(item => {
                                    if (item.date && !isNaN(item.profit)) {
                                        calendar.addEvent({
                                            title: `${parseFloat(item.profit).toFixed(2)} TK`,
                                            start: item.date,
                                            allDay: true
                                        });
                                    }
                                });
                            } else {
                                console.warn("Missing or invalid 'daily' data in response");
                            }

                            // Show total monthly profit safely
                            const monthlyTotal = parseFloat(data.monthly_total);
                            summaryEl.textContent = isNaN(monthlyTotal) ?
                                `No profit data found for ${month}` :
                                `Total Profit for ${month}: ${monthlyTotal.toFixed(2)} TK`;
                        })
                        .catch(error => {
                            console.error("Error fetching data:", error);
                            summaryEl.textContent = "Error loading monthly profit.";
                        });
                }
            });

            calendar.render();
        });
    </script>

</body>

</html>