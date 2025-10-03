<?php 
include("../conn.php");

// Check which table exists and use it
$table = 'lawyer'; // or 'lawyers' based on which one has your data

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $table");
$row = mysqli_fetch_assoc($result);
$total_lawyers = $row['total'];

// Use the correct column names (matching your database)
$query = "SELECT `u_id`, `u_name`, `p_img`, `u_email`, `specialization`, `u_pass`, `u_pass_confirm` FROM $table";
$result = mysqli_query($conn, $query);

// Add error handling
if (!$result) {
    die("Error fetching lawyer: " . mysqli_error($conn));
}


$table2 = 'users';
$result2 = mysqli_query($conn, "SELECT COUNT(*) AS totaluser FROM $table2");
$row2 = mysqli_fetch_assoc($result2);
$total_users = $row2['totaluser'];

$userQuery = "SELECT id, username, email, phone_number FROM $table2";
$userResult = mysqli_query($conn, $userQuery);

if (!$userResult) {
    die("Error fetching users: " . mysqli_error($conn));
}


    $table3 = 'appointment';
    $result3 = mysqli_query($conn, "SELECT COUNT(*) AS totalapp FROM $table3");
    $row3 = mysqli_fetch_assoc($result3);
    $total_app = $row3['totalapp'];

    $appquery = "SELECT `id`, `user_id`, `lawyer_id`, `FullName`, `PhoneNumber`, `EmailAddress`, `Address`, `status` FROM $table3";
    $appresult = mysqli_query($conn, $appquery);








?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #007bff;
        }
        .sidebar .nav-link:hover {
            color: #fff;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar bg-dark">
                <div class="text-center py-4">
            <a href="../index.php" > <!-- Anchor tag wraps the image -->
                <img src="../bbbb.png" height="70" width="auto">
                </a>
</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" id="dashboard-tab">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="managelawyers.php" class="nav-link" >
                            <i class="fas fa-user-tie me-2"></i>Manage Lawyers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manageusers.php" id="users-tab">
                            <i class="fas fa-users me-2"></i>Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manageapp.php" id="appointments-tab">
                            <i class="fas fa-calendar-check me-2"></i>Manage Appointments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminsignin.php">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2" id="section-title">Admin Dashboard</h1>
                </div>

                <!-- Dashboard Content -->
                <div id="dashboard-content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Lawyers</h5>
                                    <p class="card-text display-4" id="total-lawyers"><?php echo $total_lawyers; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Users</h5>
                                    <p class="card-text display-4" id="total-users"><?php echo  $total_users;?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info mb-3">      
                                <div class="card-body">
                                    <h5 class="card-title">Total Appointments</h5>
                                    <p class="card-text display-4" id="total-appointments"><?php echo $total_app;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lawyers Management Content -->
                <div id="lawyers-content" style="display: none;">
                    <div class="d-flex justify-content-between mb-3">
                        <!-- <h3>Manage Lawyers</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLawyerModal">
                            <i class="fas fa-plus me-2"></i>Add Lawyer
                        </button> -->
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="lawyers-table">
                            <thead>
    <!-- <tr>
        <th>ID</th>
        <th>username</th>
        <th>email</th>
        <th>Specialization</th>
        <th>Actions</th>
    </tr> -->
</thead>
<tbody>
    <?php 
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { 
    ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['Specialization']); ?></td>
            <td>
                
                <a href="delete_lawyer.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php 
        } 
    } else { 
    ?>
        <tr>
            <td colspan="5" class="text-center">No lawyers found</td>
        </tr>
    <?php } ?>
