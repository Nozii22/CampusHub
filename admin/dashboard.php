<?php
session_start();
require "../includes/connection.php";

// Admin Authentication Guard
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
    <title>Admin Dashboard | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/adminDashboard.css">
    <!-- Font Awesome & SweetAlert -->
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
                <h1>Admin Dashboard</h1>
                <p>Welcome back! Select a module below to manage campus records and operations.</p>
            </header>

            <!-- Management Cards Grid -->
            <div class="admin-grid">

                <!-- Students -->
                <article class="admin-card">
                    <div class="card-icon"><i class="fa-solid fa-user-graduate"></i></div>
                    <h2>Student Management</h2>
                    <p>Manage student accounts, active statuses, and records.</p>
                    <a href="students.php" class="btn-card">Manage Students</a>
                </article>

                <!-- Events & Activities -->
                <article class="admin-card">
                    <div class="card-icon"><i class="fa-solid fa-calendar-days"></i></div>
                    <h2>Events & Activities</h2>
                    <p>Create and organize campus events, workshops, and sports.</p>
                    <a href="events.php" class="btn-card">Manage Events</a>
                </article>

                <!-- Registrations -->
                <article class="admin-card">
                    <div class="card-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                    <h2>Registration Approvals</h2>
                    <p>Review and approve student event registration requests.</p>
                    <a href="registrations.php" class="btn-card">Manage Registrations</a>
                </article>

                <!-- Online Forms -->
                <article class="admin-card">
                    <div class="card-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                    <h2>Student Online Forms</h2>
                    <p>Review proposals, student inquiries, and feedback.</p>
                    <a href="forms.php" class="btn-card">Manage Forms</a>
                </article>

                <!-- Media -->
                <article class="admin-card">
                    <div class="card-icon"><i class="fa-solid fa-photo-film"></i></div>
                    <h2>Media Gallery</h2>
                    <p>Upload and manage campus highlight photos and videos.</p>
                    <a href="media.php" class="btn-card">Manage Media</a>
                </article>

                <!-- Website Content -->
                <article class="admin-card">
                    <div class="card-icon"><i class="fa-solid fa-bullhorn"></i></div>
                    <h2>Announcements & Content</h2>
                    <p>Publish campus notices, clubs list, and website updates.</p>
                    <a href="content.php" class="btn-card">Manage Content</a>
                </article>

                <!-- Organisation Info -->
                <article class="admin-card">
                    <div class="card-icon"><i class="fa-solid fa-building-columns"></i></div>
                    <h2>Organisation Info</h2>
                    <p>Maintain CampusHub profile, contact numbers, and about info.</p>
                    <a href="organisation.php" class="btn-card">Manage Organisation</a>
                </article>

            </div>

        </div>
    </main>

    <footer class="admin-footer">
        <p>&copy; <?php echo date("Y"); ?> CampusHub | Administration Management Console</p>
    </footer>

    <script src="../assets/js/script.js"></script>
</body>
</html>