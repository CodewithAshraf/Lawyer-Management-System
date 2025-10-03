<?php
// Include database connection
include('../conn.php');

// Process form submission if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables with null coalescing operator
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $area = mysqli_real_escape_string($conn, $_POST['area'] ?? '');
    $lawyer_id = mysqli_real_escape_string($conn, $_POST['lawyer_id'] ?? '');
     $date = mysqli_real_escape_string($conn, $_POST['date'] ?? '');

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($area) || empty($lawyer_id)) {
        echo "<script>alert('Please fill in all the fields.'); window.history.back();</script>";
        exit();
    }

    // Verify the lawyer exists
    $lawyer_check = mysqli_query($conn, "SELECT id FROM lawyers WHERE id = '$lawyer_id'");
    if (!$lawyer_check || mysqli_num_rows($lawyer_check) == 0) {
        echo "<script>alert('Selected lawyer not found'); window.history.back();</script>";
        exit();
    }

//     $user_id = 1; // Simulated user (replace with $_SESSION['user_id'] when login is added)
//     session_start();
// $user_id = $_SESSION['user_id'];
session_start();

if (!isset($_SESSION['user_id'])) { 
    echo "<script>alert('User not logged in'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];


    // Insert appointment
    $sql = "INSERT INTO `appointment`
        (`user_id`, `lawyer_id`, `FullName`, `PhoneNumber`, `EmailAddress`, `Address`, `status`,`appointment_date`)
        VALUES ('$user_id', '$lawyer_id', '$name', '$phone', '$email', '$area', 'pending')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        die("Error inserting appointment: " . mysqli_error($conn));
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
  <label for="specialization" class="formbold-form-label">Select Lawyer Specialization</label>
  <select name="specialization" id="specialization" class="formbold-form-input" required>
    <option value="">-- Select Specialization --</option>
    <?php
    include('../conn.php');
    $query = mysqli_query($conn, "SELECT DISTINCT specialization FROM lawyers");
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
                url: '../getlawyers.php',
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