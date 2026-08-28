<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$student_session = $_SESSION["student"] ?? null;
?>
<header class="main-header">
    <div class="nav-container">
        <!-- Logo -->
        <a href="home.php" class="brand-logo">Campus<span>Hub</span></a>

        <!-- Navigation Links -->
        <nav class="nav-menu">
            <a href="home.php" class="nav-link">Home</a>
            <a href="events.php" class="nav-link">Events</a>
            <a href="events.php#activities" class="nav-link">Activities</a>
            <a href="announcements.php" class="nav-link">Announcements</a>
            <a href="home.php#communities" class="nav-link">Communities</a>
            <a href="home.php#gallery" class="nav-link">Gallery</a>

            <div class="nav-auth-buttons">
                <?php if ($student_session) { ?>
                    <!-- When Logged In -->
                    <a href="profile.php" class="nav-link nav-user-profile">
                        <i class="fa-solid fa-user-circle"></i> <?php echo htmlspecialchars($student_session["first_name"] ?? "Profile"); ?>
                    </a>
                    <button type="button" class="btn-signout" onclick="studentSignOut();">Sign Out</button>
                <?php } else { ?>
                    <!-- When NOT Logged In -->
                    <a href="signin.php" class="btn-signin">Sign In</a>
                <?php } ?>
            </div>
        </nav>
    </div>
</header>