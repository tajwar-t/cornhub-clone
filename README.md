========================================
CornHub Clone - Corn Themed Video Platform
========================================

A playful, corn-themed video-sharing platform built with Plain HTML, CSS, JavaScript, and PHP.
This project is a safe and legal parody inspired by video-sharing sites, designed to host fun corn-related videos.

---

## Features

Core Features:

- Upload and stream videos with titles and categories
- Fallback to video if thumbnail is missing
- Search videos by title
- Filter videos by category
- Like button with live updates
- Responsive, flexible grid layout
- Trending videos section (most liked)
- Thumbnail previews for faster browsing
- Hover effects and animations for modern UI

Optional / Planned Features:

- Hover video previews on thumbnails
- Modal popup video player
- Infinite scroll or "load more" functionality
- User accounts with favorites/playlists

---

## Folder Structure

cornhub-clone/
│
├─ index.php # Homepage + video gallery
├─ upload.php # Video upload form
├─ like.php # AJAX like handler
├─ db.php # Database connection
├─ uploads/ # Folder to store uploaded videos
│ └─ thumbnails/ # Optional folder for thumbnails
├─ styles.css # Main stylesheet
├─ script.js # JS for interactivity
└─ README.txt # Project documentation

---

## Database Setup

1. Create database:
   CREATE DATABASE cornhub;

2. Create the 'videos' table:
   CREATE TABLE videos (
   id INT AUTO_INCREMENT PRIMARY KEY,
   title VARCHAR(255) NOT NULL,
   filename VARCHAR(255) NOT NULL,
   category VARCHAR(50) NOT NULL DEFAULT 'General',
   thumbnail VARCHAR(255) DEFAULT NULL,
   likes INT NOT NULL DEFAULT 0,
   uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

3. Update db.php with your database credentials:
   <?php
   $host = "localhost";
   $user = "root";
   $pass = "";
   $db   = "cornhub";
   
   $conn = new mysqli($host, $user, $pass, $db);
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>

---

## Installation

1. Clone or download this repository to your local server (XAMPP, WAMP, LAMP, etc.).
2. Make sure 'uploads/' and 'uploads/thumbnails/' folders are writable (chmod 755 or 777 if needed).
3. Import the database SQL into MySQL.
4. Open your browser and navigate to:
   http://localhost/cornhub-clone/index.php
5. Start uploading corn videos via upload.php

---

## Usage

- Homepage: Browse trending videos or all videos in a responsive grid.
- Upload Page: Upload new videos and select a category.
- Like Button: Click to like a video; likes update live.
- Search & Filter: Use the search bar or category dropdown to filter videos.
- Thumbnail Fallback: If no thumbnail exists, the video will display directly.

---

## Technologies Used

- Frontend: HTML5, CSS3, JavaScript
- Backend: PHP 7+
- Database: MySQL
- Optional Tools: FFMpeg for generating thumbnails

---

## Notes

- Ensure your server allows video uploads and has sufficient upload size limits.
- Recommended video types: mp4, webm, ogg
- This project is safe and legal, suitable for learning PHP, JS, and responsive design.

---

## License

This project is open-source and free to use for personal or educational purposes.

---

## Author

Tajwar 🌽
