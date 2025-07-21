<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Resident') {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost:3307", "root", "", "barangay_management_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Handle form submission
if (isset($_POST['submit_report'])) {
    $user_id = $_SESSION['user_id'];
    $report_type = $conn->real_escape_string($_POST['report_type']);
    $category = $conn->real_escape_string($_POST['category']);
    $priority_level = $conn->real_escape_string($_POST['priority_level']);
    $location = $conn->real_escape_string($_POST['location']);
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $submitter_name = $conn->real_escape_string($_POST['submitter_name']);
    $submitter_email = $conn->real_escape_string($_POST['submitter_email']);
    $submitter_contact = $conn->real_escape_string($_POST['submitter_contact']);

    // Handle file upload
    $evidence = null;
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['evidence']['name'];
        $file_tmp = $_FILES['evidence']['tmp_name'];
        $file_size = $_FILES['evidence']['size'];
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi'];
        $max_image_size = 10 * 1024 * 1024; // 5MB
        $max_video_size = 50 * 1024 * 1024; // 10MB

        if (!in_array($file_type, $allowed_types)) {
            echo "<script>alert('Invalid file type. Only images and videos are allowed.'); window.location.href='community_reports.php';</script>";
            exit();
        }

        if (($file_type === 'jpg' || $file_type === 'jpeg' || $file_type === 'png' || $file_type === 'gif') && $file_size > $max_image_size) {
            echo "<script>alert('Image size exceeds 10MB limit.'); window.location.href='community_reports.php';</script>";
            exit();
        }

        if (($file_type === 'mp4' || $file_type === 'mov' || $file_type === 'avi') && $file_size > $max_video_size) {
            echo "<script>alert('Video size exceeds 50MB limit.'); window.location.href='community_reports.php';</script>";
            exit();
        }

        $upload_dir = "uploads/evidence/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $new_file_name = uniqid("evidence_", true) . "." . $file_type;
        $file_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            $evidence = $file_path;
        } else {
            echo "<script>alert('Error uploading file.'); window.location.href='community_reports.php';</script>";
            exit();
        }
    }

        // ✅ Check if user already has a pending report
    $check = $conn->prepare("SELECT report_id FROM community_reports WHERE user_id = ? AND status NOT IN ('approved', 'resolved')");
    $check->bind_param("i", $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('You already have a pending community report. Please wait for it to be resolved or approved before submitting a new one.'); window.location.href='community_reports.php';</script>";
        exit();
    }
    $check->close();

    // Insert into database


    
    $stmt = $conn->prepare("INSERT INTO community_reports 
        (user_id, report_type, category, priority_level, location, title, description, submitter_name, submitter_email, submitter_contact, evidence) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "issssssssss",
        $user_id, $report_type, $category, $priority_level, $location, $title, $description,
        $submitter_name, $submitter_email, $submitter_contact, $evidence
    );
    $stmt->execute();
    $report_id = $stmt->insert_id;
    $stmt->close();

    // ✉️ Send email notification using PHPMailer
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'barangaybagbagmanagementsystem@gmail.com'; // Gmail mo
    $mail->Password = 'flda drgk dptd abwo'; // App password mo
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('barangaybagbagmanagementsystem@gmail.com', 'Barangay Resident');
    $mail->addAddress('barangaybagbagmanagementsystem@gmail.com'); // Papunta kay BPSO
    $mail->isHTML(true);
    $mail->Subject = 'New Community Report Submitted';

    $mailBody = "
        <h2>New Community Report</h2>
        <p><strong>Title:</strong> {$title}</p>
        <p><strong>Report Type:</strong> {$report_type}</p>
        <p><strong>Category:</strong> {$category}</p>
        <p><strong>Location:</strong> {$location}</p>
        <p><strong>Description:</strong><br>" . nl2br(htmlspecialchars($description)) . "</p>
        <p><strong>Submitter:</strong> {$submitter_name} ({$submitter_email}, {$submitter_contact})</p>
    ";

    $mail->Body = $mailBody;

    if (!$mail->send()) {
        $_SESSION['flash_error'] = "Report submitted but failed to send email notification.";
    } else {
        $_SESSION['flash_message'] = "Community report submitted successfully!";
    }

    echo "<script>alert('Report submitted successfully!'); window.location.href='community_reports.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Resident Dashboard</title>
  <script src="https://cdn.tailwindcss.com "></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#1e3a8a',
            secondary: '#10b981',
            accent: '#f59e0b'
          }
        }
      }
    };
  </script>
  <style>
    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 16rem;
      overflow-y: auto;
      z-index: 50;
    }
    #main-content {
      margin-left: 16rem;
      height: 100vh;
      overflow-y: auto;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-700 via-white to-blue-500">

