<?php
session_start();
include "../includes/connection.php";

$id = $_POST["announcement_id"] ?? "";

if (!empty($id)) {
    Database::iud("DELETE FROM `announcements` WHERE `announcementID`='" . $id . "'");

    // Auto sync XML after deletion
    $rs = Database::search("SELECT * FROM `announcements` ORDER BY `announcementID` DESC");
    $xml = new SimpleXMLElement('<announcements/>');

    while ($row = $rs->fetch_assoc()) {
        $item = $xml->addChild('announcement');
        $item->addChild('id', $row['announcementID']);
        $item->addChild('title', htmlspecialchars($row['title']));
        $item->addChild('content', htmlspecialchars($row['content']));
        $item->addChild('date', $row['posted_date']);
    }

    $xml->asXML("../announcements.xml");

    echo ("success");
} else {
    echo ("Invalid Announcement ID");
}
?>