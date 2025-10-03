<?php
session_start();
include('../conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('You must be logged in to book an appointment'); window.location.href='Signin.php';</script>";
        exit();
    }

    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $area = mysqli_real_escape_string($conn, $_POST['area'] ?? '');
    $lawyer_id = mysqli_real_escape_string($conn, $_POST['lawyer_id'] ?? '');
    $date = mysqli_real_escape_string($conn, $_POST['date'] ?? '');

    if (empty($name) || empty($phone) || empty($email) || empty($area) || empty($lawyer_id) || empty($date)) {
        echo "<script>alert('All fields are required'); window.history.back();</script>";
        exit();
    }

    // Check if lawyer exists
    $stmt = $conn->prepare("SELECT u_id FROM lawyer WHERE u_id = ?");
    $stmt->bind_param("i", $lawyer_id);
    $stmt->execute();
    $lawyer_result = $stmt->get_result();
    if ($lawyer_result->num_rows === 0) {
        echo "<script>alert('Selected lawyer does not exist'); window.history.back();</script>";
        exit();
    }

    // Check if user exists
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    if ($user_result->num_rows === 0) {
        echo "<script>alert('User not found'); window.location.href='Signin.php';</script>";
        exit();
    }

    // Insert into appointment table with exact column names
    $sql = "INSERT INTO appointment 
        (user_id, lawyer_id, FullName, PhoneNumber, EmailAddress, Address, status, appointment_date) 
        VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssss", $user_id, $lawyer_id, $name, $phone, $email, $area, $date);

    if ($stmt->execute()) {
        echo "<script>alert('Appointment booked successfully'); window.location.href='user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to book appointment'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<script src="Doc/js/jquery-1.11.0.min.js"></script>

   
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body {
    font-family: "Inter", Arial, Helvetica, sans-serif;
  }
  .formbold-mb-5 {
    margin-bottom: 20px;
    width: 100%;
  }
  .formbold-pt-3 {
    padding-top: 12px;
  }
  .formbold-main-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
  }
  .op{
    height:60px;
  }
#address{
  width: 220%;
}
  .formbold-form-wrapper {
    margin: 0 auto;
    max-width: 550px;
    width: 100%;
    background: white;
  }
  .formbold-form-label {
    display: block;
    font-weight: 500;
    font-size: 16px;
    color: #07074d;
    margin-bottom: 12px;
  }
  .formbold-form-label-2 {
    font-weight: 600;
    font-size: 20px;
    margin-bottom: 20px;
  }

  .formbold-form-input {
    width: 100%;
    padding: 12px 24px;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
    background: white;
    font-weight: 500;
    font-size: 16px;
    color: #6b7280;
    outline: none;
    resize: none;
  }
  .formbold-form-input:focus {
    border-color: #6a64f1;
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }
  .heading h1{
    text-align: center;
    color: #6a64f1;
    font-weight: 600;
    margin-top: 40px;
  }
  .formbold-btn {
    text-align: center;
    font-size: 16px;
    border-radius: 6px;
    padding: 14px 32px;
    border: none;
    font-weight: 600;
    background-color: #6a64f1;
    color: white;
    width: 100%;
    cursor: pointer;
  }
  .formbold-btn:hover {
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }

  .formbold--mx-3 {
    margin-left: -12px;
    margin-right: -12px;
  }
  .formbold-px-3 {
    padding-left: 12px;
    padding-right: 12px;
  }
  .flex {
    display: flex;
  }
  .flex-wrap {
    flex-wrap: wrap;
  }
  .w-full {
    width: 100%;
  }
  @media (min-width: 540px) {
    .sm\:w-half {
      width: 50%;
    }
  }
