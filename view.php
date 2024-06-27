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
$videos = getVideos($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Videos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional: Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

    <div class="card-primary">
        <div class="card-header">
            <h3 class="card-title">All Videos</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($videos)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Director</th>
                                <th>Release Year</th>
                                <th>Actions</th>
                                <th>Video Playback</th> <!-- New column for video playback -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($videos as $video): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($video['title']); ?></td>
                                    <td><?php echo htmlspecialchars($video['director']); ?></td>
                                    <td><?php echo htmlspecialchars($video['release_year']); ?></td>
                                    <td>
                                        <a href="index.php?page=edit&id=<?php echo $video['id']; ?>" class="btn btn-warning">Edit</a>
                                        <a href="index.php?page=delete&id=<?php echo $video['id']; ?>" class="btn btn-danger">Delete</a>
                                        <a href="index.php?page=view_single&id=<?php echo $video['id']; ?>" class="btn btn-primary">View Details</a>
                                        <a href="index.php?page=rent&id=<?php echo $video['id']; ?>" class="btn btn-success">Rent Video</a>
                                    </td>
                                    <td>
                                        <video width="320" height="240" controls>
                                            <source src="data:video/mp4;base64,<?php echo base64_encode($video['video_data']); ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <p>No videos found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

<!-- Optional: Bootstrap JS and jQuery for Bootstrap components -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
