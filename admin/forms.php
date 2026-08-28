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
    <title>Manage Online Forms | CampusHub Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/adminDashboard.css">
    <link rel="stylesheet" href="../assets/css/adminForms.css">
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
            <header class="page-intro">
                <h1>Student Online Forms & Inquiries</h1>
                <p>Review student proposals, assistance requests, and update resolution status.</p>
            </header>

            <div class="table-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Student</th>
                            <th>Category</th>
                            <th>Subject & Message</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $forms_rs = Database::search("SELECT `student_forms`.*, `students`.`first_name`, `students`.`last_name`, `students`.`email` 
                                                      FROM `student_forms` 
                                                      INNER JOIN `students` ON `student_forms`.`students_studentID` = `students`.`studentID` 
                                                      ORDER BY `student_forms`.`formID` DESC");

                        if ($forms_rs->num_rows > 0) {
                            while ($row = $forms_rs->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><strong>#<?php echo $row["formID"]; ?></strong></td>
                                    <td>
                                        <?php echo htmlspecialchars($row["first_name"] . " " . $row["last_name"]); ?><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($row["email"]); ?></small>
                                    </td>
                                    <td><span class="badge"><?php echo htmlspecialchars($row["form_type"]); ?></span></td>
                                    <td>
                                        <div class="form-subject"><?php echo htmlspecialchars($row["subject"]); ?></div>
                                        <div class="form-msg"><?php echo htmlspecialchars($row["message"]); ?></div>
                                    </td>
                                    <td><?php echo date("M d, Y", strtotime($row["submitted_at"])); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo strtolower($row["status"]); ?>">
                                            <?php echo htmlspecialchars($row["status"]); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row["status"] == "Pending") { ?>
                                            <button class="btn-action btn-edit" onclick="updateFormStatus(<?php echo $row['formID']; ?>, 'Resolved');">Approve</button>
                                            <button class="btn-action btn-delete" onclick="updateFormStatus(<?php echo $row['formID']; ?>, 'Rejected');">Reject</button>
                                        <?php } else { ?>
                                            <span class="text-muted">Completed</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo ("<tr><td colspan='7' class='text-center text-muted' style='padding: 25px;'>No student forms submitted yet.</td></tr>");
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Admin Footer -->
    <footer class="admin-footer">
        <p>&copy; <?php echo date("Y"); ?> CampusHub | Administration Management Console</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>
</html>