<?php
session_start();
include "../includes/connection.php";

$mediaId = $_POST["media_id"] ?? "";

if (!empty($mediaId)) {
    $rs = Database::search("SELECT `file_path` FROM `media_uploads` WHERE `mediaID`='" . $mediaId . "'");
    if ($rs->num_rows > 0) {
        $data = $rs->fetch_assoc();
        $filePath = "../" . $data["file_path"];

        // Delete file from disk if exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        Database::iud("DELETE FROM `media_uploads` WHERE `mediaID`='" . $mediaId . "'");
        echo ("success");
    } else {
        echo ("Media record not found.");
    }
} else {
    echo ("Invalid media ID.");
}
?>