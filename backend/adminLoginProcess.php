<?php
session_start();
include "../includes/connection.php";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

if (empty($email)) {
    echo ("Please Enter Your Admin Email Address");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address Format");
} else if (empty($password)) {
    echo ("Please Enter Your Password");
} else {
    // Check credentials in admin table
    $rs = Database::search("SELECT * FROM `admins` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");
    $num = $rs->num_rows;

    if ($num == 1) {
        $data = $rs->fetch_assoc();
        $_SESSION["admin"] = $data;
        echo ("success");
    } else {
        echo ("Invalid Admin Credentials. Access Denied.");
    }
}
?>