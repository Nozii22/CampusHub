<?php
session_start();
require "includes/connection.php";

// Check if student is signed in
$student_session = $_SESSION["student"] ?? $_SESSION["students"] ?? null;

if (!$student_session || empty($student_session["studentID"])) {
    header("Location: signin.php");
    exit();
}

$std_id = $student_session["studentID"];

// Fetch latest student data from database
$std_rs = Database::search("SELECT * FROM `students` WHERE `studentID`='" . $std_id . "'");
if ($std_rs->num_rows > 0) {
    $std = $std_rs->fetch_assoc();
} else {
    header("Location: signin.php");
    exit();
}

// Default Avatar if no profile picture is uploaded
$profile_img = !empty($std["profile_picture"]) ? $std["profile_picture"] : "assets/img/default-user.png";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert CDN -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <main class="page-main">
        <div class="container-small">

            <!-- Page Intro -->
            <header class="page-intro">
                <h1>My Profile</h1>
                <p>Manage and update your CampusHub member account details.</p>
            </header>

            <!-- Profile Form Card -->
            <div class="form-box">
                <form id="profileUpdateForm" enctype="multipart/form-data">

                    <!-- Profile Picture Section with Circular Preview -->
                    <section class="section-block avatar-section">
                        <h2>Profile Picture</h2>
                        <div class="avatar-wrapper">
                            <img src="<?php echo htmlspecialchars($profile_img); ?>" id="profilePreview" alt="Profile Picture" class="profile-avatar">
                            <label for="profile_picture" class="btn-change-avatar">
                                <i class="fa-solid fa-camera"></i> Change Photo
                            </label>
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;" onchange="previewImage(event);">
                        </div>
                    </section>

                    <!-- Personal Information -->
                    <section class="section-block">
                        <h2>Personal Information</h2>

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($std['first_name'] ?? ''); ?>" placeholder="Enter your first name" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($std['last_name'] ?? ''); ?>" placeholder="Enter your last name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($std['email'] ?? ''); ?>" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <label for="student_id_display">Student ID (Read-only)</label>
                            <input type="text" id="student_id_display" value="#STD-<?php echo htmlspecialchars($std['studentID']); ?>" readonly class="input-readonly">
                        </div>

                        <button type="button" class="btn-primary" onclick="updateProfile();">Update Profile</button>
                    </section>

                </form>
            </div>

        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/script.js"></script>
</body>

</html>