<?php
session_start();
include "../includes/connection.php";

$id = $_POST["club_id"] ?? "";

if (!empty($id)) {
    Database::iud("DELETE FROM `clubs` WHERE `clubID`='" . $id . "'");
    echo ("success");
} else {
    echo ("Invalid Club ID");
}
?>