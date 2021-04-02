<?php
// Check if the user is already logged in, if not then redirect them to login page
if (!isset($_SESSION["schedulelogin"]) && $_SESSION["schedulelogin"] !== true) {
    header("Location: login");
    exit();
}
