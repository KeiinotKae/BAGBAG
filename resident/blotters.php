<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Resident') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost:3307", "root", "", "barangay_management_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Kunin ang full name mula sa users table
$sql = "SELECT full_name FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($complainant_name);
$stmt->fetch();
$stmt->close();

$has_existing_report = false;

// Check kung may existing blotter report (Pending or Ongoing)
$sql_check = "SELECT id FROM blotter_reports WHERE residents_id = ? AND status IN ('Pending', 'Ongoing')";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $user_id);
$stmt_check->execute();
$stmt_check->store_result();
if ($stmt_check->num_rows > 0) {
    $has_existing_report = true;
}
$stmt_check->close();

// ✅ Only process form if it's submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$has_existing_report) {
    // Collect form data
    $accused_name = $conn->real_escape_string($_POST['accused_name']);
    $accused_address = $conn->real_escape_string($_POST['accused_address']);
    $accused_contact = $conn->real_escape_string($_POST['accused_contact']);
    $complaint_type = $conn->real_escape_string($_POST['complaint_type']);
    $incident_date = $conn->real_escape_string($_POST['incident_date']);
    $incident_time = $conn->real_escape_string($_POST['incident_time']);
    $incident_location = $conn->real_escape_string($_POST['incident_location']);
    $incident_details = $conn->real_escape_string($_POST['incident_details']);
    $date_reported = date('Y-m-d H:i:s');

    // Insert blotter report
    $sql = "INSERT INTO blotter_reports (
        residents_id, complainant_name, complainant_address, complainant_contact,
        accused_name, accused_address, accused_contact,
        complaint_type, incident_date, incident_time, incident_location,
        incident_details, status, date_reported
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "issssssssssss",
        $user_id, $complainant_name, $complainant_address, $complainant_contact,
        $accused_name, $accused_address, $accused_contact,
        $complaint_type, $incident_date, $incident_time, $incident_location,
        $incident_details, $date_reported
    );

    if ($stmt->execute()) {

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

        $mail->setFrom('barangaybagbagmanagementsystem@gmail.com', 'Resident of Barangay Bagbag');
        $mail->addAddress('barangaybagbagmanagementsystem@gmail.com'); // Papunta kay BPSO
        $mail->isHTML(true);
        $mail->Subject = 'New Blotter Report Submitted';

        $mailBody = "
            <h2>New Blotter Report</h2>
            <p><strong>Complainant:</strong> {$complainant_name}</p>
            <p><strong>Accused:</strong> {$accused_name}</p>
            <p><strong>Date:</strong> {$incident_date}</p>
            <p><strong>Time:</strong> {$incident_time}</p>
            <p><strong>Location:</strong> {$incident_location}</p>
            <p><strong>Details:</strong><br>" . nl2br(htmlspecialchars($incident_details)) . "</p>
        ";

        $mail->Body = $mailBody;

        if (!$mail->send()) {
            $_SESSION['flash_error'] = "Blotter submitted but failed to send email notification.";
        } else {
            $_SESSION['flash_message'] = "Blotter report submitted successfully!";
        }

        header("Location: blotters.php");
        exit();

    } else {
        $_SESSION['flash_error'] = "Error submitting report: " . $conn->error;
        header("Location: blotters.php");
        exit();
    }
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
    #sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 16rem; overflow-y: auto; z-index: 50; }
    #main-content { margin-left: 16rem; height: 100vh; overflow-y: auto; }
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
    <h1 class="text-3xl font-bold text-white">Blotter & Reports</h1>
    <div class="relative">
      <button class="relative focus:outline-none">
        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M15 17h5l-1.405-1.405A2 2 0 0118 14V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C8.67 6.165 8 7.388 8 9v5c0 .386-.149.735-.405 1.001L6 17h5m4 0v1a2 2 0 11-4 0v-1m4 0H9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="absolute top-0 right-0 inline-flex w-2 h-2 bg-red-500 rounded-full"></span>
      </button>
    </div>
  </div>

  <!-- Blotter Report Form -->
  <div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <?php if ($has_existing_report): ?>
      <h2 class="text-xl font-semibold mb-4 text-red-600">Existing Blotter Report</h2>
      <p class="text-gray-700 mb-4">You already have a pending or ongoing blotter report. Please wait for the barangay to resolve it before submitting a new one.</p>
    <?php else: ?>
      <h2 class="text-xl font-semibold mb-4">Submit Blotter Report</h2>
      <form method="post">
        <!-- Part A: Complainant Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="complainant_name" class="block text-gray-700 font-medium mb-2">A.1 Complainant Name</label>
            <input type="text" name="complainant_name" id="complainant_name"
                   value="<?= htmlspecialchars($complainant_name); ?>"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" readonly>
          </div>
        </div>

        <!-- Part B: Accused Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="accused_name" class="block text-gray-700 font-medium mb-2">B.1 Accused Name</label>
            <input type="text" name="accused_name" id="accused_name" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="accused_address" class="block text-gray-700 font-medium mb-2">B.2 Address</label>
            <input type="text" name="accused_address" id="accused_address" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="accused_contact" class="block text-gray-700 font-medium mb-2">B.3 Contact Number</label>
            <input type="text" name="accused_contact" id="accused_contact" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
        </div>

        <!-- Part C: Incident Type -->
        <div class="mb-4">
          <label for="complaint_type" class="block text-gray-700 font-medium mb-2">C. Type of Complaint</label>
          <select name="complaint_type" id="complaint_type" required
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            <option value="">-- Select Type --</option>
            <option value="Theft">Theft</option>
            <option value="Harassment">Harassment</option>
            <option value="Noise Complaint">Noise Complaint</option>
            <option value="Property Damage">Property Damage</option>
            <option value="Others">Others</option>
          </select>
        </div>

        <!-- Part D: Incident Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="incident_date" class="block text-gray-700 font-medium mb-2">D.1 Date of Incident</label>
            <input type="date" name="incident_date" id="incident_date" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="incident_time" class="block text-gray-700 font-medium mb-2">D.2 Time of Incident</label>
            <input type="time" name="incident_time" id="incident_time" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="incident_location" class="block text-gray-700 font-medium mb-2">D.3 Location of Incident</label>
            <input type="text" name="incident_location" id="incident_location" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
        </div>

        <!-- Part E: Narrative -->
        <div class="mb-4">
          <label for="incident_details" class="block text-gray-700 font-medium mb-2">E. Salaysay ng Pangyayari</label>
          <textarea name="incident_details" id="incident_details" rows="5"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required></textarea>
        </div>

        <button type="submit"
                class="px-4 py-2 bg-primary text-white rounded hover:bg-blue-800 transition duration-200">
          Isumite ang Reklamo
        </button>
      </form>
    <?php endif; ?>
  </div>

  <!-- Table of Submitted Reports -->
  <div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Your Submitted Reports</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full table-auto">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Report Date</th>
            <th class="px-4 py-2 text-left">Details</th>
            <th class="px-4 py-2 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM blotter_reports WHERE residents_id = '$user_id' ORDER BY date_reported DESC";
          $result = $conn->query($sql);
          if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
              $preview = strlen($row['incident_details']) > 100 ? substr($row['incident_details'], 0, 100) . "..." : $row['incident_details'];
          ?>
            <tr class="border-t hover:bg-gray-50">
              <td class="px-4 py-2"><?= htmlspecialchars(date("F j, Y", strtotime($row['date_reported']))) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($preview) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row['status']) ?></td>
            </tr>
          <?php endwhile; else: ?>
            <tr>
              <td colspan="3" class="px-4 py-4 text-center text-gray-500">No reports found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>