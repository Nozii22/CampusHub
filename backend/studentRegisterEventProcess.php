<?php
session_start();
include "../includes/connection.php";

// Check both session keys (student or students)
$student_session = $_SESSION["student"] ?? $_SESSION["students"] ?? null;

// If student is not logged in or studentID is missing
if (!$student_session || empty($student_session["studentID"])) {
    echo ("login_required");
    exit();
}

$studentId = $student_session["studentID"];
$eventId = $_POST["event_id"] ?? "";

if (empty($eventId)) {
    echo ("Invalid Event Selection.");
    exit();
}

// 1. Check if the student has already registered for this event
$check_rs = Database::search("SELECT * FROM `event_registration` WHERE `students_studentID`='" . $studentId . "' AND `event_eventID`='" . $eventId . "'");

if ($check_rs->num_rows > 0) {
    echo ("already_registered");
} else {
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimeZone($tz);
    $currentDateTime = $d->format("Y-m-d H:i:s");

    // 2. Insert record with Status ID 1 (Pending)
    Database::iud("INSERT INTO `event_registration` 
                (`students_studentID`, `event_eventID`, `event_registrationStatus_event_registrationStatusID`, `registration_dateTime`) 
                VALUES ('" . $studentId . "', '" . $eventId . "', '1', '" . $currentDateTime . "')");

    echo ("success");
}
?>