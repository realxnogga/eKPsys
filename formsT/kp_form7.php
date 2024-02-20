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
$message = '';

  $complaintId = $_SESSION['current_complaint_id'] ?? ''; // Using the null coalescing operator to provide a default value
$currentHearing = $_SESSION['current_hearing'] ?? '';
$formUsed = 7;

// Check if the form has been previously submitted for this complaint ID and form type
if (!empty($complaintId) && !empty($currentHearing)) {
    $query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->execute();
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        // Fetch existing row values if found
        // Assuming 'hearings' table columns are 'made_date' and 'received_date'
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $existingMadeDate = $row['made_date'];
        $existingReceivedDate = $row['received_date'];

        // Use existing values as placeholders
        // Parse dates to extract day, month, and year
        $existingMadeDay = date('d', strtotime($existingMadeDate));
        $existingMadeMonth = date('F', strtotime($existingMadeDate));
        $existingMadeYear = date('Y', strtotime($existingMadeDate));

        $existingReceivedDay = date('d', strtotime($existingReceivedDate));
        $existingReceivedMonth = date('F', strtotime($existingReceivedDate));
        $existingReceivedYear = date('Y', strtotime($existingReceivedDate));
    } else {
        // If no row found, populate with present date as placeholders
        $existingMadeDay = date('d');
        $existingMadeMonth = date('F');
        $existingMadeYear = date('Y');

        $existingReceivedMonth = date('F');
        $existingReceivedYear = date('Y');
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// After getting form inputs
$madeDay = $_POST['made_day'];
$madeMonth = $_POST['made_month'];
$madeYear = $_POST['made_year'];

$receivedDay = $_POST['received_day'];
$receivedMonth = $_POST['received_month'];
$receivedYear = $_POST['received_year'];

// Check if day, month, and year are non-empty before constructing the date
    if (!empty($madeDay) && !empty($madeMonth) && !empty($madeYear)) {
        $monthNum = date('m', strtotime("$madeMonth 1"));
        $madeDate = date('Y-m-d', mktime(0, 0, 0, $monthNum, $madeDay, $madeYear));
    } else {
        // If any of the date components are empty, set $madeDate to a default value or handle as needed
        // For example, setting it to the current date:
        $madeDate = date('Y-m-d');
    }

    // Check if day, month, and year are non-empty before constructing the date
    if (!empty($receivedDay) && !empty($receivedMonth) && !empty($receivedYear)) {
        $monthNum = date('m', strtotime("$receivedMonth 1"));
        $receivedDate = date('Y-m-d', mktime(0, 0, 0, $monthNum, $receivedDay, $receivedYear));
    } else {
        // If any of the date components are empty, set $receivedDate to a default value or handle as needed
        // For example, setting it to the current date:
        $receivedDate = date('Y-m-d');
    }



// Check if day, month, and year are non-empty before constructing the date
if (!empty($madeDay) && !empty($madeMonth) && !empty($madeYear)) {
    $monthNum = date('m', strtotime("$madeMonth 1"));
    $madeDate = date('Y-m-d', mktime(0, 0, 0, $monthNum, $madeDay, $madeYear));
}
if (!empty($receivedDay) && !empty($receivedMonth) && !empty($receivedYear)) {
    $monthNumReceived = date('m', strtotime("$receivedMonth 1"));
    $receivedDate = date('Y-m-d', mktime(0, 0, 0, $monthNumReceived, $receivedDay, $receivedYear));
}
    // Validation before submission
    if ($rowCount > 0) {
        $message = "Form already submitted for this complaint ID and form type.";
    } elseif ($currentHearing !== '1st') {
        $message = "Invalid hearing number. Form submission not allowed.";
    }
    else {
        $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, made_date, received_date)
              VALUES (:complaintId, :currentHearing, :formUsed, :madeDate, :receivedDate)
              ON DUPLICATE KEY UPDATE
              hearing_number = VALUES(hearing_number),
              form_used = VALUES(form_used),
              made_date = VALUES(made_date),
              received_date = VALUES(received_date)";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':madeDate', $madeDate);
    $stmt->bindParam(':receivedDate', $receivedDate);

    if ($stmt->execute()) {
        $message = "Form submit successful.";
    } else {
        $message = "Form submit failed.";
    }

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
    <title>kp_form2</title>
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
        max-width: 100%; /* Adjust as needed */
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


   </style>
</head>
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

    <a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>">
        <button class="btn common-button" style="position:fixed; right: 20px; top: 177px;">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </a>
    </div>
    
    <h5> <b style="font-family: 'Times New Roman', Times, serif;"> Pormularyo ng KP Blg. 7 </b></h5>

            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
    <img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 100px; width: 100px;">

    <div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
        <br>
    <h5 class="header" style="text-align: center; font-size: 18px;">Republika ng Pilipinas</h5>
    <h5 class="header" style="text-align: center;font-size: 18px;">Lalawigan ng Laguna</h5>
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
    <h5 class="header" style="text-align: center;font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5><br>
    <h5 class="header" style="text-align: center;font-size: 18px;"><b style="font-size: 18px;">TANGGAPAN NG LUPONG TAGAPAMAYAPA</b></h5>
</div></div>

<?php
$months = [
    'Enero', 'Pebrero', 'Marso', 'Abril', 'Mayo', 'Hunyo', 'Hulyo', 'Agosto', 'Setyembre', 'Oktubre', 'Nobyembre', 'Disyembre'
];

$currentYear = date('Y');
?>

   <br>
   <br>
  <div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif;" >
    <div class="input-field" style="float: right; width: 50%;">
        <!-- case num here -->
        <p style="text-align: left; margin-left:30px; font-size: 18px;">Usaping Barangay Blg. <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNum) ? $cNum : '&nbsp;'; ?></span></p>

    <p style="text-align: left; font-size: 18px; font-size: 18px; margin-left: 30px; margin-top: 0;">
        Ukol sa: <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($forTitle) ? nl2br(htmlspecialchars($forTitle)) : '&nbsp;'; ?></span> </p>
    </div>
