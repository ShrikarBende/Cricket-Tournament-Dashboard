<?php
session_start();
session_destroy(); // Destroy session
header("Location: user_login.php"); // Redirect to login
exit();
?>
