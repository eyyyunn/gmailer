<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid login!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; display:flex; height:100vh; justify-content:center; align-items:center; background:#f5f5f5; }
        form { background:#fff; padding:20px; border-radius:8px; box-shadow:0px 2px 5px rgba(0,0,0,0.2); }
        input { margin:5px 0; padding:10px; width:100%; }
        button { padding:10px; width:100%; background:#007BFF; color:#fff; border:none; border-radius:5px; }
    </style>
</head>
<body>
    <form method="post">
        <h2>Admin Login</h2>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
