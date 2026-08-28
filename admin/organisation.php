<?php
session_start();
require "../includes/connection.php";

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

$admin = $_SESSION["admin"];

// Fetch current organization details
$org_rs = Database::search("SELECT * FROM `organisation_info` WHERE `org_id`='1'");
$org_data = ($org_rs->num_rows > 0) ? $org_rs->fetch_assoc() : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintain Organisation Info | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/adminDashboard.css">
    <link rel="stylesheet" href="../assets/css/adminOrganisation.css">
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
                <h1>Organisation & Clubs Management</h1>
                <p>Maintain CampusHub profile information, contact channels, and registered student communities.</p>
            </header>

            <!-- 1. Organisation Profile Settings Section -->
            <section class="admin-card-section">
                <div class="card-header">
                    <h2>CampusHub Information & Contact Details</h2>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="org_name">Organisation Name</label>
                        <input type="text" id="org_name" value="<?php echo htmlspecialchars($org_data['org_name'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="org_email">Official Email</label>
                        <input type="email" id="org_email" value="<?php echo htmlspecialchars($org_data['email'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="org_phone">Contact Phone</label>
                        <input type="text" id="org_phone" value="<?php echo htmlspecialchars($org_data['phone'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="org_address">Campus Address</label>
                        <input type="text" id="org_address" value="<?php echo htmlspecialchars($org_data['address'] ?? ''); ?>">
                    </div>

                    <div class="form-group form-group-full">
                        <label for="org_about">About Us Description</label>
                        <textarea id="org_about" rows="3"><?php echo htmlspecialchars($org_data['about_text'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-primary" onclick="updateOrgInfo();">Update Organisation Info</button>
                </div>
            </section>

            <!-- 2. Student Club Add / Edit Form -->
            <section class="admin-card-section">
                <div class="card-header">
                    <h2 id="clubFormTitle">Register New Student Club / Community</h2>
                </div>

                <input type="hidden" id="club_id" value="">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="club_name">Club / Community Name</label>
                        <input type="text" id="club_name" placeholder="e.g. Computing Society">
                    </div>

                    <div class="form-group">
                        <label for="club_category">Category</label>
                        <select id="club_category">
                            <option value="Academic">Academic</option>
                            <option value="Technology">Technology & IT</option>
                            <option value="Sports">Sports & Athletics</option>
                            <option value="Cultural">Cultural & Arts</option>
                            <option value="Social Service">Social Service / CSR</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="leader_name">President / Leader Name</label>
                        <input type="text" id="leader_name" placeholder="Enter leader or coordinator name">
                    </div>

                    <div class="form-group form-group-full">
                        <label for="club_description">Club Description</label>
                        <textarea id="club_description" rows="2" placeholder="Brief description of club activities and objectives"></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-primary" id="saveClubBtn" onclick="saveClub();">Save Club</button>
                    <button type="button" class="btn-secondary" id="cancelClubBtn" onclick="resetClubForm();" style="display: none;">Cancel</button>
                </div>
            </section>

            <!-- 3. Search Bar -->
            <section class="search-bar-wrapper">
                <input type="text" id="searchClubInput" placeholder="Search clubs by name, category, or leader..." onkeyup="searchClubs();">
            </section>

            <!-- 4. Registered Clubs Table -->
            <section class="table-card">
                <div class="table-responsive" id="clubTableContainer">
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
                            $clubs_rs = Database::search("SELECT * FROM `clubs` ORDER BY `clubID` DESC");

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
                                echo ("<tr><td colspan='6' class='text-center'>No student clubs registered yet.</td></tr>");
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