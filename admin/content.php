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
    <title>Website Content | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/adminDashboard.css">
    <link rel="stylesheet" href="../assets/css/adminContent.css">
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
                <h1>Website Content & Announcements</h1>
                <p>Publish, update, and manage official announcements on the CampusHub website.</p>
            </header>

            <!-- 1. Add / Update Announcement Form Card -->
            <section class="admin-card-section">
                <div class="card-header">
                    <h2 id="contentFormTitle">Publish New Announcement</h2>
                </div>

                <input type="hidden" id="announcement_id" value="">

                <div class="form-grid">
                    <div class="form-group form-group-full">
                        <label for="announcement_title">Announcement Title</label>
                        <input type="text" id="announcement_title" placeholder="Enter announcement title (max 45 characters)">
                    </div>

                    <div class="form-group form-group-full">
                        <label for="announcement_content">Content / Message</label>
                        <textarea id="announcement_content" rows="3" placeholder="Enter announcement message (max 45 characters)"></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-primary" id="saveContentBtn" onclick="saveAnnouncement();">Publish Announcement</button>
                    <button type="button" class="btn-secondary" id="cancelContentBtn" onclick="resetContentForm();" style="display: none;">Cancel</button>
                </div>
            </section>

            <!-- 2. Search Bar -->
            <section class="search-bar-wrapper">
                <input type="text" id="searchContentInput" placeholder="Search announcements by title or content..." onkeyup="searchAnnouncements();">
            </section>

            <!-- 3. Announcements Records Table Card -->
            <section class="table-card">
                <div class="table-responsive" id="contentTableContainer">
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
                            $ann_rs = Database::search("SELECT * FROM `announcements` ORDER BY `announcementID` DESC");

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
                                echo ("<tr><td colspan='5' class='text-center'>No announcements published yet.</td></tr>");
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