<?php
// filepath: c:\xampp\htdocs\legalnest\lawyers\completeAppointment.php
session_start();
include("../conn.php");

if (!isset($_SESSION['lawyer_id'])) {
    header("Location: lawyerSignin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'])) {
    $appointment_id = intval($_POST['appointment_id']);
    // Only allow the lawyer to update their own appointments
    $lawyer_id = $_SESSION['lawyer_id'];
            $stmt = $conn->prepare("UPDATE appointment SET status = 'Completed' WHERE id = ? AND lawyer_id = ?");
    $stmt->bind_param("ii", $appointment_id, $lawyer_id);
    $stmt->execute();
}
header("Location: lawyer_dashboard.php");
exit();
?>