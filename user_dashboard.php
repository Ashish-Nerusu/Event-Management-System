<?php
include('db.php'); 

// user_dashboard.php
session_start();



// Check if the user is logged in, if not, redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}



// Check if the event code form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventCode = $_POST['event_code'];

   // Fetch event details from the database
   $sql = "SELECT * FROM events WHERE event_code = '$eventCode'";
   $result = mysqli_query($conn, $sql);
   
   if (mysqli_num_rows($result) > 0) {
       // Output the event details
       $row = mysqli_fetch_assoc($result);
       echo "Event Name: " . $row['event_name'] . "<br>";
       echo "Event Date: " . $row['event_date'] . "<br>";
       echo "Event Time: " . $row['event_time'] . "<br>";
       echo "Event Venue: " . $row['event_venue'] . "<br>";
       echo "Ticket Price: $" . $row['ticket_price'] . "<br>";
   } else {
       echo "No event found with that code.";
   }
}




    

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
        .dashboard-container {
            text-align: center;
        }
        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #ff4c4c;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }
        .logout-button:hover {
            background-color: #e04343;
        }
        .event-code-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 400px;
            margin-top: 20px;
        }
        .event-code-container h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
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
        .error-message {
            color: #ff4c4c;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>You are logged in.</p>
    <a href="user_logout.php" class="logout-button">Logout</a>
</div>

<div class="event-code-container">
    <h1>Enter Event Code</h1>
    <?php if (isset($error_message)) { echo "<div class='error-message'>$error_message</div>"; } ?>
    <form action="details_display.php" method="get">
    <input type="text" name="event_code" class="input-field" placeholder="Enter Event Code" required>
    <button type="submit" class="submit-button">Explore Event</button>
     </form>

</div>

</body>
</html>
