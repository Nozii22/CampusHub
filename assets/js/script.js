function AdminSignIn() {
    var email = document.getElementById("adminEmail");
    var password = document.getElementById("adminPassword");

    var f = new FormData();
    f.append("email", email.value);
    f.append("password", password.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                swal({
                    title: "Access Granted!",
                    text: "Welcome to CampusHub Admin Portal.",
                    icon: "success",
                }).then(() => {
                    window.location = "dashboard.php";
                });
            } else {
                swal({
                    title: "Login Failed!",
                    text: response,
                    icon: "error",
                });
            }
        }
    };

    // Correct relative path from admin/login.php to backend folder
    request.open("POST", "../backend/adminLoginProcess.php", true);
    request.send(f);
}

function StudentSignUp() {
    var fname = document.getElementById("first_name");
    var lname = document.getElementById("last_name");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var gender = document.getElementById("gender");
    var terms = document.getElementById("terms");

    var f = new FormData();
    f.append("first_name", fname.value);
    f.append("last_name", lname.value);
    f.append("email", email.value);
    f.append("password", password.value);
    f.append("gender", gender ? gender.value : "");
    if (terms && terms.checked) {
        f.append("terms", "agreed");
    }

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();
            if (response == "success") {
                swal({
                    title: "Registration Successfully!",
                    text: "Your Student account has been created.",
                    icon: "success",
                });
                setTimeout(function () {
                    window.location = "home.php";
                }, 2000);
            } else {
                swal({
                    title: "Registration Unsuccessfully!",
                    text: response,
                    icon: "error",
                });
            }
        }
    };

    request.open("POST", "backend/studentSignupProcess.php", true);
    
    request.send(f);
}

function StudentSignIn() {
    var email = document.getElementById("signin_email");
    var password = document.getElementById("signin_password");
    var rememberMe = document.getElementById("rememberMe");

    var f = new FormData();
    f.append("email", email.value);
    f.append("password", password.value);
    f.append("rememberMe", rememberMe.checked);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                swal({
                    title: "Welcome Back!",
                    text: "Logged into CampusHub successfully.",
                    icon: "success",
                }).then(() => {
                    window.location = "home.php";
                });
            } else {
                swal({
                    title: "Login Unsuccessfully!",
                    text: response,
                    icon: "error",
                });
            }
        }
    };

    request.open("POST", "backend/studentSigninProcess.php", true);
    request.send(f);
}

function saveStudent() {
    var id = document.getElementById("student_id").value;
    var fname = document.getElementById("first_name").value;
    var lname = document.getElementById("last_name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var gender = document.getElementById("gender").value;
    var status = document.getElementById("status").value;

    var f = new FormData();
    f.append("student_id", id);
    f.append("first_name", fname);
    f.append("last_name", lname);
    f.append("email", email);
    f.append("password", password);
    f.append("gender", gender);
    f.append("status", status);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();
            if (response == "success") {
                swal({
                    title: "Success!",
                    text: id ? "Student record updated successfully!" : "Student added successfully!",
                    icon: "success",
                }).then(() => {
                    location.reload();
                });
            } else {
                swal({ title: "Error!", text: response, icon: "error" });
            }
        }
    };

    request.open("POST", "../backend/adminSaveStudentProcess.php", true);
    request.send(f);
}

function editStudent(data) {
    document.getElementById("formTitle").innerText = "Edit Student (#" + data.studentID + ")";
    document.getElementById("student_id").value = data.studentID;
    document.getElementById("first_name").value = data.first_name;
    document.getElementById("last_name").value = data.last_name;
    document.getElementById("email").value = data.email;
    document.getElementById("gender").value = data.gender_genderID;
    document.getElementById("status").value = data.Student_status_statusID;
    
    document.getElementById("passwordGroup").style.display = "none";
    document.getElementById("saveBtn").innerText = "Update Student";
    document.getElementById("cancelBtn").style.display = "inline-block";
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    document.getElementById("formTitle").innerText = "Add New Student";
    document.getElementById("student_id").value = "";
    document.getElementById("first_name").value = "";
    document.getElementById("last_name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("password").value = "";
    document.getElementById("gender").value = "";
    document.getElementById("status").value = "1";
    
    document.getElementById("passwordGroup").style.display = "block";
    document.getElementById("saveBtn").innerText = "Save Student";
    document.getElementById("cancelBtn").style.display = "none";
}

function deleteStudent(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, this student record cannot be recovered!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            var f = new FormData();
            f.append("student_id", id);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var response = request.responseText.trim();
                    if (response == "success") {
                        swal("Deleted!", "Student record removed.", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        swal("Error!", response, "error");
                    }
                }
            };

            request.open("POST", "../backend/adminDeleteStudentProcess.php", true);
            request.send(f);
        }
    });
}

