<?php
session_start(); // Start the session

// Destroy all session data to log the user out
session_unset();  // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to the login page after logging out
header('Location: manager_login.php');
exit();
