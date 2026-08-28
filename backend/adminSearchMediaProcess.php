<?php
include "../includes/connection.php";

$search = $_POST["search"] ?? "";

$query = "SELECT `media_uploads`.*, `event`.`eventName` 
          FROM `media_uploads` 
          LEFT JOIN `event` ON `media_uploads`.`event_eventID` = `event`.`eventID`";

if (!empty($search)) {
    $query .= " WHERE `media_uploads`.`media_title` LIKE '%" . $search . "%' 
               OR `event`.`eventName` LIKE '%" . $search . "%'";
}

$query .= " ORDER BY `media_uploads`.`mediaID` DESC";
$media_rs = Database::search($query);
?>

<table class="data-table">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Preview</th>
            <th>Title</th>
            <th>Type</th>
            <th>Related Event</th>
            <th>Uploaded At</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($media_rs->num_rows > 0) {
            while ($m = $media_rs->fetch_assoc()) {
        ?>
                <tr>
                    <td><strong>#<?php echo ($m["mediaID"]); ?></strong></td>
                    <td>
                        <?php if ($m["media_type"] == "image") { ?>
                            <img src="../<?php echo ($m['file_path']); ?>" class="media-thumb" alt="thumb">
                        <?php } else { ?>
                            <video class="media-thumb" src="../<?php echo ($m['file_path']); ?>"></video>
                        <?php } ?>
                    </td>
                    <td><?php echo htmlspecialchars($m["media_title"]); ?></td>
                    <td>
                        <span class="badge <?php echo ($m['media_type'] == 'image' ? 'badge-blue' : 'badge-purple'); ?>">
                            <?php echo ucfirst($m["media_type"]); ?>
                        </span>
                    </td>
                    <td><?php echo ($m["eventName"] ? htmlspecialchars($m["eventName"]) : "<span class='text-muted'>General</span>"); ?></td>
                    <td><?php echo date("Y-m-d h:i A", strtotime($m["uploaded_at"])); ?></td>
                    <td class="text-center">
                        <button class="btn-action btn-delete" onclick="deleteMedia(<?php echo ($m['mediaID']); ?>);">Delete</button>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo ("<tr><td colspan='7' class='text-center'>No matching media records found.</td></tr>");
        }
        ?>
    </tbody>
</table>