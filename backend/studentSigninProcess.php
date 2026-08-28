<?php
session_start();
include "../includes/connection.php";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$rememberMe = $_POST["rememberMe"] ?? "false";

if (empty($email)) {
    echo ("Please Enter Your Email Address");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address");
} else if (empty($password)) {
    echo ("Please Enter Your Password");
} else {
    // Search active student records
    $rs = Database::search("SELECT * FROM `students` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");
    $num = $rs->num_rows;

    if ($num == 1) {
        $data = $rs->fetch_assoc();

        if ($data["Student_status_statusID"] == "1") {
            $_SESSION["student"] = $data;

            // Remember Me Cookies Setup
            if ($rememberMe == "true") {
                setcookie("campushub_student_email", $email, time() + (60 * 60 * 24 * 365), "/");
                setcookie("campushub_student_password", $password, time() + (60 * 60 * 24 * 365), "/");
            } else {
                setcookie("campushub_student_email", "", -1, "/");
                setcookie("campushub_student_password", "", -1, "/");
            }

            echo ("success");
        } else {
            echo ("Your account has been deactivated. Please contact administrator.");
        }
    } else {
        echo ("Invalid Email Address or Password");
    }
}
?>