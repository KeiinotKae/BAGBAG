<?php
session_start();
$conn = new mysqli("localhost:3307", "root", "", "barangay_management_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitize($conn, $value) {
    return htmlspecialchars(mysqli_real_escape_string($conn, $value));
}

// Collect common user data
$full_name = sanitize($conn, $_POST['full_name']);
$email = sanitize($conn, $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = sanitize($conn, $_POST['role']);
$status = 'approved';
$created_at = date('Y-m-d H:i:s');

// Insert into users table
$user_sql = "INSERT INTO users (full_name, email, password, role, created_at, status) VALUES (?, ?, ?, ?, ?, ?)";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("ssssss", $full_name, $email, $password, $role, $created_at, $status);

if ($user_stmt->execute()) {
    $user_id = $conn->insert_id;

    // Role-specific insert
    switch ($role) {
        case 'Official':
            $dob = sanitize($conn, $_POST['dob']);
            $pob = sanitize($conn, $_POST['pob']);
            $age = (int)$_POST['age'];
            $gender = sanitize($conn, $_POST['gender']);
            $civil_status = sanitize($conn, $_POST['civil_status']);
            $nationality = sanitize($conn, $_POST['nationality']);
            $religion = sanitize($conn, $_POST['religion']);
            $position = sanitize($conn, $_POST['position']);
            $term_start = sanitize($conn, $_POST['term_start']);
            $term_end = sanitize($conn, $_POST['term_end']);
            $address = sanitize($conn, $_POST['address']);
            $phone = sanitize($conn, $_POST['phone']);
            $email_off = sanitize($conn, $_POST['email_off']);

            $official_sql = "INSERT INTO officials (user_id, dob, pob, age, gender, civil_status, nationality, religion, position, term_start, term_end, address, phone, email_off) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $official_stmt = $conn->prepare($official_sql);
            $official_stmt->bind_param("ississssssssss", $user_id, $dob, $pob, $age, $gender, $civil_status, $nationality, $religion, $position, $term_start, $term_end, $address, $phone, $email_off);
            $official_stmt->execute();
            break;

        case 'Staff':
            $address = sanitize($conn, $_POST['address']);
            $phone = sanitize($conn, $_POST['phone']);
            $email_s = sanitize($conn, $_POST['email']);
            $position = sanitize($conn, $_POST['position']);
            $date_started = sanitize($conn, $_POST['date_started']);

            $staff_sql = "INSERT INTO staff (user_id, address, phone, email, position, date_started) 
                          VALUES (?, ?, ?, ?, ?, ?)";
            $staff_stmt = $conn->prepare($staff_sql);
            $staff_stmt->bind_param("isssss", $user_id, $address, $phone, $email_s, $position, $date_started);
            $staff_stmt->execute();
            break;

        case 'BPSO':
            $address = sanitize($conn, $_POST['address']);
            $phone = sanitize($conn, $_POST['phone']);
            $email_b = sanitize($conn, $_POST['email']);
            $position = sanitize($conn, $_POST['position']);
            $date_started = sanitize($conn, $_POST['date_started']);

            $bpso_sql = "INSERT INTO bpso (user_id, address, phone, email, position, date_started) 
                         VALUES (?, ?, ?, ?, ?, ?)";
            $bpso_stmt = $conn->prepare($bpso_sql);
            $bpso_stmt->bind_param("isssss", $user_id, $address, $phone, $email_b, $position, $date_started);
            $bpso_stmt->execute();
            break;
    }

    // Redirect or return success
    header("Location: admin_dashboard.php?success=1");
    exit();

} else {
    echo "Error: " . $user_stmt->error;
}
?>
