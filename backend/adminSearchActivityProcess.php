<?php
include "../includes/connection.php";

$search = $_POST["search"] ?? "";
$query = "SELECT * FROM `activities`";
if (!empty($search)) {
    $query .= " WHERE `activity_title` LIKE '%" . $search . "%' OR `activity_location` LIKE '%" . $search . "%'";
}
$query .= " ORDER BY `activityID` DESC";
$rs = Database::search($query);
?>
<table class="data-table">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Activity Title</th>
            <th>Location</th>
            <th>Date & Time</th>
            <th>Description</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($rs->num_rows > 0) {
            while ($ac = $rs->fetch_assoc()) {
        ?>
                <tr>
                    <td><strong>#<?php echo ($ac["activityID"]); ?></strong></td>
                    <td><?php echo htmlspecialchars($ac["activity_title"]); ?></td>
                    <td><?php echo htmlspecialchars($ac["activity_location"]); ?></td>
                    <td><?php echo date("Y-m-d h:i A", strtotime($ac["activity_date_time"])); ?></td>
                    <td><?php echo htmlspecialchars($ac["activity_description"]); ?></td>
                    <td class="text-center">
                        <button class="btn-action btn-edit" onclick='editActivity(<?php echo json_encode($ac); ?>);'>Edit</button>
                        <button class="btn-action btn-delete" onclick="deleteActivity(<?php echo ($ac['activityID']); ?>);">Delete</button>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo ("<tr><td colspan='6' class='text-center'>No matching activities found.</td></tr>");
        }
        ?>
    </tbody>
</table>