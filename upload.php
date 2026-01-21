<?php
include 'db.php';

$message = '';

$categories = ['Popping', 'Growing', 'Cooking', 'Funny', 'Other'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $file = $_FILES['video'];

    if ($file['error'] == 0) {
        $filename = time() . '_' . basename($file['name']);
        $target = 'uploads/' . $filename;

        $allowed = ['mp4', 'webm', 'ogg'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            if (move_uploaded_file($file['tmp_name'], $target)) {
                $stmt = $conn->prepare("INSERT INTO videos (title, filename, category) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $title, $filename, $category);
                $stmt->execute();
                $message = "Video uploaded successfully!";
            } else {
                $message = "Failed to move uploaded file.";
            }
        } else {
            $message = "Invalid file type. Only mp4, webm, ogg allowed.";
        }
    } else {
        $message = "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Video - CornHub Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Upload a Video 🌽</h1>
    <a href="index.php">Back to Gallery</a>
</header>

<main>
    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <label>Video Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Category:</label><br>
        <select name="category" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Video File:</label><br>
        <input type="file" name="video" accept="video/*" required><br><br>

        <button type="submit">Upload</button>
    </form>
</main>
</body>
</html>
