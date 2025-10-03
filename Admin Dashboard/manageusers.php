<?php
include('../conn.php'); // DB connection

// Fetch all users data
$query = "SELECT id, username, email, phone_number FROM users";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching users: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        #dash{
            position: relative;
            left:230px;
        }
        #rt{
            position: relative;
            left:-100px;
            margin-left:-50px;

        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-4">
                    <h3>Manage Users</h3>
                    <a href="Admindash.php" id="dash" class="btn btn-primary">
                        Back to Dashboard
                    </a>
                    <a href="adduser.php" id="rt" class="btn btn-primary ">
                        <i class="fas fa-plus me-2"></i>Add User
                    </a>
                  
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (mysqli_num_rows($result) > 0) {
                                while ($user = mysqli_fetch_assoc($result)) { 
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone_number'] ?? 'N/A'); ?></td>
                                    <td>
                                        <a href="deleteuser.php?id=<?php echo $user['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                } 
                            } else { 
                            ?>
                                <tr>
                                    <td colspan="5" class="text-center">No users found</td>
                                </tr>
                            <?php } ?>
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