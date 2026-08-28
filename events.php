<?php
session_start();
require "includes/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events & Activities | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/events.css">
    <!-- SweetAlert CDN -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main class="events-page-main">
        <div class="container">

            <!-- Page Header -->
            <header class="page-intro">
                <h1>Events & Activities</h1>
                <p>View upcoming campus events and activities and register online.</p>
            </header>

            <!-- Upcoming Events Section -->
            <section class="events-block">
                <h2 class="section-title">Upcoming Events</h2>

                <div class="events-grid">
                    <?php
                    $events_rs = Database::search("SELECT * FROM `event` ORDER BY `eventID` DESC");

                    if ($events_rs->num_rows > 0) {
                        while ($ev = $events_rs->fetch_assoc()) {
                    ?>
                            <article class="event-card">
                                <h3><?php echo htmlspecialchars($ev["eventName"]); ?></h3>
                                <p class="event-desc">
                                    <?php echo htmlspecialchars($ev["eventDescription"]); ?>
                                </p>
                                <div class="event-details">
                                    <p><strong>Date:</strong> <?php echo date("d F Y", strtotime($ev["eventDateTime"])); ?></p>
                                    <p><strong>Time:</strong> <?php echo date("h:i A", strtotime($ev["eventDateTime"])); ?></p>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($ev["eventLocation"]); ?></p>
                                </div>
                                <button type="button" class="btn-register" onclick="registerForEvent(<?php echo ($ev['eventID']); ?>);">Register Now</button>
                            </article>
                    <?php
                        }
                    } else {
                        echo ("<p class='no-data-msg'>No upcoming events available at the moment.</p>");
                    }
                    ?>
                </div>
            </section>

            <!-- Campus Activities Section -->
            <section id="activities" class="activities-block">
                <h2 class="section-title">Campus Activities</h2>
                <p class="section-subtitle">
                    Explore different activities available for CampusHub members.
                </p>

                <div class="activities-grid">
                    <?php
                    $act_rs = Database::search("SELECT * FROM `activities` ORDER BY `activityID` DESC");

                    if ($act_rs->num_rows > 0) {
                        while ($act = $act_rs->fetch_assoc()) {
                    ?>
                            <article class="activity-card">
                                <h3><?php echo htmlspecialchars($act["activity_title"]); ?></h3>
                                <p><?php echo htmlspecialchars($act["activity_description"] ?? 'Explore student club workshops, challenges and campus activities.'); ?></p>
                            </article>
                    <?php
                        }
                    } else {
                    ?>
                        <article class="activity-card">
                            <h3>Sports</h3>
                            <p>Football, cricket and other sports activities.</p>
                        </article>
                        <article class="activity-card">
                            <h3>Workshops</h3>
                            <p>Educational and skill development workshops.</p>
                        </article>
                        <article class="activity-card">
                            <h3>Competitions</h3>
                            <p>Participate in academic and creative competitions.</p>
                        </article>
                        <article class="activity-card">
                            <h3>Student Clubs</h3>
                            <p>Join student clubs and communities.</p>
                        </article>
                    <?php
                    }
                    ?>
                </div>
            </section>

        </div>

        <!-- Student's Own Registrations Status Section -->
            <?php 
            $student_session = $_SESSION["student"] ?? $_SESSION["students"] ?? null;
            if ($student_session) { 
                $std_id = $student_session["studentID"];
            ?>
                <section class="my-registrations-block">
                    <h2 class="section-title">My Registered Events</h2>
                    <p class="section-subtitle">Track your registration status and admin approvals in real-time.</p>

                    <div class="my-reg-table-container">
                        <table class="my-reg-table">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Date & Time</th>
                                    <th>Location</th>
                                    <th>Registered On</th>
                                    <th>Approval Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT `event_registration`.*, 
                                            `event`.`eventName`, `event`.`eventDateTime`, `event`.`eventLocation`, 
                                            `event_registrationstatus`.`event_registrationStatusName` AS `statusName`
                                        FROM `event_registration`
                                        INNER JOIN `event` ON `event_registration`.`event_eventID` = `event`.`eventID`
                                        INNER JOIN `event_registrationstatus` ON `event_registration`.`event_registrationStatus_event_registrationStatusID` = `event_registrationstatus`.`event_registrationStatusID`
                                        WHERE `event_registration`.`students_studentID` = '" . $std_id . "'
                                        ORDER BY `event_registration`.`event_registrationID` DESC";

                                $my_reg_rs = Database::search($query);

                                if ($my_reg_rs->num_rows > 0) {
                                    while ($my_reg = $my_reg_rs->fetch_assoc()) {
                                        $st_id = $my_reg["event_registrationStatus_event_registrationStatusID"];
                                ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($my_reg["eventName"]); ?></strong></td>
                                            <td><?php echo date("M d, Y | h:i A", strtotime($my_reg["eventDateTime"])); ?></td>
                                            <td><?php echo htmlspecialchars($my_reg["eventLocation"]); ?></td>
                                            <td><?php echo date("Y-m-d h:i A", strtotime($my_reg["registration_dateTime"])); ?></td>
                                            <td>
                                                <?php
                                                if ($st_id == "1") {
                                                    echo ('<span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> Pending</span>');
                                                } else if ($st_id == "2") {
                                                    echo ('<span class="status-badge status-approved"><i class="fa-solid fa-circle-check"></i> Approved</span>');
                                                } else if ($st_id == "3") {
                                                    echo ('<span class="status-badge status-rejected"><i class="fa-solid fa-circle-xmark"></i> Rejected</span>');
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo ("<tr><td colspan='5' class='text-center-cell'>You have not registered for any events yet.</td></tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            <?php } ?>

    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
</body>
</html>