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

    $complaintId = $_SESSION['current_complaint_id'];
    $currentHearing = $_SESSION['current_hearing'];
    $formUsed = 7;

    // Check if the form has been previously submitted for this complaint ID and form type
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
    <title>kp_form7</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">


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

    }
    h5{
        margin:0;
        padding:0;
    }
    @media print {
        select[name="received_month"] {
            border-bottom: 1px solid black; /* Set the desired border style and color */
        }
    }
</style>
</head>
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
                    <button class="btn common-button">
                        <i class="button-icon"></i> Back
                    </button>
                </a>
</div>
            <h5> <b style="font-family: 'Times New Roman', Times, serif; font-size: 12px;">KP Form No. 7 </b></h5>

            <div style="display:inline-block;text-align: center;">
            <img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 100px; width: 100px;">

            <div style="text-align: left; font-family: 'Times New Roman', Times, serif;">
          <br>
                <h5 class="header" style="text-align: center; font-size: 18px;">Republic of the Philippines</h5>
                <h5 class="header" style="text-align: center; font-size: 18px;">Province of Laguna</h5>
                <h5 class="header" style="text-align: center; font-size: 18px;">
    <?php
    $municipality = $_SESSION['municipality_name'];

    if (in_array($municipality, ['Alaminos', 'Bay', 'Los Banos', 'Calauan'])) {
        echo 'MUNICIPALITY OF ' . $municipality;
    } elseif (in_array($municipality, ['Biñan', 'Calamba', 'Cabuyao', 'San Pablo', 'San Pedro', 'Sta. Rosa'])) {
        echo 'CITY OF ' . $municipality;
    } else {
        echo 'CITY/MUNICIPALITY OF ' . $municipality;
    }
    ?>
</h5>
                <h5 class="header" style="text-align: center; font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 class="header" style="text-align: center; font-size: 18px;"> OFFICE OF THE PUNONG BARANGAY </h5>
            </div>


            
                <?php
                $months = [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                $currentYear = date('Y');
                ?>
   <br>
   <br>
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

       

                    <h3 style="text-align: center;"><b style="font-family: 'Times New Roman', Times, serif; font-size: 18px;">COMPLAINT</b></h3>

                    <div style="text-align: justify; text-indent: 0em; margin-left: 5px; font-size: 18px;"> 
                    <p style="font-size: 18px">I/WE hereby complain against above named respondent/s for violating my/our rights and interests in the following manner: 
                        <div class="a">
                        <p style="text-align: left; font-size: 18px; font-size: 18px; margin-left: 2px; margin-top: 0;">
<span style="border-bottom: 1px solid black; font-size: 18px; "><?php echo ($cDesc) ? nl2br(htmlspecialchars($cDesc)) : '&nbsp;'; ?></span>
         </p>
</div>
                </p>
                    <p style="font-size: 18px">THEREFORE, I/WE pray that the following relief/s be granted to me/us in accordance with law and/or equity: <div class="a">
                    <p style="text-align: left; font-size: 18px; font-size: 18px; margin-left: 2px; margin-top: 0;">
<span style="text-align: justify; border-bottom: 1px solid black; font-size: 18px; "><?php echo ($petition) ? nl2br(htmlspecialchars($petition)) : '&nbsp;'; ?></span>
         </p>
</div>

<form id="formId" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px;">
        Made this
        <input style="font-size: 18px; width: 22px; margin-right: 5px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="number" name="made_day" placeholder="day" min="01" max="31" value="<?php echo isset($existingMadeDay) ? $existingMadeDay : ''; ?>">of
        <select style="border: none; border-bottom: 1px solid black;width: auto; font-size: 18px; margin-right: 5px;" name="made_month">
    <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="">Select Month</option>
    <?php foreach ($months as $m): ?>
        <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="<?php echo $m; ?>" <?php echo isset($existingMadeMonth) && $existingMadeMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
    <?php endforeach; ?>
</select>,


        <input style="font-size: 18px;" type="number" name="made_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : ''; ?>">
    </div>
    <div style="position: relative;">
       
        <p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 570px; margin-right: auto; font-size: 18px;" >
            <!-- CName here but All Capital Letters --><p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 570px; margin-right: auto;">
            <span style="border-bottom: 1px solid black; font-size: 18px; "><?php echo ($cNames) ? nl2br(htmlspecialchars($cNames)) : '&nbsp;'; ?></span>
    <label id="cmplnts" name="cmplnts" size="25" style="text-align: center; font-weight: normal; font-size: 18px;">Complainant/s</label>
</p>

    </div>
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px;">
        Received and filed this
        <input style="font-size: 18px; width: 22px; margin-right: 5px; padding-bottom: 0; border: none; border-bottom: 1px solid black;" type="number" name="received_day" placeholder="day" min="01" max="31" value="<?php echo isset($existingReceivedDay) ? $existingReceivedDay : ''; ?>">
                                    of 
                                    <select select style="border: none; border-bottom: 1px solid black;width: auto; font-size: 18px; margin-right: 5px;"  name="received_month">
                                        <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="">Select Month</option>
                                        <?php foreach ($months as $m): ?>
                                            <option style="border: none; border-bottom: 1px solid black;font-size: 18px;" value="<?php echo $m; ?>" <?php echo isset($existingReceivedMonth) && $existingReceivedMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
                                        <?php endforeach; ?>
                                    </select>,
        <input style="font-size: 18px; " type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : ''; ?>">
    </div>
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
   
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button">
  

</form>



<p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 550px; margin-right: auto;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span></p>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; margin-left: 470px;   font-size: 18px; font-weight: normal; white-space: nowrap; max-width: 200px;">Punong Barangay/Kalihim ng Lupon</label>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

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
        filename: 'your_page.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' } // Set A4 as the format and portrait as the orientation
    }).then(function (pdf) {
        // Use FileSaver.js or other libraries to save the PDF
        saveAs(pdf, 'your_page.pdf');
        
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


        </div> <br>
   </div>     
    
    </body>
</div> 

</html>
