<?php
session_start();
$linkedNames = $_SESSION['linkedNames'] ?? [];
?>


<?php
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
$formUsed = 10;

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

$query = "SELECT lgu_logo FROM users WHERE id = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user has a profile picture
if ($user && !empty($user['lgu_logo'])) {
    $lgulogo = '../lgu_logo/' . $user['lgu_logo'];
} else {
    // Default profile picture if the user doesn't have one set
    $lgulogo = '../lgu_logo/defaultpic.jpg';
}


$query = "SELECT city_logo FROM users WHERE id = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user has a profile picture
if ($user && !empty($user['city_logo'])) {
    $citylogo = '../city_logo/' . $user['city_logo'];
} else {
    // Default profile picture if the user doesn't have one set
    $citylogo = '../city_logo/defaultpic.jpg';
}
?>

<?php
$tagalogMonths = array(
    'January' => 'Enero',
    'February' => 'Pebrero',
    'March' => 'Marso',
    'April' => 'Abril',
    'May' => 'Mayo',
    'June' => 'Hunyo',
    'July' => 'Hulyo',
    'August' => 'Agosto',
    'September' => 'Setyembre',
    'October' => 'Oktubre',
    'November' => 'Nobyembre',
    'December' => 'Disyembre'
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>KP Form 6 English</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
    
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <style>
        
        body, h5, p, select, input, button {
        font-size: 14px; /* Adjust the font size */
        font-family: 'Times New Roman', Times, serif;
    }

    .paper {
        background: white;
        margin: 0 auto;
        margin-bottom: 0.2cm; /* Adjust margin bottom */
        box-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);
        overflow: hidden;
        padding: 1%; /* Adjust the padding */
        box-sizing: border-box;
    }
 /* Regular screen styles */
 input[type="text"], input[type="number"] {
    border: none;
    border-bottom: 1px solid black;
    font-family: 'Times New Roman', Times, serif;
    font-size: 18px;
    text-align: left;
    outline: none;
    width: auto; /* Adjust width as necessary */
}

/* Print styles */
@media print {
    input[type="text"], input[type="number"] {
        border: none !important;
        border-bottom: 1px solid black !important;
        display: inline-block !important; /* Ensures the inputs are not ignored */
    }
    
    /* Force borders to be printed */
    input[type="text"]:after, input[type="number"]:after {
        content: "";
        display: block;
        margin-top: -1px;
        border-bottom: 1px solid black;
    }
    
    /* Ensure text inputs are visible */
    input[type="text"], input[type="number"], select {
        color: black !important; /* Ensures text is black */
        background-color: white !important; /* Ensures background is white */
        -webkit-print-color-adjust: exact !important; /* For Chrome, Safari */
        print-color-adjust: exact !important; /* Standard */
    }
        body, h5, p, select, input, button {
        font-size: 14px; /* Adjust the font size */
        font-family: 'Times New Roman', Times, serif;
    }
}
/* Add Bootstrap responsive classes for different screen sizes */
@media (min-width: 992px) {
    .paper {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: auto; /* Auto height to adapt to the content */
    }

    .paper[layout="landscape"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 21cm;
    }
}

@media print {
    .top-right-buttons {
        display: none; /* Hide the button container */
    }

    .btn {
        display: none !important; /* Hide all buttons with the class 'btn' */
    }
}

@media (min-width: 1200px) {
    .paper[size="A3"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 42cm;
    }

    .paper[size="A3"][layout="landscape"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 29.7cm;
    }

    .paper[size="A5"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 21cm;
    }

    .paper[size="A5"][layout="landscape"] {
        width: calc(100% - 4%); /* Adjusted width considering left and right padding */
        height: 14.8cm;
    }
}
        .profile-img{
   width: 3cm;
}

.header {
   text-align: center;
   padding-inline: 4cm;
}
h5 {
       margin: 0;
       padding: 0;
   }
   body {
    background: rgb(204, 204, 204);
}

.container {
    margin: 0 auto;
}

.paper {
    background: white;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
}
.paper {
    padding: 2%; /* Adjust the padding as needed */
    /* Other styles */
}
@media print {
    body {
        font-size: 12pt; /* Adjust as needed */
    }
    .input-field {
        max-width: 100%
        height: auto; /* Adjust as needed */
        /* Other print styles for input fields */
    }
}

/* Add Bootstrap responsive classes for different screen sizes */
@media (min-width: 992px) {
    .paper {
        width: 21cm;
        height: auto; /* Auto height to adapt to the content */
    }

    .paper[layout="landscape"] {
        width: 29.7cm;
        height: auto; /* Auto height to adapt to the content */
    }
}

@media (min-width: 1200px) {
    .paper[size="A3"] {
        width: 29.7cm;
        height: 42cm;
    }

    .paper[size="A3"][layout="landscape"] {
        width: 42cm;
        height: 29.7cm;
    }

    .paper[size="A5"] {
        width: 14.8cm;
        height: 21cm;
    }

    .paper[size="A5"][layout="landscape"] {
        width: 21cm;
        height: 14.8cm;
    }
}