</div>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-family: 'Times New Roman', Times, serif;">
    <div class="label"></div>
    <div style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNames) ? $cNames : '&nbsp;'; ?>
                </div>
                <div>
<p style="font-size: 18px;">(Mga) Maysumbong</p>
                </div>
                <div>
        <p style="font-size: 18px;">- laban kay/kina -</p>
    </div>
</div>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-family: 'Times New Roman', Times, serif;">
    <div class="label"></div>
    <div style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($rspndtNames) ? $rspndtNames : '&nbsp;'; ?>
                </div>
                <div>
<p style="font-size: 18px;"> (Mga) Ipinagsusumbong </p> </div>
    
</div>


                    <h3 style="text-align: center; font-family: 'Times New Roman', Times, serif; font-size: 18px;"><b style="font-size:18px ;">SUMBONG</b></h3>

                    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-family: 'Times New Roman', Times, serif; font-size: 18px;"> 
                    <p style="font-size: 18px;margin-right:96px;">AKO/KAMI, ay nagrereklamo laban sa mga ipinagsusumbong na binanggit sa itaas dahil sa paglabag ng aking/aming mga karapatan at kapakanan sa sumusunod na pamamaraan: 
                    <div class="a">
                    <p style="text-align: left; font-size: 18px; font-size: 18px; margin-left: 2px; margin-top: 0;">

       <span style="border-bottom: 1px solid black; font-size: 18px; margin-right:96px;"><?php echo ($cDesc) ? nl2br(htmlspecialchars($cDesc)) : '&nbsp;'; ?></span>


                </p>
    <p style="font-size:18px; margin-right:96px;">DAHIL DITO, AKO/KAMI, na nakikiusap na ipagkakaloob sa akin/amin ang sumusunod na (mga) kalunasan nang naaalinsunod sa batas at/o pagkamakatuwiran: 
    <div class="a"> <p style="text-align: left; font-size: 18px; font-size: 18px; margin-left: 2px; margin-top: 0;">
    <span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo ($petition) ? nl2br(htmlspecialchars($petition)) : '&nbsp;'; ?></span>




</div>

<form id="formId" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-family: 'Times New Roman', Times, serif; font-size: 18px;">
   <b style="font-size: 18px; margin-right:96px;"> Ginawa ngayong ika-
   <input style="font-size: 18px; width: 20px; margin-right: 5px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="number" name="made_day" placeholder="day" min="01" max="31" value="<?php echo isset($existingMadeDay) ? $existingMadeDay : ''; ?>">araw ng 
        <select style="border: none; border-bottom: 1px solid black;width: auto; font-size: 18px; margin-right: 5px;" name="made_month">
    <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value=""> Pumili ng Buwan </option>
    <?php foreach ($months as $m): ?>
        <option style="border: none; border-bottom: 1px solid black; font-size: 18px;" value="<?php echo $m; ?>" <?php echo isset($existingMadeMonth) && $existingMadeMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
    <?php endforeach; ?>
</select>,
        <input style="font-size: 18px;" type="number" name="made_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : ''; ?>">
    </div></b>

    <div style="position: relative;">
        <br>
        <p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 470px;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($cNames) ? $cNames : '&nbsp;'; ?>
    </span>
    <label id="cmplnts" name="cmplnts" size="25" style="text-align: center; font-size: 18px; margin-left: 5px; display:inline block;">
        (mga) Maysumbong
    </label>
</p>

 
    </div>
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px;">
    Tinanggap at inihain ngayong  
    <input style="font-size: 18px; width: 20px; margin-right: 5px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="number" name="received_day" placeholder="day" min="01" max="31" value="<?php echo isset($existingReceivedDay) ? $existingReceivedDay : ''; ?>"> araw ng
                                    <select select style="border: none; border-bottom: 1px solid black;width: auto; font-size: 18px; margin-right: 5px;"  name="received_month">
                                        <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="">Pumili ng Buwan </option>
                                        <?php foreach ($months as $m): ?>
                                            <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="<?php echo $m; ?>" <?php echo isset($existingReceivedMonth) && $existingReceivedMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
                                        <?php endforeach; ?>
                                    </select>,
        <input style="font-size: 18px;" type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : ''; ?>">
    </div>
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
  
            
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position:fixed; right: 20px; top: 130px;">

</form>

<br>
<br>
                    <p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 540px; margin-right:120px;">
    <span style="margin-right:120px;min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 470px; margin-right:120px;  font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;"><i>Punong Barangay/Kalihim ng Lupon</i></label>


    <script>
    var barangayCaseNumber = "<?php echo $cNum; ?>"; // Assume $cNum is your case number variable
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

     // Modify the filename option to include the barangay case number
     html2pdf(pdfContent, {
        margin: [10, 10, 10, 10],
        filename: 'kp_form7_' + barangayCaseNumber + '.pdf', // Dynamic filename
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
        </div> <br>
   </div>     
    </body>
</div> 

</html>
