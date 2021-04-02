<?php
require "../cookies.php";

// Initialize the session
if (!isset($_SESSION)) {
    setupSession();
}

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

setupSession();

// Redirect to login page
$_SESSION["logout"] = true;

// Redirect user to login page
header("Location: login");

exit;
