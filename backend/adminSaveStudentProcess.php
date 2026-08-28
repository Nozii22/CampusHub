<?php
session_start();
include "../includes/connection.php";

$id = $_POST["student_id"] ?? "";
$fname = $_POST["first_name"] ?? "";
$lname = $_POST["last_name"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$gender = $_POST["gender"] ?? "";
$status = $_POST["status"] ?? "1";

if (empty($fname)) {
    echo ("Please enter First Name");
} else if (empty($lname)) {
    echo ("Please enter Last Name");
} else if (empty($email)) {
    echo ("Please enter Email");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email format");
} else if (empty($id) && empty($password)) {
    echo ("Please enter a temporary Password for new student");
} else if (empty($gender)) {
    echo ("Please select Gender");
} else {
    if (!empty($id)) {
        // Update Existing Student
        Database::iud("UPDATE `students` SET 
                    `first_name`='" . $fname . "', 
                    `last_name`='" . $lname . "', 
                    `email`='" . $email . "', 
                    `gender_genderID`='" . $gender . "', 
                    `Student_status_statusID`='" . $status . "' 
                    WHERE `studentID`='" . $id . "'");
        echo ("success");
    } else {
        // Insert New Student
        $check = Database::search("SELECT * FROM `students` WHERE `email`='" . $email . "'");
        if ($check->num_rows > 0) {
            echo ("A student with this email already exists.");
        } else {
            Database::iud("INSERT INTO `students` (`first_name`, `last_name`, `email`, `password`, `Student_status_statusID`, `gender_genderID`) 
                        VALUES ('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $password . "', '" . $status . "', '" . $gender . "')");
            echo ("success");
        }
    }
}
