<?php
session_start();

// Check if logged in
if (isset($_SESSION['username'])) {
    session_destroy();
}

// Redirect back to the login page with error message
header('Location: login1.php');
?>