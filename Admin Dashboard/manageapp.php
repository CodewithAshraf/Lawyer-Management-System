<?php
include('../conn.php'); // Database connection

// Fetch all appointments with user and lawyer names
$query = "SELECT a.*, 
       u.username AS user_name, 
       l.u_name AS lawyer_name 
FROM appointment a
JOIN users u ON a.user_id = u.id
JOIN lawyer l ON a.lawyer_id = l.u_id";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching appointments: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-completed {
            background-color: #28a745;
        }
        .badge-cancelled{
            background-color: #dc3545;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        #dash{
            position: relative;
            left:290px
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-3">
                    <h3>Manage Appointments</h3>
                    <a href="Admindash.php" id="dash" class="btn btn-primary">
                        <i class="fas fa-arrow me-2"></i>Back to Dashboard
                    </a>
                    <a  href="../appointment.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Appointment
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Lawyer</th>
                                <th>Client Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($appointment = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appointment['id']) ?></td>
                                    <td><?= htmlspecialchars($appointment['lawyer_name']) ?></td>
                                    <td><?= htmlspecialchars($appointment['FullName']) ?></td>
                                    <td><?= htmlspecialchars($appointment['PhoneNumber']) ?></td>
                                    <td><?= htmlspecialchars($appointment['EmailAddress']) ?></td>
                                    <td><?= htmlspecialchars($appointment['Address']) ?></td>
                                    <td>
                                       <?php
                                    $status = strtolower($appointment['status']);
                                    $badge_class = match ($status) {
                                         'pending'   => 'badge-pending',
                                        'confirmed' => 'badge-completed',
                                        'rejected', 'cancelled' => 'badge-cancelled',
                                         default     => 'badge-secondary'
                                        };
?>
<span class="badge <?= $badge_class ?>">
    <?= htmlspecialchars($appointment['status']) ?>
</span>

                                    </td>
                                    <td>
                                        <a href="deleteapp.php?id=<?= $appointment['id'] ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to delete this appointment?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No appointments found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>