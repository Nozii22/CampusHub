<?php
session_start();
include "../includes/connection.php";

$id = $_POST["activity_id"] ?? "";
$title = $_POST["activity_title"] ?? "";
$location = $_POST["activity_location"] ?? "";
$dateTime = $_POST["activity_date_time"] ?? "";
$desc = $_POST["activity_description"] ?? "";

if (empty($title)) {
    echo ("Please enter Activity Title");
} else if (strlen($title) > 100) {
    echo ("Activity Title must be under 100 characters");
} else if (empty($location)) {
    echo ("Please enter Activity Location");
} else if (strlen($location) > 45) {
    echo ("Location must be under 45 characters");
} else if (empty($dateTime)) {
    echo ("Please select Activity Date and Time");
} else if (empty($desc)) {
    echo ("Please enter Activity Description");
} else {
    if (!empty($id)) {
        Database::iud("UPDATE `activities` SET `activity_title`='" . $title . "', `activity_description`='" . $desc . "', `activity_date_time`='" . $dateTime . "', `activity_location`='" . $location . "' WHERE `activityID`='" . $id . "'");
        echo ("success");
    } else {
        Database::iud("INSERT INTO `activities` (`activity_title`, `activity_description`, `activity_date_time`, `activity_location`) VALUES ('" . $title . "', '" . $desc . "', '" . $dateTime . "', '" . $location . "')");
        echo ("success");
    }
}
?>