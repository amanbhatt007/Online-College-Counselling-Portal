<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page or any other appropriate page
header("Location: http://127.0.0.1:5501/login.html");
exit;



