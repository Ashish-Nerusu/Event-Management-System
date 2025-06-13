
<?php
include('db.php');
session_start();

// Check if the required POST data is available
if (isset($_POST['event_code'], $_POST['username'], $_POST['ticket_price'], $_POST['num_tickets'], $_POST['event_name'])) {
    // Get POST data
    $eventCode = $_POST['event_code'];
    $username = $_POST['username'];
    $ticketPrice = $_POST['ticket_price'];
    $numTickets = $_POST['num_tickets'];
    $eventName = $_POST['event_name'];

    // Calculate the total price (including 5% tax)
    $totalPrice = $ticketPrice * $numTickets * 1.05;

    // Get the current date
    $bookingDate = date('Y-m-d');

    // Insert the booking details into the database
    $sql = "INSERT INTO bookings (username, event_code, num_tickets, total_price, booking_date, event_name) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssidss", $username, $eventCode, $numTickets, $totalPrice, $bookingDate, $eventName);
    if ($stmt->execute()) {
        // Store the booking ID in session for confirmation
        $_SESSION['booking_id'] = $stmt->insert_id;
        
        // Redirect to the booking confirmation page
        header("Location: booking_confirmation.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Missing required data!";
    exit();
}
?>

