<?php
session_start();
include("../conn.php");

if (!isset($_SESSION['lawyer_id'])) {
    header("Location: lawyerSignin.php");
    exit();
}

$lawyer_id = $_SESSION['lawyer_id'];
$query = "SELECT * FROM lawyer WHERE u_id = $lawyer_id";
$result = mysqli_query($conn, $query);
$lawyer = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Lawyer Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-blue-100 via-white to-purple-100 min-h-screen px-4 py-10 relative overflow-hidden">

<!-- Decorative circles -->
<div class="absolute top-0 right-0 w-40 h-40 bg-indigo-200 rounded-full opacity-30 blur-3xl animate-pulse"></div>
<div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-200 rounded-full opacity-30 blur-3xl animate-pulse"></div>

<div class="max-w-3xl mx-auto bg-white/90 backdrop-blur p-8 rounded-2xl shadow-xl border border-gray-200 z-10 relative">
  <h2 class="text-3xl font-bold text-center text-indigo-700 mb-8">👨‍⚖ My Profile</h2>

  <?php if ($lawyer): ?>
    <!-- ✅ Buttons Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
      <a href="lawyer_profile_update.php"
         class="text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg shadow transition font-medium">
        ✏ Update Profile
      </a>
      <a href="index.php"
         class="text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-2.5 rounded-lg shadow transition font-medium">
        ⬅ Back to Homepage
      </a>
      <a href="lawyer_dashboard.php"
         class="text-center bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg shadow transition font-medium">
        🧭 Go to Dashboard
      </a>
    </div>

    <!-- ✅ Profile Info -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
      <div class="flex items-center space-x-6">
        <img src="<?= file_exists('uploads/' . $lawyer['p_img']) ? 'uploads/' . htmlspecialchars($lawyer['p_img']) : 'uploads/default.jpg' ?>" 
             alt="Profile Image"
             class="w-28 h-28 rounded-full object-cover border-4 border-indigo-500 shadow-lg transition hover:scale-105 duration-200" />
        <div>
          <h3 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($lawyer['u_name']) ?></h3>
          <p class="text-gray-600"><?= htmlspecialchars($lawyer['u_email']) ?></p>
          <span class="inline-block mt-1 text-sm bg-indigo-100 text-indigo-700 font-semibold px-3 py-1 rounded-full">
            🏷 <?= htmlspecialchars($lawyer['specialization'] ?? 'Not Set') ?>
          </span>
        </div>
      </div>
    </div>

    <!-- ✅ Password Reveal -->
    <div class="mt-10 space-y-4 bg-gray-50 p-6 rounded-lg shadow-inner">
      <div class="flex items-center">
        <span class="font-semibold text-gray-700 mr-2">Password:</span>
        <span id="maskedPassword" class="text-gray-800 font-mono tracking-wider"><?= str_repeat("*", strlen($lawyer['u_pass'])) ?></span>
        <span id="actualPassword" class="hidden text-gray-800 font-mono tracking-wider"><?= htmlspecialchars($lawyer['u_pass']) ?></span>
        <button onclick="togglePassword()" class="ml-3 text-indigo-600 hover:text-indigo-800 transition text-lg">
          👁
        </button>
      </div>
    </div>

    <?php if (isset($_GET['updated'])): ?>
      <p class="mt-4 text-green-600 text-center font-semibold">✅ Profile updated successfully!</p>
    <?php endif; ?>

  <?php else: ?>
    <p class="text-red-500 text-center font-semibold">⚠ Profile not found. Please contact support.</p>
  <?php endif; ?>
</div>

<!-- Password toggle script -->
<script>
  function togglePassword() {
    const masked = document.getElementById('maskedPassword');
    const actual = document.getElementById('actualPassword');
    if (masked.classList.contains('hidden')) {
      masked.classList.remove('hidden');
      actual.classList.add('hidden');
    } else {
      masked.classList.add('hidden');
      actual.classList.remove('hidden');
    }
  }
</script>

</body>
</html>