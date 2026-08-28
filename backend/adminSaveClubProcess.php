<?php
session_start();
include "../includes/connection.php";

$id = $_POST["club_id"] ?? "";
$name = $_POST["club_name"] ?? "";
$category = $_POST["category"] ?? "";
$leader = $_POST["leader_name"] ?? "";
$desc = $_POST["description"] ?? "";

if (empty($name)) {
    echo ("Please enter Club Name");
} else if (empty($category)) {
    echo ("Please select Category");
} else if (empty($leader)) {
    echo ("Please enter Club Leader/President Name");
} else if (empty($desc)) {
    echo ("Please enter Club Description");
} else {
    if (!empty($id)) {
        Database::iud("UPDATE `clubs` SET 
                    `club_name`='" . $name . "', 
                    `category`='" . $category . "', 
                    `leader_name`='" . $leader . "', 
                    `description`='" . $desc . "' 
                    WHERE `clubID`='" . $id . "'");
        echo ("success");
    } else {
        Database::iud("INSERT INTO `clubs` (`club_name`, `category`, `leader_name`, `description`) 
                    VALUES ('" . $name . "', '" . $category . "', '" . $leader . "', '" . $desc . "')");
        echo ("success");
    }
}
?>