</style>
<body>

    <div class="heading">
        <h1>Book An Appointment</h1>
    </div>

  <div class="formbold-main-wrapper">
  <!-- Author: FormBold Team -->
  <!-- Learn More: https://formbold.com -->
  <div class="formbold-form-wrapper">
    <form method="POST" action="appointment.php">
      <div class="formbold-mb-5">
        <label for="name" class="formbold-form-label"> Full Name </label>
        <input type="text" name="name" id="name" placeholder="Full Name" class="formbold-form-input" />

      </div>
      <div class="formbold-mb-5">
        <label for="phone" class="formbold-form-label"> Phone Number </label>
        <input
          type="text"
          name="phone"
          id="phone"
          placeholder="Enter your phone number"
          class="formbold-form-input"
        />
      </div>
      
      <div class="formbold-mb-5">
        <label for="email" class="formbold-form-label"> Email Address </label>
        <input
          type="email"
          name="email"
          id="email"
          placeholder="Enter your email"
          class="formbold-form-input"
        />
      </div>
      

      <div class="formbold-mb-5  formbold-pt-3" >
        <label class="formbold-form-label formbold-form-label-5" >
          Address Details
        </label>
        <div class="flex flex-wrap formbold--mx-3">
          <div class="w-full sm:w-half formbold-px-3">
            <div class="formbold-mb-5 " >
              <input
                type="text"
                name="area"
                id="address"
                placeholder="Enter Your Address"
                class="formbold-form-input"
              />
            </div>
              <label class="formbold-form-label formbold-form-label-5" >
          <!-- Address Details -->
        </label>
        
        
          </div>
          <!-- Lawyer Dropdown -->
<!-- Specialization Dropdown -->
 <div class="formbold-mb-5">
        <label for="phone" class="formbold-form-label"> Date </label>
        <input
          type="date"
          name="date"
          id="date"
          placeholder="Enter date"
          class="formbold-form-input"
        />
      </div>
<div class="formbold-mb-5">
  <label for="specialization" class="formbold-form-label">Select Lawyer Specialization</label>
  <select name="specialization" id="specialization" class="formbold-form-input" required>
    <option value="">-- Select Specialization --</option>
    
    <?php
    include('../conn.php');
    $query = mysqli_query($conn, "SELECT DISTINCT specialization FROM lawyer");
    while ($row = mysqli_fetch_assoc($query)) {
      echo "<option value='{$row['specialization']}'>{$row['specialization']}</option>";
    }
    ?>
  </select>
  <!-- Lawyer Dropdown (initially hidden) -->
<div class="formbold-mb-5" id="lawyer-container" style="display: none;">
  <label for="lawyer_id" class="formbold-form-label">Select Lawyer</label>
  <select name="lawyer_id" id="lawyer_id" class="formbold-form-input" required>
    <option class="op" value="">-- Select Lawyer --</option>
  </select>
</div>
</div>


          
          
         
        </div>
      </div>
      

      <div>
         <!-- <button class="formbold-btn" type="submit" value="submit" name="button" >Book an Appointment</button> -->
          <input class="formbold-btn" type="submit" value="Book An Appointment" name="button">
      </div>
    </form>
  </div>
</div>



<!-- Make sure jQuery is loaded BEFORE your script -->
<script>
$(document).ready(function() {
    console.log("Document ready - jQuery is working");
    
    $('#specialization').change(function() {
        var specialization = $(this).val();
        console.log("Selected specialization: " + specialization);
        
        if (specialization) {
            console.log("Fetching lawyers for: " + specialization);
            
            $.ajax({
                url: 'getlawyers.php',
                type: 'POST',
                data: { specialization: specialization },
                dataType: 'html',
                success: function(response) {
                    console.log("Response received: ", response);
                    $('#lawyer_id').html(response);
                    $('#lawyer-container').show();
                    
                    // If no lawyers found, show message
                    if (response.includes('No lawyers found')) {
                        alert('No lawyers found for this specialization');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("Error loading lawyers. Please try again.");
                }
            });
        } else {
            $('#lawyer-container').hide();
            $('#lawyer_id').html('<option value="">-- Select Lawyer --</option>');
        }
    });
});
</script>


</body>
<script src="Doc/js/custom.js"></script>
<script src="Doc/js/jquery.nav.js"></script>
</html>   