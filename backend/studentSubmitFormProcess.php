<?php
session_start();
include "../includes/connection.php";

$student_session = $_SESSION["student"] ?? null;
if (!$student_session || empty($student_session["studentID"])) {
    echo ("login_required");
    exit();
}

$std_id = $student_session["studentID"];
$type = $_POST["form_type"] ?? "";
$subject = $_POST["subject"] ?? "";
$message = $_POST["message"] ?? "";

if (empty($type) || empty($subject) || empty($message)) {
    echo ("All fields are required.");
    exit();
}

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimeZone($tz);
$now = $d->format("Y-m-d H:i:s");

Database::iud("INSERT INTO `student_forms` (`students_studentID`, `form_type`, `subject`, `message`, `submitted_at`, `status`) 
            VALUES ('" . $std_id . "', '" . $type . "', '" . $subject . "', '" . $message . "', '" . $now . "', 'Pending')");

echo ("success");
?>