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
$formUsed = 27;

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
    $query = "SELECT appear_date, made_date, received_date FROM hearings WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Extract and format the timestamp values
       
      $madeDate = new DateTime($row['made_date']);
       
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

  // Logic to handle date and time inputs
  $madeDate = createDateFromInputs($madeDay, $madeMonth, $madeYear);

  // Check if there's an existing form_used = 14 within the current_hearing of the complaint_id
  $query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed AND hearing_number = :currentHearing";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':complaintId', $complaintId);
  $stmt->bindParam(':formUsed', $formUsed);
  $stmt->bindParam(':currentHearing', $currentHearing);
  $stmt->execute();
  $existingForm14Count = $stmt->rowCount();

if ($existingForm14Count > 0) {
  $message = "There is already an existing KP Form 25 in this current hearing.";
}

else{
    // Insert or update the appear_date in the hearings table
    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, made_date)
    VALUES (:complaintId, :currentHearing, :formUsed, :madeDate)
    ON DUPLICATE KEY UPDATE
    hearing_number = VALUES(hearing_number),
    form_used = VALUES(form_used),
    made_date = VALUES(made_date)
    ";


$stmt = $conn->prepare($query);
$stmt->bindParam(':complaintId', $complaintId);
$stmt->bindParam(':currentHearing', $currentHearing);
$stmt->bindParam(':formUsed', $formUsed);
$stmt->bindParam(':madeDate', $madeDate);

if ($stmt->execute()) {
$message = "Form submit successful.";
} else {
$message = "Form submit failed.";
}
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
    <title>KP Form 25</title>
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

            </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 25 </b></h5>

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

       <form method="POST">

                <h3 style="text-align: center;"><b style="font-size: 18px;"> NOTICE OF EXECUTION</b><br>

 </h3>
 <br>
        <div style="display: flex;">
  <div style="text-align: justify;">
    <!-- Content for the left column -->
  </div>



<div>
    <p style="text-indent: 2.0em; text-align: justify; font-size: 18px;">
    WHEREAS, on <input type="number" name="resp_day" placeholder="day" min="1" max="31" value="<?php echo $existingRespDay ?? ''; ?>" required>  of
                <select name="resp_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingRespMonth; ?>" <?php echo ($m === $existingRespMonth) ? 'selected' : ''; ?>><?php echo $existingRespMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
                
                <input type="text" name="resp_year" placeholder="year" size="1" value="<?php echo isset($existingRespYear) ? $existingRespYear : date('Y'); ?>" required>
        (date), an amicable settlement was signed by the parties in the above-entitled case [or an
arbitration award was rendered by the Punong Barangay/Pangkat ng Tagapagkasundo];

                <br> <p style="text-indent: 2.0em; text-align: justify; font-size: 18px;"> WHEREAS, the terms and conditions of the settlement, the dispositive portion of the award. read:
<br>   <div class="a">
        <div id="nameR" name="nameR" style="text-indent: 2.0em; text-decoration: underline; width: 700px; height: auto; border:none;border-bottom: 1px solid black; overflow-y: hidden; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"> State details here..................................................................................................................</div>
    </div>


 <p style="text-indent: 2.0em; text-align: justify;font-size: 18px;">
 The said settlement/award is now final and executory; <br>
 <p style="text-indent: 2.0em; text-align: justify;font-size: 18px;">
 WHEREAS, the party obliged  <input style="display: inline-block; border: none; border-bottom: 1px solid black; font-size: 18px; width: 300px;" type="text" placeholder="Enter Complainant/s or Respondent/s Name" value="<?php echo (isset($cNames) ? htmlspecialchars($cNames, ENT_QUOTES) : '') . '/' . (isset($rspndtNames) ? htmlspecialchars($rspndtNames, ENT_QUOTES) : ''); ?>" />

    (name) has not complied voluntarily with the aforestated amicable
settlement/arbitration award, within the period of five (5) days from the date of hearing on the motion for execution;


 <p style="text-indent: 2.0em; text-align: justify; font-size: 18px;">
 NOW, THEREFORE, in behalf of the Lupong Tagapamayapa and by virtue of the powers vested in me and the Lupon by the
Katarungang Pambarangay Law and Rules, I shall cause to be realized from the goods and personal property of <input style="display: inline-block; border: none; border-bottom: 1px solid black; font-size: 18px; width: 300px;" type="text" placeholder="Enter Complainant/s or Respondent/s Name" value="<?php echo (isset($cNames) ? htmlspecialchars($cNames, ENT_QUOTES) : '') . '/' . (isset($rspndtNames) ? htmlspecialchars($rspndtNames, ENT_QUOTES) : ''); ?>" />
 (name of party obliged) the sum of <input style="font-size: 18px; border: none; border-bottom: 1px solid black; display: inline-block;" type="text" />
(state amount of settlement or award) upon in the said amicable settlement [or
adjudged in the said arbitration award], unless voluntarily compliance of said settlement or award shall have been made upon receipt hereof.



            <div style="text-align: justify; text-indent: 0em; margin-left: 30px;font-size: 18px;"> Signed this <input type="text" name="made_day" placeholder="day" size="5" value="<?php echo $existingMadeDay ?? ''; ?>" required> day of
  <select name="made_month">
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input type="number" name="made_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">.
        

        <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button">
</form>
</div>

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 550px; margin-right: auto;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 580px;   font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">Punong Barangay</label>
       
 <p style="text-indent: 2.0em; text-align: justify; font-size: 18px;">
 Copy finished: </p>
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