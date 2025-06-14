<?php
// create_event.php

include('db.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $eventName = isset($_POST['event_name']) ? $_POST['event_name'] : '';
    $eventDate = isset($_POST['event_date']) ? $_POST['event_date'] : '';
    $eventTime = isset($_POST['event_time']) ? $_POST['event_time'] : '';
    $eventVenue = isset($_POST['event_venue']) ? $_POST['event_venue'] : '';
    $ticketPrice = isset($_POST['ticket_price']) ? $_POST['ticket_price'] : '';

    // Validate form data
    if (!empty($eventName) && !empty($eventDate) && !empty($eventTime) && !empty($eventVenue) && !empty($ticketPrice)) {
        // Generate unique event code
        $eventCode = strtoupper(substr(md5(time()), 0, 6));

        // Insert event data into database
        $sql = "INSERT INTO events (event_name, event_date, event_time, event_venue, ticket_price, event_code) 
                VALUES ('$eventName', '$eventDate', '$eventTime', '$eventVenue', '$ticketPrice', '$eventCode')";
        
        if (mysqli_query($conn, $sql)) {
            // Redirect to view_event.php with the new event's ID
            $eventId = mysqli_insert_id($conn); // Get the ID of the new event
            header("Location: view_event.php?event_id=" . $eventId);
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
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
        .event-form-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 400px;
        }
        .event-form-container h1 {
            margin-bottom: 20px;
            text-align: center;
            color: #28a745;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #2b2b2b;
            color: #ffffff;
        }
        .submit-button {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="event-form-container">
    <h1>Create New Event</h1>
    <form action="create_event.php" method="post">
        <input type="text" name="event_name" class="input-field" placeholder="Event Name" required>
        <input type="date" name="event_date" class="input-field" required>
        <input type="time" name="event_time" class="input-field" required>
        <input type="text" name="event_venue" class="input-field" placeholder="Venue" required>
        <input type="number" step="0.01" name="ticket_price" class="input-field" placeholder="Ticket Price (e.g., 20.00)" required>
        <button type="submit" class="submit-button">Submit Event</button>
    </form>
</div>

</body>
</html>
