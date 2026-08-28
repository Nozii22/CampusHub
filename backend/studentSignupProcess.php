<?php
include "../includes/connection.php";

$fname = $_POST["first_name"] ?? "";
$lname = $_POST["last_name"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$gender = $_POST["gender"] ?? "";
$terms = $_POST["terms"] ?? "";

if (empty($fname)) {
    echo ("Please Enter Your First Name");
} else if (strlen($fname) > 45) {
    echo ("First Name Must Contain Fewer Than 45 Characters");
} else if (empty($lname)) {
    echo ("Please Enter Your Last Name");
} else if (strlen($lname) > 45) {
    echo ("Last Name Must Contain Fewer Than 45 Characters");
} else if (empty($email)) {
    echo ("Please Enter Your Email");
} else if (strlen($email) > 45) {
    echo ("Email Must Contain Fewer Than 45 Characters");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address");
} else if (empty($password)) {
    echo ("Please Enter Your Password");
} else if (strlen($password) < 8 || strlen($password) > 20) {
    echo ("Password Must Contain 8 - 20 Characters");
} else if (empty($gender)) {
    echo ("Please Select Your Gender");
} else if (empty($terms)) {
    echo ("Please Agree to the Terms and Conditions");
} else {
    // Database search table name is `students`
    $rs = Database::search("SELECT * FROM `students` WHERE `email`='" . $email . "'");

    if ($rs->num_rows > 0) {
        echo ("User with this Email already exists, please sign in or use another Email");
    } else {
        // Active student status = 1
        Database::iud("INSERT INTO `students` (`first_name`, `last_name`, `email`, `password`, `Student_status_statusID`, `gender_genderID`) 
                    VALUES ('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $password . "', '1', '" . $gender . "')");
        echo ("success");
    }
}
?>