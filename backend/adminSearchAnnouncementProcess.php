<?php
include "../includes/connection.php";

$search = $_POST["search"] ?? "";

$query = "SELECT * FROM `announcements`";
if (!empty($search)) {
    $query .= " WHERE `title` LIKE '%" . $search . "%' OR `content` LIKE '%" . $search . "%'";
}
$query .= " ORDER BY `announcementID` DESC";
$ann_rs = Database::search($query);
?>

<table class="data-table">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Posted Date</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($ann_rs->num_rows > 0) {
            while ($a = $ann_rs->fetch_assoc()) {
        ?>
                <tr>
                    <td><strong>#<?php echo ($a["announcementID"]); ?></strong></td>
                    <td><?php echo htmlspecialchars($a["title"]); ?></td>
                    <td><?php echo htmlspecialchars($a["content"]); ?></td>
                    <td><?php echo date("Y-m-d h:i A", strtotime($a["posted_date"])); ?></td>
                    <td class="text-center">
                        <button class="btn-action btn-edit" onclick='editAnnouncement(<?php echo json_encode($a); ?>);'>Edit</button>
                        <button class="btn-action btn-delete" onclick="deleteAnnouncement(<?php echo ($a['announcementID']); ?>);">Delete</button>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo ("<tr><td colspan='5' class='text-center'>No matching announcements found.</td></tr>");
        }
        ?>
    </tbody>
</table>