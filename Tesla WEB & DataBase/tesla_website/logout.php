<?php
session_start();

// Unset cart-related session variables
unset($_SESSION["user_id"]);
unset($_SESSION["logout_success"]);

// Redirect to the login page
header("Location: login.php");
exit();
?>