<?php
session_start();
include "../includes/connection.php";

$formId = $_POST["form_id"] ?? "";
$status = $_POST["status"] ?? "";

if (empty($formId) || empty($status)) {
    echo ("Invalid Parameters.");
    exit();
}

Database::iud("UPDATE `student_forms` SET `status`='" . $status . "' WHERE `formID`='" . $formId . "'");
echo ("success");
?>