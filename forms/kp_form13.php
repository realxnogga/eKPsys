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
$formUsed = 13;

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
    $query = "SELECT appear_date, made_date FROM hearings WHERE id = :id";
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

        // Populate form inputs with the extracted values
        $currentDay = $appearDate->format('j');
        $currentMonth = $appearDate->format('F');
        $currentYear = $appearDate->format('Y');

        $existingMadeDay = $madeDate->format('j');
        $existingMadeMonth = $madeDate->format('F');
        $existingMadeYear = $madeDate->format('Y');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $madeDay = $_POST['made_day'] ?? '';
    $madeMonth = $_POST['made_month'] ?? '';
    $madeYear = $_POST['made_year'] ?? '';

    $day = $_POST['day'] ?? '';
    $month = $_POST['month'] ?? '';
    $year = $_POST['year'] ?? '';
    $time = $_POST['time'] ?? '';

$dateTimeString = "$year-$month-$day $time";
$appearTimestamp = DateTime::createFromFormat('Y-F-j H:i', $dateTimeString);


if ($appearTimestamp !== false) {
    $appearTimestamp = $appearTimestamp->format('Y-m-d H:i:s');

    // Logic to handle date and time inputs
    $madeDate = createDateFromInputs($madeDay, $madeMonth, $madeYear);

    // Insert or update the appear_date in the hearings table
    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, appear_date, made_date)
              VALUES (:complaintId, :currentHearing, :formUsed, :appearDate, :madeDate)
              ON DUPLICATE KEY UPDATE
              hearing_number = VALUES(hearing_number),
              form_used = VALUES(form_used),
              appear_date = VALUES(appear_date),
              made_date = VALUES(made_date)";


     $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':appearDate', $appearTimestamp);
    $stmt->bindParam(':madeDate', $madeDate);
    
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
    <title>KP Form 13</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
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
@media print {
    input[type="text"], input[type="number"], select {
        border: none !important; /* Remove all borders */
        border-bottom: 1px solid black !important; /* Apply bottom border only */
    }
}
</style>
<body>
<div class="container">
        <div class="paper">
                <div class="top-right-buttons">
                <!-- Print button -->
                <button class="btn btn-primary print-button common-button" onclick="window.print()">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
                <button class="btn btn-success download-button common-button" id="downloadButton">
                    <i class="fas fa-file button-icon"></i> Download
                </button>
                <a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>">
                 <button class="btn common-button" style="margin-top: 45px;">
                   <i class="fas fa-arrow-left"></i> Back
                </button></a>

            </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 13</b></h5>

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
        <h5 class="header" style="font-size: 18px; margin-top: 5px;">OFFICE OF THE PUNONG BARANGAY</h5>
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

       
<form method="POST">
<h3 style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;"> <b style= "font-size: 18px;"  >
SUBPOENA </b>
</h3>

<div class="form-group" style="text-align: justify;">
  <div class="label"></div>
  <div class="input-field">
    <br><br>
    <p style="font-size: 18px;"> TO:
      <span style="display: inline-block; width: 40%; text-align: center;">
        <input type="text" name="to1" id="to1" style="font-size: 18px; width: 90%; border: none; border-bottom: 1px solid black;">
      </span>
      <span style="display: inline-block; width: 40%; text-align: center;">
        <input type="text" name="to2" id="to2" style="font-size: 18px; width: 90%; border: none; border-bottom: 1px solid black;">
      </span>
      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <span style="display: inline-block; width: 40%; text-align: center;">
        <input type="text" name="to3" id="to3" style="font-size: 18px; width: 90%; border: none; border-bottom: 1px solid black;">
      </span>
      <span style="display: inline-block; width: 40%; text-align: center;">
        <input type="text" name="to4" id="to4" style="font-size: 18px; width: 90%; border: none; border-bottom: 1px solid black;">
      </span>
    </p>
  </div>
</div>



                <div style="text-align: justify;"><p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; text-align: justify; margin-left: 290px;">Witnesses</p> 
                <p style="text-indent: 2em; font-family: 'Times New Roman', Times, serif; font-size: 18px;">You are hereby commanded to appear before me on the
                <input type="number" name="day" placeholder="day" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black;" min="1" max="31" value="<?php echo $appear_day; ?>" required> day of
        <select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>


    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="font-size: 18px; text-align: center;" value="<?php echo $appear_month; ?>" <?php echo ($m === $appear_month) ? 'selected' : ''; ?>><?php echo $appear_month; ?></option>
        <?php else: ?>
            <option style="font-size: 18px; text-align: center;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
        <input type="number" name="year" placeholder="year" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; width: 60px;" min="2000" max="2099" value="<?php echo date('Y'); ?>" required> at
        <input type="time" id="time" name="time" size="5" style="font-size: 18px; border: none; border-bottom: 1px solid black;" value="<?php echo $appear_time; ?>" required> o'clock, then and there to testify in the hearing of the above-captioned case.  
                  
    </div>

    <br><div style="text-align: justify; text-indent: 2em; font-size: 18px; font-family: 'Times New Roman', Times, serif">
        This
        <input type="number" name="made_day" placeholder="day" min="1" max="31" style="font-size: 18px; border: none; border-bottom: 1px solid black;" value="<?php echo $existingMadeDay; ?>">
        day of
        <select name="made_month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="font-size: 18px;" value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option style="font-size: 18px;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
        <input type="number" name="made_year" size="1" placeholder="year" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; left: 10px; width: 60px;" min="2000" max="2099" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>">.
              
</div>
    <br><br><br>
    <div style="text-align: right;">
                <div style="min-width: 250px; border-bottom: 1px solid black; display: inline-block; right: 70px; position: relative;">
                <div class="barangay-official" style="font-family: 'Times New Roman', Times, serif; font-size: 18px; text-align: center;">
  <?php echo $punong_barangay; ?>
</div>
    <label id="punongbrgy" name="punongbrgy" size="25" style="font-family: 'Times New Roman', Times, serif; text-align: center; font-size: 18px; margin-top: 10px; position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); font-weight: normal;">
    <br><br><br>Punong Barangay//Pangkat Chairman</label>
    </div></div></span><br><br><br>

    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: relative; right: -770px; top: -780px;">
</form>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                
            </div>
        </div>
<script>
document.getElementById('downloadButton').addEventListener('click', function () {
    var buttonsToHide = document.querySelectorAll('.top-right-buttons button');
    var saveButton = document.querySelector('input[name="saveForm"]');
    var inputFields = document.querySelectorAll('input[type="text"], input[type="number"], select');
    var pdfContent = document.querySelector('.paper');

    // Hide buttons and remove borders for download
    buttonsToHide.forEach(function (button) { button.style.visibility = 'hidden'; });
    saveButton.style.visibility = 'hidden';
    inputFields.forEach(function (field) { field.style.border = 'none'; });

    // Generate PDF and initiate a download
    html2pdf().from(pdfContent).set({
        margin: 10,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, logging: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    }).save().then(function () {
        // PDF download initiated
    }).catch(function (error) {
        // Handle any errors that occurred during PDF generation
        console.error('Failed to generate PDF: ', error);
    }).finally(function() {
        // Make sure buttons are shown again after PDF generation
        buttonsToHide.forEach(function (button) { button.style.visibility = 'visible'; });
        saveButton.style.visibility = 'visible';
        inputFields.forEach(function (field) { field.style.border = '1px solid #ccc'; }); // Or whatever your default style is
    });
});

    </script>
</div>        
</div>
</body>
</html>
