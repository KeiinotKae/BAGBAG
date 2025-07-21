<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit();
}
$conn = new mysqli("localhost:3307", "root", "", "barangay_management_system");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $nationality = $conn->real_escape_string($_POST['nationality']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $pob = $conn->real_escape_string($_POST['pob']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $current_address = $conn->real_escape_string($_POST['current_address']);
    $civil_status = $conn->real_escape_string($_POST['civil_status']);
    $employment_status = $conn->real_escape_string($_POST['employment_status']);
        $religion = $conn->real_escape_string($_POST['religion']);

    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $family_members = $conn->real_escape_string($_POST['family_members']);

    // Valid ID Upload
    if (isset($_FILES['valid_id']) && $_FILES['valid_id']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/valid_ids/";
        $file_name = basename($_FILES['valid_id']['name']);
        $target_file = $upload_dir . uniqid() . "_" . $file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['valid_id']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO registered_residents 
                (full_name, nationality, gender, pob, dob, current_address, civil_status, employment_status, religion, phone, email, family_members, valid_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("sssssssssssss",
                $full_name, $nationality, $gender, $pob, $dob,
                $current_address, $civil_status, $employment_status, $religion,
                $phone, $email, $family_members, $target_file
            );

            if ($stmt->execute()) {
                header("Location: registered_residents.php");
                exit();
            } else {
                echo "Error saving data: " . $stmt->error;
            }
        } else {
            die("Error uploading file.");
        }
    } else {
        die("Please select a valid ID file to upload.");
    }
}
?>