<?php
require "../cookies.php";

// Initialize the session
if (!isset($_SESSION)) {
    setupSession();
}

if (!isset($_SESSION["schedulelogin"]) || $_SESSION["schedulelogin"] !== true) {
    header("location: login");
    exit;
}
