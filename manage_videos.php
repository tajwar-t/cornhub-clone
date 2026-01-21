<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}
include 'db.php';

// Handle deletion
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $res = $conn->query("SELECT filename, thumbnail FROM videos WHERE id = $id");
    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        $videoFile = 'uploads/' . $row['filename'];
        $thumbFile = 'uploads/thumbnails/' . $row['thumbnail'];

        if(file_exists($videoFile)) unlink($videoFile);
        if(file_exists($thumbFile)) unlink($thumbFile);

        $conn->query("DELETE FROM videos WHERE id = $id");
        $message = "Video deleted successfully!";
    }
}

// Handle upload
if(isset($_POST['upload'])){
    $title = $conn->real_escape_string($_POST['title']);
    $category = $conn->real_escape_string($_POST['category']);
    $file = $_FILES['video'];

    if($file['error'] === 0){
        $filename = time() . '_' . basename($file['name']);
        $target = 'uploads/' . $filename;

        if(move_uploaded_file($file['tmp_name'], $target)){
            $conn->query("INSERT INTO videos (title, filename, category) VALUES ('$title', '$filename', '$category')");
            $message = "Video uploaded successfully!";
        } else {
            $message = "Failed to upload video!";
        }
    } else {
        $message = "Error uploading video!";
    }
}

// Fetch all videos
$result = $conn->query("SELECT * FROM videos ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Videos - CornHub Clone</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {font-family: Arial, sans-serif; background: #fffbe6;}
        h1 {text-align:center; color:#ff9800;}
        form {background:#fffde7; padding:20px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); max-width:600px; margin:auto;}
        form input, form select {width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ffd54f;}
        form button {background:#43a047; color:#fff; padding:10px; border:none; border-radius:5px; cursor:pointer; transition:0.3s;}
        form button:hover {background:#2e7d32;}
        table {width:100%; border-collapse: collapse; margin-top:30px;}
        th, td {padding:10px; border:1px solid #ddd; text-align:center;}
        th {background:#ffcc33;}
        a.delete-btn {color:white; background:#e53935; padding:5px 10px; border-radius:4px; text-decoration:none;}
        a.delete-btn:hover {background:#b71c1c;}
        .message {margin:20px 0; color:green; font-weight:bold; text-align:center;}
        img, video {max-width:120px;}
        .main{ max-width:1200px; margin:auto; padding:20px; }
    </style>
</head>
<body>
    <header>
        <a style="padding: 0; background: transparent" href="/"><h1>CornHub 🌽</h1></a>
        <h1>Manage Videos 🌽</h1>
        <p style="text-align:center;">
            <a href="logout.php" style="
                color:#fff;
                background:#e53935;
                padding:10px 25px;
                margin: 0;
                border-radius:25px;
                text-decoration:none;
                font-weight:bold;
                transition:0.3s;
            " onmouseover="this.style.background='#b71c1c';" onmouseout="this.style.background='#e53935';">
                Logout 🌽
            </a>
        </p>
    </header>
    <div class="main">

        <?php if(isset($message)) echo "<p class='message'>$message</p>"; ?>

        <!-- Upload Form -->
        <form method="post" enctype="multipart/form-data">
            <h2>Upload New Video</h2>
            <input type="text" name="title" placeholder="Video Title" required>
            <input type="text" name="category" placeholder="Category" required>
            <input type="file" name="video" accept="video/*" required>
            <button type="submit" name="upload">Upload Video</button>
        </form>

        <!-- Video Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Thumbnail / Video</th>
                <th>Title</th>
                <th>Category</th>
                <th>Likes</th>
                <th>Uploaded At</th>
                <th>Action</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <?php
                        $thumbPath = 'uploads/thumbnails/' . $row['thumbnail'];
                        $videoPath = 'uploads/' . $row['filename'];

                        if($row['thumbnail'] && file_exists($thumbPath)){
                            echo "<img src='$thumbPath'>";
                        } else {
                            echo "<video controls>
                                    <source src='$videoPath' type='video/mp4'>
                                </video>";
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                    <td><?php echo $row['likes']; ?></td>
                    <td><?php echo $row['uploaded_at']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this video?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
