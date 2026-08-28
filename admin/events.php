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
    <title>Event & Activity Management | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/adminDashboard.css">
    <link rel="stylesheet" href="../assets/css/adminEvents.css">
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

            <!-- Page Intro -->
            <header class="page-intro">
                <h1>Event & Activity Management</h1>
                <p>Manage campus events and student activities in the CampusHub system.</p>
            </header>

            <!-- Navigation Tabs -->
            <div class="management-tabs">
                <button type="button" class="tab-btn active" id="eventTabBtn" onclick="switchSection('events');">Events Management</button>
                <button type="button" class="tab-btn" id="activityTabBtn" onclick="switchSection('activities');">Activities Management</button>
            </div>

            <!-- ================= SECTION 1: EVENTS MANAGEMENT ================= -->
            <div id="eventsSection">

                <!-- 1. Add / Update Event Form -->
                <section class="admin-card-section">
                    <div class="card-header">
                        <h2 id="eventFormTitle">Add New Event</h2>
                    </div>

                    <input type="hidden" id="event_id" value="">

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="eventName">Event Name</label>
                            <input type="text" id="eventName" placeholder="Enter event name">
                        </div>

                        <div class="form-group">
                            <label for="eventLocation">Event Location</label>
                            <input type="text" id="eventLocation" placeholder="Enter location or venue">
                        </div>

                        <div class="form-group">
                            <label for="eventDateTime">Date & Time</label>
                            <input type="datetime-local" id="eventDateTime">
                        </div>

                        <div class="form-group form-group-full">
                            <label for="eventDescription">Description</label>
                            <textarea id="eventDescription" rows="3" placeholder="Enter event description (max 100 characters)"></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-primary" id="saveEventBtn" onclick="saveEvent();">Save Event</button>
                        <button type="button" class="btn-secondary" id="cancelEventBtn" onclick="resetEventForm();" style="display: none;">Cancel</button>
                    </div>
                </section>

                <!-- Search Bar -->
                <section class="search-bar-wrapper">
                    <input type="text" id="searchEventInput" placeholder="Search events by name or location..." onkeyup="searchEvents();">
                </section>

                <!-- Events Table -->
                <section class="table-card">
                    <div class="table-responsive" id="eventTableContainer">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Event Name</th>
                                    <th>Location</th>
                                    <th>Date & Time</th>
                                    <th>Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $event_rs = Database::search("SELECT * FROM `event` ORDER BY `eventID` DESC");
                                if ($event_rs->num_rows > 0) {
                                    while ($ev = $event_rs->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><strong>#<?php echo ($ev["eventID"]); ?></strong></td>
                                            <td><?php echo htmlspecialchars($ev["eventName"]); ?></td>
                                            <td><?php echo htmlspecialchars($ev["eventLocation"]); ?></td>
                                            <td><?php echo date("Y-m-d h:i A", strtotime($ev["eventDateTime"])); ?></td>
                                            <td><?php echo htmlspecialchars($ev["eventDescription"]); ?></td>
                                            <td class="text-center">
                                                <button class="btn-action btn-edit" onclick='editEvent(<?php echo json_encode($ev); ?>);'>Edit</button>
                                                <button class="btn-action btn-delete" onclick="deleteEvent(<?php echo ($ev['eventID']); ?>);">Delete</button>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo ("<tr><td colspan='6' class='text-center'>No events found.</td></tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>

            <!-- ================= SECTION 2: ACTIVITIES MANAGEMENT ================= -->
            <div id="activitiesSection" style="display: none;">

                <!-- 1. Add / Update Activity Form -->
                <section class="admin-card-section">
                    <div class="card-header">
                        <h2 id="activityFormTitle">Add New Activity</h2>
                    </div>

                    <input type="hidden" id="activity_id" value="">

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="activity_title">Activity Title</label>
                            <input type="text" id="activity_title" placeholder="Enter activity title">
                        </div>

                        <div class="form-group">
                            <label for="activity_location">Location</label>
                            <input type="text" id="activity_location" placeholder="Enter activity location">
                        </div>

                        <div class="form-group">
                            <label for="activity_date_time">Date & Time</label>
                            <input type="datetime-local" id="activity_date_time">
                        </div>

                        <div class="form-group form-group-full">
                            <label for="activity_description">Description</label>
                            <textarea id="activity_description" rows="3" placeholder="Enter detailed activity description"></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-primary" id="saveActivityBtn" onclick="saveActivity();">Save Activity</button>
                        <button type="button" class="btn-secondary" id="cancelActivityBtn" onclick="resetActivityForm();" style="display: none;">Cancel</button>
                    </div>
                </section>

                <!-- Search Bar -->
                <section class="search-bar-wrapper">
                    <input type="text" id="searchActivityInput" placeholder="Search activities by title or location..." onkeyup="searchActivities();">
                </section>

                <!-- Activities Table -->
                <section class="table-card">
                    <div class="table-responsive" id="activityTableContainer">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Activity Title</th>
                                    <th>Location</th>
                                    <th>Date & Time</th>
                                    <th>Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $act_rs = Database::search("SELECT * FROM `activities` ORDER BY `activityID` DESC");
                                if ($act_rs->num_rows > 0) {
                                    while ($ac = $act_rs->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><strong>#<?php echo ($ac["activityID"]); ?></strong></td>
                                            <td><?php echo htmlspecialchars($ac["activity_title"]); ?></td>
                                            <td><?php echo htmlspecialchars($ac["activity_location"]); ?></td>
                                            <td><?php echo date("Y-m-d h:i A", strtotime($ac["activity_date_time"])); ?></td>
                                            <td><?php echo htmlspecialchars($ac["activity_description"]); ?></td>
                                            <td class="text-center">
                                                <button class="btn-action btn-edit" onclick='editActivity(<?php echo json_encode($ac); ?>);'>Edit</button>
                                                <button class="btn-action btn-delete" onclick="deleteActivity(<?php echo ($ac['activityID']); ?>);">Delete</button>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo ("<tr><td colspan='6' class='text-center'>No activities found.</td></tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

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