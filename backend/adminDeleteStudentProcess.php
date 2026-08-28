<?php
session_start();
include "../includes/connection.php";

$id = $_POST["student_id"] ?? "";

if (!empty($id)) {
    Database::iud("DELETE FROM `students` WHERE `studentID`='" . $id . "'");
    echo ("success");
} else {
    echo ("Invalid Student ID");
}
?>