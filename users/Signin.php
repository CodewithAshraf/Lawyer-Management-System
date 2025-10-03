<?php
session_start();
include("../conn.php");

if (isset($_POST['button'])) {
    $email = $_POST['email'];
    $password = $_POST['p'];

    $query = "SELECT * FROM `users` WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['user_name'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = 'user';

        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Invalid email or password'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Sign In</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <a href="index.php" class="absolute top-6 right-6 text-gray-400 hover:text-indigo-600 transition" title="Close">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <line x1="6" y1="6" x2="18" y2="18" stroke-width="2" stroke-linecap="round"/>
      <line x1="6" y1="18" x2="18" y2="6" stroke-width="2" stroke-linecap="round"/>
    </svg>
  </a>
  
</head>
<body class="bg-gradient-to-r from-green-100 via-blue-100 to-purple-100 min-h-screen flex items-center justify-center px-4">

  <div class="w-full max-w-md bg-white shadow-2xl rounded-xl p-8 animate-fade-in">
    <h2 class="text-3xl font-extrabold text-center text-indigo-700 mb-6">User Sign In</h2>

    

    <form method="POST" class="space-y-6" autocomplete="off">
      <div>
        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
        <input type="email" name="email" id="email" placeholder="you@example.com"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
      </div>

      <div>
        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
        <input type="password" name="p" id="password" placeholder="********"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
      </div>

      <div class="pt-2">
        <button type="submit" name="button"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition duration-200 ease-in-out shadow">
          Sign In
        </button>
      </div>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
      Don’t have an account?
      <a href="Signup.php" class="text-indigo-600 font-medium hover:underline">Sign up here</a>
    </p>
  </div>

  <!-- Fade animation -->
  <style>
    .animate-fade-in {
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>

</body>
</html>
