<?php
session_start();
require "../includes/connection.php";

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

$admin = $_SESSION["admin"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Management | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/adminDashboard.css">
    <link rel="stylesheet" href="../assets/css/adminRegistrations.css">
    <!-- Font Awesome & SweetAlert CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <!-- Dedicated Admin Top Navigation -->
    <header class="admin-top-nav">
        <div class="admin-nav-container">
            <a href="dashboard.php" class="admin-brand">Campus<span>Hub</span> <small>Control Panel</small></a>
            
            <div class="admin-user-menu">
                <span class="admin-user-tag"><i class="fa-solid fa-user-shield"></i> <?php echo htmlspecialchars($admin["username"] ?? "Admin"); ?></span>
                <button type="button" class="btn-admin-logout" onclick="adminSignOut();">Logout</button>
            </div>
        </div>
    </header>

    <main class="page-main">
        <div class="admin-container">

            <!-- Page Header -->
            <header class="page-intro">
                <h1>Registration Management</h1>
                <p>Manage, verify, approve, or reject student registrations for CampusHub events.</p>
            </header>

            <!-- Search & Filter Bar -->
            <section class="search-bar-wrapper">
                <input type="text" id="searchRegInput" placeholder="Search by student name, email, or event name..." onkeyup="searchRegistrations();">
            </section>

            <!-- Registrations Data Table Card -->
            <section class="table-card">
                <div class="table-responsive" id="registrationTableContainer">
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
                            $query = "SELECT `event_registration`.*, 
                                            `students`.`first_name`, `students`.`last_name`, `students`.`email`,
                                            `event`.`eventName`,
                                            `event_registrationstatus`.`event_registrationStatusName` AS `statusName`
                                    FROM `event_registration`
                                    INNER JOIN `students` ON `event_registration`.`students_studentID` = `students`.`studentID`
                                    INNER JOIN `event` ON `event_registration`.`event_eventID` = `event`.`eventID`
                                    INNER JOIN `event_registrationstatus` ON `event_registration`.`event_registrationStatus_event_registrationStatusID` = `event_registrationstatus`.`event_registrationStatusID`
                                    ORDER BY `event_registration`.`event_registrationID` DESC";

                            $reg_rs = Database::search($query);

                            if ($reg_rs->num_rows > 0) {
                                while ($reg = $reg_rs->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><strong>#<?php echo ($reg["event_registrationID"]); ?></strong></td>
                                        <td><?php echo htmlspecialchars($reg["first_name"] . " " . $reg["last_name"]); ?></td>
                                        <td><?php echo htmlspecialchars($reg["email"]); ?></td>
                                        <td><?php echo htmlspecialchars($reg["eventName"]); ?></td>
                                        <td><?php echo date("Y-m-d h:i A", strtotime($reg["registration_dateTime"])); ?></td>
                                        <td>
                                            <?php
                                            $st_id = $reg["event_registrationStatus_event_registrationStatusID"];
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
                                echo ("<tr><td colspan='7' class='text-center'>No event registrations found.</td></tr>");
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

    <!-- Admin Footer -->
    <footer class="admin-footer">
        <p>&copy; <?php echo date("Y"); ?> CampusHub | Administration Management Console</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>

</html>