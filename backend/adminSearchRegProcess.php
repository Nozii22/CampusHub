<?php
include "../includes/connection.php";

$search = $_POST["search"] ?? "";

$query = "SELECT `event_registration`.*, 
            `students`.`first_name`, `students`.`last_name`, `students`.`email`,
        `event`.`eventName`,
            `event_registrationstatus`.`event_registrationStatusName` AS `statusName`
        FROM `event_registration`
        INNER JOIN `students` ON `event_registration`.`students_studentID` = `students`.`studentID`
        INNER JOIN `event` ON `event_registration`.`event_eventID` = `event`.`eventID`
        INNER JOIN `event_registrationstatus` ON `event_registration`.`event_registrationStatus_event_registrationStatusID` = `event_registrationstatus`.`event_registrationStatusID`";

if (!empty($search)) {
    $query .= " WHERE `students`.`first_name` LIKE '%" . $search . "%' 
            OR `students`.`last_name` LIKE '%" . $search . "%' 
            OR `students`.`email` LIKE '%" . $search . "%' 
            OR `event`.`eventName` LIKE '%" . $search . "%'";
}

$query .= " ORDER BY `event_registration`.`event_registrationID` DESC";
$reg_rs = Database::search($query);
?>

<table class="data-table">
    <thead>
        <tr>
            <th>#Reg ID</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Event Name</th>
            <th>Date & Time</th>
            <th>Status</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($reg_rs->num_rows > 0) {
            while ($reg = $reg_rs->fetch_assoc()) {
                $st_id = $reg["event_registrationStatus_event_registrationStatusID"];
        ?>
                <tr>
                    <td><strong>#<?php echo ($reg["event_registrationID"]); ?></strong></td>
                    <td><?php echo htmlspecialchars($reg["first_name"] . " " . $reg["last_name"]); ?></td>
                    <td><?php echo htmlspecialchars($reg["email"]); ?></td>
                    <td><?php echo htmlspecialchars($reg["eventName"]); ?></td>
                    <td><?php echo date("Y-m-d h:i A", strtotime($reg["registration_dateTime"])); ?></td>
                    <td>
                        <?php
                        if ($st_id == "1") {
                            echo ('<span class="badge badge-warning">Pending</span>');
                        } else if ($st_id == "2") {
                            echo ('<span class="badge badge-success">Approved</span>');
                        } else if ($st_id == "3") {
                            echo ('<span class="badge badge-danger">Rejected</span>');
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php if ($st_id != "2") { ?>
                            <button class="btn-action btn-approve" onclick="changeRegStatus(<?php echo ($reg['event_registrationID']); ?>, 2);">Approve</button>
                        <?php } ?>

                        <?php if ($st_id != "3") { ?>
                            <button class="btn-action btn-reject" onclick="changeRegStatus(<?php echo ($reg['event_registrationID']); ?>, 3);">Reject</button>
                        <?php } ?>

                        <button class="btn-action btn-delete" onclick="deleteRegistration(<?php echo ($reg['event_registrationID']); ?>);">Delete</button>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo ("<tr><td colspan='7' class='text-center'>No matching registrations found.</td></tr>");
        }
        ?>
    </tbody>
</table>