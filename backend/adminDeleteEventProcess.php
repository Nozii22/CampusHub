<?php
session_start();
include "../includes/connection.php";

$id = $_POST["event_id"] ?? "";
if (!empty($id)) {
    Database::iud("DELETE FROM `event` WHERE `eventID`='" . $id . "'");
    echo ("success");
} else {
    echo ("Invalid Event ID");
}
?>