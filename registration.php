<!doctype html>
<html lang="en">

<head>

  <?php
session_start();
include 'connection.php';
 include 'header.php'; 

include 'registration_handler.php';

  ?>
    <title>Registration</title>
    <style>
  .card {
    position: relative;
    top: 50px;
    left: 36%;
    max-width: 980px; 
    height: 740px;  
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    padding-bottom: 500px;
  
  }
      </style>
</head>

<body>

<div class="card" style="width: 30rem;">
  <div class="card-header">Create an account</div>
  <div class="card-body">
    <?php if (isset($errors['registration'])): ?>
      <p style="color: <?php echo $errors['registration'] ? 'green' : 'red'; ?>; font-style: italic;"><?php echo $errors['registration']; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
      <select class="form-control" id="first-dropdown" onchange="populateSecondDropdown()" name="municipality_name" required>
        <option value="" disabled selected>Select Municipality</option>
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
      <br>

      <div class="form-row">
        <div class="col">
          <input type="text" class="form-control" required name="username" placeholder="Username" value="">
          <?php if (isset($errors['username'])): ?>
            <p style="color: red; font-style: italic;"><?php echo $errors['username']; ?></p>
          <?php endif; ?>
        </div>
      </div><br>
      <div class="form-row">
        <div class="col">
    <input type="text" class="form-control" required name="first_name" placeholder="First Name" value="<?php echo isset($fname) ? $fname : ''; ?>">
        </div>
      </div><br>
      <div class="form-row">
        <div class="col">
          <input type="text" class="form-control" required name="last_name" placeholder="Last Name" value="<?php echo isset($lname) ? $lname : ''; ?>">
        </div>
      </div><br>

      <div class="form-row">
        <div class="col">
          <input type="email" class="form-control" required name="email" placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>">
          <?php if (isset($errors['email'])): ?>
            <p style="color: red; font-style: italic;"><?php echo $errors['email']; ?></p>
          <?php endif; ?>
        </div>
      </div><br>

      <div class="form-row">
        <div class="col">
          <input type="number" class="form-control" required name="contact_number" placeholder="Contact Number" value="<?php echo isset($cont_num) ? $cont_num : ''; ?>">
        </div>
      </div><br>

      <div class="form-row">
        <div class="col">
<input type="password" class="form-control" required pattern=".{8,}" title="Password must be at least 8 characters long" name="password" placeholder="Password">
        </div>

        <div class="col">
          <input type="password" class="form-control" required name="cpass" placeholder="Confirm Password">
        </div>
          <?php if (isset($errors['password'])): ?>
            <p style="color: red; font-style: italic;"><?php echo $errors['password']; ?></p>
          <?php endif; ?>
      </div><br>

      <select class="form-control" id="exampleFormControlSelect1" name="utype" onchange="toggleSecretaryField()" required>
        <option value="" disabled selected>I am a:</option>
        <option value="user">Barangay Secretary</option>
        <option value="admin">DILG Secretary</option>
      </select>

      <br>

      <div style="display: none;" id="barangay-secretary-field">
        <select class="form-control" id="second-dropdown" name="barangay_name" required>
          <option disabled selected>Select Barangay</option>
        </select>
      </div>

        <?php if (isset($errors['barangay'])): ?>
          <p style="color: red; font-style: italic;"><?php echo $errors['barangay']; ?></p>
        <?php endif; ?>
      <p>Already have an account?<a href="login.php"> Login here</a>.</p>
      <input type="submit" name="register" class="btn btn-primary" value="Register"><br><br>
      <input type="reset" value="Clear Form" class="btn btn-danger">
    </form>
  </div>
</div>


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
    