<!-- Sidebar -->
<div id="sidebar">
  <?php include 'sidebar.php'; ?>
</div>

<!-- Main Content -->
<div id="main-content" class="p-8">
  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold text-white">Community Reports</h1>
  </div>

  <!-- Submit Report Form -->
  <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow mb-8">
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium">Uri ng Report</label>
        <input type="text" name="report_type" class="w-full border p-2 rounded" required />
      </div>
      <div>
        <label class="block text-sm font-medium">Category</label>
        <select name="category" class="w-full border p-2 rounded" required>
          <option value="">Papilian</option>
          <option>Health & Sanitation</option>
          <option>Peace & Order</option>
          <option>Infrastructure</option>
          <option>Social Services</option>
          <option>Environmental</option>
          <option>Disaster</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Priority Level</label>
        <select name="priority_level" class="w-full border p-2 rounded" required>
          <option value="">Papilian</option>
          <option>Low</option>
          <option>Medium</option>
          <option>High</option>
          <option>Urgent</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Lokasyon</label>
        <input type="text" name="location" class="w-full border p-2 rounded" required />
      </div>
      <div class="col-span-2">
        <label class="block text-sm font-medium">Pamagat</label>
        <input type="text" name="title" class="w-full border p-2 rounded" required />
      </div>
      <div class="col-span-2">
        <label class="block text-sm font-medium">Buong Deskripsyon</label>
        <textarea name="description" rows="4" class="w-full border p-2 rounded"></textarea>
      </div>

      <!-- Evidence Upload -->
      <div class="col-span-2">
        <label class="block text-sm font-medium">Ebidensya (Image or Video, Max: 10MB for Image, 50MB for Video)</label>
        <input type="file" name="evidence" class="w-full border p-2 rounded" accept="image/*,video/*" />
      </div>

      <!-- New Fields -->
      <div class="col-span-2">
        <label class="block text-sm font-medium">Pangalan ng Nagsumite</label>
        <input type="text" name="submitter_name" class="w-full border p-2 rounded" required />
      </div>
      <div class="col-span-2">
        <label class="block text-sm font-medium">Email Address</label>
        <input type="email" name="submitter_email" class="w-full border p-2 rounded" required />
      </div>
      <div class="col-span-2">
        <label class="block text-sm font-medium">Contact Number</label>
        <input type="text" name="submitter_contact" class="w-full border p-2 rounded" required />
      </div>
      <!-- End of New Fields -->

      <div class="col-span-2">
        <button type="submit" name="submit_report" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-800">
          Isumite ang Report
        </button>
      </div>
    </div>
  </form>

  <!-- Display User's Reports -->
  <h2 class="text-2xl font-semibold text-white mb-4">Mga Naisumiteng Ulat</h2>
  <?php
  $user_id = $_SESSION['user_id'];
  $result = $conn->query("SELECT * FROM community_reports WHERE user_id = $user_id ORDER BY created_at DESC");

  if ($result->num_rows === 0) {
    echo '<p class="text-gray-700">Wala pang ulat na naisumite.</p>';
  } else {
    echo '<div class="space-y-6">';
    while ($row = $result->fetch_assoc()) {
      echo '<div class="bg-white p-6 rounded shadow">';
      echo "<h3 class='text-xl font-bold'>{$row['title']}</h3>";
      echo "<p><strong>Status:</strong> {$row['status']}</p>";
      echo "<p><strong>Lokasyon:</strong> {$row['location']}</p>";
      echo "<p><strong>Kategorya:</strong> {$row['category']}</p>";

      // Display Submitter Info
      echo "<p><strong>Pangalan:</strong> {$row['submitter_name']}</p>";
      echo "<p><strong>Email:</strong> {$row['submitter_email']}</p>";
      echo "<p><strong>Contact:</strong> {$row['submitter_contact']}</p>";

      echo "<p><strong>Petsa:</strong> " . date("F j, Y, g:i a", strtotime($row['created_at'])) . "</p>";

      // Display Evidence
      if (!empty($row['evidence'])) {
          $ext = strtolower(pathinfo($row['evidence'], PATHINFO_EXTENSION));
          if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
              echo "<img src='{$row['evidence']}' class='mt-4 max-h-64 rounded' />";
          } elseif (in_array($ext, ['mp4', 'mov', 'avi'])) {
              echo "<video src='{$row['evidence']}' controls class='mt-4 max-h-64 rounded'></video>";
          }
      }

      echo '</div>';
    }
    echo '</div>';
  }
  ?>
</div>

</body>
</html>