function searchStudents() {
    var query = document.getElementById("searchInput").value;
    var f = new FormData();
    f.append("search", query);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            document.getElementById("studentTableBody").innerHTML = request.responseText;
        }
    };

    request.open("POST", "../backend/adminSearchStudentProcess.php", true);
    request.send(f);
}

function switchSection(section) {
    var evSec = document.getElementById("eventsSection");
    var actSec = document.getElementById("activitiesSection");
    var evBtn = document.getElementById("eventTabBtn");
    var actBtn = document.getElementById("activityTabBtn");

    if (section === "events") {
        evSec.style.display = "block";
        actSec.style.display = "none";
        evBtn.classList.add("active");
        actBtn.classList.remove("active");
    } else {
        evSec.style.display = "none";
        actSec.style.display = "block";
        actBtn.classList.add("active");
        evBtn.classList.remove("active");
    }
}


function saveEvent() {
    var id = document.getElementById("event_id").value;
    var name = document.getElementById("eventName").value;
    var location = document.getElementById("eventLocation").value;
    var dateTime = document.getElementById("eventDateTime").value;
    var desc = document.getElementById("eventDescription").value;

    var f = new FormData();
    f.append("event_id", id);
    f.append("eventName", name);
    f.append("eventLocation", location);
    f.append("eventDateTime", dateTime);
    f.append("eventDescription", desc);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();
            if (response == "success") {
                swal("Success!", id ? "Event updated successfully!" : "Event added successfully!", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Error!", response, "error");
            }
        }
    };
    request.open("POST", "../backend/adminSaveEventProcess.php", true);
    request.send(f);
}

function editEvent(data) {
    document.getElementById("eventFormTitle").innerText = "Edit Event (#" + data.eventID + ")";
    document.getElementById("event_id").value = data.eventID;
    document.getElementById("eventName").value = data.eventName;
    document.getElementById("eventLocation").value = data.eventLocation;
    document.getElementById("eventDateTime").value = data.eventDateTime.replace(" ", "T");
    document.getElementById("eventDescription").value = data.eventDescription;

    document.getElementById("saveEventBtn").innerText = "Update Event";
    document.getElementById("cancelEventBtn").style.display = "inline-block";
    window.scrollTo({ top: 0, behavior: "smooth" });
}

function resetEventForm() {
    document.getElementById("eventFormTitle").innerText = "Add New Event";
    document.getElementById("event_id").value = "";
    document.getElementById("eventName").value = "";
    document.getElementById("eventLocation").value = "";
    document.getElementById("eventDateTime").value = "";
    document.getElementById("eventDescription").value = "";

    document.getElementById("saveEventBtn").innerText = "Save Event";
    document.getElementById("cancelEventBtn").style.display = "none";
}

function deleteEvent(id) {
    swal({
        title: "Are you sure?",
        text: "Delete this event record permanently?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            var f = new FormData();
            f.append("event_id", id);
            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() == "success") {
                        swal("Deleted!", "Event deleted successfully.", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        swal("Error!", req.responseText, "error");
                    }
                }
            };
            req.open("POST", "../backend/adminDeleteEventProcess.php", true);
            req.send(f);
        }
    });
}

function searchEvents() {
    var search = document.getElementById("searchEventInput").value;
    var f = new FormData();
    f.append("search", search);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            document.getElementById("eventTableContainer").innerHTML = req.responseText;
        }
    };
    req.open("POST", "../backend/adminSearchEventProcess.php", true);
    req.send(f);
}


