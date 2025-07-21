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
    <?php include 'admin_sidebar.php'; ?>
</div>

<!-- Main Content -->
<div id="main-content" class="p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white">Administrator Dashboard</h1>
    </div>

    <!-- User Tables with Charts -->
    <?php
    $roles = ['Official', 'Resident', 'Staff', 'BPSO'];
    foreach ($roles as $role):
        $sql = "SELECT id, full_name, email, role, created_at, status FROM users WHERE role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $role);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        $status_count = ['approved' => 0, 'pending' => 0, 'rejected' => 0];

        while ($user = $result->fetch_assoc()) {
            $users[] = $user;
            $status = strtolower($user['status']);
            if (isset($status_count[$status])) {
                $status_count[$status]++;
            }
        }
    ?>

    <div class="bg-white shadow-md rounded-lg p-4 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4"><?= $role ?> Accounts</h2>

        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Table Section -->
            <div class="w-full lg:w-2/3">
                <?php if (count($users) > 0): ?>
                    <table class="min-w-full table-auto border border-gray-200 rounded-md overflow-hidden">
                        <thead class="bg-blue-100 text-blue-800">
                            <tr>
                                <th class="px-4 py-2 text-left">Full Name</th>
                                <th class="px-4 py-2 text-left">Email</th>
                                <th class="px-4 py-2 text-left">Role</th>
                                <th class="px-4 py-2 text-left">Created At</th>
                                <th class="px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr class="border-t even:bg-gray-50">
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['full_name']) ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['role']) ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['created_at']) ?></td>
                                    <td class="px-4 py-2 font-semibold
                                        <?= strtolower($user['status']) === 'approved' ? 'text-green-600' : (
                                             strtolower($user['status']) === 'rejected' ? 'text-red-600' : 'text-yellow-600'
                                        ) ?>">
                                        <?= htmlspecialchars(ucfirst($user['status'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-gray-500">No <?= strtolower($role) ?> accounts yet.</p>
                <?php endif; ?>
            </div>

            <!-- Pie Chart Section -->
            <div class="w-full lg:w-1/3 flex justify-center items-center">
                <canvas id="<?= strtolower($role) ?>Chart" width="250" height="250"></canvas>
                <script>
                    const <?= strtolower($role) ?>ChartCtx = document.getElementById('<?= strtolower($role) ?>Chart').getContext('2d');
                    new Chart(<?= strtolower($role) ?>ChartCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Approved', 'Pending'],
                            datasets: [{
                                data: [<?= $status_count['approved'] ?>, <?= $status_count['pending'] ?>],
                                backgroundColor: ['#10b981', '#f59e0b']
                            }]
                        },
                        options: {
                            responsive: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                title: {
                                    display: true,
                                    text: '<?= $role ?> Status Breakdown'
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
       <!-- Button Below -->
<div class="mt-4 text-right">
    <button 
        onclick="document.getElementById('modal-<?= strtolower($role) ?>').classList.remove('hidden')"
        class="inline-block bg-blue-700 text-white px-5 py-2 rounded-md hover:bg-blue-800 transition-all duration-200">
        Add <?= $role ?> Account
    </button>
</div>

    </div>

    <?php endforeach; ?>

    <?php foreach ($roles as $role): ?>
<!-- Modal for <?= $role ?> -->
<div id="modal-<?= strtolower($role) ?>" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white p-6 rounded-lg w-full max-w-2xl relative">
    <button class="absolute top-2 right-2 text-gray-600" onclick="document.getElementById('modal-<?= strtolower($role) ?>').classList.add('hidden')">&times;</button>
    <h3 class="text-xl font-bold mb-4">Add <?= $role ?> Account</h3>
    <form action="add_user_role.php" method="POST">

      
      <!-- Common User Fields -->
      <input type="hidden" name="role" value="<?= $role ?>">
      <input type="hidden" name="status" value="approved">
      
      <div class="grid grid-cols-2 gap-4">
        <input name="full_name" type="text" placeholder="Full Name" class="border p-2 rounded w-full" required>
        <input name="email" type="email" placeholder="Email" class="border p-2 rounded w-full" required>
        <input name="password" type="password" placeholder="Password" class="border p-2 rounded w-full" required>
      </div>

      <!-- Dynamic Fields per Role -->
      <?php if ($role === 'Official'): ?>
        <div class="grid grid-cols-2 gap-4">
          <input name="dob" type="date" placeholder="Date of Birth" class="border p-2 rounded w-full" required>
          <input name="pob" type="text" placeholder="Place of Birth" class="border p-2 rounded w-full">
          <input name="age" type="number" placeholder="Age" class="border p-2 rounded w-full">
          <select name="gender" class="border p-2 rounded w-full">
            <option>Male</option><option>Female</option>
          </select>
          <input name="civil_status" type="text" placeholder="Civil Status" class="border p-2 rounded w-full">
          <input name="nationality" type="text" placeholder="Nationality" class="border p-2 rounded w-full">
          <input name="religion" type="text" placeholder="Religion" class="border p-2 rounded w-full">
          <input name="position" type="text" placeholder="Position" class="border p-2 rounded w-full">
          <input name="term_start" type="date" class="border p-2 rounded w-full">
          <input name="term_end" type="date" class="border p-2 rounded w-full">
          <input name="address" type="text" placeholder="Address" class="border p-2 rounded w-full">
          <input name="phone" type="text" placeholder="Phone" class="border p-2 rounded w-full">
          <input name="email_off" type="email" placeholder="Official Email" class="border p-2 rounded w-full">
        </div>
      <?php elseif ($role === 'Staff'): ?>
        <div class="grid grid-cols-2 gap-4">
          <input name="address" type="text" placeholder="Address" class="border p-2 rounded w-full">
          <input name="phone" type="text" placeholder="Phone" class="border p-2 rounded w-full">
          <input name="email" type="email" placeholder="Email" class="border p-2 rounded w-full">
          <input name="position" type="text" placeholder="Position" class="border p-2 rounded w-full">
          <input name="date_started" type="date" class="border p-2 rounded w-full">
        </div>
      <?php elseif ($role === 'BPSO'): ?>
        <div class="grid grid-cols-2 gap-4">
          <input name="address" type="text" placeholder="Address" class="border p-2 rounded w-full">
          <input name="phone" type="text" placeholder="Phone" class="border p-2 rounded w-full">
          <input name="email" type="email" placeholder="Email" class="border p-2 rounded w-full">
          <input name="position" type="text" placeholder="Position" class="border p-2 rounded w-full">
          <input name="date_started" type="date" class="border p-2 rounded w-full">
        </div>
      <?php endif; ?>

      <div class="text-right mt-4">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>

</div>

</body>
</html>
