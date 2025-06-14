<?php
session_start();
include 'db.php';

// Fetch all users from the database
$sql = "SELECT user_id, username, email FROM managers";  // Using 'user_id' as the primary key
$result = $conn->query($sql);

// Handle deletion
if (isset($_GET['delete_user_id'])) {
    $delete_user_id = $_GET['delete_user_id'];
    $delete_sql = "DELETE FROM managers WHERE user_id = '$delete_user_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
    header("Location: manager_management.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #555;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
        }
        .add-user-button, .edit-button, .delete-button {
            padding: 10px;
            color: #fff;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .add-user-button {
            background-color: #28a745;
            margin-bottom: 20px;
        }
        .edit-button {
            background-color: #007bff;
        }
        .delete-button {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <h1>Manager Management</h1>

    <!-- Add User Button -->
    <button class="add-user-button" onclick="location.href='add_manager.php'">Add Manager</button>

    <!-- User Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>
                            <a href="edit_manager.php?user_id=<?= htmlspecialchars($row['user_id']) ?>" class="edit-button">Edit</a>
                            <a href="manager_management.php?delete_user_id=<?= htmlspecialchars($row['user_id']) ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this Manager?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No Managers found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