function saveActivity() {
    var id = document.getElementById("activity_id").value;
    var title = document.getElementById("activity_title").value;
    var location = document.getElementById("activity_location").value;
    var dateTime = document.getElementById("activity_date_time").value;
    var desc = document.getElementById("activity_description").value;

    var f = new FormData();
    f.append("activity_id", id);
    f.append("activity_title", title);
    f.append("activity_location", location);
    f.append("activity_date_time", dateTime);
    f.append("activity_description", desc);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();
            if (response == "success") {
                swal("Success!", id ? "Activity updated successfully!" : "Activity added successfully!", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Error!", response, "error");
            }
        }
    };
    request.open("POST", "../backend/adminSaveActivityProcess.php", true);
    request.send(f);
}

function editActivity(data) {
    document.getElementById("activityFormTitle").innerText = "Edit Activity (#" + data.activityID + ")";
    document.getElementById("activity_id").value = data.activityID;
    document.getElementById("activity_title").value = data.activity_title;
    document.getElementById("activity_location").value = data.activity_location;
    document.getElementById("activity_date_time").value = data.activity_date_time.replace(" ", "T");
    document.getElementById("activity_description").value = data.activity_description;

    document.getElementById("saveActivityBtn").innerText = "Update Activity";
    document.getElementById("cancelActivityBtn").style.display = "inline-block";
    window.scrollTo({ top: 0, behavior: "smooth" });
}

function resetActivityForm() {
    document.getElementById("activityFormTitle").innerText = "Add New Activity";
    document.getElementById("activity_id").value = "";
    document.getElementById("activity_title").value = "";
    document.getElementById("activity_location").value = "";
    document.getElementById("activity_date_time").value = "";
    document.getElementById("activity_description").value = "";

    document.getElementById("saveActivityBtn").innerText = "Save Activity";
    document.getElementById("cancelActivityBtn").style.display = "none";
}

function deleteActivity(id) {
    swal({
        title: "Are you sure?",
        text: "Delete this activity record permanently?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            var f = new FormData();
            f.append("activity_id", id);
            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() == "success") {
                        swal("Deleted!", "Activity deleted successfully.", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        swal("Error!", req.responseText, "error");
                    }
                }
            };
            req.open("POST", "../backend/adminDeleteActivityProcess.php", true);
            req.send(f);
        }
    });
}

function searchActivities() {
    var search = document.getElementById("searchActivityInput").value;
    var f = new FormData();
    f.append("search", search);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            document.getElementById("activityTableContainer").innerHTML = req.responseText;
        }
    };
    req.open("POST", "../backend/adminSearchActivityProcess.php", true);
    req.send(f);
}

// Change Registration Status (Approve / Reject)
function changeRegStatus(regId, statusId) {
    var actionText = statusId === 2 ? "approve" : "reject";

    swal({
        title: "Are you sure?",
        text: "Do you want to " + actionText + " this event registration?",
        icon: "info",
        buttons: true,
    }).then((confirm) => {
        if (confirm) {
            var f = new FormData();
            f.append("reg_id", regId);
            f.append("status_id", statusId);

            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() == "success") {
                        swal("Updated!", "Registration status has been updated.", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        swal("Error!", req.responseText, "error");
                    }
                }
            };
            req.open("POST", "../backend/adminUpdateRegStatusProcess.php", true);
            req.send(f);
        }
    });
}

// Delete Registration
function deleteRegistration(regId) {
    swal({
        title: "Are you sure?",
        text: "Permanently delete this registration record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            var f = new FormData();
            f.append("reg_id", regId);

            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() == "success") {
                        swal("Deleted!", "Registration removed.", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        swal("Error!", req.responseText, "error");
                    }
                }
            };
            req.open("POST", "../backend/adminDeleteRegProcess.php", true);
            req.send(f);
        }
    });
}

