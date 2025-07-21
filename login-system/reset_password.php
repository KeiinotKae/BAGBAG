<?php
$token = $_GET['token'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 via-white to-blue-300 p-6">
  <div class="bg-white/30 backdrop-blur-lg p-8 rounded-3xl shadow-xl w-full max-w-md">
    <h1 class="text-2xl font-bold text-center text-primary mb-6">Reset Your Password</h1>

    <form method="POST" action="process_reset_password.php" class="space-y-6">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

      <div>
  <label for="new_password" class="block mb-2 font-semibold text-gray-800">New Password</label>
  <input type="password" name="new_password" id="new_password" required
    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary"
    onkeyup="checkStrength(this.value)" />
  <progress id="strength-bar" value="0" max="5" class="w-full mt-2 h-2 bg-gray-200 rounded"></progress>
  <div id="strength-text" class="text-sm mt-1"></div>
</div>


      <div>
        <label for="confirm_password" class="block mb-2 font-semibold text-gray-800">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password" required
          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary" />
      </div>

      <button type="submit"
        class="w-full py-3 bg-primary text-white rounded-lg font-semibold hover:bg-blue-800 transition">
        Update Password
      </button>
    </form>
  </div>
</body>

<script>
function checkStrength(password) {
  let strengthBar = document.getElementById("strength-bar");
  let strengthText = document.getElementById("strength-text");
  let strength = 0;

  if (password.length > 5) strength++;
  if (/[A-Z]/.test(password)) strength++;
  if (/[0-9]/.test(password)) strength++;
  if (/[\W]/.test(password)) strength++;
  if (password.length > 10) strength++;

  strengthBar.value = strength;

  const messages = ["Very Weak", "Weak", "Fair", "Good", "Strong", "Very Strong"];
  strengthText.textContent = messages[strength];
  strengthText.className = "text-sm font-medium mt-1 " + (
    strength < 2 ? "text-red-500" :
    strength < 4 ? "text-yellow-500" :
    "text-green-600"
  );
}
</script>

</html>
