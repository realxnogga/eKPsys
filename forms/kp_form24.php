<?php
session_start();
include 'connection.php';
$forTitle = $_SESSION['forTitle'] ?? '';
$cNames = $_SESSION['cNames'] ?? '';
$rspndtNames = $_SESSION['rspndtNames'] ?? '';
$cDesc = $_SESSION['cDesc'] ?? '';
$petition = $_SESSION['petition'] ?? '';
$cNum = $_SESSION['cNum'] ?? '';

$punong_barangay = $_SESSION['punong_barangay'] ?? '';

$complaintId = $_SESSION['current_complaint_id'] ?? '';
$currentHearing = $_SESSION['current_hearing'] ?? '';
$formUsed = 9;

// Fetch existing row values if the form has been previously submitted
$query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed";
$stmt = $conn->prepare($query);
$stmt->bindParam(':complaintId', $complaintId);
$stmt->bindParam(':formUsed', $formUsed);
$stmt->execute();
$rowCount = $stmt->rowCount();

$currentYear = date('Y');

// Array of months
$months = array(
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
);

$currentMonth = date('F'); 
$currentDay = date('j');

$id = $_GET['formID'] ?? '';

$existingScenario = 0; 
$existingScenarioInfo = ''; 

$existOfficer = '';
// Check if formID exists in the URL
if (!empty($id)) {
    // Fetch data based on the provided formID
    $query = "SELECT appear_date, made_date, received_date, resp_date, officer, scenario, scenario_info FROM hearings WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Extract and format the timestamp values
        $appearDate = new DateTime($row['appear_date']);
        $appear_day = $appearDate->format('j');

        $appear_month = $appearDate->format('F');
        $appear_year = $appearDate->format('Y');
        $appear_time = $appearDate->format('H:i'); // Format for the time input

        $madeDate = new DateTime($row['made_date']);
        $receivedDate = new DateTime($row['received_date']);
        $respDate = new DateTime($row['resp_date']);

        // Populate form inputs with the extracted values
        $currentDay = $appearDate->format('j');
        $currentMonth = $appearDate->format('F');
        $currentYear = $appearDate->format('Y');

        $existingMadeDay = $madeDate->format('j');
        $existingMadeMonth = $madeDate->format('F');
        $existingMadeYear = $madeDate->format('Y');

        $existingReceivedDay = $receivedDate->format('j');
        $existingReceivedMonth = $receivedDate->format('F');
        $existingReceivedYear = $receivedDate->format('Y');

        $existingRespDay = $respDate->format('j');
        $existingRespMonth = $respDate->format('F');
        $existingRespYear = $respDate->format('Y');

        $existOfficer = $row['officer'];
        $existingScenario = $row['scenario'];
        $existingScenarioInfo = $row['scenario_info'];

$rspndtName1 = ''; // Default to empty strings
$rspndtName2 = '';
$rspndtName3 = '';
$rspndtName4 = '';

$existScen3 = $existingScenarioInfo; // Default to empty strings
$existScen4 = $existingScenarioInfo;


// Echo existing scenario and scenario_info in the corresponding input fields
if ($existingScenario == 1) {
    $rspndtName1 = $rspndtNames;
} elseif ($existingScenario == 2) {
    $rspndtName2 = $rspndtNames;
} elseif ($existingScenario == 3) {
    $rspndtName3 = $rspndtNames;
    $existingScenarioInfo = $row['scenario_info']; // Assign scenario_info for scenario 3
} elseif ($existingScenario == 4) {
    $rspndtName4 = $rspndtNames;
    $existingScenarioInfo = $row['scenario_info']; // Assign scenario_info for scenario 4
         }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $madeDay = $_POST['made_day'] ?? '';
    $madeMonth = $_POST['made_month'] ?? '';
    $madeYear = $_POST['made_year'] ?? '';

    $receivedDay = $_POST['received_day'] ?? '';
    $receivedMonth = $_POST['received_month'] ?? '';
    $receivedYear = $_POST['received_year'] ?? '';

    $respDay = $_POST['resp_day'] ?? '';
    $respMonth = $_POST['resp_month'] ?? '';
    $respYear = $_POST['resp_year'] ?? '';

    $officer = $_POST['officer'];

    $day = $_POST['day'] ?? '';
    $month = $_POST['month'] ?? '';
    $year = $_POST['year'] ?? '';
    $time = $_POST['time'] ?? '';

$scenario = null;
$scenarioInfo = null;

if (!empty($_POST['scenario_1'])) {
    $scenario = 1;
    $scenarioInfo = '';
} elseif (!empty($_POST['scenario_2'])) {
    $scenario = 2;
    $scenarioInfo = '';
} elseif (!empty($_POST['scenario_3'])) {
    $scenario = 3;
    $scenarioInfo = $_POST['scenario_3a'];
} elseif (!empty($_POST['scenario_4'])) {
    $scenario = 4;
    $scenarioInfo = $_POST['scenario_4a'];
}


$dateTimeString = "$year-$month-$day $time";
$appearTimestamp = DateTime::createFromFormat('Y-F-j H:i', $dateTimeString);


if ($appearTimestamp !== false) {
    $appearTimestamp = $appearTimestamp->format('Y-m-d H:i:s');

    // Logic to handle date and time inputs
    $madeDate = createDateFromInputs($madeDay, $madeMonth, $madeYear);
    $receivedDate = createDateFromInputs($receivedDay, $receivedMonth, $receivedYear);
    $respDate = createDateFromInputs($respDay, $respMonth, $respYear);

    // Insert or update the appear_date in the hearings table
    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, appear_date, made_date, received_date, resp_date, officer, scenario, scenario_info)
          VALUES (:complaintId, :currentHearing, :formUsed, :appearDate, :madeDate, :receivedDate, :respDate, :officer, :scenario, :scenarioInfo)
          ON DUPLICATE KEY UPDATE
          hearing_number = VALUES(hearing_number),
          form_used = VALUES(form_used),
          appear_date = VALUES(appear_date),
          made_date = VALUES(made_date),
          received_date = VALUES(received_date),
          resp_date = VALUES(resp_date),
          officer = VALUES(officer),
          scenario = VALUES(scenario),
          scenario_info = VALUES(scenario_info)
          ";


    $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':appearDate', $appearTimestamp);
    $stmt->bindParam(':madeDate', $madeDate);
    $stmt->bindParam(':receivedDate', $receivedDate);
    $stmt->bindParam(':respDate', $respDate);
    $stmt->bindParam(':officer', $officer);
    $stmt->bindParam(':scenario', $scenario);
    $stmt->bindParam(':scenarioInfo', $scenarioInfo);

    if ($stmt->execute()) {
        $message = "Form submit successful.";
    } else {
        $message = "Form submit failed.";
    }
}
else {
        // Handle case where DateTime object creation failed
        $message ="Invalid date/time format! Input: ". $dateTimeString;
    }
}

