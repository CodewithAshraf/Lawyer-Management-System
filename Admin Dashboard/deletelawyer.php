<?php
include('../conn.php'); // Database connection

if (isset($_GET['id'])) {
    $lawyer_id = $_GET['id'];

    // Delete lawyer from the database
    $query = "DELETE FROM lawyers WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $lawyer_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: managelawyers.php?success=Lawyer deleted successfully");
        exit();
    } else {
        header("Location: managelawyers.php?error=Failed to delete lawyer");
        exit();
    }
} else {
    header("Location: managelawyers.php");
    exit();
}
?>