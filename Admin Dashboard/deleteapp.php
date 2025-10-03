<?php
include('../conn.php'); // Database connection

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Delete appointment from the database
    $query = "DELETE FROM appointment WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $appointment_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: manageapp.php?success=Appointment deleted successfully");
        exit();
    } else {
        header("Location: manageapp.php?error=Failed to delete appointment");
        exit();
    }
} else {
    header("Location: manageapp.php");
    exit();
}
?>