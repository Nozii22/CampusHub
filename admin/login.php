<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | CampusHub</title>
    <!-- External CSS Link -->
    <link rel="stylesheet" href="../assets/css/adminLogin.css">
    <!-- SweetAlert CDN -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

    <div class="login-container">
        <h1>CampusHub</h1>
        <h2>Admin Login Portal</h2>

        <form onsubmit="event.preventDefault();">
            <div class="form-group">
                <label for="adminEmail">Email Address</label>
                <input type="email" id="adminEmail" placeholder="admin@campushub.com" required>
            </div>

            <div class="form-group">
                <label for="adminPassword">Password</label>
                <input type="password" id="adminPassword" placeholder="••••••••" required>
            </div>

            <button type="button" class="btn-login" onclick="AdminSignIn();">Sign In</button>
        </form>

        <a href="../index.php" class="back-link">&larr; Back to Home</a>
    </div>

    <!-- JavaScript Link -->
    <script src="../assets/js/script.js"></script>
</body>
</html>