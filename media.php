<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media & Gallery | CampusHub</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/media.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main class="media-page-main">
        <div class="container">

            <!-- Page Header -->
            <header class="page-intro">
                <h1>Media & Gallery</h1>
                <p>Upload photographs and activity updates and view campus multimedia content.</p>
            </header>

            <div class="media-layout-grid">
                
                <!-- Upload Media Section -->
                <section class="media-upload-card">
                    <h2 class="card-heading">Upload Photo or Activity Update</h2>
                    
                    <form action="" method="POST" enctype="multipart/form-data" class="campus-form">
                        
                        <div class="form-group">
                            <label for="media_title">Title</label>
                            <input type="text" id="media_title" name="media_title" placeholder="Enter media title" required>
                        </div>

                        <div class="form-group">
                            <label for="media_type">Media Type</label>
                            <select id="media_type" name="media_type" required>
                                <option value="">Select Media Type</option>
                                <option value="photo">Photo</option>
                                <option value="activity">Activity Update</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="media_file">Upload File</label>
                            <input type="file" id="media_file" name="media_file" accept="image/*,video/*" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4" placeholder="Enter a brief description..."></textarea>
                        </div>

                        <button type="submit" class="btn-submit">Upload Media</button>

                    </form>
                </section>

                <!-- Multimedia Feed / Gallery Section -->
                <section class="multimedia-feed-card">
                    <h2 class="card-heading">Campus Multimedia</h2>

                    <div class="media-articles-list">
                        <article class="media-item">
                            <span class="media-badge badge-photo">Photo</span>
                            <h3>Student Sports Meet</h3>
                            <p class="media-text">Photos from the recent campus sports event.</p>
                            <p class="media-type-tag"><strong>Media Type:</strong> Photo</p>
                        </article>

                        <article class="media-item">
                            <span class="media-badge badge-activity">Activity Update</span>
                            <h3>Technology Workshop</h3>
                            <p class="media-text">Activity updates from the technology workshop.</p>
                            <p class="media-type-tag"><strong>Media Type:</strong> Activity Update</p>
                        </article>

                        <article class="media-item">
                            <span class="media-badge badge-photo">Photo</span>
                            <h3>Campus Community Event</h3>
                            <p class="media-text">Multimedia content from a student community event.</p>
                            <p class="media-type-tag"><strong>Media Type:</strong> Photo</p>
                        </article>
                    </div>
                </section>

            </div>

        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>