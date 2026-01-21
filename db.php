<?php
// db.php - connect to MySQL
$host = "localhost";
$user = "root";
$pass = "";
$db   = "cornhub";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