// Live Search Registrations
function searchRegistrations() {
    var search = document.getElementById("searchRegInput").value;
    var f = new FormData();
    f.append("search", search);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            document.getElementById("registrationTableContainer").innerHTML = req.responseText;
        }
    };
    req.open("POST", "../backend/adminSearchRegProcess.php", true);
    req.send(f);
}

// Toggle File Accept type based on media dropdown selection
function updateFileAccept() {
    var type = document.getElementById("media_type").value;
    var fileInput = document.getElementById("media_file");
    if (type === "image") {
        fileInput.accept = "image/*";
    } else {
        fileInput.accept = "video/*";
    }
}

// Upload Media AJAX Handler
function uploadMedia() {
    var title = document.getElementById("media_title").value;
    var type = document.getElementById("media_type").value;
    var eventId = document.getElementById("event_id").value;
    var fileInput = document.getElementById("media_file");

    if (!fileInput.files || fileInput.files.length === 0) {
        swal("Error!", "Please choose a media file to upload.", "error");
        return;
    }

    var file = fileInput.files[0];
    var f = new FormData();
    f.append("media_title", title);
    f.append("media_type", type);
    f.append("event_id", eventId);
    f.append("media_file", file);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var response = req.responseText.trim();
            if (response == "success") {
                swal("Success!", "Media uploaded successfully!", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Upload Failed!", response, "error");
            }
        }
    };

    req.open("POST", "../backend/adminUploadMediaProcess.php", true);
    req.send(f);
}

// Delete Media Record and Server File
function deleteMedia(mediaId) {
    swal({
        title: "Are you sure?",
        text: "Permanently delete this media item and its file?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            var f = new FormData();
            f.append("media_id", mediaId);

            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() == "success") {
                        swal("Deleted!", "Media file deleted successfully.", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        swal("Error!", req.responseText, "error");
                    }
                }
            };

            req.open("POST", "../backend/adminDeleteMediaProcess.php", true);
            req.send(f);
        }
    });
}

// Live Search Media Records
function searchMedia() {
    var search = document.getElementById("searchMediaInput").value;
    var f = new FormData();
    f.append("search", search);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            document.getElementById("mediaTableContainer").innerHTML = req.responseText;
        }
    };
    req.open("POST", "../backend/adminSearchMediaProcess.php", true);
    req.send(f);
}

// Save / Update Announcement
function saveAnnouncement() {
    var id = document.getElementById("announcement_id").value;
    var title = document.getElementById("announcement_title").value;
    var content = document.getElementById("announcement_content").value;

    var f = new FormData();
    f.append("announcement_id", id);
    f.append("title", title);
    f.append("content", content);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var response = req.responseText.trim();
            if (response == "success") {
                swal({
                    title: "Success!",
                    text: id ? "Announcement updated successfully!" : "Announcement published successfully!",
                    icon: "success",
                }).then(() => {
                    location.reload();
                });
            } else {
                swal("Error!", response, "error");
            }
        }
    };
    req.open("POST", "../backend/adminSaveAnnouncementProcess.php", true);
    req.send(f);
}

// Edit Announcement Handler
function editAnnouncement(data) {
    document.getElementById("contentFormTitle").innerText = "Edit Announcement (#" + data.announcementID + ")";
    document.getElementById("announcement_id").value = data.announcementID;
    document.getElementById("announcement_title").value = data.title;
    document.getElementById("announcement_content").value = data.content;

    document.getElementById("saveContentBtn").innerText = "Update Announcement";
    document.getElementById("cancelContentBtn").style.display = "inline-block";
    window.scrollTo({ top: 0, behavior: "smooth" });
}

// Reset Announcement Form
function resetContentForm() {
    document.getElementById("contentFormTitle").innerText = "Publish New Announcement";
    document.getElementById("announcement_id").value = "";
    document.getElementById("announcement_title").value = "";
    document.getElementById("announcement_content").value = "";

    document.getElementById("saveContentBtn").innerText = "Publish Announcement";
    document.getElementById("cancelContentBtn").style.display = "none";
}

