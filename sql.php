<?php
$con = mysqli_connect("ADDRESS", "USERNAME", "PASSWORD", "DATABASE");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
