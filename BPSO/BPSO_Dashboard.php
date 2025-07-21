<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'BPSO') {
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost:3307", "root", "", "barangay_management_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Administrator Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <?php include 'BPSO_Sidebar.php'; ?>
</div>

<!-- Main Content -->
<div id="main-content" class="p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white">Barangay Peace and Order Office Dashboard</h1>
    </div>

    
</div>

</body>
</html>