@media print {
    body, .paper {
        background: white;
        margin: 0;
        box-shadow: 0;
    }
}

   @media print {
  /* Adjust print styles here */
  .input-field {
    /* Example: Ensure input fields do not expand beyond their containers */
    max-width: 100%;
  }
}
button {
    font-family: 'Arial', sans-serif; /* Example font-family */
    font-size: 16px; /* Example font-size */
    font-weight: bold; /* Example font-weight */
}

   </style>
</head>
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

    <a href="../user_lupon.php">
        <button class="btn common-button" style="position:fixed; right: 20px; top: 130px;">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </a>
               
                </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 6</b></h5>

 <div style="display:inline-block;text-align: center;">
<img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $citylogo; ?>" alt="City Logo" style="height: 80px; width: 80px;">
<div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
<br>
                <h5 style="text-align: center;font-size: 18px;">Republic of the Philippines</h5>
                <h5 style="text-align: center;font-size: 18px;">Province of Laguna</h5>
                <h5 class="header" style="text-align: center; font-size: 18px;">
    <?php
    $municipality = $_SESSION['municipality_name'];

    if (in_array($municipality, ['Alaminos', 'Bay', 'Los Banos', 'Calauan'])) {
        echo 'Bayan ng ' . $municipality;
    } elseif (in_array($municipality, ['Biñan', 'Calamba', 'Cabuyao', 'San Pablo', 'San Pedro', 'Sta. Rosa'])) {
        echo 'Lungsod ng ' . $municipality;
    } else {
        echo 'ungsod/Bayan ng ' . $municipality;
    }
    ?>
    
</h5>
                <h5 style="text-align: center;font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;font-size: 18px;">
                <h5 style="text-align: center; font-size: 18px; margin-top: 5px;">OFFICE OF THE PUNONG BARANGAY</h5>
            
</div>

          
<div class="e" style="font-size: 18px; text-align: right; margin-right: 40px; font-family: 'Times New Roman', Times, serif;"> <br>
        
        <?php
// Get the current date
$currentDate = date('F d, Y');

$months = [
    'Enero' => 'January',
    'Pebrero' => 'February',
    'Marso' => 'March',
    'Abril' => 'April',
    'Mayo' => 'May',
    'Hunyo' => 'June',
    'Hulyo' => 'July',
    'Agosto' => 'August',
    'Setyembre' => 'September',
    'Oktubre' => 'October',
    'Nobyember' => 'November',
    'Disyembre' => 'December'
];

// Replace the month in English with its Tagalog equivalent
$tagalogDate = strtr($currentDate, $months);

// Print the formatted date
echo $tagalogDate;
?>

                <h3 style="text-align: center;"><b style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">WITHDRAWAL OF APPOINTMENT</b></h3>
    
                <form method="POST">
                <div style="text-align: left;">
                <br><p style="text-align: justify; font-size: 12px; margin-top:0; font-size: 18px;font-family: 'Times New Roman', Times, serif;">TO:
    <input type="text" id="recipient" name="recipient" list="nameList" required style="width:200px; height: 20px; font-size: 18px;font-family: 'Times New Roman', Times, serif;">
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
</p>
                <p style="text-align: justify; font-size: 12px; font-size: 18px; text-indent: 2em; font-family: 'Times New Roman', Times, serif;">
                After due hearing and with the concurrence of a majority of all the Lupong Tagapamayapa members of this Barangay, your appointment as member thereof is hereby withdrawn effective upon receipt hereof, on the following ground/s:
            </p>        
                <!-- Use PHP to set the checkbox status based on some condition -->
                <?php
    $isChecked = false; // Replace this with your own condition to determine if the checkbox should be checked or not
?>

<?php
    $isChecked1 = false; // Replace this with your own condition to determine if the first checkbox should be checked or not
    $isChecked2 = false; // Replace this with your own condition to determine if the second checkbox should be checked or not
?>

<!-- Create the first checkbox with PHP inline with the first input -->
<input type="checkbox" name="my_checkbox1" <?php if ($isChecked1) echo "checked"; ?>>
<span style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">-
incapacity to discharge the duties of your office as shown by
    <input type="text" id="day1" name="day1" required style="width: 330px; height: 20px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" required>.
</span>
<br>
<!-- Create the second checkbox with PHP inline with the second input -->
<input type="checkbox" name="my_checkbox2" <?php if ($isChecked2) echo "checked"; ?>>
<span style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">-
unsuitability by reason of  
    <input type="text" id="day2" name="day2" required style="width: 330px; height: 20px; font-size: 18px; font-family: 'Times New Roman', Times, serif;" required><br>
    (Check whichever is applicable and detail or specify the act/s or
omission/s constituting the ground/s for withdrawal.)
 
    <br>
