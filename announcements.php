<?php
require "includes/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/announcements.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <main class="announcements-main">
        <div class="container">

            <!-- Page Header -->
            <header class="page-intro">
                <h1>Announcements & Notifications</h1>
                <p>Stay updated with the latest CampusHub announcements, academic updates, and event notifications.</p>
            </header>

            <!-- Dynamic Announcements Grid -->
            <div class="announcements-grid">

                <?php
                // Assignment XML Integration fallback check
                if (file_exists("announcements.xml")) {
                    $xml = simplexml_load_file("announcements.xml");
                    $hasXmlData = count($xml->announcement) > 0;
                } else {
                    $hasXmlData = false;
                }

                // Primary Database Query
                $ann_rs = Database::search("SELECT * FROM `announcements` ORDER BY `announcementID` DESC");
                $ann_num = $ann_rs->num_rows;

                if ($ann_num > 0) {
                    $categories = ['important', 'academic', 'event', 'general'];
                    $index = 0;

                    while ($ann = $ann_rs->fetch_assoc()) {
                        $cat = $categories[$index % 4];
                        $index++;
                ?>
                        <section class="announcement-card <?php echo ($cat); ?>">
                            <div class="card-top">
                                <span class="badge badge-<?php echo ($cat); ?>"><?php echo ucfirst($cat); ?></span>
                                <span class="ann-date"><?php echo date("M d, Y", strtotime($ann["posted_date"])); ?></span>
                            </div>
                            <h2><?php echo htmlspecialchars($ann["title"]); ?></h2>
                            <p><?php echo htmlspecialchars($ann["content"]); ?></p>
                        </section>
                <?php
                    }
                } else {
                ?>
                    <div class="no-announcements">
                        <p>No active announcements found at the moment. Please check back later!</p>
                    </div>
                <?php
                }
                ?>

            </div>

        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>

</html>