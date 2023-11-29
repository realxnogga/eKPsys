<?php
include 'connection.php';
session_start();

include 'header.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'admin_func.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secretary's Corners</title>
</head>
<body>
<h2 style="text-align: center;">Secretary's Corner</h2>
<a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
<div class="card" style="width: 30rem;">
  <div class="card-header">Create an account</div>
  <div class="card-body">
    <?php if (isset($errors['registration'])): ?>
      <p style="color: <?php echo $errors['registration'] ? 'green' : 'red'; ?>; font-style: italic;"><?php echo $errors['registration']; ?></p>
    <?php endif; ?>
    <form action="" method="POST">

        <div class="form-row">
        <div class="col">
      <input type="text" class="form-control" name="munic_name" value="testing" disabled>
      </div>
      </div><br>
    
      <br>

      <div class="form-row">
        <div class="col">
          <input type="text" class="form-control" required name="username" placeholder="Username" value="User Name">
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
          <input type="password" class="form-control" required name="password" placeholder="Password">
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

<?php include('footer.php'); ?>

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
</body>
</html>
