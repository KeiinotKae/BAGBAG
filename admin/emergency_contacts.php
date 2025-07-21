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

// Handle multiple image upload
if (isset($_POST['upload_image']) && isset($_FILES['emergency_contacts'])) {
    $uploadDir = "emergency_contacts/";
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $fileCount = count($_FILES['emergency_contacts']['name']);

    for ($i = 0; $i < $fileCount; $i++) {
        $tmpName = $_FILES['emergency_contacts']['tmp_name'][$i];
        if (!$tmpName) continue;

        $fileName = basename($_FILES['emergency_contacts']['name'][$i]);
        $uploadFile = $uploadDir . $fileName;
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        // Check if image
        $check = getimagesize($tmpName);
        if ($check === false) {
            echo "<script>alert('File $fileName is not an image.');</script>";
            continue;
        }

        // Check file type
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "<script>alert('$fileName: Only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            continue;
        }

        // Move file
        if (move_uploaded_file($tmpName, $uploadFile)) {
            $stmt = $conn->prepare("INSERT INTO emergency_contacts (image_path) VALUES (?)");
            $stmt->bind_param("s", $uploadFile);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "<script>alert('Error uploading $fileName.');</script>";
        }
    }

    echo "<script>alert('Images uploaded successfully.'); window.location.href='';</script>";
}

// Handle delete image
if (isset($_GET['delete_image'])) {
    $id = $_GET['delete_image'];
    $stmt = $conn->prepare("SELECT image_path FROM emergency_contacts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();

    if (!empty($imagePath) && file_exists($imagePath)) {
        unlink($imagePath);
    }

    $stmt = $conn->prepare("DELETE FROM emergency_contacts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Image deleted successfully.'); window.location.href='';</script>";
}

// Fetch all images
$sql = "SELECT id, image_path FROM emergency_contacts ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Administrator Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <?php include 'admin_sidebar.php'; ?>
</div>

<!-- Main Content -->
<div id="main-content" class="p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white">Upload Committee Images</h1>
    </div>

    <!-- Image Upload Form -->
    <form action="" method="post" enctype="multipart/form-data" class="mb-6">
        <label class="block mb-2 text-white font-semibold">Upload Committee Images:</label>
        <input type="file" name="emergency_contacts[]" multiple accept="image/*" required
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600">
        <button type="submit" name="upload_image"
            class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Upload Images
        </button>
    </form>

    <!-- Display Uploaded Images -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <h2 class="text-2xl font-semibold text-white mb-4 col-span-full">Committee Images</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="relative group">
                    <img src="<?= $row['image_path'] ?>" alt="Committee Image" class="w-full h-auto rounded shadow-md">
                    <a href="?delete_image=<?= $row['id'] ?>" 
                       onclick="return confirm('Are you sure you want to delete this image?')"
                       class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 bg-red-600 text-white px-2 py-1 rounded text-sm hover:bg-red-700 transition-opacity">
                        Delete
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-gray-200">No images uploaded yet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>