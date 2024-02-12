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
$formUsed = 17;

// Fetch existing row values if the form has been previously submitted
$query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed";
$stmt = $conn->prepare($query);
$stmt->bindParam(':complaintId', $complaintId);
$stmt->bindParam(':formUsed', $formUsed);
$stmt->execute();
$rowCount = $stmt->rowCount();

$currentYear = date('Y'); // Get the current year

// Array of months
$months = array(
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
);

$currentMonth = date('F'); 
$currentDay = date('j');

$id = $_GET['formID'] ?? '';

// Check if formID exists in the URL
if (!empty($id)) {
    // Fetch data based on the provided formID
    $query = "SELECT made_date, received_date, resp_date FROM hearings WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $madeDate = new DateTime($row['made_date']);
        $receivedDate = new DateTime($row['received_date']);
        $respDate = new DateTime($row['resp_date']);

        $existingMadeDay = $madeDate->format('j');
        $existingMadeMonth = $madeDate->format('F');
        $existingMadeYear = $madeDate->format('Y');

        $existingReceivedDay = $receivedDate->format('j');
        $existingReceivedMonth = $receivedDate->format('F');
        $existingReceivedYear = $receivedDate->format('Y');

        $existingRespDay = $respDate->format('j');
        $existingRespMonth = $respDate->format('F');
        $existingRespYear = $respDate->format('Y');


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
    
    // Logic to handle date and time inputs
    $madeDate = createDateFromInputs($madeDay, $madeMonth, $madeYear);
    $receivedDate = createDateFromInputs($receivedDay, $receivedMonth, $receivedYear);
    $respDate = createDateFromInputs($respDay, $respMonth, $respYear);

    // Insert or update the appear_date in the hearings table
    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, made_date, received_date, resp_date)
              VALUES (:complaintId, :currentHearing, :formUsed, :madeDate, :receivedDate, :respDate)
              ON DUPLICATE KEY UPDATE
              hearing_number = VALUES(hearing_number),
              form_used = VALUES(form_used),
              made_date = VALUES(made_date),
              received_date = VALUES(received_date),
              resp_date = VALUES(resp_date)
              ";


     $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':madeDate', $madeDate);
    $stmt->bindParam(':receivedDate', $receivedDate);
    $stmt->bindParam(':respDate', $respDate);

    
    if ($stmt->execute()) {
        $message = "Form submit successful.";
    } else {
        $message = "Form submit failed.";
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
    <title>KP FORM 17</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">

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

    }
    h5{
        margin:0;
        padding:0;
    }
    .checkbox-container {
        display: flex;
        align-items: center;
    }

    .checkbox-label {
        margin-left: 10px;
        font-size: 18px;
        font-weight:normal;
    }

    .a {
        margin-top: 5px;
        margin-bottom: 15px;
    }
    

    @media print {
        
        
        .checkbox-label {
            border-bottom: none;
        }
        #nameR {
            border-bottom: none;
        }
    }
</style>
</head>
<body>
<div class="container">
        <div class="paper">
                <div class="top-right-buttons">
                <!-- Print button -->

            </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 17 </b></h5>

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
    <div class="label"></div>
    <div style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($rspndtNames) ? $rspndtNames : '&nbsp;'; ?>
                </div>
                <div>
<p style="font-size: 18px;"> Respondent/s </p> </div>
<form method ="POST">
<h3 style="text-align: center;"><b style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">REPUDIATION</b></h3>

<div style="text-align: justify; text-indent: 0em; margin-left: 1px; font-size: 18px; font-family: 'Times New Roman', Times, serif;">I/WE hereby repudiate the settlement/agreement for arbitration on the ground that my/our consent was vitiated by: <br>
(Check out whichever is applicable)
    </div>
    <br>

    <div style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <div class="checkbox-container">
        <input type="checkbox" id="fraudCheckbox">
        <label for="fraudCheckbox" class="checkbox-label"> Fraud. (State details)</label>
    </div>
    <div class="a">
        <div id="nameR" name="nameR" style="text-decoration: underline; width: 700px; height: auto; border:none; overflow-y: hidden; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"> State details here.........................................................................................................................</div>
    </div>

    <div class="checkbox-container">
        <input type="checkbox" id="violenceCheckbox">
        <label for="violenceCheckbox" class="checkbox-label"> Violence. (State details)</label>
    </div>
    <div class="a">
        <div id="nameR" name="nameR" style="text-decoration: underline; width: 700px; height: auto; border:none;  overflow-y: hidden; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"> State details here.........................................................................................................................</div>
    </div>

    <div class="checkbox-container">
        <input type="checkbox" id="intimidationCheckbox">
        <label for="intimidationCheckbox" class="checkbox-label"> Intimidation. (State details)</label>
    </div>
    <div class="a">
        <div id="nameR" name="nameR" style="text-decoration: underline; width: 700px; height: auto; border:none;  overflow-y: hidden; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"> State details here.........................................................................................................................</div>
    </div>
