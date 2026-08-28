<?php
require "includes/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | CampusHub</title>
    <link rel="stylesheet" href="assets/css/signup.css">
    <!-- SweetAlert CDN -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

    <!-- Header -->
    <header class="auth-header">
        <a href="index.php" class="brand-title">CampusHub</a>
        <a href="index.php" class="back-link">&larr; Back to Home</a>
    </header>

    <!-- Sign Up Form Card -->
    <main class="auth-container">
        <div class="signup-box">
            <h1>Create Account</h1>
            <p>Join CampusHub and connect with your campus community.</p>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" placeholder="Enter your first name">
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" placeholder="Enter your last name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Create a password">
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <?php
                    $gender_rs = Database::search("SELECT * FROM `gender`");
                    $gender_num = $gender_rs->num_rows;

                    for ($x = 0; $x < $gender_num; $x++) {
                        $gender_data = $gender_rs->fetch_assoc();
                    ?>
                        <option value="<?php echo ($gender_data["genderID"]); ?>"><?php echo ($gender_data["genderName"]); ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="terms-group">
                <label>
                    <input type="checkbox" id="terms">
                    I agree to the CampusHub terms and conditions.
                </label>
            </div>

            <button type="button" class="btn-submit" onclick="StudentSignUp();">Create Account</button>

            <p class="signin-text">
                Already have an account? <a href="signin.php">Sign In</a>
            </p>
        </div>
    </main>

    <!-- JavaScript File -->
    <script src="assets/js/script.js"></script>
</body>
</html>