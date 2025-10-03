<?php
// Start session at the very beginning
session_start();

// Include database connection
include("../conn.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: Signin.php");
    exit();
}

// Get user details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Verify user exists
if (!$user) {
    die("User not found in database");
}

// Debug: Print user ID to verify
// echo "User ID: " . $user_id;

// Get appointment statistics with NULL check
$stats_query = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'Confirmed' THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = 'Won' THEN 1 ELSE 0 END) as won,
                SUM(CASE WHEN status = 'Loss' THEN 1 ELSE 0 END) as loss
                FROM appointment WHERE user_id = ?";
$stmt = $conn->prepare($stats_query);
if (!$stmt) {
    die("Error preparing stats query: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    die("Error executing stats query: " . $stmt->error);
}
$stats_result = $stmt->get_result();
$stats = $stats_result->fetch_assoc();

// Normalize NULL values to 0
$stats = array_map(function($value) {
    return is_null($value) ? 0 : $value;
}, $stats);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
         :root {
            --primary-color: #3a5eff;
            --primary-dark: #2e4ccc;
            --secondary-color: #f8f9fa;
            --text-color: #333;
            --light-gray: #e9ecef;
            --medium-gray: #adb5bd;
            --dark-gray: #495057;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.2s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            width: 95%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header Styles */
        .dashboard-header {
            background-color: white;
            box-shadow: var(--box-shadow);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .dashboard-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            color: var(--primary-color);
            font-size: 24px;
            font-weight: 700;
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-nav a {
            color: var(--dark-gray);
            font-size: 18px;
            text-decoration: none;
            transition: var(--transition);
        }

        .user-nav a:hover {
            color: var(--primary-color);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 10px;
            background-color: var(--primary-color);
            color: white;
            padding: 8px 15px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .logout-btn:hover{
            background-color: #1d54b9ff;
            color: rgba(255, 255, 255, 1);
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(220, 53, 69, 0.18);
        }

        /* Main Content Layout */
        .dashboard-container {
            display: flex;
            margin-top: 30px;
            gap: 20px;
        }

        .sidebar {
            width: 300px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 40px 40px;
            height: fit-content;
        }

        .dashboard-nav {
            display: flex;
            flex-direction: column;
        }

        .dashboard-nav a {
            padding: 12px 20px;
            color: var(--dark-gray);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
        }

        .dashboard-nav a:hover,
        .dashboard-nav a.active {
            background-color: var(--light-gray);
            color: var(--primary-color);
        }

        .dashboard-nav a i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex: 1;
        }

        .main-content h2 {
            margin-bottom: 20px;
            color: var(--dark-gray);
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
        }

        .card h3 {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dark-gray);
        }

        .profile-card {
            grid-column: span 1;
        }

        .profile-info {
            display: flex;
            gap: 20px;
        }

        .profile-pic img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--light-gray);
        }

        .profile-details {
            flex: 1;
        }

        .profile-details p {
            margin-bottom: 8px;
        }

        .profile-details strong {
            color: var(--dark-gray);
            min-width: 80px;
            display: inline-block;
        }

        .edit-btn {
            display: inline-block;
            margin-top: 10px;
            background-color: var(--primary-color);
            color: white;
            padding: 8px 15px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .edit-btn:hover {
            background-color: var(--primary-dark);
        }

        .stats-card {
            grid-column: span 1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .stat-item {
            text-align: center;
            padding: 15px;
            background-color: var(--secondary-color);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            display: block;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .total-appointments .stat-number {
            color: var(--primary-color);
        }

        .pending-appointments .stat-number {
            color: var(--warning-color);
        }

        .confirmed-appointments .stat-number {
            color: var(--success-color);
        }

        .completed-appointments .stat-number {
            color: #17a2b8;
        }

        .stat-label {
            font-size: 14px;
            color: var(--medium-gray);
        }

        /* Appointments Table */
        .appointments-card {
            margin-bottom: 30px;
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .appointments-table th,
        .appointments-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }

        .appointments-table th {
            background-color: var(--secondary-color);
            font-weight: 600;
            color: var(--dark-gray);
        }

        .appointments-table tr:hover {
            background-color: var(--secondary-color);
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-badge.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-badge.confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-badge.cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-badge.completed {
            background-color: #cce5ff;
            color: #004085;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            margin-right: 5px;
            transition: var(--transition);
        }

        .view-btn {
            background-color: var(--primary-color);
        }

        .view-btn:hover {
            background-color: var(--primary-dark);
        }

        .cancel-btn {
            background-color: var(--danger-color);
        }

        .cancel-btn:hover {
            background-color: #c82333;
        }

        .no-appointments {
            text-align: center;
            padding: 20px;
            color: var(--medium-gray);
        }

        .no-appointments a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .no-appointments a:hover {
            text-decoration: underline;
        }

        /* Upcoming Appointments */
        .upcoming-appointments {
            margin-bottom: 30px;
        }

        .upcoming-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }

        .upcoming-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 15px;
            border-left: 4px solid var(--primary-color);
        }

        .upcoming-card h4 {
            margin-bottom: 10px;
            color: var(--dark-gray);
        }

        .upcoming-card p {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .upcoming-card .lawyer-name {
            font-weight: 600;
            color: var(--primary-color);
        }

        .upcoming-card .appointment-date {
            color: var(--dark-gray);
            font-weight: 500;
        }

        .upcoming-card .status {
            display: inline-block;
            margin-top: 5px;
        }

        /* Footer Styles */
        .dashboard-footer {
            background-color: white;
            padding: 20px 0;
            margin-top: 40px;
            border-top: 1px solid var(--light-gray);
        }

        .dashboard-footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-footer p {
            color: var(--medium-gray);
            font-size: 14px;
        }

        .footer-nav {
            display: flex;
            gap: 15px;
        }

        .footer-nav a {
            color: var(--medium-gray);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }

        .footer-nav a:hover {
            color: var(--primary-color);
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .profile-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .appointments-table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 576px) {
            .user-nav {
                gap: 10px;
            }

            .user-profile span {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
</head>

<body>
    <header class="dashboard-header">
        <div class="container">
            <div class="logo">
                
            </div>
            <nav class="user-nav">
                <div class="user-profile">
                    <span><?php echo htmlspecialchars($user['username']); ?></span>
                </div>
                <a href="logout.php" class="logout-btn">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="dashboard-container">
            <aside class="sidebar">
                <nav class="dashboard-nav">
                    <a href="index.php" class="active"><i class="fas fa-home"></i> Home</a>
                    <a href="user_profile.php"><i class="fas fa-user"></i> Profile</a>
                    <a href="appointment.php"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
                </nav>
            </aside>

            <div class="main-content">
                <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>

                <div class="dashboard-cards">
                    <div class="card profile-card">
                        <h3><i class="fas fa-user"></i> Your Profile</h3>
                        <div class="profile-info">
                            <div class="profile-details">
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
                                <a href="edituserprofile.php" class="edit-btn">Edit Profile</a>
                            </div>
                        </div>
                    </div>

                    <div class="card stats-card">
    <h3><i class="fas fa-chart-bar"></i> Appointment Stats</h3>
    <div class="stats-grid">
        <div class="stat-item total-appointments">
            <span class="stat-number"><?php echo $stats['total'] ?? 0; ?></span>
            <span class="stat-label">Total Appointments</span>
        </div>
        <div class="stat-item pending-appointments">
            <span class="stat-number"><?php echo $stats['pending'] ?? 0; ?></span>
            <span class="stat-label">Pending</span>
        </div>
        <div class="stat-item confirmed-appointments">
            <span class="stat-number"><?php echo $stats['confirmed'] ?? 0; ?></span>
            <span class="stat-label">Confirmed</span>
        </div>
        <div class="stat-item rejected-appointments">
            <span class="stat-number"><?php echo $stats['rejected'] ?? 0; ?></span>
            <span class="stat-label">Rejected</span>
        </div>
        <div class="stat-item win-appointments">
            <span class="stat-number"><?php echo $stats['won'] ?? 0; ?></span>
            <span class="stat-label">Win</span>
        </div>
        <div class="stat-item loss-appointments">
            <span class="stat-number"><?php echo $stats['loss'] ?? 0; ?></span>
            <span class="stat-label">Loss</span>
        </div>
    </div>
</div>
                </div>


                <!-- All Appointments Section -->
                <div class="card appointments-card">
                    <h3><i class="fas fa-calendar-check"></i> All Appointments</h3>
                     <!-- if ($appointments_result->num_rows > 0):  -->
                       <?php
$user_id = $_SESSION['user_id'] ?? null;
$appointments_result = null;

if ($user_id) {
    $query = "SELECT a.*, l.u_name AS lawyer_name, l.specialization
              FROM appointment a
              JOIN lawyer l ON a.lawyer_id = l.u_id
              WHERE a.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $appointments_result = $stmt->get_result();
}
?>

<?php if ($appointments_result && $appointments_result->num_rows > 0): ?>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Lawyer ID</th>
                <th>Specialization</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($appointment = $appointments_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($appointment['lawyer_id']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['specialization']); ?></td>
                    <td><?php echo date('M j, Y', strtotime($appointment['appointment_date'])); ?></td>
                    <td>
                        <span class="status-badge <?php echo strtolower($appointment['status']); ?>">
                            <?php echo htmlspecialchars($appointment['status']); ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="no-appointments">You don't have any appointments yet. <a href="appointment.php">Book one now!</a></p>
<?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <footer class="dashboard-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> LegalConnect. All rights reserved.</p>
            <nav class="footer-nav">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact Us</a>
            </nav>
        </div>
    </footer>
</body>

</html>