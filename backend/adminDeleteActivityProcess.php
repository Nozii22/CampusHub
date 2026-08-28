<?php
session_start();
include "../includes/connection.php";

$id = $_POST["activity_id"] ?? "";
if (!empty($id)) {
    Database::iud("DELETE FROM `activities` WHERE `activityID`='" . $id . "'");
    echo ("success");
} else {
    echo ("Invalid Activity ID");
}
?>