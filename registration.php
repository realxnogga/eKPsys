<?php
session_start();
include 'connection.php';
include 'registration_handler.php';
include 'functions.php';


  ?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">

</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-5">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                </a>
                <div class="text-center">
    <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle"><br><br>
    <b><h5 class="card-title mb-9 fw-semibold">Create Account</h5></b>
</div>
<b>

<?php if (isset($errors['registration'])): ?>
      <p style="color: <?php echo $errors['registration'] ? 'green' : 'red'; ?>; font-style: italic;"><?php echo $errors['registration']; ?></p>
    <?php endif; ?><b>
    <form action="" method="POST">
    <label for="mediation">Select Municipality:</label>

      <select class="form-select" id="first-dropdown" onchange="populateSecondDropdown()" name="municipality_name" required>
        <option value="" disabled selected>Select</option>
        <option value="Alaminos">Alaminos</option>
        <option value="Bay">Bay</option>
        <option value="Binan">Biñan</option>
        <option value="Cabuyao">Cabuyao</option>
        <option value="Calamba">Calamba</option>
        <option value="Calauan">Calauan</option>
        <option value="Los Baños">Los Baños</option>
        <option value="San Pablo">San Pablo</option>
        <option value="San Pedro">San Pedro</option>
        <option value="Sta Rosa">Sta. Rosa</option>
      </select>
      <?php if (isset($errors['municipality'])): ?>
        <p style="color: red; font-style: italic;"><?php echo $errors['municipality']; ?></p>
      <?php endif; ?>
      

      <div class="form-row">
        <div class="col">
        <label for="mediation">Username:</label>

          <input type="text" class="form-control" required name="username" placeholder="Enter username" value="">
          <?php if (isset($errors['username'])): ?>
            <p style="color: red; font-style: italic;"><?php echo $errors['username']; ?></p>
          <?php endif; ?>
        </div>
      </div>
      <div class="row">   
        <div class="col-md-6 mb-6">
                <label for="mediation">First Name:</label>
                <input type="text" class="form-control" required name="first_name" placeholder="Enter Name" value="<?php echo isset($fname) ? $fname : ''; ?>">
            </div>
            <div class="col-md-6 mb-6">
                <label for="conciliation">Last Name:</label>
                   <input type="text" class="form-control" required name="last_name" placeholder="Enter Name" value="<?php echo isset($lname) ? $lname : ''; ?>">
            </div>
      </div>

      <div class="row">   
        <div class="col-md-6 mb-6">
                <label for="mediation">Email:</label>
                <input type="email" class="form-control" required name="email" placeholder="Enter Email" value="<?php echo isset($email) ? $email : ''; ?>">
            </div>
            <div class="col-md-6 mb-6">
                <label for="conciliation">Contact Number:</label>
                <input type="number" class="form-control" required name="contact_number" placeholder="Enter Number" value="<?php echo isset($cont_num) ? $cont_num : ''; ?>">
            </div>
      </div>

      <div class="row">   
        <div class="col-md-6 mb-6">
                <label for="mediation">Password:</label>
                <input type="password" class="form-control" required name="password" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}" title="Password must contain at least 8 characters, including uppercase(A-Z), lowercase (a-z), number(0-9), and special character (!@#$%^&*). Example: Cluster-A2024">
            </div>
            <div class="col-md-6 mb-6">
                <label for="conciliation">Confirm Password:</label>
                <input type="password" class="form-control" required name="cpass" placeholder="Enter Password">
                <?php if (isset($errors['password'])): ?>
            <p style="color: red; font-style: italic;"><?php echo $errors['password']; ?></p>
          <?php endif; ?>
            </div>
      </div>

      <label for="mediation">I am a:</label>
      <select class="form-select" id="exampleFormControlSelect1" name="utype" onchange="toggleSecretaryField()" required>
        <option value="" disabled selected>Select</option>
        <option value="user">Barangay Secretary</option>
        <option value="admin">C/MLGOOs</option>
      </select>

      <br>

      <div style="display: none;" id="barangay-secretary-field">
      <label for="mediation">Select Barangay:</label>
        <select class="form-select" id="second-dropdown" name="barangay_name" required>
          <option disabled selected>Select</option>
        </select>
      </div>

        <?php if (isset($errors['barangay'])): ?>
          <p style="color: red; font-style: italic;"><?php echo $errors['barangay']; ?></p>
        <?php endif; ?>
      <p>Already have an account?<a href="login.php"> Login here</a>.</p>
      <input type="submit" name="register" class="btn btn-primary m1" value="Register"><br><br>
    </form>
          
                
              

       </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<script>
  function toggleSecretaryField() {
    const userTypeSelect = document.getElementById("exampleFormControlSelect1");
    const barangaySecretaryField = document.getElementById("barangay-secretary-field");

    if (userTypeSelect.value === "user") {
      barangaySecretaryField.style.display = "block";
    } else {
      barangaySecretaryField.style.display = "none";
    }
  }
</script>
<script src="populateBrgyscript.js"></script> 