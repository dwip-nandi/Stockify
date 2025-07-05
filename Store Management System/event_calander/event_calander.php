<?php
require('D:/Ampps/www/Store Management System/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Discount Calendar - Stockify</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.bootstrap5.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 2rem 1rem;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .calendar-container {
            background-color: #fff;
            max-width: 1600px;
            width: 100%;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.1);
        }

        h1 {
            text-align: center;
            color: #198754;
            margin-bottom: 1.5rem;
            font-weight: 700;
            text-shadow: 1px 1px 4px rgba(25, 135, 84, 0.3);
        }

        #calendar {
            max-width: 100%;
        }

        .fc-daygrid-day-frame {
            padding: 0.25rem 0.5rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .calendar-container {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container"><?php require('D:\Ampps\www\Store Management System\banner.php'); ?>
        <div class="calendar-container">
            <h1>Discount Calendar</h1>
            <div id="calendar"></div>
        </div>
    </div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/locales-all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.bootstrap5.min.js"></script>

    <!-- Bootstrap Bundle JS (for tooltips) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: 'fetch_events.php',
                height: 'auto',
                editable: false,
                dayMaxEvents: true,
                eventColor: '#198754',

                // ✅ Show description as tooltip
                eventDidMount: function(info) {
                    if (info.event.extendedProps.description) {
                        new bootstrap.Tooltip(info.el, {
                            title: info.event.extendedProps.description,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                }
            });

            calendar.render();
        });
    </script>

</body>

</html>