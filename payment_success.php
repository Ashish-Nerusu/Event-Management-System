<?php
include('db.php');
session_start();

// Process payment (e.g., integrate with a payment gateway here)
// If payment is successful, proceed with the booking confirmation

// Get data from the form
$username = $_POST['username'];
$eventCode = $_POST['event_code'];
$eventName = $_POST['event_name'];
$numTickets = $_POST['num_tickets'];
$totalPrice = $_POST['total_price'];
$bookingDate = date('Y-m-d');

// Insert booking details into the database
$sql = "INSERT INTO bookings (username, event_code, event_name, num_tickets, total_price, booking_date) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssdis", $username, $eventCode, $eventName, $numTickets, $totalPrice, $bookingDate);

if ($stmt->execute()) {
    // Get the booking ID of the inserted booking
    $bookingId = $stmt->insert_id;
    // Redirect to the booking confirmation page
    header("Location: booking_confirmation.php?booking_id=" . $bookingId);
    exit();
} else {
    echo "Error: Could not process the booking.";
}

$stmt->close();
?>
