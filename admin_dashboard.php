<?php
// Start the session
session_start();

// Check if the admin is logged in, otherwise redirect to login
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            width: 400px;
            text-align: center;
        }
        .dashboard-container h1 {
            margin-bottom: 20px;
        }
        .dashboard-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .dashboard-button:hover {
            background-color: #218838;
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
    <h1>Welcome, Admin!</h1>
    <button class="dashboard-button" onclick="location.href='user_management.php'">User Management</button>
    <button class="dashboard-button" onclick="location.href='manager_management.php'">Manager Management</button>
    <button class="dashboard-button" onclick="location.href='event_management_monitoring.php'">Event Management Monitoring</button>
    <button class="dashboard-button" onclick="location.href='view_bookings.php'">View bookings</button>
    <button class="dashboard-button logout-button" onclick="location.href='admin_logout.php'">Logout</button>
</div>

</body>
</html>