// Function to create a date from day, month, and year inputs
function createDateFromInputs($day, $month, $year) {
    if (!empty($day) && !empty($month) && !empty($year)) {
        $monthNum = date('m', strtotime("$month 1"));
        return date('Y-m-d', mktime(0, 0, 0, $monthNum, $day, $year));
    } else {
        return date('Y-m-d');
    }
}

function createTimestampFromInputs($day, $month, $year, $time) {
    if (!empty($day) && !empty($month) && !empty($year) && !empty($time)) {
        return date('Y-m-d H:i:s', strtotime("$year-$month-$day $time"));
    } else {
        return null; 
    }
}

// Retrieve the profile picture name of the current user
$query = "SELECT profile_picture FROM users WHERE id = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user has a profile picture
if ($user && !empty($user['profile_picture'])) {
    $profilePicture = '../profile_pictures/' . $user['profile_picture'];
} else {
    // Default profile picture if the user doesn't have one set
    $profilePicture = '../profile_pictures/defaultpic.jpg';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>KP Form 24</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


</head>
<style>
     .profile-img{
    width: 3cm;
}

.header {
    text-align: center;
    padding-inline: 4cm;
}
    /* Hide the number input arrows */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hide the number input arrows for Firefox */
    input[type=number] {
        -moz-appearance: textfield;
        border: none;
        width: 30px;

    }
    h5{
        margin:0;
        padding:0;
    }
    @media print {
        .page-break {
            page-break-before: always;
        }
        input {
        border-bottom: 1px solid black !important;
    }
      {
        select[name="received_month"] {
            border-bottom: 1px solid black; /* Set the desired border style and color */
        }
    }
    }
    .bottom-border {
    border: none;
    border-bottom: 1px solid black;
}

</style>
<body>
<div class="container">
        <div class="paper">
                
                <div class="top-right-buttons">
    <button class="btn btn-primary print-button common-button" onclick="window.print()" style="position:fixed; right: 20px;">
        <i class="fas fa-print button-icon"></i> Print
    </button>
    <button class="btn btn-success download-button common-button" id="downloadButton" style="position:fixed; right: 20px; top: 75px; ">
        <i class="fas fa-file button-icon"></i> Download
    </button>

    <a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>">
        <button class="btn common-button" style="position:fixed; right: 20px; top: 177px;">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </a>

            </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 24 </b></h5>

            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
    <img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 100px; width: 100px;">

    <div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
        <br>
        <h5 class="header" style="font-size: 18px;">Republic of the Philippines</h5>
        <h5 class="header" style="font-size: 18px;">Province of Laguna</h5>
        <h5 class="header" style="text-align: center; font-size: 18px;">
    <?php
    $municipality = $_SESSION['municipality_name'];

    if (in_array($municipality, ['Alaminos', 'Bay', 'Los Banos', 'Calauan'])) {
        echo 'Municipality of ' . $municipality;
    } elseif (in_array($municipality, ['Biñan', 'Calamba', 'Cabuyao', 'San Pablo', 'San Pedro', 'Sta. Rosa'])) {
        echo 'City of ' . $municipality;
    } else {
        echo 'City/Municipality of ' . $municipality;
    }
    ?>
</h5>
        <h5 class="header" style="font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
        <h5 class="header" style="font-size: 18px;">OFFICE OF THE LUPONG TAGAPAMAYAPA</h5>
    </div>
</div>
<br>
<br>

            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $currentYear = date('Y');
            ?>

<div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif;" >
    <div class="input-field" style="float: right; width: 50%;">
        <!-- case num here -->
        <p style="text-align: left; margin-left:30px; font-size: 18px;">Barangay Case No.<span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNum) ? $cNum : '&nbsp;'; ?></span></p>

        <p style="text-align: left; margin-left:30px; margin-top: 0; font-size: 18px;"> For:  <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($forTitle) ? nl2br(htmlspecialchars($forTitle)) : '&nbsp;'; ?></span> </p>
    </div>
