<?php
include "../includes/connection.php";

$search = $_POST["search"] ?? "";

$query = "SELECT `students`.*, `gender`.`genderName` FROM `students` 
        INNER JOIN `gender` ON `students`.`gender_genderID` = `gender`.`genderID`";

if (!empty($search)) {
    $query .= " WHERE `students`.`first_name` LIKE '%" . $search . "%' 
            OR `students`.`last_name` LIKE '%" . $search . "%' 
            OR `students`.`email` LIKE '%" . $search . "%'";
}

$query .= " ORDER BY `students`.`studentID` DESC";
$students_rs = Database::search($query);
?>

<table class="data-table">
    <thead>
        <tr>
            <th>#ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Status</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($students_rs->num_rows > 0) {
            while ($student = $students_rs->fetch_assoc()) {
        ?>
                <tr>
                    <td><strong>#<?php echo ($student["studentID"]); ?></strong></td>
                    <td><?php echo htmlspecialchars($student["first_name"]); ?></td>
                    <td><?php echo htmlspecialchars($student["last_name"]); ?></td>
                    <td><?php echo htmlspecialchars($student["email"]); ?></td>
                    <td><?php echo htmlspecialchars($student["genderName"]); ?></td>
                    <td>
                        <?php if ($student["Student_status_statusID"] == "1") { ?>
                            <span class="badge badge-success">Active</span>
                        <?php } else { ?>
                            <span class="badge badge-danger">Inactive</span>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <button class="btn-action btn-edit" onclick='editStudent(<?php echo json_encode($student); ?>);'>Edit</button>
                        <button class="btn-action btn-delete" onclick="deleteStudent(<?php echo ($student['studentID']); ?>);">Delete</button>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo ("<tr><td colspan='7' class='text-center'>No matching student records found.</td></tr>");
        }
        ?>
    </tbody>
</table>