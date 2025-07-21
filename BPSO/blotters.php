<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'BPSO') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost:3307", "root", "", "barangay_management_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_id'], $_POST['status'])) {
    $report_id = intval($_POST['report_id']);
    $status = $conn->real_escape_string($_POST['status']);

    $update_sql = "UPDATE blotter_reports SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $status, $report_id);
    $stmt->execute();
    $stmt->close();

    echo "<script>window.location.href='blotters.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Barangay Officials Dashboard</title>
  <script src="https://cdn.tailwindcss.com "></script>
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
    @media print {
      body * { visibility: hidden; }
      #printArea, #printArea * { visibility: visible; }
      #printArea { position: absolute; top: 0; left: 0; width: 100%; padding: 40px; }
    }
  </style>
</head>
<body class="flex min-h-screen bg-gradient-to-br from-blue-700 via-white to-blue-500">

<?php include 'BPSO_Sidebar.php'; ?>

<div class="flex-1 p-8 overflow-y-auto">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold text-white">Blotters & Reports</h1>
  </div>

  <div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Submitted Blotter Reports</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Complainant</th>
            <th class="px-4 py-2 text-left">Reklamo</th>
            <th class="px-4 py-2 text-left">Petsa</th>
            <th class="px-4 py-2 text-left">Status</th>
            <th class="px-4 py-2 text-left">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM blotter_reports ORDER BY date_reported DESC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
              $preview = strlen($row['incident_details']) > 100 ? substr($row['incident_details'], 0, 100) . "..." : $row['incident_details'];
          ?>
            <tr class="border-t hover:bg-gray-50">
              <td class="px-4 py-2"><?= htmlspecialchars($row['complainant_name']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($preview) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars(date("F j, Y", strtotime($row['date_reported']))) ?></td>
              <td class="px-4 py-2">
                <form method="post" class="inline">
                  <input type="hidden" name="report_id" value="<?= $row['id'] ?>">
                  <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                    <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Ongoing" <?= $row['status'] === 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                    <option value="Resolved" <?= $row['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                  </select>
                </form>
              </td>
              <td class="px-4 py-2">

              <a href="view_blotter.php?id=<?= $row['id'] ?>" 
   class="text-blue-600 hover:underline flex items-center gap-1" 
   target="_blank" 
   title="Open in new tab">
   View Details 📄
</a>
</td>
            </tr>
          <?php endwhile; else: ?>
            <tr>
              <td colspan="5" class="px-4 py-4 text-center text-gray-500">No blotter reports found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->

</div>

<!-- jspdf CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js "></script>

<script>
function openModal(data) {
  const modal = document.getElementById("blotterModal");
  const box = document.getElementById("modalBox");

  const content = `
    <div class="text-center mb-6 border-b pb-4">
      <img src="https://via.placeholder.com/100 " alt="Barangay Logo" class="mx-auto w-20 h-20 mb-2">
      <h1 class="text-2xl font-bold uppercase">Republic of the Philippines</h1>
      <h2 class="text-xl font-semibold">Province of Rizal</h2>
      <h3 class="text-xl font-semibold">Municipality of Taytay</h3>
      <h4 class="text-xl font-semibold">Barangay San Isidro Labrador</h4>
      <h5 class="text-xl font-semibold mt-4">Blotter Report</h5>
    </div>
    <div class="mt-6">
      <p><strong>Complainant:</strong> ${data.complainant_name}</p>
      <p><strong>Accused:</strong> ${data.accused_name}</p>
      <p><strong>Date Reported:</strong> ${new Date(data.date_reported).toLocaleDateString()}</p>
      <p><strong>Status:</strong> ${data.status}</p>
      <hr class="my-4">
      <p class="font-semibold">Incident Details:</p>
      <div class="border border-gray-300 p-4 rounded whitespace-pre-wrap text-justify bg-gray-50">${data.incident_details}</div>
    </div>
    <div class="mt-8 text-right text-sm text-gray-600">
      <p>Prepared by: Barangay Official</p>
      <p>Date: ${new Date().toLocaleDateString()}</p>
    </div>
  `;

  document.getElementById("printArea").innerHTML = content;
  modal.classList.remove("hidden");

  // Trigger animation
  requestAnimationFrame(() => {
    box.classList.remove("scale-95", "opacity-0");
    box.classList.add("scale-100", "opacity-100");
  });
}

function closeModal() {
  const modal = document.getElementById("blotterModal");
  const box = document.getElementById("modalBox");

  box.classList.remove("scale-100", "opacity-100");
  box.classList.add("scale-95", "opacity-0");

  setTimeout(() => {
    modal.classList.add("hidden");
  }, 200);
}

function downloadPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF('p', 'pt', 'a4');
  doc.html(document.getElementById("printArea"), {
    callback: function (doc) {
      doc.save('Blotter_Report.pdf');
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