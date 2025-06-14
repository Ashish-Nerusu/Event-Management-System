<?php
include('db.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

$username = $_SESSION['username']; // Assuming username is stored in session after login

// Check if event code is passed via GET
if (isset($_GET['event_code'])) {
    $eventCode = $_GET['event_code'];

    // Fetch event details from the database
    $sql = "SELECT * FROM events WHERE event_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $eventCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Get event details
        $row = $result->fetch_assoc();
        $eventName = $row['event_name'];
        $ticketPrice = $row['ticket_price'];
    } else {
        $error_message = "No event found with that code.";
    }
    $stmt->close();
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
    <title>Book Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            padding: 20px;
            margin: 0;
        }

        .booking-container {
            background-color: #1e1e1e;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        }

        h1 {
            color: #4CAF50;
            text-align: center;
        }

        .price-info {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            color: #ffffff;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #444444;
            border-radius: 5px;
            background-color: #333333;
            color: #ffffff;
        }

        .pay-button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .pay-button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="booking-container">
    <?php if (isset($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } else { ?>
        <h1>Book Event: <?php echo htmlspecialchars($eventName); ?></h1>
        <form action="payment_process.php" method="post">
            <input type="hidden" name="event_code" value="<?php echo htmlspecialchars($eventCode); ?>">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="ticket_price" value="<?php echo htmlspecialchars($ticketPrice); ?>">
            <input type="hidden" name="event_name" value="<?php echo htmlspecialchars($eventName); ?>">

            <div class="form-group">
                <label for="numTickets">Number of Tickets:</label>
                <input type="number" name="num_tickets" id="numTickets" min="1" value="1" required>
            </div>

            <div class="price-info">
                <div id="price">Price: $<?php echo number_format($ticketPrice, 2); ?></div>
                <div id="tax">5% Tax: $<?php echo number_format($ticketPrice * 0.05, 2); ?></div>
                <div id="totalPrice">Total Price: $<?php echo number_format($ticketPrice * 1.05, 2); ?></div>
            </div>

            <button type="submit" class="pay-button">Confirm</button>
        </form>
    <?php } ?>
</div>

<script>
    const ticketPrice = <?php echo json_encode($ticketPrice); ?>;

    document.getElementById('numTickets').addEventListener('input', function() {
        const numTickets = parseInt(this.value) || 1;
        const price = numTickets * ticketPrice;
        const tax = price * 0.05;
        const totalPrice = price + tax;

        document.getElementById('price').innerText = `Price: $${price.toFixed(2)}`;
        document.getElementById('tax').innerText = `5% Tax: $${tax.toFixed(2)}`;
        document.getElementById('totalPrice').innerText = `Total Price: $${totalPrice.toFixed(2)}`;
    });
</script>

</body>
</html>
