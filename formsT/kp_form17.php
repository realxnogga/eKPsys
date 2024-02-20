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
>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>KP FORM 17</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
    
        
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

.placeholder-text {
    margin-left: 15px;
    text-indent: 0em;
    font-size: 18px;
    text-align: justify;
    font-family: 'Times New Roman', Times, serif;
    text-decoration: underline;
    width: 750px;
    height: auto;
    border: none;
    overflow-y: hidden;
    resize: vertical;
    font-size: 18px;
    white-space: pre-line;
}

.placeholder-text:empty:before {
    content: 'State details here......................................................................................................................................';
    color: #999; /* Adjust the color of the placeholder text */
    text-decoration: underline;
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
            <h5> <b style="font-family: 'Times New Roman', Times, serif;">Pormularyo ng KP Blg. 17 </b></h5>
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
        <p style="text-align: left; margin-left:30px; font-size: 18px;">Usaping Barangay Blg. <span style="min-width: 170px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
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
<h3 style="text-align: center;"><b style="text-align: center; font-size: 18px;  font-family: 'Times New Roman', Times, serif;">PAGTANGGI</b></h3>
<form id="formId" method="POST">
<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;  font-size: 18px;  font-family: 'Times New Roman', Times, serif;">Sa pamamagitan nito’y itinatangi ko/naming ang pag-aayos/kasunduan sa paghahatol sapagkat ang akin/aming pag-sang-ayon ay walang saysay dahilan sa: <br>
(Lagyan ng tsek ang angkop)
    </div>
    <br>
    <div class="a" style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <input type="checkbox" id="panlilinlangCheckbox" name="panlilinlangCheckbox" style="text-indent: 0em; margin-left: 20.5px;">
    <label style="font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: normal;" for="panlilinlangCheckbox"> Panlilinlang (Ipaliwanag)</label>
    <div id="panlilinlangText" name="panlilinlangText" 
    style="border-bottom: 1px solid black;  text-indent: 0em; margin-left: 20.5px; text-decoration: underline; width: 700px; height: auto; border:none; overflow-y: hidden; resize: vertical; font-size: 18px; white-space: pre-line;" 
    contenteditable="true"> <br></div>
</div>

<div class="a" style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <input type="checkbox" id="karahasanCheckbox" name="karahasanCheckbox" style="text-indent: 0em; margin-left: 20.5px;">
    <label style="font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: normal;" for="karahasanCheckbox"> Karahasan (Ipaliwanag)</label>
    <div id="karahasanText" name="karahasanText"  style="border-bottom: 1px solid black;  text-indent: 0em; margin-left: 20.5px; text-decoration: underline; width: 700px; height: auto; border:none; overflow-y: hidden; resize: vertical; font-size: 18px; white-space: pre-line;" 
    contenteditable="true"> <br></div>
</div>

<div class="a" style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <input type="checkbox" id="pananakotCheckbox" name="pananakotCheckbox" style="text-indent: 0em; margin-left: 20.5px;">
    <label style="font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: normal;" for="pananakotCheckbox"> Pananakot (Ipaliwanag)</label>
    <div id="pananakotText" name="pananakotText"  style="border-bottom: 1px solid black;  text-indent: 0em; margin-left: 20.5px; text-decoration: underline; width: 700px; height: auto; border:none; overflow-y: hidden; resize: vertical; font-size: 18px; white-space: pre-line;" 
    contenteditable="true"> <br></div>
</div>


<br>

    <div style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; text-align: justify; text-indent: 0em; margin-left: 20.5px;">Ngayong ika- <input  style="text-align:center; font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="text" name="day" placeholder="araw" size="1" required> araw ng
    <select style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " name="made_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option  style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option  style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; "  value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
 <input  style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; "  type="number" name="made_year" size="1" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">.              
</div> <br>
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
</div><br>
<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px;  font-family: 'Times New Roman', Times, serif;"> NILAGDAAN at PINANUMPAAN sa harap ko ngayong ika- 
<input  style="font-size: 18px; text-align:center; font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="text" name="resp_day" placeholder="araw" size="5" value="<?php echo $existingRespDay ?? ''; ?>"> araw ng
  <select style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " name="resp_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " value="<?php echo $existingRespMonth; ?>" <?php echo ($m === $existingRespMonth) ? 'selected' : ''; ?>><?php echo $existingRespMonth; ?></option>
        <?php else: ?>
            <option style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="number" name="resp_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingRespYear) ? $existingRespYear : date('Y'); ?>">.
              </div><br>

<p class="important-warning-text" style="font-size: 18px; text-align: center; margin-left: 490px;  font-family: 'Times New Roman', Times, serif;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span>
    <label style="font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: normal; margin-left: 15px;"> <i>Punong Barangay/Tagapangulo ng Pangkat </i></span>
</p>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px; font-size: 18px; font-family: 'Times New Roman', Times, serif; ">Tinangap at inihain ngayong ika- <input  style="font-size: 18px; text-align:center; font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="text" name="resp_day" placeholder="araw" size="5" value="<?php echo $existingRespDay ?? ''; ?>"> araw ng
  <select style="text-align:center; font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " name="resp_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " value="<?php echo $existingRespMonth; ?>" <?php echo ($m === $existingRespMonth) ? 'selected' : ''; ?>><?php echo $existingRespMonth; ?></option>
        <?php else: ?>
            <option style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input style="font-size: 18px;  font-family: 'Times New Roman', Times, serif; border:none; border-bottom: 1px solid black; " type="number" name="resp_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingRespYear) ? $existingRespYear : date('Y'); ?>">.
                      
</div>

<?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position:fixed; right: 20px; top: 130px;">
</form>
     
  <div style="text-align: justify;margin: top 0; text-indent: 0em; margin-left: 20.5px; font-size: 16px; font-family: 'Times New Roman', Times, serif; ">*Ang hindi pagtanggi sa pag-aayos o kasunduan ng paghahatol ng tagapamagitan sa loob ng taning na panahon, alinsunod sa itinakdang sampung (10) araw ay ipapalagay na isang pagtatakwil sa karapatang tumutol batay sa nasabing kadahilanan. 
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
        filename: 'kp_form17_' + barangayCaseNumber + '.pdf', // Dynamic filename
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

</html>
