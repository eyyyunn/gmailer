<?php
require 'config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer autoload

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = $_POST['to'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;   // your Gmail
        $mail->Password   = SMTP_PASS;   // your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // use TLS
        $mail->Port       = 587;

        // Sender & recipient
        $mail->setFrom(SMTP_USER, 'Admin');
        $mail->addAddress($to);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br($message);
        $mail->AltBody = $message;

        $mail->send();
        echo "✅ Message sent successfully! <a href='dashboard.php'>Back</a>";
    } catch (Exception $e) {
        echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
