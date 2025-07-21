<?php
session_start();
require 'db_connect.php';

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['message'] = "Email not found.";
        header("Location: forgot_password.php");
        exit();
    }

    // Generate token
    $token = bin2hex(random_bytes(32));
    $url = "http://localhost/Barangay_Management_System_2/login-system/reset_password.php?token=$token";

    // Optional: delete old tokens first
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Store token
    $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();

    // Send email via PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'barangaybagbagmanagementsystem@gmail.com'; // Your Gmail
        $mail->Password = 'flda drgk dptd abwo'; // App password (not Gmail password)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('barangaybagbagmanagementsystem@gmail.com', 'Barangay Bagbag System');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body    = "
            <h2>Reset Your Password</h2>
            <p>Click the button below to reset your password:</p>
            <a href='$url' style='padding: 10px 15px; background: #1e3a8a; color: white; text-decoration: none; border-radius: 5px;'>Reset Password</a>
            <p>If you didn't request this, you can ignore this email.</p>
        ";

        $mail->send();
        $_SESSION['message'] = "Reset link sent to your email.";
    } catch (Exception $e) {
        $_SESSION['message'] = "Mailer Error: " . $mail->ErrorInfo;
    }

    header("Location: forgot_password.php");
    exit();
}
?>