// Delete Announcement Handler
function deleteAnnouncement(id) {
    swal({
        title: "Are you sure?",
        text: "Permanently delete this announcement?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            var f = new FormData();
            f.append("announcement_id", id);

            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() == "success") {
                        swal("Deleted!", "Announcement removed.", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        swal("Error!", req.responseText, "error");
                    }
                }
            };
            req.open("POST", "../backend/adminDeleteAnnouncementProcess.php", true);
            req.send(f);
        }
    });
}

// Live Search Announcements
function searchAnnouncements() {
    var search = document.getElementById("searchContentInput").value;
    var f = new FormData();
    f.append("search", search);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            document.getElementById("contentTableContainer").innerHTML = req.responseText;
        }
    };
    req.open("POST", "../backend/adminSearchAnnouncementProcess.php", true);
    req.send(f);
}

// 1. Update Organisation Info Form
function updateOrgInfo() {
    var name = document.getElementById("org_name").value;
    var email = document.getElementById("org_email").value;
    var phone = document.getElementById("org_phone").value;
    var address = document.getElementById("org_address").value;
    var about = document.getElementById("org_about").value;

    var f = new FormData();
    f.append("org_name", name);
    f.append("email", email);
    f.append("phone", phone);
    f.append("address", address);
    f.append("about_text", about);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var response = req.responseText.trim();
            if (response == "success") {
                swal("Updated!", "Organisation information updated successfully.", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Error!", response, "error");
            }
        }
    };
    req.open("POST", "../backend/adminUpdateOrgInfoProcess.php", true);
    req.send(f);
}

// 2. Save / Update Student Club
function saveClub() {
    var id = document.getElementById("club_id").value;
    var name = document.getElementById("club_name").value;
    var category = document.getElementById("club_category").value;
    var leader = document.getElementById("leader_name").value;
    var desc = document.getElementById("club_description").value;

    var f = new FormData();
    f.append("club_id", id);
    f.append("club_name", name);
    f.append("category", category);
    f.append("leader_name", leader);
    f.append("description", desc);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var response = req.responseText.trim();
            if (response == "success") {
                swal("Success!", id ? "Club details updated!" : "New club added successfully!", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Error!", response, "error");
            }
        }
    };
    req.open("POST", "../backend/adminSaveClubProcess.php", true);
    req.send(f);
}

// 3. Edit Club Trigger
function editClub(data) {
    document.getElementById("clubFormTitle").innerText = "Edit Club (#" + data.clubID + ")";
    document.getElementById("club_id").value = data.clubID;
    document.getElementById("club_name").value = data.club_name;
    document.getElementById("club_category").value = data.category;
    document.getElementById("leader_name").value = data.leader_name;
    document.getElementById("club_description").value = data.description;

    document.getElementById("saveClubBtn").innerText = "Update Club";
    document.getElementById("cancelClubBtn").style.display = "inline-block";
    window.scrollTo({ top: 400, behavior: "smooth" });
}

// 4. Reset Club Form
function resetClubForm() {
    document.getElementById("clubFormTitle").innerText = "Register New Student Club / Community";
    document.getElementById("club_id").value = "";
    document.getElementById("club_name").value = "";
    document.getElementById("club_category").value = "Academic";
    document.getElementById("leader_name").value = "";
    document.getElementById("club_description").value = "";

    document.getElementById("saveClubBtn").innerText = "Save Club";
    document.getElementById("cancelClubBtn").style.display = "none";
}

// 5. Delete Club
function deleteClub(id) {
    swal({
        title: "Are you sure?",
        text: "Permanently delete this club record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            var f = new FormData();
            f.append("club_id", id);

            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() == "success") {
                        swal("Deleted!", "Club record removed.", "success").then(() => {
                            location.reload();
                        });
                    } else {
                        swal("Error!", req.responseText, "error");
                    }
                }
            };
            req.open("POST", "../backend/adminDeleteClubProcess.php", true);
            req.send(f);
        }
    });
}

// 6. Live Search Clubs
function searchClubs() {
    var search = document.getElementById("searchClubInput").value;
    var f = new FormData();
    f.append("search", search);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            document.getElementById("clubTableContainer").innerHTML = req.responseText;
        }
    };
    req.open("POST", "../backend/adminSearchClubProcess.php", true);
    req.send(f);
}

