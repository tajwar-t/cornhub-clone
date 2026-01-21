<?php
session_start();

$admin_user = "admin";
$admin_pass = "password123";
$message = '';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === $admin_user && $password === $admin_pass){
        $_SESSION['admin'] = true;
        header("Location: manage_videos.php");
        exit;
    } else {
        $message = "Invalid username or password!";
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

<form method="post">
    <h2>Admin Login 🌽</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>