</span>


                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
   
    <p class="important-warning-text" style="text-align: center; margin-left: 380px; margin-right: auto;font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <input type="text" id="positionInput" name="pngbrgy" style="font-size: 18px; font-family: 'Times New Roman', Times, serif; border: none; border-bottom: 1px solid black; outline: none; text-align: center;" size="25" value="<?= strtoupper($linkedNames['punong_barangay'] ?? 'Punong Barangay') ?>">
    <p style=" margin-left: 420px; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-top: 20px;">Punong Barangay/Lupon Chairman
</p>
<br>

            <p style="text-align: justify; text-indent: 4em;font-size: 18px; margin-left:25px; font-family: 'Times New Roman', Times, serif;">CONFORME (Signatures):
            </p>
                    <div style="display: flex;">
                <div style="flex: 1; margin-left: 95px;">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <?php $formattedIndex = sprintf("%02d", $i); ?>
                        <p style="margin: 0;font-size: 18px; font-family: 'Times New Roman', Times, serif;"><?php echo $formattedIndex; ?>. <input type="text" name="appointed_lupon_<?php echo $formattedIndex; ?>" style="width: 210px; margin-bottom: 5px;"></p>
                    <?php endfor; ?>
                </div>
                <div style="flex: 1; margin-left: 10px;">
                    <?php for ($i = 7; $i <= 11; $i++): ?>
                        <?php $formattedIndex = sprintf("%02d", $i); ?>
                        <p style="margin: 0;font-size: 18px; font-family: 'Times New Roman', Times, serif;"><?php echo $formattedIndex; ?>. <input type="text" name="appointed_lupon_<?php echo $formattedIndex; ?>" style="width: 210px; margin-bottom: 5px;"></p>
                    <?php endfor; ?>
                </div>
            </div>
        </div><br><br>
                </div>

        
                <form method="POST">
            <div style="text-align: justify; text-indent: 2em; font-size: 18px; font-family: 'Times New Roman', Times, serif">
            Received this
            <input type="number" name="received_day" placeholder="day" min="1" max="31" style="text-align: center; font-size: 18px; border: none; border-bottom: 1px solid black;" value="<?php echo $existingReceivedDay ?? ''; ?>">
            of
            <select name="received_month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="font-size: 18px;" value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option style="font-size: 18px;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input type="number" name="year" placeholder="year" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; width: 60px;" min="2000" max="2099" value="<?php echo date('Y'); ?>" required>.</div>
                    </p>
                    <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </form>
    
    <br><br>
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 380px; margin-right: auto;font-size: 18px;font-family: 'Times New Roman', Times, serif;">
    <input type="text" id="pngbrgy" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; font-size: 18px;font-family: 'Times New Roman', Times, serif;" size="25">
    <p style=" margin-left: 530px; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-top: 20px;">Signature
    </p><br>
    <b style="text-align: justify; font-size: 12px; margin-top: 0;font-size: 18px;font-family: 'Times New Roman', Times, serif;">NOTE:
</b>
    <p style="text-align: justify; font-size: 12px; text-indent: 2em;font-size: 18px;font-family: 'Times New Roman', Times, serif;">
    The members of the <i>Lupon</i> conforming to the withdrawal must personally affix their signatures or thumb marks on the pertinent
spaces above. The withdrawal must be conformed to by more than one-half of the total number of members of the <i>Lupon</i> including
the Punong Barangay and the member concerned.
    
</p>    
    <div class="blank-page"></div>
    </body>
        </div>
        
        <script>
    var barangayCaseNumber = "<?php echo $cNum; ?>"; // Assume $cNum is your case number variable
    document.getElementById('downloadButton').addEventListener('click', function () {
        // Elements to hide during PDF generation
        var buttonsToHide = document.querySelectorAll('.top-right-buttons button');
        
        // Hide the specified buttons
        buttonsToHide.forEach(function (button) {
            button.style.display = 'none';
        });

// Ensure input borders are visible for PDF generation
var toInputs = document.querySelectorAll('input[name^="to"]');
toInputs.forEach(function(input) {
    input.style.borderBottom = '1px solid black';
});

        var pdfContent = document.querySelector('.paper');
        var downloadButton = document.getElementById('downloadButton');

        // Hide the download button
        downloadButton.style.display = 'none';

        // Modify the filename option to include the barangay case number
        html2pdf(pdfContent, {
            margin: [10, 10, 10, 10],
            filename: 'kp_form6_' + barangayCaseNumber + '.pdf', // Dynamic filename
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                scale: 2, // Adjust the scale as necessary
                width: pdfContent.clientWidth, // Set a fixed width based on the on-screen width of the content
                windowWidth: document.documentElement.offsetWidth // Set the window width to match the document width
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        }).then(function () {
            // Show the download button after PDF generation
            downloadButton.style.display = 'inline-block';

            // Show the other buttons after PDF generation
            buttonsToHide.forEach(function (button) {
                button.style.display = 'inline-block';
            });

            // Restore borders for all input types and select
            inputFields.forEach(function (field) {
                field.style.border = ''; // Use an empty string to revert to the default border
            });
        });
    });
</script>
</body>
</html> 