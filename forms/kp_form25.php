<?php
session_start();
$linkedNames = $_SESSION['linkedNames'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>kp_form25</title>
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
                <h5>KP Form No. 25</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
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

                <h3 style="text-align: center;"><b> NOTICE OF EXECUTION </b><br>

 </h3>
 <br>
        <div style="display: flex;">
  <div style="text-align: justify;">
    <!-- Content for the left column -->
  </div>



<div>
    <p style="text-indent: 2.0em; text-align: justify;">
 WHEREAS, on

    <input type="text" name="day" placeholder="day" size="1" required>  of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
             an amicable settlement was signed by the parties in the above-entitled case [or an
arbitration award was rendered by the Punong Barangay/Pangkat ng Tagapagkasundo]; <br> <br>
WHEREAS, the terms and conditions of the settlement, the dispositive portion of the award. read:
 <hr style="border-top: 1px solid black; width: 100%;">

 <p style="text-indent: 2.0em; text-align: justify;">
    The said settlement/award is now final and executory;
WHEREAS, the party obliged

<select id="ComplainantRespondent" name="ComplainantRespondent" onchange="toggleInputField()" required>
  <option value="" disabled selected>Complainant/s/Respondent/s</option>
  <option value="Complainant">Complainant/s Name</option>
  <option value="Respondent">Respondent/s Name</option>
</select>
has not complied voluntarily with the aforestated amicable
settlement/arbitration award, within the period of five (5) days from the date of hearing on the motion for execution;
<div id="nameInput" style="display: none;">
  <input type="text" id="name" name="name" placeholder="Enter Name" oninput="updateOptionText(this.value)" onkeydown="checkEnterKey(event)">
</div>

<p id="selectedOptionLabel" style="display: none;"></p>

<script>
  function toggleInputField() {
    var selectElement = document.getElementById("ComplainantRespondent");
    var nameInput = document.getElementById("nameInput");
    var selectedOptionLabel = document.getElementById("selectedOptionLabel");

    if (selectElement.value === "Complainant") {
      nameInput.style.display = "block";
      nameInput.placeholder = "Enter Name";
      selectedOptionLabel.style.display = "inline";
      selectedOptionLabel.textContent = "Complainant: ";
      selectElement.options[selectElement.selectedIndex].text = "Complainant: " + nameInput.value;
    } else if (selectElement.value === "Respondent") {
      nameInput.style.display = "block";
      nameInput.placeholder = "Enter Name";
      selectedOptionLabel.style.display = "inline";
      selectedOptionLabel.textContent = "Respondent: ";
      selectElement.options[selectElement.selectedIndex].text = "Respondent: " + nameInput.value;
    } else {
      nameInput.style.display = "none";
      selectElement.options[selectElement.selectedIndex].text = "Complainant/s/Respondent/s";
      selectedOptionLabel.style.display = "none";
    }
  }

  function updateOptionText(value) {
    var selectElement = document.getElementById("ComplainantRespondent");
    var selectedOptionLabel = document.getElementById("selectedOptionLabel");

    if (selectElement.value === "Complainant") {
      selectElement.options[selectElement.selectedIndex].text = "Complainant: " + value;
    } else if (selectElement.value === "Respondent") {
      selectElement.options[selectElement.selectedIndex].text = "Respondent: " + value;
    }
  }

  function checkEnterKey(event) {
    if (event.key === "Enter") {
      event.preventDefault();
      var nameInput = document.getElementById("name");
      nameInput.value = "";
      nameInput.blur(); // Remove focus from the input field
      var nameInputContainer = document.getElementById("nameInput");
      nameInputContainer.style.display = "none";
      var selectElement = document.getElementById("ComplainantRespondent");
      selectElement.focus(); // Return focus to the select element
      var selectedOptionLabel = document.getElementById("selectedOptionLabel");
      selectedOptionLabel.style.display = "none";
    }
  }
</script>
 <p style="text-indent: 2.0em; text-align: justify;">
NOW, THEREFORE, in behalf of the Lupong Tagapamayapa and by virtue of the powers vested in me and the Lupon by the
Katarungang Pambarangay Law and Rules, I shall cause to be realized from the goods and personal property of
<select id="ComplainantRespondent" name="ComplainantRespondent" onchange="toggleInputField()" required>
  <option value="" disabled selected>Complainant/s/Respondent/s</option>
  <option value="Complainant">Complainant/s Name</option>
  <option value="Respondent">Respondent/s Name</option>
</select>
the sum of _________________ (state amount of settlement or award) upon in the said amicable settlement [or
adjudged in the said arbitration award], unless voluntary compliance of said settlement or award shall have been made upon receipt
hereof.
<div id="nameInput" style="display: none;">
  <input type="text" id="name" name="name" placeholder="Enter Name" oninput="updateOptionText(this.value)" onkeydown="checkEnterKey(event)">
</div>

<p id="selectedOptionLabel" style="display: none;"></p>

<script>
  function toggleInputField() {
    var selectElement = document.getElementById("ComplainantRespondent");
    var nameInput = document.getElementById("nameInput");
    var selectedOptionLabel = document.getElementById("selectedOptionLabel");

    if (selectElement.value === "Complainant") {
      nameInput.style.display = "block";
      nameInput.placeholder = "Enter Name";
      selectedOptionLabel.style.display = "inline";
      selectedOptionLabel.textContent = "Complainant: ";
      selectElement.options[selectElement.selectedIndex].text = "Complainant: " + nameInput.value;
    } else if (selectElement.value === "Respondent") {
      nameInput.style.display = "block";
      nameInput.placeholder = "Enter Name";
      selectedOptionLabel.style.display = "inline";
      selectedOptionLabel.textContent = "Respondent: ";
      selectElement.options[selectElement.selectedIndex].text = "Respondent: " + nameInput.value;
    } else {
      nameInput.style.display = "none";
      selectElement.options[selectElement.selectedIndex].text = "Complainant/s/Respondent/s";
      selectedOptionLabel.style.display = "none";
    }
  }

  function updateOptionText(value) {
    var selectElement = document.getElementById("ComplainantRespondent");
    var selectedOptionLabel = document.getElementById("selectedOptionLabel");

    if (selectElement.value === "Complainant") {
      selectElement.options[selectElement.selectedIndex].text = "Complainant: " + value;
    } else if (selectElement.value === "Respondent") {
      selectElement.options[selectElement.selectedIndex].text = "Respondent: " + value;
    }
  }

  function checkEnterKey(event) {
    if (event.key === "Enter") {
      event.preventDefault();
      var nameInput = document.getElementById("name");
      nameInput.value = "";
      nameInput.blur(); // Remove focus from the input field
      var nameInputContainer = document.getElementById("nameInput");
      nameInputContainer.style.display = "none";
      var selectElement = document.getElementById("ComplainantRespondent");
      selectElement.focus(); // Return focus to the select element
      var selectedOptionLabel = document.getElementById("selectedOptionLabel");
      selectedOptionLabel.style.display = "none";
    }
  }
</script>
            </p>

    </p></div>
</div>

            <div style="text-align: justify; text-indent: 0em; margin-left: 30px;"> Signed this <input type="text" name="day" placeholder="day" size="1" required>  of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
              
            </p>

        </form>
</div>

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <div style="position: relative;">
        <br>
        <br>
        <br>
     <hr style="border-top: 1px solid black; width: 30%; margin-left: 530px;">
        <p style="text-align: right ">
Punong Barangay</p>
        <br>
      
</div>
 <p style="text-indent: 2.0em; text-align: justify;">
Copy Finished: </p>
  <br>
 

<div style="display: flex; justify-content: center;">
  <div style="margin-right: 50px; flex: 1;">
    <hr style="border-top: 1px solid black; width: 100%;">
      <br>
     <hr style="border-top: 1px solid black; width: 100%;">
    <p style="text-align: center;">Complainant/s</p>
  </div>
  <div style="margin-left: 50px; flex: 1;">
    <hr style="border-top: 1px solid black; width: 100%;">
    <br>   
     <hr style="border-top: 1px solid black; width: 100%;">
    <p style="text-align: center;">Respondent/s</p>
    <br>
  </div>

        <div class="blank-page"></div> <!-- Add a blank div with the class "blank-page" to be excluded from printing -->
<br>
</p>
</div>
</p>
</div>

</div>
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