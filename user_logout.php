<?php
// logout.php
session_start();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: user_login.php");
exit();
?>
