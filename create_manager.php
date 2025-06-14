<?php
// Start session and include database connection
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle form submission to create a manager
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Insert new manager into the database
    $sql = "INSERT INTO managers (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "Manager account created successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
        }
        label, input {
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #1e1e1e;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h2>Create Manager</h2>

    <form method="POST" action="">
        <label for="username">Manager Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Manager Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Create Manager">
    </form>

</body>
</html>
