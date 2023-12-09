<?php
// file: logout.php

// Start the session
session_start();
// Unset all session variables
session_unset();
// Destroy the session
session_destroy();
// Redirect to the login page using JavaScript
echo '<script>window.location.href = "../login";</script>';
exit;
?>
