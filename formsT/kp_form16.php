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
$formUsed = 16;

// Array of months
$months = array(
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
);

// Check if the form has been previously submitted for this complaint ID and form type
$query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed";
$stmt = $conn->prepare($query);
$stmt->bindParam(':complaintId', $complaintId);
$stmt->bindParam(':formUsed', $formUsed);
$stmt->execute();
$rowCount = $stmt->rowCount();

if ($rowCount > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $existingMadeDate = $row['made_date'];
    $existingSettlement = $row['settlement']; // Fetch existing settlement value

    // Use existing values as placeholders
    // Parse dates to extract day, month, and year
    $existingMadeDay = date('j', strtotime($existingMadeDate));
    $existingMadeMonth = date('F', strtotime($existingMadeDate));
    $existingMadeYear = date('Y', strtotime($existingMadeDate));

} else {
    // If no row found, populate with present date as placeholders
    $existingMadeDay = date('j');
    $existingMadeMonth = date('F');
    $existingMadeYear = date('Y');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // After getting form inputs
    $madeDay = $_POST['made_day'];
    $madeMonth = $_POST['made_month'];
    $madeYear = $_POST['made_year'];
    $settlement = $_POST['settle']; // Get the 'settle' textarea input

    // Check if day, month, and year are non-empty before constructing the date
    if (!empty($madeDay) && !empty($madeMonth) && !empty($madeYear)) {
        $monthNum = date('m', strtotime("$madeMonth 1"));
        $madeDate = date('Y-m-d', mktime(0, 0, 0, $monthNum, $madeDay, $madeYear));
    } else {
        // If any of the date components are empty, set $madeDate to a default value or handle as needed
        // For example, setting it to the current date:
        $madeDate = date('Y-m-d');
    }

    // Validation before submission
    if ($rowCount > 0) {
        $message = "Form already submitted for this complaint ID and form type.";
    } else {
        $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, made_date, settlement)
                  VALUES (:complaintId, :currentHearing, :formUsed, :madeDate, :settlement)
                  ON DUPLICATE KEY UPDATE
                  hearing_number = VALUES(hearing_number),
                  form_used = VALUES(form_used),
                  made_date = VALUES(made_date),
                  settlement = VALUES(settlement)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':complaintId', $complaintId);
        $stmt->bindParam(':currentHearing', $currentHearing);
        $stmt->bindParam(':formUsed', $formUsed);
        $stmt->bindParam(':madeDate', $madeDate);
        $stmt->bindParam(':settlement', $settlement);

        if ($stmt->execute()) {
            $message = "Form submit successful.";
            // Update 'CStatus' and 'CMethod' in 'complaints' table
            $updateQuery = "UPDATE complaints SET CStatus = 'Settled', CMethod = 'Mediation' WHERE id = :complaintId";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindParam(':complaintId', $complaintId);
            $updateStmt->execute();
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
<html lang="en">
<head>
    <title>kp_form16</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">

  <!-- Add Bootstrap responsive classes for different screen sizes -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <style>
        .paper {
    background: white;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    overflow: hidden; /* Add overflow property to handle content overflow */

    /* Add padding to create margins */
    padding: 2%; /* Adjust the value as needed */

    /* Set box-sizing to include padding in the element's total width and height */
    box-sizing: border-box;
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
            <h5> <b style="font-family: 'Times New Roman', Times, serif;"> Pormularyo ng KP Blg. 16 </b></h5>

            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
    <img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 100px; width: 100px;">

    <div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
        <br>
                <h5 style="text-align: center;font-size: 18px;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;font-size: 18px;">Lalawigan ng Laguna</h5>
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
                <h5 style="text-align: center;font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5><br>
                <h5 style="text-align: center;font-size: 18px;"><b style="font-size: 18px;font-family: 'Times New Roman', Times, serif;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA </b></h5>
            </div>
</div>

            <?php
$months = [
    'Enero', 'Pebrero', 'Marso', 'Abril', 'Mayo', 'Hunyo', 'Hulyo', 'Agosto', 'Setyembre', 'Oktubre', 'Nobyembre', 'Disyembre'
];

$currentYear = date('Y');
?>

<br><br>

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
                <h5 style="text-align: center;font-size: 18px;"><b style="font-size: 18px;font-family: 'Times New Roman', Times, serif;">KASUNDUANG PAG-AAYOS </b></h3>
                <form id="formId" method="POST">
    <div style="text-align: justify; text-indent: 0em; margin-left: 15px; font-size: 18px;font-family: 'Times New Roman', Times, serif;"> Kami, ang (mga) maysumbong at (mga) ipinagsusumbong sa usaping isinasaad sa itaas, ay nagkakasundo sa pamamagitan nito na aayusin ang aming alitan tulad ng sumusunod:            
    </div>
    <div class="a">
        <div id="name" placeholder="Ilahad ang kasunduan" name="name" style="margin-left: 15px; text-indent: 0em;  font-size: 18px; text-align: justify; font-family: 'Times New Roman', Times, serif;text-decoration: underline; width: 750px; height: auto; border:none; overflow-y: hidden; resize: vertical; font-size: 18px; white-space: pre-line;" 
        contenteditable="true"> </div>
    </div>
<p style="margin-left: 15px; text-indent: 0em; text-align: justify;  font-size: 18px; font-family: 'Times New Roman', Times, serif;"> at nangangako na aming tutuparin ng may katapatan ang mga alituntunin ng pag-aayos. </p>

<div style="text-align: justify; text-indent: 0em; margin-left: 15px;  font-size: 18px; font-family: 'Times New Roman', Times, serif;"> Pinagkasunduan ngayong ika-<input style=" font-size: 18px; font-family: 'Times New Roman', Times, serif; border:none; border-bottom:1px solid black;" type="text" name="day" placeholder="araw" size="1" required> araw ng
                <select style=" border:none; border-bottom:1px solid black;font-size: 18px; font-family: 'Times New Roman', Times, serif;" name="month" required>
                    <option style=" border:none; border-bottom:1px solid black;font-size: 18px; font-family: 'Times New Roman', Times, serif;"  value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option style=" border:none; border-bottom:1px solid black;font-size: 18px; font-family: 'Times New Roman', Times, serif;"  value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                <input style="border:none; border-bottom: 1px solid black;font-size: 18px;font-family: 'Times New Roman', Times, serif;" type="number" name="made_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">.            
          
</div>
<br><br>
<?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position:fixed; right: 20px; top: 130px;">
</form>

    <div style="display: flex; justify-content: space-between; font-size: 18px; text-align: center; ">
    <div style="text-align: center; margin-left: 10px;">
        <p style="font-size: 18px;font-family: 'Times New Roman', Times, serif; text-align:left;margin-left: 10px; "><i>(Mga) Maysumbong	</i></p>
        <ul style="margin-bottom: 10; padding: 0; list-style: none; font-size: 18px; text-align: center;">
        <span style="min-width: 30px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;"><?php echo $cNames; ?></span>
        </ul>
    </div>

    <div style="text-align: center; margin-right: 350px;font-family: 'Times New Roman', Times, serif;">
        <p style="font-size: 18px;font-family: 'Times New Roman', Times, serif; text-align:left;"><i> (Mga) Ipinagsusumbong </i></p>
        <ul style="margin-bottom: 10; padding: 0; list-style: none; font-size: 18px; text-align: center;">
        <span style="min-width: 30px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;font-family: 'Times New Roman', Times, serif;"><?php echo $rspndtNames; ?></span>
        </ul>
    </div>
</div>
<br>
  <div class="e">
    <b style="font-size: 18px;font-family: 'Times New Roman', Times, serif; text-align: justify; text-indent: 0em; margin-left: 15px;"> <i> PAGPAPATUNAY </i></b>
    <p style="text-align: justify; text-indent: 0em; margin-left: 15px; font-size: 18px;font-family: 'Times New Roman', Times, serif; " >Pinatutunayan ko sa pamamagitan nito na ang sinusundang kasunduan ng pag-aayos ay pinagkasunduan ng mga panig nang Malaya at kusang-loob, matapos kong maipaliwanag sa kanila kung ano ang pag-aayos na ito at ang mga kahihinatnan nito.</p>
  </div><br><br>
  <p class="important-warning-text" style="font-size: 18px; text-align: center; margin-left: 490px;  font-family: 'Times New Roman', Times, serif;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span>
    <label style="font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: normal; margin-left: 15px;"> <i>Punong Barangay/Tagapangulo ng Pangkat </i></span>
</p>

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
        filename: 'kp_form16_' + barangayCaseNumber + '.pdf', // Dynamic filename
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

</body>
<br>
<div class="blank-page">        
       
</div>
</html>
