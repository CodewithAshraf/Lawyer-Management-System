<?php
session_start();
include("../conn.php");

if (isset($_POST['button'])) {
    $name = $_POST['name'];
    $password = $_POST['p'];

    $query = "SELECT * FROM `admin` WHERE name='$name' AND password='$password'";
    $result = mysqli_query($conn,$query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

     
       

         echo "<script>alert('Registration successful!');</script>";

        header("Location: Admindash.php");
        exit;
    } else {
        echo "<script>alert('Invalid name or password'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lawyer Sign In</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-100 via-indigo-100 to-purple-100 min-h-screen flex items-center justify-center px-4">

  <div class="w-full max-w-md bg-white shadow-2xl rounded-xl p-8 animate-fade-in">
    <h2 class="text-3xl font-extrabold text-center text-indigo-700 mb-6">Admin SignIn</h2>

    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Enter Your Name</label>
        <input type="name" name="name" id="name" placeholder="Username"
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
      <a href="adminsignup.php" class="text-indigo-600 font-medium hover:underline">Sign up here</a>
    </p>
  </div>

  <!-- Optional: Tailwind fade animation -->
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