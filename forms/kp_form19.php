<?php
session_start();
$linkedNames = $_SESSION['linkedNames'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>kp_form19</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
    
</head>
<body>
    <br>
    <div class="container">
        <div class="paper">
                <div class="top-right-buttons">
                <!-- Print button -->
                <button class="btn btn-primary print-button common-button" onclick="window.print()">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
               
            </div>
            
             <div style="text-align: left;">
                <h5>KP Form No. 19</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
            </div>
             <?php
    $caseErr = $forErr = $compErr = $respErr = "";
    $case = $for = $complainant = $respondent = "";
     
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (empty($_POST["case"])) {
            $caseErr = "Case is required";
          } else {
            $case = test_input($_POST["case"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$case)) {
      $caseErr = "Only letters and white space allowed";
    }
  }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (empty($_POST["For"])) {
            $forErr = "For is required";
          } else {
            $for = test_input($_POST["For"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$for)) {
      $forErr = "Only letters and white space allowed";
    }
  }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (empty($_POST["Complainant"])) {
            $compErr = "Complainant is required";
          } else {
            $complainant = test_input($_POST["Complainant"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$complainant)) {
      $compErr = "Only letters and white space allowed";
    }
  }
              
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (empty($_POST["Respondents"])) {
            $respErr = "Case is required";
          } else {
            $respondent = test_input($_POST["Respondents"]);  
            if (!preg_match("/^[a-zA-Z-' ]*$/",$respondent)) {
      $respErr = "Only letters and white space allowed";
    }
  }


    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
}
}
}
}

?>

            
<form method="post" action="<?php ($_SERVER["PHP_SELF"]);?>"> 


<div class="form-group" style="text-align: right;">


    <div class="label"> </div>
    <div class="input-field">
        <input type="text" name="barangayCaseNo" pattern="\d{3}-\d{3}-\d{4}" maxlength="15" placeholder="Case No. - Blotter No. - MMYY" style="width: 30%;"
        value="<?php echo $case;?>"> <br><br> <p>For: <input type="text" name="for" id="for" size="30" value="<?php echo $for;?>"> <br> <input type="text" name="for" id="for" size="30">
    </div>
</div>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> Complainants:<br><input type="text" name="complainant" id="complainant" size="30"><br><input type="text" name="complainant" id="complainant" size="30"> </p>
    <br><p> — against —</p>
</div>
</div>

<div>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> Respondents:<br><input type="text" name="respondent" id="respondent" size="30"><br><input type="text" name="respondent" id="respondent" size="30" 
            value="<?php echo $respondent;?>"> </p>
    </div>
</div>
            
            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>

           

                <script>
                    var yearInput = document.getElementById('year');

                    yearInput.addEventListener('keyup', function(event) {
                        if (event.keyCode === 38) {
                            event.preventDefault();
                            var year = parseInt(yearInput.value);
                            yearInput.value = year + 1;
                        }
                    });

                    yearInput.addEventListener('keyup', function(event) {
                        if (event.keyCode === 40) {
                            event.preventDefault();
                            var year = parseInt(yearInput.value);
                            yearInput.value = year - 1;
                        }
                    });
                </script>

                <h3 style="text-align: center;"><b> NOTICE OF HEARING <br>
(RE: FAILURE TO APPEAR)</b> </h3>
   <div style="margin-left: 20px; text-align: left;">
    <div>
      To:
      <br>
     <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
      <input type="text" name="complainant" id="complainant" size="30"><br><input type="text" name="complainant" id="complainant" size="30"> 
      <br>
      <br>
       <label style=" text-align: left; font-weight: normal;"> Respondent/s </label>
  </div>
                  
  </div>
</div>
</div>
    <div>
     <p style="text-indent: 2.8em; text-align: justify; ">
  You are hereby required to appear before me on

    <input type="text" name="day" placeholder="day" size="1" required>  of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
             at <label for="timeInput"> </label>
        <input type="time" id="timeInput">
        

    <script>
        function getTime() {
            var selectedTime = document.getElementById("timeInput").value;
            alert("Selected Time: " + selectedTime);
        }
    </script> o'clock in the morning/afternoon to explain why you failed to appear for mediation/conciliation scheduled on
<input type="text" name="day" placeholder="day" size="1" required>  of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
and why your counterclaim (if any) arising from the complaint should not be dismissed, a certificate to bar the filing of said counterclaim in
court/government office should not be issued, and contempt proceedings should not be initiated in court for willful failure or refusal to
appear before the Punong Barangay/Pangkat ng Tagapagkasundo.
<br>
<br>
 This <input type="text" name="day" placeholder="day" size="1" required>  of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
              <div id="nameInput" style="display: none;">
  <input type="text" id="name" name="name" placeholder="Enter Name" oninput="updateOptionText(this.value)" onkeydown="checkEnterKey(event)">
</div>

        <br>
        <br>
        <br>
    <hr style="border-top: 1px solid black; width: 30%; margin-left: 530px;">
        <p style="text-align: right; margin-left: 500px; margin-right: auto;">Punong Barangay/Pangkat Chairman</p>
        <br>
      <div style="text-align: left; text-indent: 0em; margin-left: 0px;">


Notified this 
<br>

<br>
 This <input type="text" name="day" placeholder="day" size="1" required>  of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
              
<br>
<br>
    </div>
       <br>
      <h3 style="text-align:left">Complainant/s</h3>
    <div style="text-align:left;" >
        <input type="text" placeholder=" ">
        <br>
        <input type="text" placeholder=" ">


    <h3 style="text-align:left">Respondent/s</h3>
    <div style="text-align:left;">
        <input type="text" placeholder=" ">
        <br>
        <input type="text" placeholder=" ">
    </div>
</div>
 <br>
        
     <!-- New arrow buttons -->
        <div style="position: fixed; bottom: 20px; right: 20px; display: flex; flex-direction: column;">
        <!-- Button to go to the top of the form -->
        <button class="btn btn-dark arrow-button" onclick="goToTop()">
            <i class="fas fa-arrow-up"></i>
        </button>
        <!-- Button to go to the bottom of the form -->
        <button class="btn btn-secondary arrow-button" onclick="goToBottom()">
            <i class="fas fa-arrow-down"></i>
        </button>
        </div>
        <script>
        // Function to scroll to the top of the form
        function goToTop() {
            window.scrollTo(0, 0);
        }
        
        // Function to scroll to the bottom of the form
        function goToBottom() {
            window.scrollTo(0, document.body.scrollHeight);
        }
    </script>
      
</body>
</html>