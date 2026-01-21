<?php
session_start();
include 'db.php';

$message = '';

if(isset($_POST['register'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if($password !== $confirm){
        $message = "Passwords do not match!";
    } else {
        // Check if username exists
        $res = $conn->query("SELECT id FROM users WHERE username='$username'");
        if($res->num_rows > 0){
            $message = "Username already exists!";
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $conn->query("INSERT INTO users (username, password) VALUES ('$username','$hashed')");
            $message = "Registration successful! <a href='login.php'>Login here</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - CornHub Clone</title>
<style>
    body {font-family: Arial; background: linear-gradient(135deg,#fff8e1,#ffd54f); display:flex; flex-direction: column; justify-content:center; align-items:center; height:100vh;}
    form {background:#fffde7; padding:30px 40px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.2); width:350px; text-align:center;}
    input {width:100%; padding:12px; margin:10px 0; border-radius:25px; border:1px solid #ffd54f; outline:none; font-size:1rem;}
    button {padding:12px; width:100%; background:#43a047; color:#fff; border:none; border-radius:25px; font-weight:bold; cursor:pointer; transition:0.3s; margin-top:10px;}
    button:hover {background:#2e7d32; transform: scale(1.05);}
    .message {color:red; font-weight:bold; margin-bottom:10px;}
    h2 {color:#ff9800; text-shadow:1px 1px #b28500; margin-bottom:20px;}
</style>
</head>
<body>
<a style="padding: 0; background: transparent; margin-bottom: 50px; text-decoration: none; color: #000000" href="/"><h1>CornHub 🌽</h1></a>
<form method="post">
    <h2>Register 🌽</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm" placeholder="Confirm Password" required>
    <button type="submit" name="register">Register</button>
</form>
<p style="text-align:center; margin-top:30px;">
    Already have an account? <a href="login.php" style=" font-weight: 700; color:#ff9800; text-decoration:none;">Login here 🌽</a>
</p>
</body>
</html>
