<?php
// Include database connection
include('db.php');

// Fetch all bookings along with event names from the `events` table
$sql = "SELECT b.username, b.event_code, e.event_name, b.num_tickets, b.total_price, b.booking_date
        FROM bookings b
        LEFT JOIN events e ON b.event_code = e.event_code"; // Correct join between bookings and events

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }
        h1 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }
        .table-container, .summary-container {
            width: 100%;
            max-width: 800px;
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
    </style>
</head>
<body>

<h1>Booking Management</h1>

<div class="table-container">
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Username</th>
                    <th>Event Code</th>
                    <th>Event Name</th>
                    <th>Number of Tickets</th>
                    <th>Total Price</th>
                    <th>Booking Date</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['username'] . "</td>
                    <td>" . $row['event_code'] . "</td>
                    <td>" . ($row['event_name'] ? $row['event_name'] : 'No event found') . "</td>  <!-- Display event name -->
                    <td>" . $row['num_tickets'] . "</td>
                    <td>$" . $row['total_price'] . "</td>
                    <td>" . $row['booking_date'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No bookings found.</p>";
    }
    ?>
</div>

<div class="summary-container">
    <h2>Summary of Earnings by Date</h2>
    <?php
    // Calculate earnings summary and fetch event names for each date
    $summary_sql = "SELECT b.booking_date, 
                            GROUP_CONCAT(DISTINCT e.event_name ORDER BY e.event_name SEPARATOR ', ') AS events,
                            SUM(b.total_price) as total_earnings
                    FROM bookings b
                    LEFT JOIN events e ON b.event_code = e.event_code
                    GROUP BY b.booking_date
                    ORDER BY b.booking_date";
    $summary_result = $conn->query($summary_sql);

    if ($summary_result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Date</th>
                    <th>Events</th>
                    <th>Total Earnings</th>
                </tr>";
        while ($summary_row = $summary_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $summary_row['booking_date'] . "</td>
                    <td>" . ($summary_row['events'] ? $summary_row['events'] : 'No events found') . "</td>
                    <td>$" . $summary_row['total_earnings'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No earnings summary available.</p>";
    }
    ?>
</div>

<?php
$conn->close();
?>

</body>
</html>
