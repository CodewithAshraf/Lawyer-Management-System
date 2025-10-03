<?php
session_start();
include("../conn.php");

// Redirect if not logged in
if (!isset($_SESSION['lawyer_id'])) {
    header("Location: lawyerSignin.php");
    exit();
}

$lawyer_id = $_SESSION['lawyer_id'];

// Fetch lawyer info
$query = "SELECT * FROM lawyer WHERE u_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $lawyer_id);
$stmt->execute();
$result = $stmt->get_result();
$lawyer = $result->fetch_assoc();
$stmt->close();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $specialization = $_POST['specialization'];

    // Image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_name = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($temp, "uploads/" . $image_name);
    } else {
        $image_name = $lawyer['p_img']; // Keep old image
    }

    // Update query
    $stmt = $conn->prepare("UPDATE lawyer SET u_name=?, u_email=?, u_pass=?, specialization=?, p_img=? WHERE u_id=?");
    $stmt->bind_param("sssssi", $name, $email, $pass, $specialization, $image_name, $lawyer_id);
    $success = $stmt->execute();

    if ($success) {
        $_SESSION['lawyer_name'] = $name;
        header("Location: lawyer_profile.php?updated=1");
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
            <input type="text" name="name" value="<?= htmlspecialchars($lawyer['u_name']) ?>" required
                   class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($lawyer['u_email']) ?>" required
                   class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Password</label>
            <input type="text" name="password" value="<?= htmlspecialchars($lawyer['u_pass']) ?>" required
                   class="w-full p-2 border rounded">
        </div>

        <div class="mb-4 relative">
            <label class="block text-gray-700">Specialization</label>
            <select name="specialization" required class="w-full p-2 pr-10 border rounded appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <?php
                $options = [
                    "Criminal Law", "Family Law", "Corporate Law", "Intellectual Property",
                    "Tax Law", "Environmental Law", "Civil Litigation", "Labor and Employment Law",
                    "Immigration Lawyer", "Banking & Finance Law"
                ];
                foreach ($options as $opt) {
                    $selected = ($lawyer['specialization'] === $opt) ? 'selected' : '';
                    echo "<option value=\"$opt\" $selected>$opt</option>";
                }
                ?>
            </select>
            <div class="pointer-events-none absolute top-12 right-4 transform -translate-y-1/2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Profile Image</label>
            <input type="file" name="image" class="w-full">
            <?php if (!empty($lawyer['p_img'])): ?>
                <img src="uploads/<?= htmlspecialchars($lawyer['p_img']) ?>" class="mt-2 w-24 h-24 rounded-full object-cover border">
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
