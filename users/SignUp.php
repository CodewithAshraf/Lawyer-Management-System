<?php
if (isset($_POST['button'])) {
    include('../conn.php');

    $name = $_POST['n'];
    $email = $_POST['e'];
    $pass = $_POST['p'];
    $cpass = $_POST['cp'];
    $phonenumber = $_POST['ph'];

    $in = $_FILES['img']['name'];
    $it = $_FILES['img']['tmp_name'];

    if ($pass !== $cpass) {
        echo "<script>alert('Passwords do not match'); window.history.back();</script>";
        exit();
    }

    // Hash the password securely
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    if (!is_dir("uploads")) {
        mkdir("uploads");
    }

    move_uploaded_file($it, 'uploads/' . $in);

    $sql = "INSERT INTO `users`(`username`, `email`, `ProfileImage`, `phone_number`, `password`,`c_pass`) VALUES 
    ('$name','$email','$in','$phonenumber','$pass','$cpass')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: Signin.php");
        exit();
    } else {
        echo "<script>alert('Signup failed: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Signup</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-blue-50 min-h-screen flex items-center justify-center px-4">

  <div class="bg-white shadow-2xl rounded-2xl w-full max-w-xl p-10 animate-fade-in border border-blue-200">
    <h2 class="text-4xl font-bold text-center text-blue-700 mb-8">🧑‍💼 Register as User</h2>

    

    <form method="POST" enctype="multipart/form-data" class="space-y-6">

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Username</label>
        <input type="text" name="n" placeholder="John Doe"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Profile Image</label>
        <input type="file" name="img" accept="image/*"
          class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition duration-150 ease-in-out" required>
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Email Address</label>
        <input type="email" name="e" placeholder="you@example.com"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Phone Number</label>
        <input type="tel" name="ph" placeholder="12345678901"
          pattern="[0-9]{11,15}" title="11-15 digit phone number"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Password</label>
        <input type="password" name="p" placeholder=""
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mt-4">
        <label class="block mb-1 font-semibold text-gray-700">Confirm Password</label>
        <input type="password" name="cp" placeholder=""
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
      </div>

      <!-- Password mismatch error message -->
      <div id="password-error" class="text-red-600 text-sm mt-2 hidden">
        Passwords do not match.
      </div>

      <div class="pt-4">
        <button type="submit" name="button"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-lg transition duration-200 ease-in-out">
          ✅ Sign Up
        </button>
      </div>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
      Already have an account?
      <a href="Signin.php" class="text-blue-600 font-medium hover:underline">Sign In</a>
    </p>
  </div>

  <style>
    .animate-fade-in {
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
  <script>
    const password = document.querySelector('input[name="p"]');
    const confirmPassword = document.querySelector('input[name="cp"]');
    const errorDiv = document.getElementById('password-error');
    const submitBtn = document.querySelector('button[name="button"]');

    function validatePassword() {
      if (confirmPassword.value !== password.value) {
        errorDiv.classList.remove('hidden');
        submitBtn.disabled = true;
      } else {
        errorDiv.classList.add('hidden');
        submitBtn.disabled = false;
      }
    }

    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);
  </script>
</body>
</html>
