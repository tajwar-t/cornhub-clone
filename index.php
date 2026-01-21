<?php
include 'db.php';

// Fetch trending videos (most liked, limit 8)
$trendingResult = $conn->query("SELECT * FROM videos ORDER BY likes DESC LIMIT 8");

// Fetch all categories
$catResult = $conn->query("SELECT DISTINCT category FROM videos");
$categories = [];
while ($cat = $catResult->fetch_assoc()) {
    $categories[] = $cat['category'];
}

// Handle search/filter
$search = $_GET['search'] ?? '';
$categoryFilter = $_GET['category'] ?? '';

$sql = "SELECT * FROM videos WHERE 1=1";
$params = [];

if ($search) {
    $sql .= " AND title LIKE ?";
    $params[] = "%$search%";
}
if ($categoryFilter) {
    $sql .= " AND category=?";
    $params[] = $categoryFilter;
}

$sql .= " ORDER BY uploaded_at DESC";
$stmt = $conn->prepare($sql);

if ($params) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CornHub Clone 🌽</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<header>
    <h1>CornHub 🌽</h1>

    <div class="header-buttons">
        <a href="manage_videos.php" class="manage-btn">Manage Videos</a>
    </div>

    <form method="get" style="margin-top:10px;">
        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
        <select name="category">
            <option value="">All Categories</option>
            <?php foreach($categories ?? [] as $cat): ?>
                <option value="<?php echo $cat; ?>" <?php if(($categoryFilter ?? '')==$cat) echo 'selected'; ?>>
                    <?php echo $cat; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>
</header>

<main>
    <!-- Trending Section -->
    <section class="trending">
        <h2>🔥 Trending Videos</h2>
        <div class="grid">
            <?php while($row = $trendingResult->fetch_assoc()): ?>
            <div class="video-card">
                <?php 
                    $thumbPath = 'uploads/thumbnails/' . ($row['thumbnail'] ?: '');
                    $videoPath = 'uploads/' . htmlspecialchars($row['filename']);
                ?>
                
                <?php if ($row['thumbnail'] && file_exists($thumbPath)): ?>
                    <!-- Show thumbnail if it exists -->
                    <a href="<?php echo $videoPath; ?>" target="_blank">
                        <img src="<?php echo $thumbPath; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    </a>
                <?php else: ?>
                    <!-- Fallback: show video directly -->
                    <video controls width="100%">
                        <source src="<?php echo $videoPath; ?>" type="video/mp4">
                        Your browser does not support HTML5 video.
                    </video>
                <?php endif; ?>

                <p><?php echo htmlspecialchars($row['title']); ?> - <em><?php echo $row['category']; ?></em></p>
                <button class="like-btn" data-id="<?php echo $row['id']; ?>">
                    Like (<span id="likes-<?php echo $row['id']; ?>"><?php echo $row['likes']; ?></span>)
                </button>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- All Videos Grid -->
    <section class="all-videos">
        <h2>All Videos</h2>
        <div class="grid">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="video-card">
                    <?php 
                        $thumbPath = 'uploads/thumbnails/' . ($row['thumbnail'] ?: '');
                        $videoPath = 'uploads/' . htmlspecialchars($row['filename']);
                    ?>
                    
                    <?php if ($row['thumbnail'] && file_exists($thumbPath)): ?>
                        <!-- Show thumbnail if it exists -->
                        <a href="<?php echo $videoPath; ?>" target="_blank">
                            <img src="<?php echo $thumbPath; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        </a>
                    <?php else: ?>
                        <!-- Fallback: show video directly -->
                        <video controls width="100%">
                            <source src="<?php echo $videoPath; ?>" type="video/mp4">
                            Your browser does not support HTML5 video.
                        </video>
                    <?php endif; ?>

                    <p><?php echo htmlspecialchars($row['title']); ?> - <em><?php echo $row['category']; ?></em></p>
                    <button class="like-btn" data-id="<?php echo $row['id']; ?>">
                        Like (<span id="likes-<?php echo $row['id']; ?>"><?php echo $row['likes']; ?></span>)
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<script src="script.js"></script>
</body>
</html>
