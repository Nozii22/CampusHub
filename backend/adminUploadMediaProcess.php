<?php
session_start();
include "../includes/connection.php";

$title = $_POST["media_title"] ?? "";
$type = $_POST["media_type"] ?? "";
$eventId = !empty($_POST["event_id"]) ? "'" . $_POST["event_id"] . "'" : "NULL";

if (empty($title)) {
    echo ("Please enter a media title.");
} else if (strlen($title) > 45) {
    echo ("Media title must be under 45 characters.");
} else if (!isset($_FILES["media_file"])) {
    echo ("Please choose a file to upload.");
} else {
    $file = $_FILES["media_file"];
    $fileName = $file["name"];
    $fileTmp = $file["tmp_name"];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedImage = ["jpg", "jpeg", "png", "webp"];
    $allowedVideo = ["mp4", "webm", "mkv"];

    if ($type == "image" && !in_array($fileExt, $allowedImage)) {
        echo ("Invalid image format. Allowed: JPG, PNG, WEBP.");
        exit();
    } else if ($type == "video" && !in_array($fileExt, $allowedVideo)) {
        echo ("Invalid video format. Allowed: MP4, WEBM.");
        exit();
    }

    // Ensure uploads directory exists
    $targetDir = "../uploads/media/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $uniqueName = uniqid("media_") . "." . $fileExt;
    $targetFilePath = $targetDir . $uniqueName;
    $dbFilePath = "uploads/media/" . $uniqueName;

    if (move_uploaded_file($fileTmp, $targetFilePath)) {
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimeZone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `media_uploads` (`media_title`, `media_type`, `file_path`, `event_eventID`, `uploaded_at`) 
                    VALUES ('" . $title . "', '" . $type . "', '" . $dbFilePath . "', " . $eventId . ", '" . $date . "')");
        echo ("success");
    } else {
        echo ("Failed to upload file to the server folder.");
    }
}
?>