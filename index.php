<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusHub | Student Services</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/footer.css">


</head>
<body>

    <!-- Header -->
    <header class="landing-header">
        <div class="header-container">
            <a href="index.php" class="brand-logo">Campus<span>Hub</span></a>

            <nav class="nav-links">
                <a href="signin.php" class="btn-signin">Sign In</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="landing-main">
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <p class="tagline">Student Services Platform</p>
                <h1>Connect. Participate. Grow.</h1>
                <p class="hero-desc">
                    CampusHub brings student events, activities, communities, announcements, 
                    and student services together in one simple platform.
                </p>
                <div class="hero-actions">
                    <!-- <a href="home.php" class="btn-explore">JOIN NOW CampusHub &rarr;</a> -->
                </div>
            </div>
        </section>

        <!-- Features / Portal Cards Section -->
        <section class="features-section">
            <div class="features-header">
                <h2>CampusHub</h2>
                <p>Student Portal Overview</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <h3>Events & Activities</h3>
                    <p>Discover upcoming campus events, workshops, and sports matches.</p>
                </div>

                <div class="feature-card">
                    <h3>Student Communities</h3>
                    <p>Connect with peer groups and student clubs across campuses.</p>
                </div>

                <div class="feature-card">
                    <h3>Announcements</h3>
                    <p>Stay updated with instant campus news and circulars.</p>
                </div>

                <div class="feature-card">
                    <h3>Media & Gallery</h3>
                    <p>Explore campus photos, videos, and student memories.</p>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>