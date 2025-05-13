<?php


// Start the session
session_start();

// Destroy the session to log the user out
session_unset();
session_destroy();

// Redirect to the login page after logging out
header("Location: index.html");
exit();
?>