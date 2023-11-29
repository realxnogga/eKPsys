<!DOCTYPE html>
<html lang="en">
<head>

<title>Home</title>
<?php include('header.php'); ?>

<style>
    /* Add your preferred styles for the breadcrumb */
    .breadcrumb {
      background-color: #16336D;
      display: flex;
      align-items: center;
      width: 100%;
      margin: 0 auto; /* Center-align the breadcrumb */
      padding: 20px 95px;
      color: white;
      border-radius: 50px;
    }

    .breadcrumb a {
      text-decoration: none;
      color: white;
      margin-right: 10px;
    }

    .breadcrumb a:hover {
      text-decoration: underline;
    }

    /* Style for content sections */
    .content-section {
      display: none;
      padding: 20px;
      width: 100%;
      height: 100%;
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background-color: white; /* Set the background color for the entire page */
    }

    



  





body {
  margin: 0;
  padding: 0;
  padding: 20px 50px;
}

/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn {   
  float: left;
  width: 75%;
}

/* Right column */
.rightcolumn {
  float: left;
  width: 25%;
  padding-left: 20px;
}

/* Fake image */
.fakeimg {
  background-color: #aaa;
  width: 100%;
  padding: 20px;
}

/* Add a card effect for articles */
.card {
   background-color: white;
   padding: 50px;
   margin-top: 20px;
}



/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;

}


/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 800px) {
  .leftcolumn, .rightcolumn {   
    width: 100%;
    padding: 0;
  }
}



   

    /* slide */

    .image-container {
      position: relative;
      width: 100%;
      height: 100%;
      overflow: hidden;
      border-radius: 10px;
      top: 1px;


    }

    .image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(70%); 
    }

    .caption {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 20px;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.7)); /* Adjust gradient colors as needed */
      color: white;
      text-align: center;
    }



    
  </style>

</head>

<body>






  




<div class="row">
  <div class="leftcolumn">
    <div class="card">





    </div>

  </div>
  <div class="rightcolumn">
    <div class="card">

    <h4>Register | Create an account</h4><br>

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

    

  </div>
</div>


    
</div>















</div>





</body>
</html>
