<?php
session_start();
include("../conn.php");

if (!isset($_SESSION['lawyer_id'])) {
    header("Location: lawyerSignin.php");
    exit();
}

$lawyer_id = $_SESSION['lawyer_id'];

// Handle form actions (Confirm / Reject / Win / Loss)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'], $_POST['status'])) {
    $appointment_id = (int)$_POST['appointment_id'];
    $status = $_POST['status'];

    $valid_status = ['Confirmed', 'Rejected', 'Won', 'Loss'];

    if (in_array($status, $valid_status)) {
        $stmt = $conn->prepare("UPDATE appointment SET status = ? WHERE id = ? AND lawyer_id = ?");
        $stmt->bind_param("sii", $status, $appointment_id, $lawyer_id);

        if ($stmt->execute()) {
            header("Location: lawyer_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Database update failed');</script>";
        }
    } else {
        echo "<script>alert('Invalid status');</script>";
    }
}

// Fetch lawyer info
$lawyer_query = mysqli_query($conn, "SELECT u_name, u_email, specialization FROM lawyer WHERE u_id = $lawyer_id LIMIT 1");
if (!$lawyer_query) {
    die("Query Failed: " . mysqli_error($conn));
}

$lawyer_data = mysqli_fetch_assoc($lawyer_query);
$lawyer_name = $lawyer_data['u_name'] ?? 'Lawyer';
$lawyer_email = $lawyer_data['u_email'] ?? '--';
$lawyer_specialization = $lawyer_data['specialization'] ?? '--';

// Count pending appointments
$appointments_count_result = mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM appointment WHERE lawyer_id = $lawyer_id AND status = 'Pending'");
$appointments_count = mysqli_fetch_assoc($appointments_count_result)['total'] ?? 0;

// Count confirmed appointments
$active_cases_count_result = mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM appointment WHERE lawyer_id = $lawyer_id AND status = 'Confirmed'");
$active_cases_count = mysqli_fetch_assoc($active_cases_count_result)['total'] ?? 0;

// Fetch recent cases (Won or Loss)
$recent_cases_query = $conn->prepare("SELECT * FROM appointment WHERE lawyer_id = ? AND status IN ('Won', 'Loss') ORDER BY appointment_date DESC LIMIT 10");
$recent_cases_query->bind_param("i", $lawyer_id);
$recent_cases_query->execute();
$recent_cases_result = $recent_cases_query->get_result();

// Fetch active appointments (Pending and Confirmed)
$appointments_query = $conn->prepare("SELECT * FROM appointment WHERE lawyer_id = ? AND status NOT IN ('Won', 'Loss') ORDER BY appointment_date ASC");
$appointments_query->bind_param("i", $lawyer_id);
$appointments_query->execute();
$appointments_result = $appointments_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lawyer Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow py-8 mb-6">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex flex-col items-center">
        <a href="lawyer_profile.php" class="flex items-center space-x-2 group">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-700 group-hover:text-blue-800 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A6.978 6.978 0 0112 15c2.147 0 4.073.943 5.38 2.433M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <h1 class="text-4xl font-extrabold text-blue-700 group-hover:text-blue-800 transition">
            Welcome, <?= htmlspecialchars($lawyer_name) ?>
          </h1>
        </a>
      </div>
    </div>
  </header>
  

