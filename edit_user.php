<?php
// edit_user.php
session_start();
include 'db.php'; // Database connection

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch the user's current data
    $query = "SELECT username, email FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $email);
    $stmt->fetch();
    $stmt->close();

    // If the form is submitted, update the user's information
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_username = $_POST['username'];
        $new_email = $_POST['email'];

        $update_query = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $new_username, $new_email, $user_id);

        if ($stmt->execute()) {
            // Redirect back to user management page with success message
            header("Location: user_management.php?message=User updated successfully");
            exit();
        } else {
            $error_message = "Failed to update user. Please try again.";
        }

        $stmt->close();
    }
} else {
    // Redirect to user management if no user_id is provided
    header("Location: user_management.php");
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #ffffff; /* Light text */
            padding: 20px;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #4CAF50; /* Green text for heading */
        }

        form {
            background-color: #1e1e1e; /* Dark form background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5); /* Dark shadow */
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #ffffff; /* Light label text */
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #444444; /* Dark border */
            border-radius: 5px;
            background-color: #333333; /* Dark input field */
            color: #ffffff; /* White text inside input */
            font-size: 16px;
        }

        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #4CAF50; /* Green border on focus */
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50; /* Green button */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        button[type="button"] {
            background-color: #d9534f; /* Red for cancel button */
        }

        button[type="button"]:hover {
            background-color: #c9302c; /* Darker red on hover */
        }

        .error-message {
            color: red;
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Edit User</h2>
    <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

        <button type="submit">Save Changes</button>
        <button type="button" onclick="window.location.href='user_management.php'">Cancel</button>
    </form>
</body>
</html>