</div>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;font-size: 18px;font-family: 'Times New Roman', Times, serif; "> This
    <input style="border: none; border-bottom: 1px solid black;font-size: 18px; width: 33px; margin-right: 5px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="number" name="received_day" placeholder="day" min="01" max="31" value="<?php echo isset($existingReceivedDay) ? $existingReceivedDay : ''; ?>"> day of 
                                    <select select style="border: none; border-bottom: 1px solid black;width: auto; font-size: 18px; margin-right: 5px;"  name="received_month">
                                        <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="">Select Month</option>
                                        <?php foreach ($months as $m): ?>
                                            <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="<?php echo $m; ?>" <?php echo isset($existingReceivedMonth) && $existingReceivedMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
                                        <?php endforeach; ?>
                                    </select>,
        <input style="border-bottom: 1px solid black; width: 42px; font-size: 18px;" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : ''; ?>"> .              
</div> 
<br>
<div style="display: flex; justify-content: space-between; font-size: 18px; text-align: center; ">
    <div style="text-align: center; margin-left: 210px;">
        <p style="font-size: 18px;font-family: 'Times New Roman', Times, serif; ">Complainant/s</p>
        <ul style="margin-bottom: 10; padding: 0; list-style: none; font-size: 18px; text-align: center;">
        <span style="min-width: 30px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;"><?php echo $cNames; ?></span>
           
        </ul>
    </div>

    <div style="text-align: center; margin-right: 210px;font-family: 'Times New Roman', Times, serif;">
        <p style="font-size: 18px;font-family: 'Times New Roman', Times, serif; ">Respondent/s</p>
        <ul style="margin-bottom: 10; padding: 0; list-style: none; font-size: 18px; text-align: center;">
        <span style="min-width: 30px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;"><?php echo $rspndtNames; ?></span>
          
        </ul>
    </div>
</div>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px;font-family: 'Times New Roman', Times, serif; "> SUBSCRIBED AND SWORN TO before me this <input style=" border:none; border-bottom:1px solid black; font-size: 18px;" type="text" name="day" placeholder="day" size="1" required> day of
<select select style="border: none; border-bottom: 1px solid black;width: auto; font-size: 18px; margin-right: 5px;"  name="received_month">
                                        <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="">Select Month</option>
                                        <?php foreach ($months as $m): ?>
                                            <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="<?php echo $m; ?>" <?php echo isset($existingReceivedMonth) && $existingReceivedMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
                                        <?php endforeach; ?>
                                    </select>,
        <input style="border-bottom: 1px solid black; width: 42px; font-size: 18px;" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : ''; ?>"> .              
</div><br>
<p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 550px; margin-right: auto;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 410px;   font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">Punong Barangay/Pangkat Chairman/Member</label>
               
<br>
<br>
<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px; "> Received and filed * this <input style="border:none; border-bottom:1px solid black;font-size: 18px;" type="text" name="day" placeholder="day" size="1" required> day of
<select select style="border: none; border-bottom: 1px solid black;width: auto; font-size: 18px; margin-right: 5px;"  name="received_month">
                                        <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="">Select Month</option>
                                        <?php foreach ($months as $m): ?>
                                            <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="<?php echo $m; ?>" <?php echo isset($existingReceivedMonth) && $existingReceivedMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
                                        <?php endforeach; ?>
                                    </select>,
        <input style="border-bottom: 1px solid black; width: 42px; font-size: 18px;" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : ''; ?>"> .              
</div><br>


<p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 550px; margin-right: auto;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 580px;   font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">Punong Barangay</label>
               <br> <br>
  <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px; ">* Failure to repudiate the settlement or the arbitration agreement within the time limits respectively set (ten [10] days from the date of settlement and five[5] days from the date of arbitration agreement) shall be deemed a waiver of the right to challenge on
said grounds.
    </div>       
</div>

<?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <button class="btn btn-primary print-button common-button" onclick="window.print()" style="position: relative; right: -785px; top: -1298px;">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
            
                <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button">
</form>
<a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>">
    <button class="btn common-button" style="margin-left: -330px; margin-top: -2595px;">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</a>
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
                    </body>
</html>
