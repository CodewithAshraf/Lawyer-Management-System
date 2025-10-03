  <?php 
  
  include("../conn.php");
// Only process form if submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data if it exists
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : '';
    
    // Handle file upload
    if (isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
        $image = $_FILES['profile']['name'];
        $tmp = $_FILES['profile']['tmp_name'];
        $uploadDir = "../uploads/";
        
        
        
        // Move uploaded file
        move_uploaded_file($tmp, $uploadDir . $image);
        
        // Insert into database
        $query = "INSERT INTO `lawyers`(`username`, `email`, `password`, `ProfileImage`, `Specialization`)
                 VALUES ('$username','$email','$password','$image','$specialization')";
        mysqli_query($conn, $query);

         if (mysqli_query($conn, $query)) {
            
        
            header("Location: managelawyers.php");
        exit();
    } 
   
}
        
        // Redirect after successful submission
    
    }


  
  
  
  ?>
  
  <style>
      .modal {
    display: block;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow-y: auto;
    background-color: rgba(0, 0, 0, 0.6);
  }

.modal-content {
  background-color: #fff;
  margin: 5% auto;
  padding: 30px;
  border-radius: 10px;
  width: 90%;
  max-width: 450px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
  position: relative;
  animation: fadeSlide 0.5s ease-out;
    margin-top:10px;
}

@keyframes fadeSlide {
  0% {
    opacity: 0;
    transform: translateY(-30px) scale(0.95);
  }
  100% {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}


  .modal-content h2 {
    margin-bottom: 20px;
    font-size: 24px;
    text-align: center;
  }

  .modal-content label {
    font-weight: 600;
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
  }

  .modal-content input,
  .modal-content select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-size: 15px;
  }

  .modal-content button {
    width: 100%;
    background-color: #007bff;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
  }

  .modal-content button:hover {
    background-color: #0056b3;
  }

  .close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 25px;
    color: #333;
    cursor: pointer;
  }

  .close:hover {
    color: #000;
  }
.para{
    text-align:center;
}

body{
    background-color:white;
}
.select2-container {
  z-index: 99999 !important;
}
/* Make Select2 input look like other inputs */
.select2-container--default .select2-selection--single {
  height: 45px !important; /* Match your input height */
  border: 1px solid #ccc !important;
  border-radius: 6px !important;
  padding: 10px !important;
  font-size: 15px !important;
  box-sizing: border-box;
}

/* Align text vertically */
.select2-container--default .select2-selection--single .select2-selection__rendered {
  /* line-height: 25px !important; Adjust for vertical alignment */
}

/* Remove blue border on focus */
.select2-container--default .select2-selection--single:focus {
  outline: none !important;
  box-shadow: none !important;
}



  </style>
  
  
  
  
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
      <!-- Lawyer Registration Popup -->
<div id="signupModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="document.getElementById('signupModal').style.display='none'">&times;</span>
    <h2>Add Your Lawyer</h2>
    <p class="para">Please Fill the Following Fields to Add Lawyer</p>
    <form method="POST" enctype="multipart/form-data">
      <label>Username</label>
      <input type="text" name="username" placeholder="John Doe" required>

      <label>Profile Image</label>
      <input type="file" name="profile" required>

      <label>Email Address</label>
      <input type="email" name="email" placeholder="you@example.com" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter Your Password " required>

      <label>Specialization</label>
      <select name="specialization" required >
        <option value="">Select your specialization</option>
        <option value="Criminal Law">Criminal Law</option>
        <option value="Family Law">Family Law</option>
        <option value="Corporate Law">Corporate Law</option>
        <option value="Immigration Law">Immigration Law</option>
        >
      </select>

      <button type="submit">Add Lawyer</button>
      
    </form>
  </div>
</div>

<script>
  $(document).ready(function () {
    // Wait a bit to ensure modal and its elements are rendered
    setTimeout(function () {
      $('select[name="specialization"]').select2({
        width: '100%',
        dropdownAutoWidth: true
      });
    }, 100); // delay by 100ms
  });
</script>


</body>
</html>
