<?php
session_start();
include "../includes/connection.php";

$reg_id = $_POST["reg_id"] ?? "";

if (!empty($reg_id)) {
    Database::iud("DELETE FROM `event_registration` WHERE `event_registrationID`='" . $reg_id . "'");
    echo ("success");
} else {
    echo ("Invalid Registration ID.");
}
?>