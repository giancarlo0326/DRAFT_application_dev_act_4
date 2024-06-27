<?php
// Ensure the session is started only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'database.php';
include 'functions.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $director = $_POST['director'];
    $release_year = $_POST['release_year'];

    // File upload handling
    $video_file = $_FILES['video_file'];

    // Check if file was uploaded without errors
    if ($video_file['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $video_file['tmp_name'];

        // Read the uploaded file content
        $video_data = file_get_contents($tmp_name);

        // Add video details to database
        addVideo($title, $director, $release_year, $user_id, $video_data);

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Video added successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
}
?>

<div class="card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Video</h3>
    </div>
    <form action="index.php?page=add" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" placeholder="Enter title" required>
            </div>
            <div class="form-group">
                <label for="director">Director</label>
                <input type="text" class="form-control" name="director" placeholder="Enter director" required>
            </div>
            <div class="form-group">
                <label for="release_year">Release Year</label>
                <input type="number" class="form-control" name="release_year" placeholder="Enter release year" required>
            </div>
            <div class="form-group">
                <label for="video_file">Upload Video</label>
                <input type="file" class="form-control-file" name="video_file" accept="video/*" required>
            </div>
            <p>Maximum of 100 MB only</p>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add Video</button>
        </div>
    </form>
</div>