<main class="max-w-7xl mx-auto px-4">

  <!-- Profile -->
  <section class="mb-10">
    <a href="lawyer_profile.php" class="block w-full sm:max-w-md md:max-w-lg xl:max-w-xl hover:scale-105 transition-transform duration-300 mx-auto">
      <div class="relative bg-gradient-to-tr from-indigo-100 via-white to-purple-100 p-6 rounded-3xl shadow-2xl hover:shadow-indigo-300 transition-all duration-300 animate-pulse hover:animate-none">
        <div class="absolute top-4 right-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A6.978 6.978 0 0112 15c2.147 0 4.073.943 5.38 2.433M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <div>
          <h2 class="text-lg font-semibold text-gray-500 mb-1">My Profile</h2>
          <p class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($lawyer_name) ?></p>
          <p class="text-sm text-gray-600 mb-1"><?= htmlspecialchars($lawyer_email) ?></p>
          <div class="mt-2 text-sm">
            <span class="text-indigo-600 font-semibold">Specialization:</span>
            <span class="text-gray-700"><?= htmlspecialchars($lawyer_specialization) ?></span>
          </div>
        </div>
      </div>
    </a>
  </section>

  <!-- Dashboard Cards -->
  <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
    <?php
    $cards = [
      ["label" => "Appointments", "count" => $appointments_count, "color" => "blue"],
      ["label" => "Active Cases", "count" => $active_cases_count, "color" => "indigo"]
    ];

    foreach ($cards as $card): ?>
      <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 flex flex-col justify-between">
        <div class="flex justify-between items-center mb-4">
          <div>
            <p class="text-sm text-gray-500"><?= $card['label'] ?></p>
            <p class="text-3xl font-bold text-gray-800"><?= $card['count'] ?></p>
          </div>
          <span class="material-icons text-<?= $card['color'] ?>-500 text-4xl">
            <!-- Add icon if needed -->
          </span>
        </div>
        <div class="h-1 bg-<?= $card['color'] ?>-100 rounded-full">
          <div class="w-2/3 h-full bg-<?= $card['color'] ?>-500 rounded-full"></div>
        </div>
      </div>
    <?php endforeach; ?>
  </section>

  <!-- Appointments Section -->
  <section class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-10">
    <div class="xl:col-span-2 bg-white p-6 rounded-2xl shadow">
      <h2 class="text-xl font-bold text-blue-700 mb-4">All Appointments</h2>
      <ul class="space-y-4 text-sm">
        <?php

        if ($appointments_result->num_rows > 0) {
          while ($appointment = $appointments_result->fetch_assoc()) {
            $name = htmlspecialchars($appointment['FullName']);
            $date = date("d M, Y", strtotime($appointment['appointment_date']));
            $status = htmlspecialchars($appointment['status']);
            $status_color = match (strtolower($status)) {
              'approved' => 'green',
              'pending' => 'yellow',
              'rejected' => 'red',
              'confirmed' => 'blue',
              default => 'gray',
            };

            echo "<li class='flex flex-col sm:flex-row sm:justify-between sm:items-center text-gray-700 border-b pb-2'>
                    <div><strong>$name</strong> - $date</div>
                    <div class='flex items-center gap-2 mt-2 sm:mt-0'>
                      <span class='text-$status_color-600 font-semibold'>$status</span>";

            if (strtolower($status) === 'pending') {
              echo "<form method='POST' action='./approveAppointment.php' class='inline'>
                      <input type='hidden' name='appointment_id' value='{$appointment['id']}'>
                      <input type='hidden' name='status' value='Confirmed'>
                      <button class='text-sm text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded' type='submit'>Confirm</button>
                    </form>
                    <form method='POST' action='./approveAppointment.php' class='inline'>
                      <input type='hidden' name='appointment_id' value='{$appointment['id']}'>
                      <input type='hidden' name='status' value='Rejected'>
                      <button class='text-sm text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded' type='submit'>Reject</button>
                    </form>";
            }

            if (strtolower($status) === 'confirmed') {
              echo "<form method='POST' action='./approveAppointment.php' class='inline'>
                      <input type='hidden' name='appointment_id' value='{$appointment['id']}'>
                      <input type='hidden' name='status' value='Won'>
                      <button class='text-sm text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded' type='submit'>Win</button>
                    </form>
                    <form method='POST' action='./approveAppointment.php' class='inline'>
                      <input type='hidden' name='appointment_id' value='{$appointment['id']}'>
                      <input type='hidden' name='status' value='Loss'>
                      <button class='text-sm text-white bg-gray-500 hover:bg-gray-600 px-3 py-1 rounded' type='submit'>Loss</button>
                    </form>";
            }

            echo "</div></li>";
          }
        } else {
          echo "<li class='text-gray-500'>No appointments yet.</li>";
        }
        ?>
      </ul>
    </div>

    <!-- Messages Panel -->
    <div class="bg-white p-6 rounded-2xl shadow">
      <h2 class="text-xl font-bold text-blue-700 mb-4">Messages (Quick View)</h2>
      <p class="text-sm text-gray-600">No new messages.</p>
    </div>
  </section>

  <!-- Recent Cases -->
  <section class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
      <h2 class="text-xl font-bold text-blue-700 mb-4">Recent Cases (Won/Loss)</h2>
      <ul class="space-y-4 text-sm">
<?php
        

        if ($recent_cases_result->num_rows > 0) {
          while ($case = $recent_cases_result->fetch_assoc()) {
            $name = htmlspecialchars($case['FullName']);
            $date = date("d M, Y", strtotime($case['appointment_date']));
            $status = htmlspecialchars($case['status']);
            $status_color = $status === 'Won' ? 'text-green-600' : 'text-red-600';

            echo " <li class='flex justify-between text-gray-700'>
                    <div>
                      <span class='font-semibold'>$name</span><br>
                      <span class='text-sm text-gray-500'>$date</span>
                    </div>
                    <span class='text-sm font-bold $status_color'>$status</span>
                  </li> ";
          }
        } else {
          echo "<li class='text-gray-500'>No recent cases.</li>";
        }
        ?>
       
      </ul>
    </div>
  </section>

  <!-- Mobile Notice -->
  <section class="md:hidden mt-6">
    <div class="bg-white p-4 rounded-xl shadow text-center">
      <p class="text-sm text-gray-700">Full dashboard is best viewed on desktop.</p>
    </div>
  </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form[action="./approveAppointment.php"]');

    forms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(form);

            fetch('./approveAppointment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Raw Response:', response); // Log raw response for debugging
                return response.json();
            })
            .then(data => {
                console.log('Parsed Response:', data); // Log parsed response for debugging
                if (data.success) {
                    // Update the UI dynamically without reloading
                    const statusElement = form.querySelector('input[name="status"]').value;
                    if (statusElement === 'Confirmed') {
                        form.closest('li').remove(); // Remove the appointment from the list
                    } else if (['Won', 'Loss'].includes(statusElement)) {
                        form.closest('li').remove(); // Remove from active cases and add to recent cases
                    }
                } else {
                    alert(`Error: ${data.message}`); // Show error alert only for failures
                }
            })
            .catch(error => {
                console.error('Error:', error); // Log error details for debugging
                alert('An unexpected error occurred. Please check the console for details.');
            });
        });
    });
});
</script>
<script>
$(document).on("click", ".case-action", function () {
    var caseId = $(this).data("id");
    var action = $(this).data("action"); // 'confirm', 'win', 'loss'

    $.ajax({
        url: "lawyer_dashboard.php",
        method: "POST",
        data: {
            case_id: caseId,
            action: action
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                alert("Action successful!");
                location.reload(); // or update the row without reloading
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function () {
            alert("An unexpected error occurred. Please try again.");
        }
    });
});</script>


</body>


</html>
