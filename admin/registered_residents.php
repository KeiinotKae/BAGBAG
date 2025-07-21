<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost:3307", "root", "", "barangay_management_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all residents
$sql = "SELECT * FROM registered_residents";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Administrator Dashboard</title>
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

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background-color: white;
        padding: 2rem;
        border-radius: 0.5rem;
        max-width: 600px;
        width: 90%;
        max-height: 90vh; /* Limit height */
        overflow-y: auto; /* Enable scrolling */
        position: relative;
    }
</style>
</head>
<body class="bg-gradient-to-br from-blue-700 via-white to-blue-500">

<!-- Sidebar -->
<div id="sidebar">
    <?php include 'admin_sidebar.php'; ?>
</div>

<!-- Main Content -->
<div id="main-content" class="p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white">Registered Resident List</h1>
        <button onclick="openModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition">+ Add Resident</button>
    </div>

    <!-- Residents Table -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-800 text-white">
                <tr>
    <th class="px-6 py-3 text-left text-sm uppercase">Full Name</th>
    <th class="px-6 py-3 text-left text-sm uppercase">Nationality</th>
    <th class="px-6 py-3 text-left text-sm uppercase">Gender</th>
    <th class="px-6 py-3 text-left text-sm uppercase">POB</th>
    <th class="px-6 py-3 text-left text-sm uppercase">DOB</th>
    <th class="px-6 py-3 text-left text-sm uppercase">Address</th>
    <th class="px-6 py-3 text-left text-sm uppercase">Phone</th>
    <th class="px-6 py-3 text-left text-sm uppercase">Valid ID</th>
    <th class="px-6 py-3 text-left text-sm uppercase">Registered On</th>
</tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Table Body -->
<?php while ($row = $result->fetch_assoc()): ?>
<tr class="hover:bg-gray-100">
    <td class="px-6 py-4"><?= htmlspecialchars($row['full_name']) ?></td>
    <td class="px-6 py-4"><?= htmlspecialchars($row['nationality']) ?></td>
    <td class="px-6 py-4"><?= htmlspecialchars($row['gender']) ?></td>
    <td class="px-6 py-4"><?= htmlspecialchars($row['pob']) ?></td>
    <td class="px-6 py-4"><?= htmlspecialchars($row['dob']) ?></td>
    <td class="px-6 py-4"><?= htmlspecialchars($row['current_address']) ?></td>
    <td class="px-6 py-4"><?= htmlspecialchars($row['phone']) ?></td>
    <td class="px-6 py-4">
        <?php if (!empty($row['valid_id'])): ?>
            <a href="<?= htmlspecialchars($row['valid_id']) ?>" target="_blank" class="text-blue-600 hover:underline">View File</a>
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
    <td class="px-6 py-4"><?= date("F j, Y g:i A", strtotime($row['created_at'])) ?></td>
</tr>
<?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div id="residentModal" class="modal">
    <div class="modal-content">
        <h2 class="text-2xl font-bold mb-4">Add New Resident</h2>
        <form action="add_resident.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
    <label class="block font-semibold text-gray-700">Full Name</label>
    <input type="text" name="full_name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>
<div>
    <label class="block font-semibold text-gray-700">Nationality</label>
    <input type="text" name="nationality" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>
<div>
    <label class="block font-semibold text-gray-700">Gender</label>
    <select name="gender" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Select</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>
</div>
            <div>
    <label class="block font-semibold text-gray-700">POB (Place of Birth)</label>
    <input type="text" name="pob" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>
<div>
    <label class="block font-semibold text-gray-700">DOB (Date of Birth)</label>
    <input type="date" name="dob" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>
            <div>
                <label class="block font-semibold text-gray-700">Current Address</label>
                <textarea name="current_address" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Civil Status</label>
                <select name="civil_status" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                    <option value="Divorced">Divorced</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Employment Status</label>
                <input type="text" name="employment_status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Religion</label>
                <input type="text" name="religion" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
    <label class="block font-semibold text-gray-700">Phone</label>
    <input type="text" name="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>
            <div>
                <label class="block font-semibold text-gray-700">Email Address</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Family Members</label>
                <textarea name="family_members" placeholder="e.g. Maria Dela Cruz (Spouse), Ana Dela Cruz (Daughter)" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div>
    <label class="block font-semibold text-gray-700">Valid ID File</label>
    <input type="file" name="valid_id" accept="image/*,.pdf" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    <small class="text-gray-500 mt-1">Accepted formats: JPG, PNG, PDF</small>
</div>
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Resident</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('residentModal').classList.add('show');
}
function closeModal() {
    document.getElementById('residentModal').classList.remove('show');
}
</script>

</body>
</html>