<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Destroy the session cookie (important for security)
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 3600, "/");
}

// Redirect to signin page
header("Location: usersignin.php?logout=1");
exit();
?>
