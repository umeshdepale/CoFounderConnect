<?php
session_start();

// Destroy all session data
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page or homepage
header("Location: http://umeshdepale.com/cofounder/");
exit();
?>
