<?php
include "../includes/connection.php";

$search = $_POST["search"] ?? "";
$query = "SELECT * FROM `event`";
if (!empty($search)) {
    $query .= " WHERE `eventName` LIKE '%" . $search . "%' OR `eventLocation` LIKE '%" . $search . "%'";
}
$query .= " ORDER BY `eventID` DESC";
$rs = Database::search($query);
?>
<table class="data-table">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Event Name</th>
            <th>Location</th>
            <th>Date & Time</th>
            <th>Description</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($rs->num_rows > 0) {
            while ($ev = $rs->fetch_assoc()) {
        ?>
                <tr>
                    <td><strong>#<?php echo ($ev["eventID"]); ?></strong></td>
                    <td><?php echo htmlspecialchars($ev["eventName"]); ?></td>
                    <td><?php echo htmlspecialchars($ev["eventLocation"]); ?></td>
                    <td><?php echo date("Y-m-d h:i A", strtotime($ev["eventDateTime"])); ?></td>
                    <td><?php echo htmlspecialchars($ev["eventDescription"]); ?></td>
                    <td class="text-center">
                        <button class="btn-action btn-edit" onclick='editEvent(<?php echo json_encode($ev); ?>);'>Edit</button>
                        <button class="btn-action btn-delete" onclick="deleteEvent(<?php echo ($ev['eventID']); ?>);">Delete</button>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo ("<tr><td colspan='6' class='text-center'>No matching events found.</td></tr>");
        }
        ?>
    </tbody>
</table>