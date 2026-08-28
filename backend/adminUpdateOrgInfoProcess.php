<?php
session_start();
include "../includes/connection.php";

$name = $_POST["org_name"] ?? "";
$email = $_POST["email"] ?? "";
$phone = $_POST["phone"] ?? "";
$address = $_POST["address"] ?? "";
$about = $_POST["about_text"] ?? "";

if (empty($name)) {
    echo ("Please enter Organisation Name");
} else if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Please enter a valid Email address");
} else if (empty($phone)) {
    echo ("Please enter Contact Phone");
} else if (empty($address)) {
    echo ("Please enter Campus Address");
} else if (empty($about)) {
    echo ("Please enter About Us details");
} else {
    Database::iud("UPDATE `organisation_info` SET 
                `org_name`='" . $name . "', 
                `email`='" . $email . "', 
                `phone`='" . $phone . "', 
                `address`='" . $address . "', 
                `about_text`='" . $about . "' 
                WHERE `org_id`='1'");
    echo ("success");
}
?>