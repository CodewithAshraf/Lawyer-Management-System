<?php
session_start();

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['button'])) {
    include('../conn.php');

    // Get raw inputs (no htmlspecialchars)
    $name = mysqli_real_escape_string($conn, $_POST['n']);
    $email = mysqli_real_escape_string($conn, $_POST['e']);
    $phone = mysqli_real_escape_string($conn, $_POST['ph']);
    $pass = $_POST['p'];

    // Initialize error array
    $errors = [];

    // Validate inputs
    if (empty($name)) {
        $errors[] = "Username is required";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }

    if (empty($phone) || !preg_match('/^[0-9]{11,15}$/', $phone)) {
        $errors[] = "Valid phone number is required (11-15 digits)";
    }

    if (empty($pass) || strlen($pass) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }

    // Check if email already exists
    $check_email = "SELECT email FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_email);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $errors[] = "Email already registered";
    }

    mysqli_stmt_close($stmt);

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Insert using prepared statement
        $sql = "INSERT INTO users (username, email, phone_number, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            // Set session variables
            $_SESSION['registration_success'] = true;
            $_SESSION['new_user_email'] = $email;

            // Redirect to login page
            header("Location: admindash.php");
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lawyers - Sign Up</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Rest of your head content remains the same -->
    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
    }

    .form-container {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 500px;
        transition: all 0.3s ease;
    }

    .form-container:hover {
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
    }

    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: 600;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #495057;
        font-size: 14px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"] {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 15px;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    input:focus {
        border-color: #3a5eff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(58, 94, 255, 0.1);
    }

    .btn {
        width: 100%;
        padding: 14px;
        background-color: #3a5eff;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .btn:hover {
        background-color: #2e4ccc;
        transform: translateY(-2px);
    }

    .btn:active {
        transform: translateY(0);
    }

    p {
        text-align: center;
        margin-top: 25px;
        color: #6c757d;
        font-size: 15px;
    }

    a {
        color: #3a5eff;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }

    a:hover {
        color: #2e4ccc;
        text-decoration: underline;
    }

    .error-message {
        color: #dc3545;
        margin-bottom: 20px;
        padding: 12px 16px;
        border-radius: 8px;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        font-size: 14px;
    }

    .success-message {
        color: #28a745;
        margin-bottom: 20px;
        padding: 12px 16px;
        border-radius: 8px;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        font-size: 14px;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .form-container {
            padding: 30px 20px;
        }
        
        h2 {
            font-size: 24px;
        }
    }
</style>
</head>

<body>
    <div class="form-container">
        <h2>Sign Up</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['registration_success'])): ?>
            <div class="success-message">
                <p>Registration successful! Please sign in.</p>
            </div>
            <?php unset($_SESSION['registration_success']); ?>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="n" id="username" placeholder="Enter Username" required
                value="<?= isset($_POST['n']) ? $_POST['n'] : '' ?>">

            <label for="email">Email address</label>
            <input type="email" name="e" id="email" placeholder="Enter Email" required
                value="<?= isset($_POST['e']) ? $_POST['e'] : '' ?>">

            <label for="phone">Phone Number (11-15 digits)</label>
            <input type="tel" name="ph" id="phone" placeholder="Phone Number" required
                pattern="[0-9]{11,15}" title="11-15 digit phone number"
                value="<?= isset($_POST['ph']) ? $_POST['ph'] : '' ?>">

            <label for="password">Password (min 8 characters)</label>
            <input type="password" name="p" id="password" placeholder="Password" required minlength="8">

            <input type="submit" value="Sign Up" name="button" class="btn">
        </form>

       
    </div>

    
</body>
</html>