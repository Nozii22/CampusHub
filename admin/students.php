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
    <title>Student Management | CampusHub Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/adminDashboard.css">
    <link rel="stylesheet" href="../assets/css/adminForms.css">
    <link rel="stylesheet" href="../assets/css/adminStudentsManage.css">
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
                <h1>Student Management</h1>
                <p>Register, search, update, and manage student records in the CampusHub system.</p>
            </header>

            <!-- 1. Add / Update Student Form -->
            <section class="table-card" style="margin-bottom: 25px; padding: 20px;">
                <div class="card-header">
                    <h2 id="formTitle" style="font-size: 16px; margin-bottom: 15px;">Add New Student</h2>
                </div>
                
                <input type="hidden" id="student_id" value="">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" placeholder="Enter first name">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" placeholder="Enter last name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" placeholder="Enter email address">
                    </div>

                    <div class="form-group" id="passwordGroup">
                        <label for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter temporary password">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="">Select Gender</option>
                            <?php
                            $gender_rs = Database::search("SELECT * FROM `gender`");
                            while ($gender_data = $gender_rs->fetch_assoc()) {
                            ?>
                                <option value="<?php echo ($gender_data["genderID"]); ?>"><?php echo ($gender_data["genderName"]); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Account Status</label>
                        <select id="status">
                            <option value="1">Active</option>
                            <option value="2">Inactive / Blocked</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions" style="margin-top: 15px;">
                    <button type="button" class="btn-action btn-edit" id="saveBtn" onclick="saveStudent();" style="padding: 8px 16px;">Save Student</button>
                    <button type="button" class="btn-action btn-delete" id="cancelBtn" onclick="resetForm();" style="display: none; padding: 8px 16px;">Cancel</button>
                </div>
            </section>

            <!-- 2. Search Bar -->
            <section class="search-bar-wrapper" style="margin-bottom: 15px;">
                <input type="text" id="searchInput" placeholder="Search by student name or email..." onkeyup="searchStudents();" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </section>

            <!-- 3. Students Table -->
            <section class="table-card">
                <div class="table-responsive" id="studentTableBody">
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
                            $students_rs = Database::search("SELECT `students`.*, `gender`.`genderName` FROM `students` 
                                                            INNER JOIN `gender` ON `students`.`gender_genderID` = `gender`.`genderID` 
                                                            ORDER BY `students`.`studentID` DESC");

                            if ($students_rs->num_rows > 0) {
                                while ($student = $students_rs->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><strong>#<?php echo ($student["studentID"]); ?></strong></td>
                                        <td><?php echo htmlspecialchars($student["first_name"]); ?></td>
                                        <td><?php echo htmlspecialchars($student["last_name"]); ?></td>
                                        <td><small class="text-muted"><?php echo htmlspecialchars($student["email"]); ?></small></td>
                                        <td><?php echo htmlspecialchars($student["genderName"]); ?></td>
                                        <td>
                                            <?php if ($student["Student_status_statusID"] == "1") { ?>
                                                <span class="badge badge-resolved">Active</span>
                                            <?php } else { ?>
                                                <span class="badge badge-rejected">Inactive</span>
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
                                echo ("<tr><td colspan='7' class='text-center text-muted' style='padding: 25px;'>No student records found.</td></tr>");
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