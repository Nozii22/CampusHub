<?php
session_start();
include "../includes/connection.php";

$reg_id = $_POST["reg_id"] ?? "";
$status_id = $_POST["status_id"] ?? "";

if (!empty($reg_id) && !empty($status_id)) {
    Database::iud("UPDATE `event_registration` SET `event_registrationStatus_event_registrationStatusID`='" . $status_id . "' WHERE `event_registrationID`='" . $reg_id . "'");
    echo ("success");
} else {
    echo ("Invalid request parameters.");
}
?>