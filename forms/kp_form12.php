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
$formUsed = 12;


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
        $appearDate = new DateTime($row['appear_date']);
        $appear_day = $appearDate->format('j');

        $appear_month = $appearDate->format('F');
        $appear_year = $appearDate->format('Y');
        $appear_time = $appearDate->format('H:i'); // Format for the time input

        $madeDate = new DateTime($row['made_date']);
        $receivedDate = new DateTime($row['received_date']);

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
    $receivedDate = createDateFromInputs($receivedDay, $receivedMonth, $receivedYear);

    // Insert or update the appear_date in the hearings table
    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, appear_date, made_date, received_date)
              VALUES (:complaintId, :currentHearing, :formUsed, :appearDate, :madeDate, :receivedDate)
              ON DUPLICATE KEY UPDATE
              hearing_number = VALUES(hearing_number),
              form_used = VALUES(form_used),
              appear_date = VALUES(appear_date),
              made_date = VALUES(made_date),
              received_date = VALUES(received_date)";


     $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':appearDate', $appearTimestamp);
    $stmt->bindParam(':madeDate', $madeDate);
    $stmt->bindParam(':receivedDate', $receivedDate);
    
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
    <title>KP FORM 12</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    
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
</head>
<body>
    <br>
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
</div>
 <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 12</b></h5>

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

<?php
$months = [
    'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
];

$currentYear = date('Y');
?>

<br><br>
         

<div style="display: flex;">
    <div class="input-field">
        <p style="font-size: 18px;  font-family: 'Times New Roman', Times, serif;">
        TO:    <span style=" font-family: 'Times New Roman', Times, serif;min-width: 150px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($cNames) ? $cNames : '&nbsp;'; ?></span></p>
    
        <p style="font-size: 18px; text-indent:2em; font-family: 'Times New Roman', Times, serif; margin-left:6px;"> Complainant/s </p>

</div>


    <div style=" font-family: 'Times New Roman', Times, serif; margin-left:50px;"class="input-field">
        <p style="font-size: 18px; ">  <span style=" font-family: 'Times New Roman', Times, serif; min-width: 150px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($rspndtNames) ? $rspndtNames: '&nbsp;'; ?></span></p>
   <p style=" font-family: 'Times New Roman', Times, serif; font-size: 18px; text-indent:2em; margin-left:-35px;">Respondent/s </p>
   
</div>

            </div>
            <form method="POST">
                <div style="text-align: center; text-indent: 0em; margin-left: 1px; font-size:18px;   font-family: 'Times New Roman', Times, serif;">
                <p><b style="font-size:18px; font-family: 'Times New Roman', Times, serif;">NOTICE OF HEARING<br>(CONCILIATION PROCEEDINGS)
</b></p> 
                <div style="text-align: justify; text-indent: 2em; margin-left: 1px; font-size:18px; "> You are hereby required to appear before the Pangkat on the
                <input style="font-size: 18px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="number" name="day" placeholder="day" min="1" max="31" value="<?php echo $appear_day; ?>" required> of
    <select style="border: none; border-bottom: 1px solid black; font-size: 18px;" name="month" required>
        <?php foreach ($months as $m): ?>
            <?php if ($id > 0): ?>
                <option style="font-size: 18px;" value="<?php echo $appear_month; ?>" <?php echo ($m === $appear_month) ? 'selected' : ''; ?>><?php echo $appear_month; ?></option>
            <?php else: ?>
                <option style="font-size: 18px;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>,
    <input style="font-size: 18px; width: 3em; margin-right: 5px; border: none; border-bottom: 1px solid black;" type="number" name="year" placeholder="year" min="<?php echo date('Y'); ?>" max="<?php echo date('Y') + 100; ?>" value="<?php echo date('Y'); ?>" required>
    at <input style="font-size: 18px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="time" id="time" name="time" size="5" style="border: none;" value="<?php echo $appear_time; ?>" required> o'clock for a
hearing of the above-entitled case.

