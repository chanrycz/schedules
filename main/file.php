<?php
require "../cookies.php";

// Initialize the session
if (!isset($_SESSION)) {
    setupSession();
}

header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: application/json');

require '../sql.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST["data"]) && ($_GET["write"] == "true")) {
        $data = json_decode(strip_tags(urldecode($_POST["data"]), [
            "b",
            "strong",
            "i",
            "em",
            "mark",
            "small",
            "del",
            "strike",
            "ins",
            "sup",
            "sub"
        ]));
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo '{"error": true, "message": "Invalid JSON"}';
            exit;
        } else {
            if ($query = mysqli_query($con, "SELECT * FROM `users` WHERE email='" . $_SESSION["email"] . "'")) {
                if (mysqli_num_rows($query) > 0) {
                    $query = mysqli_query($con, "UPDATE `users` SET `data`='" . mysqli_real_escape_string($con, json_encode($data)) . "' WHERE `email`='" . $_SESSION["email"] . "'");
                    if ($query) {
                        echo '{"success": true, "message": "Data saved"}';
                        exit;
                    } else {
                        echo '{"error": true, "message": "Database error"}';
                        exit;
                    }
                } else {
                    echo '{"error": true, "message": "User not found"}';
                    exit;
                }
            } else {
                echo '{"error": true, "message": "Database error"}';
                exit;
            }
            exit;
        }
    } else {
        echo '{"error": true, "message": "Invalid request"}';
        exit;
    }
} else if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET["empty"])) {
        if (isset($_SESSION["email"])) {
            echo '{"timetable":[{"day":"Monday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Tuesday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Wednesday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Thursday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Friday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]}],"periods":[{"start":"08:00","end":"09:20"},{"start":"09:20","end":"09:40"},{"start":"09:40","end":"11:00"},{"start":"11:10","end":"12:30"},{"start":"12:45","end":"13:45"},{"start":"13:45","end":"15:05"},{"start":"15:10","end":"16:30"}],"colors":{},"other":{"timeSkipNextDay":{"enabled":true,"time":1020}},"success":true,"message":"Data is corrupted, using empty template"}';
        } else {
            echo '{"error": true, "message": "Not logged in"}';
            exit;
        }
        exit;
    } else if (isset($_GET["reset"])) {
        if ($query = mysqli_query($con, "SELECT * FROM `users` WHERE email='" . $_SESSION["email"] . "'")) {
            if (mysqli_num_rows($query) > 0) {
                    echo '{"timetable":[{"day":"Monday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Tuesday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Wednesday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Thursday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Friday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]}],"periods":[{"start":"08:00","end":"09:20"},{"start":"09:20","end":"09:40"},{"start":"09:40","end":"11:00"},{"start":"11:10","end":"12:30"},{"start":"12:45","end":"13:45"},{"start":"13:45","end":"15:05"},{"start":"15:10","end":"16:30"}],"colors":{},"other":{"timeSkipNextDay":{"enabled":true,"time":1020}},"success":true,"message":"Data reset successfully"}';
                    exit;
                } else {
                    echo '{"error": true, "message": "Database error"}';
                    exit;
                }
            } else {
                echo '{"error": true, "message": "User not found"}';
                exit;
            }
        } else {
            echo '{"error": true, "message": "Database error"}';
            exit;
        }
    } else if (isset($_SESSION["email"])) {
        if ($query = mysqli_query($con, "SELECT * FROM `users` WHERE email='" . $_SESSION["email"] . "'")) {
            if (mysqli_num_rows($query) > 0) {
                if ($row = mysqli_fetch_assoc($query)) {
                    if ($row["data"] != "null" && !empty($row["data"])) {
                        $data = json_decode($row["data"], true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            echo '{"error": true, "message": "Invalid JSON"}';
                            exit;
                        } else {
                            $data["success"] = true;
                            echo json_encode($data);
                            exit;
                        }
                    } else {
                        echo '{"error": true, "message": "Invalid JSON"}';
                        exit;
                    }
                } else {
                    echo '{"error": true, "message": "Database error"}';
                    exit;
                }
            } else {
                echo '{"error": true, "message": "User not found"}';
                exit;
            }
        } else {
            echo '{"error": true, "message": "Database error"}';
            exit;
        }
    } else {
        echo '{"error": true, "message": "Not logged in"}';
        exit;
    }
} else {
    echo '{"error": true, "message": "Invalid request"}';
    exit;
}
