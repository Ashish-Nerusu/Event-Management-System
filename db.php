<?php
// Database connection settings
$servername = "localhost";  // Your server (usually localhost for local development)
$username = "root";         // Your MySQL username (default is 'root' in XAMPP)
$password = "";             // Your MySQL password (default is empty in XAMPP)
$dbname = "ems3"; // Your database name


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
