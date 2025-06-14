<?php
session_start(); // Start the session




if (!isset($_SESSION['username'])) {
    header('Location: manager_login.php'); // Redirect to login if not authenticated
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
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
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 400px;
        }
        .dashboard-container h1 {
            margin-bottom: 20px;
        }
        .action-button {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            background-color: #17a2b8;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }
        .action-button:hover {
            background-color: #138496;
        }
        .logout-button {
            background-color: #dc3545;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <!-- Create New Event Button -->
    <form action="create_event.php" method="post">
        <button type="submit" class="action-button">Create New Event</button>
    </form>

    <!-- Edit Existing Events Button -->
    <form action="edit_events.php" method="post">
        <button type="submit" class="action-button">Edit Existing Events</button>
    </form>

    


<!-- Logout Button -->
<form action="manager_logout.php" method="post">
    <button type="submit" class="action-button logout-button">Logout</button>
</form>


</body>
</html>