</tbody>
                        </table>
                    </div>
                </div>

                <!-- Users Management Content -->
                <div id="users-content" style="display: none;">
                    <div class="d-flex justify-content-between mb-3">
                        <h3>Manage Users</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fas fa-plus me-2"></i>Add User
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="users-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <!-- <th>Status</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Users data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Appointments Management Content -->
                <div id="appointments-content" style="display: none;">
                    <div class="d-flex justify-content-between mb-3">
                        <h3>Manage Appointments</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                            <i class="fas fa-plus me-2"></i>Add Appointment
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="appointments-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Lawyer</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Appointments data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Lawyer Modal -->
    <div class="modal fade" id="addLawyerModal" tabindex="-1" aria-labelledby="addLawyerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLawyerModalLabel">Add New Lawyer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addLawyerForm">
                        <div class="mb-3">
                            <label for="lawyerName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="lawyerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="lawyerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="lawyerEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="lawyerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="lawyerPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="lawyerSpecialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control" id="lawyerSpecialization" required>
                        </div>
                        <div class="mb-3">
                            <label for="lawyerStatus" class="form-label">Status</label>
                            <select class="form-select" id="lawyerStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveLawyerBtn">Save Lawyer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Lawyer Modal -->
    <div class="modal fade" id="editLawyerModal" tabindex="-1" aria-labelledby="editLawyerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLawyerModalLabel">Edit Lawyer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editLawyerForm">
                        <input type="hidden" id="editLawyerId">
                        <div class="mb-3">
                            <label for="editLawyerName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="editLawyerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLawyerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editLawyerEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLawyerSpecialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control" id="editLawyerSpecialization" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLawyerStatus" class="form-label">Status</label>
                            <select class="form-select" id="editLawyerStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateLawyerBtn">Update Lawyer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="userName" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="userPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="userPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="userPhone" required>
                        </div>
                        <div class="mb-3">
                            <label for="userStatus" class="form-label">Status</label>
                            <select class="form-select" id="userStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveUserBtn">Save User</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId">
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="editUserName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editUserEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="editUserPhone" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserStatus" class="form-label">Status</label>
                            <select class="form-select" id="editUserStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateUserBtn">Update User</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Appointment Modal -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAppointmentModalLabel">Add New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAppointmentForm">
                        <div class="mb-3">
                            <label for="appointmentUser" class="form-label">User</label>
                            <select class="form-select" id="appointmentUser" required>
                                <!-- Users will be loaded here -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentLawyer" class="form-label">Lawyer</label>
                            <select class="form-select" id="appointmentLawyer" required>
                                <!-- Lawyers will be loaded here -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="appointmentDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="appointmentTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentStatus" class="form-label">Status</label>
                            <select class="form-select" id="appointmentStatus">
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveAppointmentBtn">Save Appointment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Appointment Modal -->
    <div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAppointmentModalLabel">Edit Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAppointmentForm">
                        <input type="hidden" id="editAppointmentId">
                        <div class="mb-3">
                            <label for="editAppointmentUser" class="form-label">User</label>
                            <select class="form-select" id="editAppointmentUser" required>
                                <!-- Users will be loaded here -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editAppointmentLawyer" class="form-label">Lawyer</label>
                            <select class="form-select" id="editAppointmentLawyer" required>
                                <!-- Lawyers will be loaded here -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editAppointmentDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="editAppointmentDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAppointmentTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="editAppointmentTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAppointmentStatus" class="form-label">Status</label>
                            <select class="form-select" id="editAppointmentStatus">
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateAppointmentBtn">Update Appointment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                    <input type="hidden" id="deleteItemId">
                    <input type="hidden" id="deleteItemType">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            document.getElementById('dashboard-tab').addEventListener('click', function(e) {
                e.preventDefault();
                showSection('dashboard');
            });
            
            document.getElementById('lawyers-tab').addEventListener('click', function(e) {
                e.preventDefault();
                showSection('lawyers');
                loadLawyers();
            });
            
            document.getElementById('users-tab').addEventListener('click', function(e) {
                e.preventDefault();
                showSection('users');
                loadUsers();
            });
            
            document.getElementById('appointments-tab').addEventListener('click', function(e) {
                e.preventDefault();
                showSection('appointments');
                loadAppointments();
            });

            // Show the dashboard by default
            showSection('dashboard');
            loadDashboardStats();

            // Lawyer form handling
            document.getElementById('saveLawyerBtn').addEventListener('click', saveLawyer);
            document.getElementById('updateLawyerBtn').addEventListener('click', updateLawyer);

            // User form handling
            document.getElementById('saveUserBtn').addEventListener('click', saveUser);
            document.getElementById('updateUserBtn').addEventListener('click', updateUser);

            // Appointment form handling
            document.getElementById('saveAppointmentBtn').addEventListener('click', saveAppointment);
            document.getElementById('updateAppointmentBtn').addEventListener('click', updateAppointment);

            // Delete confirmation
            document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
        });

        function showSection(section) {
            // Hide all sections
            document.getElementById('dashboard-content').style.display = 'none';
            document.getElementById('lawyers-content').style.display = 'none';
            document.getElementById('users-content').style.display = 'none';
            document.getElementById('appointments-content').style.display = 'none';

            // Remove active class from all tabs
            document.getElementById('dashboard-tab').classList.remove('active');
            document.getElementById('lawyers-tab').classList.remove('active');
            document.getElementById('users-tab').classList.remove('active');
            document.getElementById('appointments-tab').classList.remove('active');

            // Show the selected section and set active tab
            document.getElementById(`${section}-content`).style.display = 'block';
            document.getElementById(`${section}-tab`).classList.add('active');
            document.getElementById('section-title').textContent = section.charAt(0).toUpperCase() + section.slice(1);
        }

        function loadDashboardStats() {
            // In a real application, you would fetch these from your backend
            // document.getElementById('total-lawyers').textContent = '12';
            document.getElementById('total-users').textContent = '45';
            document.getElementById('total-appointments').textContent = '23';
        }

        function loadLawyers() {
            // In a real application, you would fetch this from your backend
            const lawyers = [
                // { id: 1, name: 'John Smith', email: 'john@example.com', specialization: 'Family Law', status: 'active' },
                // { id: 2, name: 'Sarah Johnson', email: 'sarah@example.com', specialization: 'Criminal Law', status: 'active' },
                // { id: 3, name: 'Michael Brown', email: 'michael@example.com', specialization: 'Corporate Law', status: 'inactive' }
            ];

            const tbody = document.querySelector('#lawyers-table tbody');
            tbody.innerHTML = '';

            lawyers.forEach(lawyer => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${lawyer.id}</td>
                    <td>${lawyer.name}</td>
                    <td>${lawyer.email}</td>
                    <td>${lawyer.specialization}</td>
                    <td><span class="badge ${lawyer.status === 'active' ? 'bg-success' : 'bg-secondary'}">${lawyer.status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary edit-lawyer" data-id="${lawyer.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-item" data-id="${lawyer.id}" data-type="lawyer">Delete</button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Add event listeners to edit buttons
            document.querySelectorAll('.edit-lawyer').forEach(button => {
                button.addEventListener('click', function() {
                    const lawyerId = this.getAttribute('data-id');
                    editLawyer(lawyerId);
                });
            });

            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-item').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const itemType = this.getAttribute('data-type');
                    showDeleteConfirmation(itemId, itemType);
                });
            });
        }

        function loadUsers() {
            // In a real application, you would fetch this from your backend
            const users = [
                { id: 1, name: 'Alice Johnson', email: 'alice@example.com', phone: '555-1234', status: 'active' },
                { id: 2, name: 'Bob Williams', email: 'bob@example.com', phone: '555-5678', status: 'active' },
                { id: 3, name: 'Charlie Davis', email: 'charlie@example.com', phone: '555-9012', status: 'inactive' }
            ];

            const tbody = document.querySelector('#users-table tbody');
            tbody.innerHTML = '';

            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td><span class="badge ${user.status === 'active' ? 'bg-success' : 'bg-secondary'}">${user.status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary edit-user" data-id="${user.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-item" data-id="${user.id}" data-type="user">Delete</button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Add event listeners to edit buttons
            document.querySelectorAll('.edit-user').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    editUser(userId);
                });
            });

            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-item').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const itemType = this.getAttribute('data-type');
                    showDeleteConfirmation(itemId, itemType);
                });
            });
        }

        function loadAppointments() {
            // In a real application, you would fetch this from your backend
            const appointments = [
                { id: 1, userId: 1, userName: 'Alice Johnson', lawyerId: 1, lawyerName: 'John Smith', date: '2023-06-15', time: '14:00', status: 'scheduled' },
                { id: 2, userId: 2, userName: 'Bob Williams', lawyerId: 2, lawyerName: 'Sarah Johnson', date: '2023-06-16', time: '10:30', status: 'completed' },
                { id: 3, userId: 3, userName: 'Charlie Davis', lawyerId: 1, lawyerName: 'John Smith', date: '2023-06-17', time: '15:45', status: 'cancelled' }
            ];

            const tbody = document.querySelector('#appointments-table tbody');
            tbody.innerHTML = '';

            appointments.forEach(appointment => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${appointment.id}</td>
                    <td>${appointment.userName}</td>
                    <td>${appointment.lawyerName}</td>
                    <td>${appointment.date}</td>
                    <td>${appointment.time}</td>
                    <td><span class="badge ${getStatusBadgeClass(appointment.status)}">${appointment.status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary edit-appointment" data-id="${appointment.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-item" data-id="${appointment.id}" data-type="appointment">Delete</button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Add event listeners to edit buttons
            document.querySelectorAll('.edit-appointment').forEach(button => {
                button.addEventListener('click', function() {
                    const appointmentId = this.getAttribute('data-id');
                    editAppointment(appointmentId);
                });
            });

            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-item').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const itemType = this.getAttribute('data-type');
                    showDeleteConfirmation(itemId, itemType);
                });
            });

            // Load users and lawyers for dropdowns
            loadUsersForAppointments();
            loadLawyersForAppointments();
        }

        function getStatusBadgeClass(status) {
            switch(status) {
                case 'scheduled': return 'bg-primary';
                case 'completed': return 'bg-success';
                case 'cancelled': return 'bg-danger';
                default: return 'bg-secondary';
            }
        }

        function saveLawyer() {
            const name = document.getElementById('lawyerName').value;
            const email = document.getElementById('lawyerEmail').value;
            const password = document.getElementById('lawyerPassword').value;
            const specialization = document.getElementById('lawyerSpecialization').value;
            const status = document.getElementById('lawyerStatus').value;

            // In a real application, you would send this data to your backend
            console.log('Saving lawyer:', { name, email, password, specialization, status });

            // Close the modal and refresh the lawyers list
            const modal = bootstrap.Modal.getInstance(document.getElementById('addLawyerModal'));
            modal.hide();
            loadLawyers();
            loadDashboardStats();
        }

        function editLawyer(lawyerId) {
            // In a real application, you would fetch the lawyer data from your backend
            const lawyer = {
                id: lawyerId,
                name: 'John Smith',
                email: 'john@example.com',
                specialization: 'Family Law',
                status: 'active'
            };

            document.getElementById('editLawyerId').value = lawyer.id;
            document.getElementById('editLawyerName').value = lawyer.name;
            document.getElementById('editLawyerEmail').value = lawyer.email;
            document.getElementById('editLawyerSpecialization').value = lawyer.specialization;
            document.getElementById('editLawyerStatus').value = lawyer.status;

            const modal = new bootstrap.Modal(document.getElementById('editLawyerModal'));
            modal.show();
        }

        function updateLawyer() {
            const id = document.getElementById('editLawyerId').value;
            const name = document.getElementById('editLawyerName').value;
            const email = document.getElementById('editLawyerEmail').value;
            const specialization = document.getElementById('editLawyerSpecialization').value;
            const status = document.getElementById('editLawyerStatus').value;

            // In a real application, you would send this data to your backend
            console.log('Updating lawyer:', { id, name, email, specialization, status });

            // Close the modal and refresh the lawyers list
            const modal = bootstrap.Modal.getInstance(document.getElementById('editLawyerModal'));
            modal.hide();
            loadLawyers();
        }

        function saveUser() {
            const name = document.getElementById('userName').value;
            const email = document.getElementById('userEmail').value;
            const password = document.getElementById('userPassword').value;
            const phone = document.getElementById('userPhone').value;
            const status = document.getElementById('userStatus').value;

            // In a real application, you would send this data to your backend
            console.log('Saving user:', { name, email, password, phone, status });

            // Close the modal and refresh the users list
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            modal.hide();
            loadUsers();
            loadDashboardStats();
        }

        function editUser(userId) {
            // In a real application, you would fetch the user data from your backend
            const user = {
                id: userId,
                name: 'Alice Johnson',
                email: 'alice@example.com',
                phone: '555-1234',
                status: 'active'
            };

            document.getElementById('editUserId').value = user.id;
            document.getElementById('editUserName').value = user.name;
            document.getElementById('editUserEmail').value = user.email;
            document.getElementById('editUserPhone').value = user.phone;
            document.getElementById('editUserStatus').value = user.status;

            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        }

        function updateUser() {
            const id = document.getElementById('editUserId').value;
            const name = document.getElementById('editUserName').value;
            const email = document.getElementById('editUserEmail').value;
            const phone = document.getElementById('editUserPhone').value;
            const status = document.getElementById('editUserStatus').value;

            // In a real application, you would send this data to your backend
            console.log('Updating user:', { id, name, email, phone, status });

            // Close the modal and refresh the users list
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            modal.hide();
            loadUsers();
        }

        function loadUsersForAppointments() {
            // In a real application, you would fetch this from your backend
            const users = [
                { id: 1, name: 'Alice Johnson' },
                { id: 2, name: 'Bob Williams' },
                { id: 3, name: 'Charlie Davis' }
            ];

            const userSelect = document.getElementById('appointmentUser');
            const editUserSelect = document.getElementById('editAppointmentUser');
            
            userSelect.innerHTML = '';
            editUserSelect.innerHTML = '';

            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.name;
                userSelect.appendChild(option.cloneNode(true));
                editUserSelect.appendChild(option);
            });
        }

        function loadLawyersForAppointments() {
            // In a real application, you would fetch this from your backend
            const lawyers = [
                { id: 1, name: 'John Smith' },
                { id: 2, name: 'Sarah Johnson' },
                { id: 3, name: 'Michael Brown' }
            ];

            const lawyerSelect = document.getElementById('appointmentLawyer');
            const editLawyerSelect = document.getElementById('editAppointmentLawyer');
            
            lawyerSelect.innerHTML = '';
            editLawyerSelect.innerHTML = '';

            lawyers.forEach(lawyer => {
                const option = document.createElement('option');
                option.value = lawyer.id;
                option.textContent = lawyer.name;
                lawyerSelect.appendChild(option.cloneNode(true));
                editLawyerSelect.appendChild(option);
            });
        }

        function saveAppointment() {
            const userId = document.getElementById('appointmentUser').value;
            const lawyerId = document.getElementById('appointmentLawyer').value;
            const date = document.getElementById('appointmentDate').value;
            const time = document.getElementById('appointmentTime').value;
            const status = document.getElementById('appointmentStatus').value;

            // In a real application, you would send this data to your backend
            console.log('Saving appointment:', { userId, lawyerId, date, time, status });

            // Close the modal and refresh the appointments list
            const modal = bootstrap.Modal.getInstance(document.getElementById('addAppointmentModal'));
            modal.hide();
            loadAppointments();
            loadDashboardStats();
        }

        function editAppointment(appointmentId) {
            // In a real application, you would fetch the appointment data from your backend
            const appointment = {
                id: appointmentId,
                userId: 1,
                lawyerId: 1,
                date: '2023-06-15',
                time: '14:00',
                status: 'scheduled'
            };

            document.getElementById('editAppointmentId').value = appointment.id;
            document.getElementById('editAppointmentUser').value = appointment.userId;
            document.getElementById('editAppointmentLawyer').value = appointment.lawyerId;
            document.getElementById('editAppointmentDate').value = appointment.date;
            document.getElementById('editAppointmentTime').value = appointment.time;
            document.getElementById('editAppointmentStatus').value = appointment.status;

            const modal = new bootstrap.Modal(document.getElementById('editAppointmentModal'));
            modal.show();
        }

        function updateAppointment() {
            const id = document.getElementById('editAppointmentId').value;
            const userId = document.getElementById('editAppointmentUser').value;
            const lawyerId = document.getElementById('editAppointmentLawyer').value;
            const date = document.getElementById('editAppointmentDate').value;
            const time = document.getElementById('editAppointmentTime').value;
            const status = document.getElementById('editAppointmentStatus').value;

            // In a real application, you would send this data to your backend
            console.log('Updating appointment:', { id, userId, lawyerId, date, time, status });

            // Close the modal and refresh the appointments list
            const modal = bootstrap.Modal.getInstance(document.getElementById('editAppointmentModal'));
            modal.hide();
            loadAppointments();
        }

        function showDeleteConfirmation(itemId, itemType) {
            document.getElementById('deleteItemId').value = itemId;
            document.getElementById('deleteItemType').value = itemType;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            modal.show();
        }

        function confirmDelete() {
            const itemId = document.getElementById('deleteItemId').value;
            const itemType = document.getElementById('deleteItemType').value;

            // In a real application, you would send this request to your backend
            console.log(`Deleting ${itemType} with ID:`, itemId);

            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
            modal.hide();

            // Refresh the appropriate list
            if (itemType === 'lawyer') {
                loadLawyers();
            } else if (itemType === 'user') {
                loadUsers();
            } else if (itemType === 'appointment') {
                loadAppointments();
            }

            loadDashboardStats();
        }
    </script>
</body>
</html>