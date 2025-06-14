<?php
include('db.php');
session_start();

// Check if the user is logged in, if not, redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

// Check if the event code is passed via GET
if (isset($_GET['event_code'])) {
    $eventCode = $_GET['event_code'];

    // Fetch event details from the database
    $sql = "SELECT * FROM events WHERE event_code = '$eventCode'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Output the event details
        $row = mysqli_fetch_assoc($result);
        $eventName = $row['event_name'];
        $eventDate = $row['event_date'];
        $eventTime = $row['event_time'];
        $eventVenue = $row['event_venue'];
        $ticketPrice = $row['ticket_price'];
    } else {
        $error_message = "No event found with that code.";
    }
} else {
    header("Location: user_dashboard.php");
    exit();
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
            width: 500px;
            text-align: center;
        }
        .event-details-container h1 {
            margin-bottom: 20px;
        }
        .event-details-container p {
            font-size: 18px;
            margin: 10px 0;
        }
        .book-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }
        .book-button:hover {
            background-color: #218838;
        }
        .error-message {
            color: #ff4c4c;
        }
    </style>
</head>
<body>

<div class="event-details-container">
    <?php if (isset($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } else { ?>
        <h1><?php echo $eventName; ?></h1>
        <p><strong>Date:</strong> <?php echo $eventDate; ?></p>
        <p><strong>Time:</strong> <?php echo $eventTime; ?></p>
        <p><strong>Venue:</strong> <?php echo $eventVenue; ?></p>
        <p><strong>Ticket Price:</strong> $<?php echo $ticketPrice; ?></p>
        <a href="book_event.php?event_code=<?php echo $eventCode; ?>" class="book-button">Book Event</a>
    <?php } ?>
</div>

</body>
</html>
