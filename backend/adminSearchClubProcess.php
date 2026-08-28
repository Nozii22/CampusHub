<?php
include "../includes/connection.php";

$search = $_POST["search"] ?? "";

$query = "SELECT * FROM `clubs`";
if (!empty($search)) {
    $query .= " WHERE `club_name` LIKE '%" . $search . "%' 
            OR `category` LIKE '%" . $search . "%' 
            OR `leader_name` LIKE '%" . $search . "%'";
}
$query .= " ORDER BY `clubID` DESC";
$clubs_rs = Database::search($query);
?>

<table class="data-table">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Club Name</th>
            <th>Category</th>
            <th>Leader / PIC</th>
            <th>Description</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($clubs_rs->num_rows > 0) {
            while ($c = $clubs_rs->fetch_assoc()) {
        ?>
                <tr>
                    <td><strong>#<?php echo ($c["clubID"]); ?></strong></td>
                    <td><?php echo htmlspecialchars($c["club_name"]); ?></td>
                    <td><span class="badge badge-category"><?php echo htmlspecialchars($c["category"]); ?></span></td>
                    <td><?php echo htmlspecialchars($c["leader_name"]); ?></td>
                    <td><?php echo htmlspecialchars($c["description"]); ?></td>
                    <td class="text-center">
                        <button class="btn-action btn-edit" onclick='editClub(<?php echo json_encode($c); ?>);'>Edit</button>
                        <button class="btn-action btn-delete" onclick="deleteClub(<?php echo ($c['clubID']); ?>);">Delete</button>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo ("<tr><td colspan='6' class='text-center'>No matching clubs found.</td></tr>");
        }
        ?>
    </tbody>
</table>