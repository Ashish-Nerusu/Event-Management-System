<?php
include('db.php'); // Include the database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");  // Redirect to login if not logged in
    exit();
}

// Check if necessary POST data is available
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_code'], $_POST['username'], $_POST['num_tickets'], $_POST['ticket_price'])) {
    
    // Sanitize and validate input
    $eventCode = htmlspecialchars($_POST['event_code']);
    $username = htmlspecialchars($_POST['username']);
    $numTickets = filter_input(INPUT_POST, 'num_tickets', FILTER_VALIDATE_INT);
    $ticketPrice = filter_input(INPUT_POST, 'ticket_price', FILTER_VALIDATE_FLOAT);

    // Validate the number of tickets and ticket price
    if ($numTickets < 1 || !$ticketPrice) {
        // Handle invalid input
        die("Invalid input. Please ensure the number of tickets and price are correct.");
    }

    // Calculate the total price including tax (5% tax)
    $tax = $ticketPrice * 0.05; // 5% tax
    $totalPrice = ($ticketPrice * $numTickets) + $tax;

    // Fetch the event name from the events table
    $sql = "SELECT event_name FROM events WHERE event_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $eventCode);
    $stmt->execute();
    $stmt->bind_result($eventName);
    $stmt->fetch();
    $stmt->close();

    // If the event is not found, show an error
    if (!$eventName) {
        die("Event not found.");
    }

    // Prepare the SQL query to insert booking details into the database
    $stmt = $conn->prepare("INSERT INTO bookings (username, event_code, event_name, num_tickets, total_price, booking_date) VALUES (?, ?, ?, ?, ?, CURDATE())");
    $stmt->bind_param("sssis", $username, $eventCode, $eventName, $numTickets, $totalPrice);

    // Execute the query and check if the data was successfully inserted
    if ($stmt->execute()) {
        // If successful, redirect to a confirmation page
        header("Location: booking_confirmation.php"); // You can create this page
        exit();
    } else {
        // If there was an error, display an error message
        echo "Error: Unable to store booking details. Please try again.";
    }

    $stmt->close(); // Close the prepared statement
} else {
    // If required POST data is missing, redirect back to the booking page
    header("Location: book_event.php");
    exit();
}
?>
