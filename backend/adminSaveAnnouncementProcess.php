<?php
session_start();
include "../includes/connection.php";

$id = $_POST["announcement_id"] ?? "";
$title = $_POST["title"] ?? "";
$content = $_POST["content"] ?? "";

if (empty($title)) {
    echo ("Please enter Announcement Title");
} else if (strlen($title) > 45) {
    echo ("Title must be 45 characters or fewer");
} else if (empty($content)) {
    echo ("Please enter Announcement Content");
} else if (strlen($content) > 45) {
    echo ("Content must be 45 characters or fewer");
} else {
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimeZone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if (!empty($id)) {
        Database::iud("UPDATE `announcements` SET `title`='" . $title . "', `content`='" . $content . "' WHERE `announcementID`='" . $id . "'");
    } else {
        Database::iud("INSERT INTO `announcements` (`title`, `content`, `posted_date`) VALUES ('" . $title . "', '" . $content . "', '" . $date . "')");
    }

    // Auto sync to XML for assignment requirements
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
}
?>