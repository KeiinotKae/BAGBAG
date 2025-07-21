<?php
// ✅ PHPMailer (Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Database configuration
$host = 'localhost:3307';
$username = 'root';
$password = '';
$dbname = 'barangay_management_system';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Common fields
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $conn->real_escape_string($_POST['role']);

    if ($password !== $confirm_password) {
        die("Passwords do not match!");
    }

    // 💡 Validate against registered_residents if role is 'Resident'
    if ($role === 'Resident') {
        $dob = $conn->real_escape_string($_POST['dob'] ?? '');
        $gender = $conn->real_escape_string($_POST['gender'] ?? '');

        $check = $conn->prepare("SELECT * FROM registered_residents WHERE full_name = ? AND dob = ? AND gender = ?");
        $check->bind_param("sss", $full_name, $dob, $gender);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            echo "<script>
                alert('You are not in the official list of registered residents. Please check your details or contact the Barangay.');
                window.location.href='register.php';
            </script>";
            exit();
        }
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into users table (auto-approved)
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role, status) VALUES (?, ?, ?, ?, 'approved')");
    $stmt->bind_param("ssss", $full_name, $email, $hashed_password, $role);

    if (!$stmt->execute()) {
        die("Error registering user: " . $conn->error);
    }

    $user_id = $stmt->insert_id;

    // ✅ PHPMailer: Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'barangaybagbagmanagementsystem@gmail.com';
        $mail->Password   = 'flda drgk dptd abwo'; // Replace with Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('barangaybagbagmanagementsystem@gmail.com', 'Barangay Bagbag System');
        $mail->addAddress($email, $full_name);
        $mail->isHTML(true);
        $mail->Subject = 'Your Account is Approved';
        $mail->Body    = "
            Hi <b>$full_name</b>,<br><br>
            Your account for the Barangay Management System has been <b>successfully approved</b>.<br><br>
            You may now log in at <a href='http://localhost/your-login-url'>Login Page</a>.<br><br>
            Regards,<br>Barangay Admin
        ";
        $mail->send();
    } catch (Exception $e) {
        error_log("PHPMailer error: " . $mail->ErrorInfo);
    }

    // ✅ Save extra info based on role
    if ($role === 'Resident') {
        $pob = $conn->real_escape_string($_POST['pob'] ?? '');
        $age = intval($_POST['age'] ?? 0);
        $civil_status = $conn->real_escape_string($_POST['civil_status'] ?? '');
        $nationality = $conn->real_escape_string($_POST['nationality'] ?? '');
        $religion = $conn->real_escape_string($_POST['religion'] ?? '');
        $address = $conn->real_escape_string($_POST['address'] ?? '');
        $phone = $conn->real_escape_string($_POST['phone'] ?? '');
        $res_email = $conn->real_escape_string($_POST['res_email'] ?? '');
        $resident_type = $conn->real_escape_string($_POST['resident_type'] ?? '');
        $stay_length = $conn->real_escape_string($_POST['stay_length'] ?? '');
        $employment_status = $conn->real_escape_string($_POST['employment_status'] ?? '');
        $proof = $conn->real_escape_string($_POST['proof'] ?? '');
        $date_registered = date('Y-m-d');

        $stmt2 = $conn->prepare("
            INSERT INTO residents (
                user_id, dob, pob, age, gender, civil_status, nationality, religion,
                address, phone, res_email, resident_type, stay_length, proof,
                date_registered, employment_status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt2->bind_param(
            "isssssssssssssss",
            $user_id, $dob, $pob, $age, $gender, $civil_status, $nationality, $religion,
            $address, $phone, $res_email, $resident_type, $stay_length, $proof,
            $date_registered, $employment_status
        );

        if (!$stmt2->execute()) {
            die("Error saving resident info: " . $conn->error);
        }
    }

    echo "<script>alert('Registration successful! Please check your email inbox.'); window.location.href='login.php';</script>";
}
?>
