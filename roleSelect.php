<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Role</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-6 relative">

  <!-- Close Button with Alert -->
  <button onclick="handleCancel()" class="absolute top-6 right-6 text-blue-600 hover:text-blue-800 text-2xl font-bold" title="Cancel & Return">
    &times;
  </button>

  <div class="max-w-3xl w-full bg-blue-50 rounded-2xl shadow-xl p-10">
    <h1 class="text-3xl font-bold text-center text-blue-700 mb-10">Select Your Role</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
      <!-- User Option -->
      <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-300">
        <h2 class="text-2xl font-semibold text-blue-600 mb-4 text-center">I'm a User</h2>
        <p class="text-gray-600 text-center mb-6">Continue as a client seeking legal help.</p>
        <div class="flex justify-center">
          <a href="users/index.php" class="group relative inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg transition duration-300 hover:bg-blue-700 hover:shadow-lg">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all">👉</span>
            <span class="transition-all group-hover:translate-x-2">Continue</span>
          </a>
        </div>
      </div>

      <!-- Lawyer Option -->
      <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-300">
        <h2 class="text-2xl font-semibold text-blue-600 mb-4 text-center">I'm a Lawyer</h2>
        <p class="text-gray-600 text-center mb-6">Continue as a legal service provider.</p>
        <div class="flex justify-center">
          <a href="lawyers/index.php" class="group relative inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg transition duration-300 hover:bg-blue-700 hover:shadow-lg">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all">⚖️</span>
            <span class="transition-all group-hover:translate-x-2">Continue</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript Alert Handler -->
  <script>
    function handleCancel() {
      alert("To have a better experience of website please click the Get Started button.");
      window.location.href = "index.php";
    }
  </script>
</body>
</html>
