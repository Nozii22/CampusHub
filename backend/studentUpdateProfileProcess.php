<?php
session_start();
include "../includes/connection.php";

$student_session = $_SESSION["student"] ?? $_SESSION["students"] ?? null;

if (!$student_session || empty($student_session["studentID"])) {
    echo ("Please login to update your profile.");
    exit();
}

$studentId = $student_session["studentID"];
$fname = $_POST["first_name"] ?? "";
$lname = $_POST["last_name"] ?? "";
$email = $_POST["email"] ?? "";

if (empty($fname)) {
    echo ("Please enter your first name.");
} else if (empty($lname)) {
    echo ("Please enter your last name.");
} else if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Please enter a valid email address.");
} else {
    // Check if email is already taken by another student
    $check_email = Database::search("SELECT `studentID` FROM `students` WHERE `email`='" . $email . "' AND `studentID`!='" . $studentId . "'");
    if ($check_email->num_rows > 0) {
        echo ("This email is already in use by another student.");
        exit();
    }

    $imageQuery = "";

    // Handle Profile Picture Upload
    if (isset($_FILES["profile_picture"])) {
        $file = $_FILES["profile_picture"];
        $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png", "webp"];

        if (in_array($ext, $allowed)) {
            $targetDir = "../uploads/profiles/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $fileName = "profile_" . $studentId . "_" . time() . "." . $ext;
            $targetFilePath = $targetDir . $fileName;
            $dbPath = "uploads/profiles/" . $fileName;

            if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                $imageQuery = ", `profile_picture`='" . $dbPath . "'";
                // Update session image
                $_SESSION["student"]["profile_picture"] = $dbPath;
            }
        } else {
            echo ("Invalid image format. Allowed: JPG, PNG, WEBP.");
            exit();
        }
    }

    // Update Database
    Database::iud("UPDATE `students` SET 
                `first_name`='" . $fname . "', 
                `last_name`='" . $lname . "', 
                `email`='" . $email . "' " . $imageQuery . " 
                WHERE `studentID`='" . $studentId . "'");

    // Update Session Data
    $_SESSION["student"]["first_name"] = $fname;
    $_SESSION["student"]["last_name"] = $lname;
    $_SESSION["student"]["email"] = $email;

    echo ("success");
}
?>