</div>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-family: 'Times New Roman', Times, serif;">
    <div class="label"></div>
    <div style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNames) ? $cNames : '&nbsp;'; ?>
                </div>
              
<p style="font-size: 18px;"> Complainant/s </p>
<p style="font-size: 18px;">- against -</p>
                </div>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-family: 'Times New Roman', Times, serif;">
  
    <div style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($rspndtNames) ? $rspndtNames : '&nbsp;'; ?>
                </div>
             
<p style="font-size: 18px;"> Respondent/s </p> 

       

                <h3 style="text-align: center;"><b style="font-size: 18px;"> NOTICE OF HEARING<br>
                (RE: MOTION FOR EXECUTION) </b> </h3>

                <div style="display: flex;">
    <div class="input-field">
        <p style="font-size: 18px;"> TO:     <span style="min-width: 150px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($cNames) ? $cNames : '&nbsp;'; ?></span></p>
    
        <p style="font-size: 18px; text-indent:2em;"> Complainant/s  </p>

</div>


    <div style="margin-left:20px;"class="input-field">
        <p style="font-size: 18px; ">  <span style="min-width: 150px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($rspndtNames) ? $rspndtNames: '&nbsp;'; ?></span></p>
   <p style="font-size: 18px; text-indent:2em;"> Respondent/s </p>
   
</div>

            </div>
    <br>

    <p style="font-size: 18px; text-indent: 2.8em; text-align: justify;font-size: 18px; ">
    You are hereby required to appear before me on     
    <input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width: 42px; font-size: 18px;"
 type="number" name="day" placeholder="day" min="1" max="31" value="<?php echo $appear_day; ?>" required>  of
                <select style="width:100px; border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; font-size: 18px;"
 name="month" required>
                    <option style=" border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width:44px;font-size: 18px;"
 value="">Select Month</option>
                    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width:44px; font-size: 18px;"
 value="<?php echo $appear_month; ?>" <?php echo ($m === $appear_month) ? 'selected' : ''; ?>><?php echo $appear_month; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
                </select>,
                
        <input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width: 42px; font-size: 18px;" type="text" name="year" placeholder="year" size="1" value="<?php echo isset($appear_year) ? $appear_year : date('Y'); ?>" required> at <input type="time" id="time" name="time" size="5" style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black;  font-size: 18px;"  value="<?php echo $appear_time; ?>"required>  o'clock in the morning/afternoon/evening for the hearing of the motion for execution, copy of which is attached hereto, filed by <input type="text" id="NamesContent" name="NamesContent" placeholder="Enter Complainant/s or Respondent/s Name" style="border: none; font-size: 18px; width:320px; text-align: right; margin-left: 10px; border-bottom: 1px solid black; display: inline-block;" />

    <!-- <select id="ComplainantRespondent" name="ComplainantRespondent" onchange="toggleInputField()" required style="display: inline-block;  border: none; border-bottom: 1px solid black;">
        <option style=" border: none; border-bottom: 1px solid black;" value="" disabled selected>Complainant/s/Respondent/s</option>
        <option style=" border: none; border-bottom: 1px solid black;" value="Complainant">Complainant/s</option>
        <option style=" border: none; border-bottom: 1px solid black;" value="Respondent">Respondent/s</option>
    </select> -->
</div>

