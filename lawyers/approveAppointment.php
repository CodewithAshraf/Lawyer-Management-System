<?php
session_start();
include("../conn.php");

if (!isset($_SESSION['lawyer_id'])) {
    header("Location: lawyerSignin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id = intval($_POST['appointment_id'] ?? 0);
    $new_status = $_POST['status'] ?? '';

    // Debugging: Check if POST data is received
    if (!$appointment_id || !$new_status) {
        echo json_encode(["success" => false, "message" => "Error: Missing appointment_id or status."]);
        exit();
    }

    // Optional: validate allowed statuses
    $allowed_statuses = ['Confirmed', 'Rejected', 'Won', 'Loss'];
    if (!in_array($new_status, $allowed_statuses)) {
        echo json_encode(["success" => false, "message" => "Invalid status."]);
        exit();
    }

    // Update the appointment status
    $stmt = $conn->prepare("UPDATE appointment SET status = ? WHERE id = ?");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("si", $new_status, $appointment_id);

    if ($stmt->execute()) {
        // Adjust counts dynamically
        if ($new_status === 'Confirmed' || in_array($new_status, ['Won', 'Loss'])) {
            $active_cases_query = "SELECT COUNT(*) AS active_cases FROM appointment WHERE lawyer_id = {$_SESSION['lawyer_id']} AND status = 'Confirmed'";
            $active_cases_result = $conn->query($active_cases_query);

            if (!$active_cases_result) {
                echo json_encode(["success" => false, "message" => "Error fetching active cases: " . $conn->error]);
                exit();
            }

            $active_cases_count = $active_cases_result->fetch_assoc()['active_cases'] ?? 0;

            $update_query = "UPDATE lawyer SET active_cases_count = $active_cases_count WHERE u_id = {$_SESSION['lawyer_id']}";
            if (!$conn->query($update_query)) {
                echo json_encode(["success" => false, "message" => "Error updating active cases count: " . $conn->error]);
                exit();
            }
        }

        echo json_encode(["success" => true, "message" => "Status updated successfully."]);
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Error executing statement: " . $stmt->error]);
        exit();
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit();
}
?>
