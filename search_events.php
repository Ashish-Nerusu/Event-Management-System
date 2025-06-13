<?php
// Include database connection
include('db.php');

// Check if a search term is provided
if (isset($_GET['term'])) {
    $term = $_GET['term'] . '%'; // Add wildcard for partial matching
    $sql = "SELECT event_name FROM events WHERE event_name LIKE ? LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row['event_name'];
    }
    
    echo json_encode($events); // Return the results as JSON
    $stmt->close();
}
?>
