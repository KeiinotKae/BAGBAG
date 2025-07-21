<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }

    // Get email from token + optional expiry check (1 hour)
    $stmt = $conn->prepare("SELECT email, created_at FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['message'] = "Invalid or expired token.";
        header("Location: forgot_password.php");
        exit();
    }

    $row = $result->fetch_assoc();
    $email = $row['email'];
    $created_at = strtotime($row['created_at']);
    $now = time();

    // Optional: Token valid for 1 hour only
    if (($now - $created_at) > 3600) {
        $_SESSION['message'] = "Reset link has expired.";
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        header("Location: forgot_password.php");
        exit();
    }

    // Update user password (hashed)
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();

    // Delete used token
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $_SESSION['message'] = "Your password has been successfully updated.";
    // Log password reset
$stmt = $conn->prepare("INSERT INTO password_reset_logs (email, action) VALUES (?, 'Password Updated')");
$stmt->bind_param("s", $email);
$stmt->execute();

    header("Location: login.php");
    exit();
}
?>
