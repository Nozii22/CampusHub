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
    <title>Media Management | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/adminDashboard.css">
    <link rel="stylesheet" href="../assets/css/adminMedia.css">
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
                <h1>Media Management</h1>
                <p>Upload, organize, preview, and manage event photos and videos in the CampusHub system.</p>
            </header>

            <!-- 1. Upload Media Form Card -->
            <section class="admin-card-section">
                <div class="card-header">
                    <h2>Upload New Media File</h2>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="media_title">Media Title</label>
                        <input type="text" id="media_title" placeholder="e.g. Hackathon 2026 Opening">
                    </div>

                    <div class="form-group">
                        <label for="media_type">Media Type</label>
                        <select id="media_type" onchange="updateFileAccept();">
                            <option value="image">Photo (Image)</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="event_id">Related Event (Optional)</label>
                        <select id="event_id">
                            <option value="">None / General Media</option>
                            <?php
                            $event_rs = Database::search("SELECT `eventID`, `eventName` FROM `event` ORDER BY `eventID` DESC");
                            while ($ev = $event_rs->fetch_assoc()) {
                            ?>
                                <option value="<?php echo ($ev["eventID"]); ?>"><?php echo htmlspecialchars($ev["eventName"]); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="media_file">Select File</label>
                        <input type="file" id="media_file" accept="image/*">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-primary" onclick="uploadMedia();">Upload Media</button>
                </div>
            </section>

            <!-- 2. Search & Filter Bar -->
            <section class="search-bar-wrapper">
                <input type="text" id="searchMediaInput" placeholder="Search media by title or related event..." onkeyup="searchMedia();">
            </section>

            <!-- 3. Media Records Table Card -->
            <section class="table-card">
                <div class="table-responsive" id="mediaTableContainer">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Preview</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Related Event</th>
                                <th>Uploaded At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT `media_uploads`.*, `event`.`eventName` 
                                      FROM `media_uploads` 
                                      LEFT JOIN `event` ON `media_uploads`.`event_eventID` = `event`.`eventID` 
                                      ORDER BY `media_uploads`.`mediaID` DESC";
                            $media_rs = Database::search($query);

                            if ($media_rs->num_rows > 0) {
                                while ($m = $media_rs->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><strong>#<?php echo ($m["mediaID"]); ?></strong></td>
                                        <td>
                                            <?php if ($m["media_type"] == "image") { ?>
                                                <img src="../<?php echo ($m['file_path']); ?>" class="media-thumb" alt="thumb">
                                            <?php } else { ?>
                                                <video class="media-thumb" src="../<?php echo ($m['file_path']); ?>"></video>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($m["media_title"]); ?></td>
                                        <td>
                                            <span class="badge <?php echo ($m['media_type'] == 'image' ? 'badge-blue' : 'badge-purple'); ?>">
                                                <?php echo ucfirst($m["media_type"]); ?>
                                            </span>
                                        </td>
                                        <td><?php echo ($m["eventName"] ? htmlspecialchars($m["eventName"]) : "<span class='text-muted'>General</span>"); ?></td>
                                        <td><?php echo date("Y-m-d h:i A", strtotime($m["uploaded_at"])); ?></td>
                                        <td class="text-center">
                                            <button class="btn-action btn-delete" onclick="deleteMedia(<?php echo ($m['mediaID']); ?>);">Delete</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo ("<tr><td colspan='7' class='text-center'>No media uploads found.</td></tr>");
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