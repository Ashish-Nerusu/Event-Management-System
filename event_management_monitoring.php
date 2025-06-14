<?php
// Include database connection
include('db.php');

// Start output buffering
ob_start();  // Start output buffering to prevent header errors

// Fetch all events, without manager_id association for simplicity
$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management Monitoring</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h1 {
            text-align: center;
            color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1e1e1e;
            color: #ffffff;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        th {
            background-color: #333;
        }
        tr:hover {
            background-color: #333333;
        }
        button {
            padding: 8px 16px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h1>Event Management Monitoring</h1>

<?php
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Manager Username</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Event Time</th>
                <th>Venue</th>
                <th>Ticket Price</th>
                <th>Event Code</th>
                <th>Actions</th>
            </tr>";
    // Loop through the events and display them
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['event_id'] . "</td>";
        echo "<td>manager</td>";  // Use 'manager' as a default manager username for all events
        echo "<td>" . $row['event_name'] . "</td>";
        echo "<td>" . $row['event_date'] . "</td>";
        echo "<td>" . $row['event_time'] . "</td>";
        echo "<td>" . $row['event_venue'] . "</td>";
        echo "<td>$" . $row['ticket_price'] . "</td>";
        echo "<td>" . $row['event_code'] . "</td>";
        echo "<td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['event_id'] . "'>
                    <button type='submit' name='revoke_event'>Revoke Event</button>
                </form>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['event_id'] . "'>
                    <button type='submit' name='regenerate_code'>Regenerate Code</button>
                </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No events found.</p>";
}

// Handle event revocation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['revoke_event'])) {
    $id = $_POST['id'];

    // Delete the event from the database
    $sql_delete = "DELETE FROM events WHERE event_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);
    if ($stmt_delete->execute()) {
        // Redirect to the same page after successful revocation
        header("Location: event_management_monitoring.php"); // Use header to redirect
        exit();  // Make sure to stop the script after the redirection
    } else {
        echo "<p>Error revoking event: " . $stmt_delete->error . "</p>";
    }
    $stmt_delete->close();
}

// Handle event code regeneration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['regenerate_code'])) {
    $id = $_POST['id'];
    $new_code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6)); // Generate a new 6-char code

    // Update the event code in the database
    $sql_update_code = "UPDATE events SET event_code = ? WHERE event_id = ?";
    $stmt_update_code = $conn->prepare($sql_update_code);
    $stmt_update_code->bind_param("si", $new_code, $id);
    if ($stmt_update_code->execute()) {
        // Redirect to the same page after regenerating the code
        header("Location: event_management_monitoring.php"); // Use header to redirect
        exit();  // Make sure to stop the script after the redirection
    } else {
        echo "<p>Error regenerating event code: " . $stmt_update_code->error . "</p>";
    }
    $stmt_update_code->close();
}

$conn->close();

// End output buffering and flush the output
ob_end_flush();
?>

</body>
</html>
