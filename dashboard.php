<?php
require 'config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Send Message</title>
    <style>
        body { font-family: Arial; margin:50px; background:#f5f5f5; }
        form { max-width:400px; background:#fff; padding:20px; border-radius:8px; box-shadow:0px 2px 5px rgba(0,0,0,0.2); }
        input, textarea { margin:5px 0; padding:10px; width:100%; }
        button { padding:10px; width:100%; background:#28a745; color:#fff; border:none; border-radius:5px; }
        a { display:inline-block; margin-top:10px; }
    </style>
</head>
<body>
    <form action="send_mail.php" method="post">
        <h2>Send Email</h2>
        <input type="email" name="to" placeholder="Recipient Email" required>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" rows="5" placeholder="Message" required></textarea>
        <button type="submit">Send</button>
        <a href="logout.php">Logout</a>
    </form>
</body>
</html>
