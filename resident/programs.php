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

// Fetch all program images
$sql = "SELECT image_path FROM programs ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
$images = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['image_path'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Resident Dashboard</title>
  <script src="https://cdn.tailwindcss.com "></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js "></script>
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
    <h1 class="text-3xl font-bold text-white">Programs </h1>
  </div>

  <!-- Display Committee Images -->
  <div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-semibold text-primary mb-6">Barangay Programs</h2>

    <?php if (!empty($images)): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <?php foreach ($images as $imagePath): ?>
          <div class="w-full">
            <img src="../admin/programs/<?php echo basename($imagePath); ?>" 
                 alt="Program Image"
                 class="w-full h-auto object-cover rounded-lg shadow-md">
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-600">No program images uploaded yet.</p>
    <?php endif; ?>
  </div>

</div>

</body>
</html>