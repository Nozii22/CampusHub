<?php
session_start();
require "includes/connection.php";

$student_session = $_SESSION["student"] ?? null;
if (!$student_session || empty($student_session["studentID"])) {
    header("Location: signin.php");
    exit();
}
$std_id = $student_session["studentID"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Online Forms | CampusHub</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/forms.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main class="page-main">
        <div class="container-small">

            <header class="page-intro">
                <h1>Submit Online Forms</h1>
                <p>Submit inquiries, activity proposals, or feedback directly to CampusHub administration.</p>
            </header>

            <div class="form-box">
                <form id="onlineSubmissionForm">
                    <div class="form-group">
                        <label for="form_type">Form Category / Purpose</label>
                        <select id="form_type" name="form_type">
                            <option value="General Inquiry">General Campus Inquiry</option>
                            <option value="Activity Proposal">Propose New Campus Activity</option>
                            <option value="Club Assistance">Club Support & Resources</option>
                            <option value="Event Feedback">Event Feedback & Suggestions</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject / Title</label>
                        <input type="text" id="subject" name="subject" placeholder="Enter brief summary of your request" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Detailed Message / Description</label>
                        <textarea id="message" name="message" rows="5" placeholder="Explain your proposal, inquiry or feedback in detail..." required></textarea>
                    </div>

                    <button type="button" class="btn-primary" onclick="submitOnlineForm();">Submit Online Form</button>
                </form>
            </div>

            <!-- Submission History -->
            <section class="history-section">
                <h2>My Submitted Forms</h2>
                <div class="history-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Category</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sub_rs = Database::search("SELECT * FROM `student_forms` WHERE `students_studentID`='" . $std_id . "' ORDER BY `formID` DESC");
                            if ($sub_rs->num_rows > 0) {
                                while ($sub = $sub_rs->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td>#<?php echo $sub["formID"]; ?></td>
                                        <td><span class="badge"><?php echo htmlspecialchars($sub["form_type"]); ?></span></td>
                                        <td><?php echo htmlspecialchars($sub["subject"]); ?></td>
                                        <td><?php echo date("M d, Y", strtotime($sub["submitted_at"])); ?></td>
                                        <td><span class="status-tag status-<?php echo strtolower($sub["status"]); ?>"><?php echo htmlspecialchars($sub["status"]); ?></span></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo ("<tr><td colspan='5' class='text-center'>No forms submitted yet.</td></tr>");
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
</body>
</html>