// Student Event Registration Handler
function registerForEvent(eventId) {
    var f = new FormData();
    f.append("event_id", eventId);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var res = req.responseText.trim();

            if (res === "success") {
                swal("Registered!", "You have successfully registered for this event. Status is Pending Admin approval.", "success");
            } else if (res === "already_registered") {
                swal("Notice", "You are already registered for this event.", "info");
            } else if (res === "login_required") {
                swal({
                    title: "Login Required",
                    text: "Please sign in to your student account to register for events.",
                    icon: "warning",
                    buttons: ["Cancel", "Sign In Now"]
                }).then((goLogin) => {
                    if (goLogin) {
                        window.location.href = "signin.php";
                    }
                });
            } else {
                swal("Registration Failed", res, "error");
            }
        }
    };
    req.open("POST", "backend/studentRegisterEventProcess.php", true);
    req.send(f);
}

// Instant Image Preview on File Selection
function previewImage(event) {
    var file = event.target.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("profilePreview").src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Profile Update AJAX Request
function updateProfile() {
    var fname = document.getElementById("first_name").value;
    var lname = document.getElementById("last_name").value;
    var email = document.getElementById("email").value;
    var pic = document.getElementById("profile_picture").files[0];

    var f = new FormData();
    f.append("first_name", fname);
    f.append("last_name", lname);
    f.append("email", email);
    if (pic) {
        f.append("profile_picture", pic);
    }

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            var res = req.responseText.trim();
            if (res === "success") {
                swal("Success!", "Profile details updated successfully.", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Update Failed", res, "error");
            }
        }
    };

    req.open("POST", "backend/studentUpdateProfileProcess.php", true);
    req.send(f);
}

// Student Sign Out Handler
function studentSignOut() {
    swal({
        title: "Sign Out?",
        text: "Are you sure you want to sign out from your account?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSignOut) => {
        if (willSignOut) {
            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() === "success") {
                        window.location.href = "signin.php";
                    }
                }
            };
            req.open("GET", "backend/studentSignOutProcess.php", true);
            req.send();
        }
    });
}// Student Sign Out Handler
function studentSignOut() {
    swal({
        title: "Sign Out?",
        text: "Are you sure you want to sign out from your account?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSignOut) => {
        if (willSignOut) {
            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() === "success") {
                        window.location.href = "signin.php";
                    }
                }
            };
            req.open("GET", "backend/studentSignOutProcess.php", true);
            req.send();
        }
    });
}

function submitOnlineForm() {
    var type = document.getElementById("form_type").value;
    var subject = document.getElementById("subject").value;
    var message = document.getElementById("message").value;

    if (!subject.trim() || !message.trim()) {
        swal("Required Fields", "Please enter both subject and message details.", "warning");
        return;
    }

    var f = new FormData();
    f.append("form_type", type);
    f.append("subject", subject);
    f.append("message", message);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            if (req.responseText.trim() === "success") {
                swal("Form Submitted!", "Your online form request has been submitted to administration.", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Error", req.responseText, "error");
            }
        }
    };
    req.open("POST", "backend/studentSubmitFormProcess.php", true);
    req.send(f);
}

function updateFormStatus(formId, status) {
    var f = new FormData();
    f.append("form_id", formId);
    f.append("status", status);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
            if (req.responseText.trim() === "success") {
                swal("Updated!", "Form status marked as " + status + ".", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Error", req.responseText, "error");
            }
        }
    };
    req.open("POST", "../backend/adminUpdateFormStatusProcess.php", true);
    req.send(f);
}

// Admin Sign Out Handler
function adminSignOut() {
    swal({
        title: "Admin Logout?",
        text: "Are you sure you want to end your administrative session?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willLogout) => {
        if (willLogout) {
            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText.trim() === "success") {
                        window.location.href = "login.php";
                    }
                }
            };
            req.open("GET", "../backend/adminSignOutProcess.php", true);
            req.send();
        }
    });
}