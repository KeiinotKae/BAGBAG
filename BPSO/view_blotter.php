<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'BPSO') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid blotter ID.");
}

$report_id = intval($_GET['id']);

$conn = new mysqli("localhost:3307", "root", "", "barangay_management_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM blotter_reports WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Blotter report not found.");
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Barangay Blotter Report</title>
  <script src="https://cdn.tailwindcss.com "></script>
  <style>
    @media print {
      body * { visibility: hidden; }
      #printArea, #printArea * { visibility: visible; }
      #printArea { position: absolute; top: 0; left: 0; width: 100%; padding: 40px; }
    }
  </style>
</head>
<body class="bg-white p-8">

  <div id="printArea" class="prose max-w-none p-8 mx-auto w-full max-w-screen-md">
    <div class="text-center mb-6">
      <img src="../images/Gaid.png" alt="Barangay Logo" class="mx-auto w-20 h-20 mb-2">
      <h1 class="text-2xl font-bold uppercase">Republic of the Philippines</h1>
      <h2 class="text-xl font-semibold">National Capital Region (NCR) </h2>
      <h3 class="text-xl font-semibold">Municipality of Quezon City</h3>
      <h4 class="text-xl font-semibold">Barangay Bagbag </h4>
      <h5 class="text-xl font-semibold mt-4">Blotter Report</h5>
    </div>

    <div class="mt-6">
      <p><strong>Complainant:</strong> <?= htmlspecialchars($row['complainant_name']) ?></p>
      <p><strong>Accused:</strong> <?= htmlspecialchars($row['accused_name']) ?></p>
      <p><strong>Date Reported:</strong> <?= date("F j, Y", strtotime($row['date_reported'])) ?></p>
      <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
      <hr class="my-4">
      <p class="font-semibold">Incident Details:</p>
      <div class="p-4 whitespace-pre-wrap text-justify">
        <?= htmlspecialchars($row['incident_details']) ?>
      </div>
    </div>

    <div class="mt-8 text-right text-sm text-gray-600">
      <p>Prepared by: Barangay Official</p>
      <p>Date: <?= date("F j, Y") ?></p>
    </div>
  </div>

  <div class="mt-6 flex justify-end space-x-2 print:hidden">
    <button onclick="window.print()" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded shadow">🖨️ Print</button>
    <button onclick="downloadPDF()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">⬇️ Download PDF</button>
  </div>

  <!-- jspdf CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js "></script>
  <script>
    function downloadPDF() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF('p', 'pt', 'a4');
      doc.html(document.getElementById("printArea"), {
        callback: function (doc) {
          doc.save('Blotter_Report_<?= $row['id'] ?>.pdf');
        },
        x: 20,
        y: 20,
        html2canvasOptions: {
          scale: 2
        }
      });
    }
  </script>

</body>
</html>