<?php
// filepath: c:\xampp\htdocs\legalnest\users\getlawyers.php
include('../conn.php');

if (isset($_POST['specialization'])) {
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $query = mysqli_query($conn, "SELECT u_id, u_name FROM lawyer WHERE specialization = '$specialization'");
    if (mysqli_num_rows($query) > 0) {
        echo '<option value="">-- Select Lawyer --</option>';
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<option value='{$row['u_id']}'>{$row['u_name']}</option>";
        }
    } else {
        echo '<option value="">No lawyers found</option>';
    }
} else {
    echo '<option value=\"\">No specialization selected</option>';
}
?>