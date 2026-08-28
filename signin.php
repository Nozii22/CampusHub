<?php
require "includes/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | CampusHub</title>
    <link rel="stylesheet" href="assets/css/signin.css">
    <!-- SweetAlert CDN -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

    <!-- Header -->
    <header class="auth-header">
        <a href="index.php" class="brand-title">CampusHub</a>
        <a href="index.php" class="back-link">&larr; Back to Home</a>
    </header>

    <!-- Sign In Form Card -->
    <main class="auth-container">
        <div class="signin-box">
            <h1>Sign In</h1>
            <p>Welcome back to CampusHub.</p>

            <?php
            $email = "";
            $password = "";

            if (isset($_COOKIE["campushub_student_email"])) {
                $email = $_COOKIE["campushub_student_email"];
            }

            if (isset($_COOKIE["campushub_student_password"])) {
                $password = $_COOKIE["campushub_student_password"];
            }
            ?>

            <!-- Email Field -->
            <div class="form-group">
                <label for="signin_email">Email Address</label>
                <input type="email" id="signin_email" placeholder="Enter your email" value="<?php echo ($email); ?>">
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="signin_password">Password</label>
                <input type="password" id="signin_password" placeholder="Enter your password" value="<?php echo ($password); ?>">
            </div>

            <!-- Remember Me Checkbox -->
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" id="rememberMe" <?php if (!empty($email)) { echo ("checked"); } ?>>
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <button type="button" class="btn-submit" onclick="StudentSignIn();">Sign In</button>

            <p class="signup-text">
                Don't have an account? <a href="signup.php">Sign Up</a>
            </p>
        </div>
    </main>

    <!-- JavaScript File -->
    <script src="assets/js/script.js"></script>
</body>
</html>