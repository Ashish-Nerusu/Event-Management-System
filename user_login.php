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
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
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
            header("Location: user_dashboard.php");
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
    <title>User Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000000;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #1e1e1e;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.7);
            width: 320px;
            text-align: center;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-container legend {
            font-size: 1.8em;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 20px;
        }
        .input-field {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
            border: none;
            outline: none;
            background-color: #333;
            color: #ffffff;
        }
        .submit-button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .submit-button:hover {
            background-color: #218838;
        }
        .signup-link {
            margin-top: 15px;
            font-size: 14px;
        }
        .signup-link a {
            color: #007bff;
            text-decoration: none;
        }
        .signup-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #ff4c4c;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-container">
    <form action="user_login.php" method="post">
        <legend>User Login</legend>
        <?php if ($error_message) { echo "<div class='error-message'>$error_message</div>"; } ?>
        <input type="text" name="username" class="input-field" placeholder="Username" required>
        <input type="password" name="password" class="input-field" placeholder="Password" required>
        <button type="submit" class="submit-button">Login</button>
        <div class="signup-link">
            Don't have an account? <a href="user_signup.php">Sign up</a>
        </div>
    </form>
</div>

</body>
</html>