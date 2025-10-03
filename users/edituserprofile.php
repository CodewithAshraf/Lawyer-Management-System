<?php
session_start();
include("../conn.php");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password']; // You can hash this if needed
    $phonenumber = $_POST['ph'];

    // Image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_name = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($temp, "uploads/" . $image_name);
    } else {
        $image_name = $user['ProfileImage']; // Keep old image
    }

    // Update query (now includes c_pass)
    $stmt = $conn->prepare("UPDATE `users` SET `username`=?, `email`=?, `ProfileImage`=?, `phone_number`=?, `password`=?, `c_pass`=? WHERE id=?");
    $stmt->bind_param("ssssssi", $name, $email, $image_name, $phonenumber, $pass, $pass, $user_id);
    $success = $stmt->execute();

    if ($success) {
        $_SESSION['user_name'] = $name;
        header("Location: user_profile.php?updated=1");
        exit();
    } else {
        echo "<script>alert('Update failed: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-semibold text-indigo-600 mb-6 text-center">Update Profile</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block text-gray-700">Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['username']) ?>" required
                   class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                   class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Password</label>
            <input type="text" name="password" value="<?= htmlspecialchars($user['password']) ?>" required
                   class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Phone Number</label>
            <input type="tel" name="ph" value="<?= htmlspecialchars($user['phone_number']) ?>" 
                   placeholder="12345678901"
                   pattern="[0-9]{11,15}" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Profile Image</label>
            <input type="file" name="image" class="w-full">
            <?php if (!empty($user['ProfileImage'])): ?>
                <img src="uploads/<?= htmlspecialchars($user['ProfileImage']) ?>" class="mt-2 w-24 h-24 rounded-full object-cover border">
            <?php endif; ?>
        </div>

        <div class="text-center">
            <button type="submit" name="update" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded">
                Update
            </button>
        </div>
    </form>
</div>

</body>
</html>
