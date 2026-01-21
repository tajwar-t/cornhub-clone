<?php
session_start();
include 'db.php';
$message = '';

if(isset($_POST['login'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE username='$username'");
    if($res->num_rows > 0){
        $user = $res->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['admin'] = true;
            $_SESSION['username'] = $user['username'];
            header("Location: manage_videos.php");
            exit;
        } else {
            $message = "Incorrect password!";
        }
    } else {
        $message = "Username not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login - CornHub Clone</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #fff8e1, #ffd54f);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    form {
        background: #fffde7;
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        width: 350px;
        text-align: center;
        animation: pop 0.5s ease;
    }

    h2 {
        color: #ff9800;
        margin-bottom: 20px;
        text-shadow: 1px 1px #b28500;
    }

    input {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 25px;
        border: 1px solid #ffd54f;
        outline: none;
        font-size: 1rem;
    }

    button {
        padding: 12px;
        width: 100%;
        background: #43a047;
        color: #fff;
        border: none;
        border-radius: 25px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
        margin-top: 10px;
    }

    button:hover {
        background: #2e7d32;
        transform: scale(1.05);
    }

    .message {
        color: red;
        font-weight: bold;
        margin-bottom: 10px;
    }

    @keyframes pop {
        from {transform: scale(0.9); opacity: 0;}
        to {transform: scale(1); opacity: 1;}
    }
</style>
</head>
<body>
<a style="padding: 0; background: transparent; margin-bottom: 50px; text-decoration: none; color: #000000" href="/"><h1>CornHub 🌽</h1></a>
<form method="post">
    <h2>Admin Login 🌽</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>
<p style="text-align:center; margin-top:30px;">
    Don't have an account? <a href="register.php" style=" font-weight: 700; color:#ff9800; text-decoration:none;">Register here 🌽</a>
</p>
</body>
</html>
