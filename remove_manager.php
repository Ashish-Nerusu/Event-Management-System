<?php
// Start session and include database connection
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle manager removal
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $managerId = $_POST['manager_id'];

    // Delete manager from the database
    $sql = "DELETE FROM managers WHERE id='$managerId'";
    if (mysqli_query($conn, $sql)) {
        echo "Manager removed successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch all managers from the database
$managers = mysqli_query($conn, "SELECT * FROM managers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Manager</title>
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
        label, select {
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #ff4c4c;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h2>Remove Manager</h2>

    <form method="POST" action="">
        <label for="manager_id">Select Manager to Remove:</label>
        <select id="manager_id" name="manager_id" required>
            <?php while ($row = mysqli_fetch_assoc($managers)) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
            <?php } ?>
        </select>

        <input type="submit" value="Remove Manager">
    </form>

</body>
</html>
