<?php
// Start the session
session_start();

// Include the database connection
include 'db.php';

// Initialize error and success messages
$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert new user
        $stmt = $conn->prepare("INSERT INTO managers (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $success_message = "User registered successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Signup</title>
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
        .signup-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 300px;
        }
        .signup-container h1 {
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
        .success-message {
            color: #28a745;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h1>Manager Signup</h1>
    <?php if ($error_message) { echo "<div class='error-message'>$error_message</div>"; } ?>
    <?php if ($success_message) { echo "<div class='success-message'>$success_message</div>"; } ?>
    <form action="manager_signup.php" method="post">
        <input type="text" name="username" class="input-field" placeholder="Username" required>
        <input type="email" name="email" class="input-field" placeholder="Email" required>
        <input type="password" name="password" class="input-field" placeholder="Password" required>
        <input type="password" name="confirm_password" class="input-field" placeholder="Confirm Password" required>
        <button type="submit" class="submit-button">Sign Up</button>
        <button type="button" class="login-button" onclick="location.href='manager_login.php'">Login</button>
    </form>
</div>

</body>
</html>
