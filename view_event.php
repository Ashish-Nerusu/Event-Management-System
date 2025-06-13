<?php
// view_event.php

// Include database connection
include('db.php');

// Retrieve the last created event details (adjust query based on your needs)
$sql = "SELECT * FROM events ORDER BY id DESC LIMIT 1"; // Get the most recent event
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $event = mysqli_fetch_assoc($result);
} else {
    echo "No event found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .event-details-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 400px;
            text-align: center;
        }
        h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        .detail {
            margin: 10px 0;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<div class="event-details-container">
    <h1><?php echo htmlspecialchars($event['event_name']); ?></h1>
    <div class="detail">Date: <?php echo htmlspecialchars($event['event_date']); ?></div>
    <div class="detail">Time: <?php echo htmlspecialchars($event['event_time']); ?></div>
    <div class="detail">Venue: <?php echo htmlspecialchars($event['event_venue']); ?></div>
    <div class="detail">Ticket Price: $<?php echo htmlspecialchars($event['ticket_price']); ?></div>
    <div class="detail">Event Code: <?php echo htmlspecialchars($event['event_code']); ?></div>
</div>

</body>
</html>