<script>
    function toggleInputField() {
        var selectedOption = document.getElementById("ComplainantRespondent").value;
        var inputField = document.getElementById("NamesContent");

        if (selectedOption === "Complainant") {
            inputField.placeholder = "Enter Complainant/s Name";
            inputField.value = "<?php echo !empty($cNames) ? $cNames : ''; ?>";
        } else if (selectedOption === "Respondent") {
            inputField.placeholder = "Enter Respondent/s Name";
            inputField.value = "<?php echo !empty($rspndtNames) ? $rspndtNames : ''; ?>";
        }
    }
</script>
<br>
<div style="text-align:center;"><input style="text-align:center;font-size: 18px; border:none; border-bottom: 1px solid black;" type="text" name="year" id="dateInput" placeholder="Date" size="15" value="">
<p style="font-size: 18px; text-align:center;"> (Date) </p> 
<script>
    // Get current date
    const currentDate = new Date();

    // Format the date as M/Day/Year
    const options = { month: 'short', day: 'numeric', year: 'numeric' };
    const formattedDate = currentDate.toLocaleDateString('en-US', options);

    // Set the formatted date as the input value
    document.getElementById('dateInput').value = formattedDate;
</script>
</div>

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>


        <div id="nameInput" style="display: none;">
  <input type="text" id="name" name="name" placeholder="Enter Name" oninput="updateOptionText(this.value)" onkeydown="checkEnterKey(event)">
</div>
<p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 550px; margin-right: auto;">
    <span style=" font-family: 'Times New Roman', Times, serif; min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style=" font-family: 'Times New Roman', Times, serif;text-align: center; margin-left: 470px;   font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">Punong Barangay/Kalihim ng Lupon</label>
          
<div style="font-size: 18px; font-family: 'Times New Roman', Times, serif;"> 
Notified this <input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black;  font-size: 18px;" type="text" name="received_day" placeholder="day" size="5" value="<?php echo $existingReceivedDay ?? ''; ?>"> day of
  <select style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black;  font-size: 18px;" name="received_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black;  font-size: 18px;" value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black;  font-size: 18px;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input style="border: none; border-bottom: 1px solid black; border-bottom: 1px solid black; width:44px; font-size: 18px;" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : date('Y'); ?>">.
      
    </div>

    <div class="d">
    <div style=" font-family: 'Times New Roman', Times, serif;text-align: left; font-size: 18px; margin-left: 120px;"><br>
    <p style="font-size: 18px; text-align: center; margin-right: 355px;" ><br>Complainant/s <p class="important-warning-text" style="text-align: left; font-size: 18px; margin-left: 570px; margin-left: auto;">  <div style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNames) ? $cNames : '&nbsp;'; ?>
                </div>
            <id="cmplnts" name="cmplnts" size="25"  style="text-align: left;"></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
    <p style="font-size: 18px; margin-right: 355px; text-align: center;">Respondent/s <p class="important-warning-text" style="text-align: left; font-size: 18px; margin-left: 570px; margin-left: auto;">  <div style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($rspndtNames) ? $rspndtNames : '&nbsp;'; ?>
                </div>
            <id="rspndt" name="rspndt" size="25"  style="text-align: left;"></p><br><br>
  </div>
 </div>
</p>

<?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
   
            
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position:fixed; right: 20px; top: 130px;">

</form>


<script>
        document.getElementById('downloadButton').addEventListener('click', function () {
            // Elements to hide during PDF generation
            var buttonsToHide = document.querySelectorAll('.top-right-buttons button');
            var saveButton = document.querySelector('input[name="saveForm"]');

            // Hide the specified buttons
            buttonsToHide.forEach(function (button) {
                button.style.display = 'none';
            });

            // Hide the Save button
            saveButton.style.display = 'none';

            // Remove borders for all input types and select
            var inputFields = document.querySelectorAll('input, select');
            inputFields.forEach(function (field) {
                field.style.border = 'none';
            });

            var pdfContent = document.querySelector('.paper');
            var downloadButton = document.getElementById('downloadButton');

            // Hide the download button
            downloadButton.style.display = 'none';

            // Use html2pdf to generate a PDF
            html2pdf(pdfContent, {
                margin: 10,
                filename: 'your_page.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            }).then(function () {
                // Show the download button after PDF generation
                downloadButton.style.display = 'inline-block';

                // Show the Save button after PDF generation
                saveButton.style.display = 'inline-block';

                // Show the other buttons after PDF generation
                buttonsToHide.forEach(function (button) {
                    button.style.display = 'inline-block';
                });

                // Restore borders for all input types and select
                inputFields.forEach(function (field) {
                    field.style.border = ''; // Use an empty string to revert to default border
                });
            });
        });
    </script>

           
                </div>
            </div>
        </div>

<br>           
</div>
</body>

</html>