<?php
session_start();
include("../conn.php");

if (isset($_POST['button'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['p'];

    $sql="INSERT INTO `admin`(`Name`, `Email`, `Password`) VALUES ('$name','$email','$password')";

    $result = mysqli_query($conn,$sql);
    if ($result) {
        echo "Signup successfully";
        header("Location:adminsignin.php");
    }
    else{
        echo "Invalid Credentials";
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
    <h2 class="text-3xl font-extrabold text-center text-indigo-700 mb-6">Admin SignUp</h2>

    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Enter Your Name</label>
        <input type="name" name="name" id="name" placeholder="Username"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
      </div>

      <div>
        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email address</label>
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
      Already have an Account? 
      <a href="adminsignin.php" class="text-indigo-600 font-medium hover:underline">Sign in here</a>
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