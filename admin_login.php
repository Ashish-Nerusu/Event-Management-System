<?php
// Start the session
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Simulate login by checking hardcoded credentials
    if ($inputUsername ==  "admin" && $inputPassword == "admin123") {
        // Login successful
        $_SESSION['admin'] = $inputUsername;
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        // Login failed
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
        h2 {
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
        }
        label, input {
            margin-bottom: 10px;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            border-radius: 5px;
            border: none;
        }
        input[type="submit"] {
            background-color: #1e1e1e;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error {
            color: #ff4c4c;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Admin Login</h2>
    
    <form method="POST" action="">
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>
</body>
</html>
