<?php
session_start();

if (!isset($_SESSION["student"])) {
    header("Location: index.php");
    exit();
}?>


<?php
require "includes/connection.php";

// 1. Fetch Organisation Info
$org_rs = Database::search("SELECT * FROM `organisation_info` LIMIT 1");
$org = ($org_rs->num_rows > 0) ? $org_rs->fetch_assoc() : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/media.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main class="home-main">

        <!-- Hero / Welcome Section -->
        <section id="home" class="hero-section">
            <div class="container">
                <h1>Welcome to <?php echo htmlspecialchars($org['org_name'] ?? 'CampusHub'); ?></h1>
                <p class="hero-tagline">Your campus, your community, your experience.</p>
                <p class="hero-desc">
                    <?php echo htmlspecialchars($org['about_text'] ?? 'Discover campus events, activities, student communities and important announcements in one place.'); ?>
                </p>
            </div>
        </section>

        <!-- Events Section -->
        <section id="events" class="content-section">
            <div class="container">
                <div class="section-header-row">
                    <div>
                        <h2 class="section-title">Upcoming Events</h2>
                        <p class="section-desc">Join exciting workshops, tech challenges, and campus gatherings.</p>
                    </div>
                    <a href="events.php" class="see-all-link">See All Events &rarr;</a>
                </div>

                <div class="cards-grid">
                    <?php
                    $events_rs = Database::search("SELECT * FROM `event` ORDER BY `eventID` DESC LIMIT 3");
                    if ($events_rs->num_rows > 0) {
                        while ($event = $events_rs->fetch_assoc()) {
                    ?>
                            <article class="event-card">
                                <h3><?php echo htmlspecialchars($event["eventName"]); ?></h3>
                                <p class="card-desc"><?php echo htmlspecialchars($event["eventDescription"]); ?></p>
                                <p class="card-meta">Location: <?php echo htmlspecialchars($event["eventLocation"]); ?> | Date: <?php echo date("d M | h:i A", strtotime($event["eventDateTime"])); ?></p>
                                <a href="events.php" class="btn-card">Register Now</a>
                            </article>
                    <?php
                        }
                    } else {
                        echo ("<p class='card-desc'>No upcoming events available right now.</p>");
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Activities Section -->
        <section id="activities" class="content-section bg-light">
            <div class="container">
                <div class="section-header-row">
                    <div>
                        <h2 class="section-title">Campus Activities</h2>
                        <p class="section-desc">Explore activities and sports programs available for students.</p>
                    </div>
                    <a href="events.php#activities" class="see-all-link">See All Activities &rarr;</a>
                </div>

                <ul class="tag-list">
                    <?php
                    $act_rs = Database::search("SELECT `activity_title` FROM `activities` ORDER BY `activityID` DESC LIMIT 6");
                    if ($act_rs->num_rows > 0) {
                        while ($act = $act_rs->fetch_assoc()) {
                    ?>
                            <li><?php echo htmlspecialchars($act["activity_title"]); ?></li>
                    <?php
                        }
                    } else {
                    ?>
                        <li>Sports & Athletics</li>
                        <li>Arts & Drama</li>
                        <li>Tech Workshops</li>
                        <li>Competitions</li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </section>

        <!-- Announcements Section -->
        <section id="announcements" class="content-section">
            <div class="container">
                <div class="section-header-row">
                    <div>
                        <h2 class="section-title">Announcements</h2>
                        <p class="section-desc">Stay informed with official notices and important deadline updates.</p>
                    </div>
                    <a href="announcements.php" class="see-all-link">See All Notices &rarr;</a>
                </div>

                <div class="announcement-list">
                    <?php
                    $ann_rs = Database::search("SELECT * FROM `announcements` ORDER BY `announcementID` DESC LIMIT 3");
                    if ($ann_rs->num_rows > 0) {
                        while ($ann = $ann_rs->fetch_assoc()) {
                    ?>
                            <article class="announcement-item">
                                <h3><?php echo htmlspecialchars($ann["title"]); ?></h3>
                                <p><?php echo htmlspecialchars($ann["content"]); ?></p>
                            </article>
                    <?php
                        }
                    } else {
                        echo ("<p class='card-desc'>No announcements published at the moment.</p>");
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Communities Section -->
        <section id="communities" class="content-section bg-light">
            <div class="container">
                <div class="section-header-row">
                    <div>
                        <h2 class="section-title">Student Communities</h2>
                        <p class="section-desc">Connect with clubs and student bodies that share your passion.</p>
                    </div>
                    <!-- <a href="communities.php" class="see-all-link">See All Clubs &rarr;</a> -->
                </div>

                <ul class="tag-list">
                    <?php
                    $clubs_rs = Database::search("SELECT `club_name` FROM `clubs` ORDER BY `clubID` DESC LIMIT 6");
                    if ($clubs_rs->num_rows > 0) {
                        while ($club = $clubs_rs->fetch_assoc()) {
                    ?>
                            <li><?php echo htmlspecialchars($club["club_name"]); ?></li>
                    <?php
                        }
                    } else {
                    ?>
                        <li>Computing & Tech Society</li>
                        <li>Rotaract Club</li>
                        <li>Sports Council</li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="content-section">
            <div class="container">
                <div class="section-header-row">
                    <div>
                        <h2 class="section-title">Media & Gallery</h2>
                        <p class="section-desc">Explore highlights from recent campus events and activities.</p>
                    </div>
                    <!-- <a href="gallery.php" class="see-all-link">See Full Gallery &rarr;</a> -->
                </div>
                
                <div class="media-grid">
                    <?php
                    $media_rs = Database::search("SELECT * FROM `media_uploads` ORDER BY `mediaID` DESC LIMIT 4");
                    if ($media_rs->num_rows > 0) {
                        while ($m = $media_rs->fetch_assoc()) {
                    ?>
                            <div class="media-item-card">
                                <div class="media-display-frame">
                                    <?php if ($m["media_type"] == "image") { ?>
                                        <img src="<?php echo htmlspecialchars($m['file_path']); ?>" alt="<?php echo htmlspecialchars($m['media_title']); ?>" class="card-media-element">
                                    <?php } else { ?>
                                        <video src="<?php echo htmlspecialchars($m['file_path']); ?>" class="card-media-element" controls preload="metadata"></video>
                                    <?php } ?>
                                    <span class="media-type-tag"><?php echo ucfirst($m["media_type"]); ?></span>
                                </div>
                                <div class="media-card-body">
                                    <h3 class="media-card-title" title="<?php echo htmlspecialchars($m['media_title']); ?>">
                                        <?php echo htmlspecialchars($m["media_title"]); ?>
                                    </h3>
                                    <span class="media-card-date"><?php echo date("M d, Y", strtotime($m["uploaded_at"])); ?></span>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo ("<p class='card-desc'>No media uploaded yet.</p>");
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Call to Action (Join Section) -->
        <section id="join" class="cta-section">
            <div class="container">
                <h2>Join CampusHub</h2>
                <p>Create your account and become part of the CampusHub student community.</p>
                <div class="cta-buttons">
                    <!-- <a href="signup.php" class="btn-primary">Create Account</a> -->
                    <a href="signin.php" class="btn-primary">Sign In</a>
                </div>
            </div>
        </section>

    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- SweetAlert CDN for confirmation popup -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="assets/js/script.js"></script>

</body>
</html>