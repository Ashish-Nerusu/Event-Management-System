
<?php
include('db.php');
session_start();

// Check if the booking ID exists in the session
if (isset($_SESSION['booking_id'])) {
    $bookingId = $_SESSION['booking_id'];

    // Fetch the booking details from the database using the correct column name 'id'
    $sql = "SELECT * FROM bookings WHERE booking_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
    } else {
        echo "Booking not found.";
        exit();
    }
    $stmt->close();
} else {
    echo "No booking found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #ffffff; /* Light text */
            padding: 20px;
            margin: 0;
        }

        .confirmation-container {
            background-color: #1e1e1e; /* Dark container */
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        .confirmation-details {
            margin-top: 20px;
        }

        .confirmation-details p {
            font-size: 18px;
        }

        .button {
            display: block;
            margin-top: 20px;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="confirmation-container">
    <h1>Booking Confirmation</h1>
    <div class="confirmation-details">
        <p><strong>Event Name:</strong> <?php echo htmlspecialchars($booking['event_name']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($booking['username']); ?></p>
        <p><strong>Number of Tickets:</strong> <?php echo htmlspecialchars($booking['num_tickets']); ?></p>
        <p><strong>Total Price:</strong> $<?php echo number_format($booking['total_price'], 2); ?></p>
        <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($booking['booking_date']); ?></p>
    </div>

    <a href="payment_process.html" class="button">Pay Now</a>
</div>

</body>
</html>
