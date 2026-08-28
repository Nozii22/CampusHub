<?php
session_start();
include "../includes/connection.php";

$id = $_POST["event_id"] ?? "";
$name = $_POST["eventName"] ?? "";
$location = $_POST["eventLocation"] ?? "";
$dateTime = $_POST["eventDateTime"] ?? "";
$desc = $_POST["eventDescription"] ?? "";

if (empty($name)) {
    echo ("Please enter Event Name");
} else if (strlen($name) > 45) {
    echo ("Event Name must be under 45 characters");
} else if (empty($location)) {
    echo ("Please enter Event Location");
} else if (strlen($location) > 45) {
    echo ("Location must be under 45 characters");
} else if (empty($dateTime)) {
    echo ("Please select Event Date and Time");
} else if (empty($desc)) {
    echo ("Please enter Event Description");
} else if (strlen($desc) > 100) {
    echo ("Description must be under 100 characters");
} else {
    if (!empty($id)) {
        Database::iud("UPDATE `event` SET `eventName`='" . $name . "', `eventLocation`='" . $location . "', `eventDateTime`='" . $dateTime . "', `eventDescription`='" . $desc . "' WHERE `eventID`='" . $id . "'");
        echo ("success");
    } else {
        Database::iud("INSERT INTO `event` (`eventName`, `eventLocation`, `eventDateTime`, `eventDescription`) VALUES ('" . $name . "', '" . $location . "', '" . $dateTime . "', '" . $desc . "')");
        echo ("success");
    }
}
?>