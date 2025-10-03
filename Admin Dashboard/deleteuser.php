<?php
include('../conn.php'); // Database connection

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user from the database
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: manageusers.php?success=User deleted successfully");
        exit();
    } else {
        header("Location: manageusers.php?error=Failed to delete user");
        exit();
    }
} else {
    header("Location: manageusers.php");
    exit();
}
?>