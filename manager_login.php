<?php
// Start the session
session_start();

// Include the database connection
include 'db.php';

// Initialize error message
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // This can be an empty string

    // Prepare SQL statement to fetch user data by username
    $stmt = $conn->prepare("SELECT user_id, username, password FROM managers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($user_id, $db_username, $db_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $db_password)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;

            // Redirect to user dashboard
            header("Location: manager_dashboard.php");
            exit();
        } else {
            $error_message = "Invalid username or password!";
        }
    } else {
        $error_message = "User not found!";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Login</title>
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
        .login-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 300px;
        }
        .login-container h1 {
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

<div class="login-container">
    <h1>Manager Login</h1>
    <?php if ($error_message) { echo "<div class='error-message'>$error_message</div>"; } ?>
    <form action="manager_login.php" method="post">
        <input type="text" name="username" class="input-field" placeholder="Username" required>
        <input type="password" name="password" class="input-field" placeholder="Password" required>
        <button type="submit" class="submit-button">Login</button>
        <button type="button" class="register-button" onclick="location.href='manager_signup.php'">Sign Up</button>
        <button type="button" class="register-button" onclick="location.href='manager_signup.php'">back</button>
        <img src="images/adn.jpeg" alt="Admin Login" width>
        </form>
</div>

</body>
</html>