</div>  
               </div> 
               <br>

               
                <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px; font-family: 'Times New Roman', Times, serif;">
                 This <input style="height:33px; text-align:center; font-size: 18px; font-family: 'Times New Roman', Times, serif; width: 44px; margin-right: 5px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="text" name="received_day" placeholder="day" size="5" value="<?php echo $existingReceivedDay ?? ''; ?>" required>  day of
                <select style="height:33px; border: none; border-bottom: 1px solid black; font-family: 'Times New Roman', Times, serif; width: auto; font-size: 18px; margin-right: 5px;"  name="received_month"  required>
                                        <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
                                    </select>,
        <input style="font-family: 'Times New Roman', Times, serif; font-size: 18px; border: none;  border-bottom: 1px solid black; width: 40px;" min="2000" max="2099" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : date('Y'); ?>" required>.
    
                </div>
       <div style="position: relative;">
                    <br><br>


               <p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 550px; margin-right: auto;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 590px; font-family: 'Times New Roman', Times, serif;  font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">Pangkat Chairman</label>
                    

        <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;font-size: 18px; font-family: 'Times New Roman', Times, serif;">
        <br><br>Notified this <input style="height:33px; text-align:center; font-size: 18px; font-family: 'Times New Roman', Times, serif; width: 44px; margin-right: 5px; padding-bottom: 0; border: none; border-bottom: 1px solid black;"type="text" name="received_day" placeholder="day" size="5" value="<?php echo $existingReceivedDay ?? ''; ?>" required>  day of
                <select style="height:33px; border: none; border-bottom: 1px solid black; font-family: 'Times New Roman', Times, serif; width: auto; font-size: 18px; margin-right: 5px;"  name="received_month"  required>  
                                        <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
                                    </select>,
        <input style="font-family: 'Times New Roman', Times, serif; font-size: 18px; border: none;  border-bottom: 1px solid black; width: 40px;" min="2000" max="2099" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : date('Y'); ?>" required>.
    
        </div>

        <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button col-md-2" style="position:fixed; right: 20px; top: 130px;">


            </form>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
<br>
<br><br>
    <div class="d">
    <div style="display: flex; justify-content: space-between; font-size: 18px; text-align: center; ">
    <div style="text-align: center; margin-left: 190px;">
        <p style="font-size: 18px;font-family: 'Times New Roman', Times, serif; ">	Complainant/s</p>
        <ul style="margin-bottom: 10; padding: 0; list-style: none; font-size: 18px; text-align: center;">
        <span style="min-width: 30px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;"><?php echo $cNames; ?></span>
           
        </ul>
    </div>

    <div style="text-align: center; margin-right: 170px;font-family: 'Times New Roman', Times, serif;">
        <p style="font-size: 18px;font-family: 'Times New Roman', Times, serif; ">Respondent/s</p>
        <ul style="margin-bottom: 10; padding: 0; list-style: none; font-size: 18px; text-align: center;">
        <span style="min-width: 30px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;"><?php echo $rspndtNames; ?></span>
          
        </ul>
    </div>
</div>
         
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

    var pdfContent = document.querySelector('.paper');

    // Use html2pdf to generate a PDF
    html2pdf(pdfContent, {
        margin: 10, // Set the margin to 10mm on all sides
        filename: document.title.replace(/\s/g, '_') + '.pdf', // Use the page title as the filename
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' } // Set A4 as the format and portrait as the orientation
    }).then(function (pdf) {
        // Use FileSaver.js or other libraries to save the PDF
        saveAs(pdf, document.title.replace(/\s/g, '_') + '.pdf');
        
        // Show the download button after PDF generation
        downloadButton.style.display = 'inline-block';

        // Show the Save button after PDF generation
        saveButton.style.display = 'inline-block';

        // Show the other buttons after PDF generation
        buttonsToHide.forEach(function (button) {
            button.style.display = 'inline-block';
        });
    });
});
</script>
            </div>
        </div>
    </div>
</body>

<br>
<div class="blank-page">        
    
</div>
</html>
