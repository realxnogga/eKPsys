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
$formUsed = 25;

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
  $message = "There is already an existing KP Form 23 in this current hearing.";
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

<!DOCTYPE html>
<html>
<head>
    <title>KP Form 23 Tagalog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


    
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- here angle the link for responsive paper -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
</head>
<style>
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
        width: 40px;
        text-align: center;

    }
    h5 {
        margin: 0;
        padding: 0;
    }
    h3 {
        margin: 0;
        padding: 0;
    }
    .centered-line {
        border-bottom: 1px ridge black;
        display: inline-block;
        min-width: 350px;
        text-align: center;
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
        height: 29.7cm;
    }

    .paper[layout="landscape"] {
        width: 29.7cm;
        height: 21cm;
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
  /* Adjust print styles here */
  .input-field {
    /* Example: Ensure input fields do not expand beyond their containers */
    max-width: 100%;
  }
  input[name="saveForm"] {
            display: none;
        }
  
  input[type="text"] {
        border-bottom: 1px solid black !important;
    }
        /* Hide elements that should not be printed */
        .btn, .top-right-buttons {
            display: none !important;
    }
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

            </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">Pormularyo ng KP Blg. 23</b></h5>

           <div style="display:inline-block;text-align: center;">
<img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $citylogo; ?>" alt="City Logo" style="height: 80px; width: 80px;">
<div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
<br>
        <h5 class="header" style="font-size: 18px;">Republika ng Pilipinas</h5>
        <h5 class="header" style="font-size: 18px;">Lalawigan ng Laguna</h5>
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
        <h5 class="header" style="font-size: 18px;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>

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
        <p style="text-align: left; margin-left:30px; font-size: 18px;">Usaping Barangay Blg.<span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNum) ? $cNum : '&nbsp;'; ?></span></p>

        <p style="text-align: left; margin-left:30px; margin-top: 0; font-size: 18px;">Ukol sa:<span style="border-bottom: 1px solid black; font-size: 18px;"><?php echo !empty($forTitle) ? nl2br(htmlspecialchars($forTitle)) : '&nbsp;'; ?></span> </p>
    </div>
</div>

<div class="form-group" style="text-align: justify; text-indent: 0em; font-family: 'Times New Roman', Times, serif;">
    <div class="label"></div>
    <div style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNames) ? $cNames : '&nbsp;'; ?>
                </div>
              
<p style="font-size: 18px;">(Mga) Maysumbong:</p>
<p style="font-size: 18px;">-laban kay/kina-</p>
                </div>

<div class="form-group" style="text-align: justify; text-indent: 0em; font-family: 'Times New Roman', Times, serif;">
  
    <div style="min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($rspndtNames) ? $rspndtNames : '&nbsp;'; ?>
                </div>
             
<p style="font-size: 18px;"> (Mga) Ipinagsusumbong:</p> 

       
<form method="POST">
                <h3 style="text-align: center;"><b style="font-size: 18px;">PANUKALA SA PAGPAPATUPAD</b>
 </h3><br>
         <div style="text-align: justify; text-indent: 0em;">
           
                <p style="font-size: 18px;"> Ang (mga) maysumbong/ipinagsusumbong ay nagpahayag ng mga sumusunod: </p>
    <div>

   <div style="font-size: 18px; text-align: justify; text-indent: 0em; margin-left: 38.5px;"> 1. Noong  <input type="text" name="made_day" placeholder="day" size="5" style="width: 30px; border:none; border-bottom: 1px solid black; text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingMadeDay ?? ''; ?>" required> araw ng 
  <select name="made_month" style="height: 30px; border:none; border-bottom: 1px solid black; text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;">
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="border:none; border-bottom: 1px solid black; text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option style="border:none; border-bottom: 1px solid black; text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input type="number" name="made_year" placeholder="year" style="width: 44px; border:none; border-bottom: 1px solid black; text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : date('Y'); ?>">.
        

     Ng mga panig sa usaping ito ay (petsa) lumagda sa isang  matiwasay na pag-aayos/ tumanggap ng gawad ng paghahatol na ibinigay ng Tagapangulo ng Lupon/Pangkat ng Tagapagkasundo;
           
</div>


<div style="font-size: 18px; text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <p style="font-size: 18px; text-indent: 0em; margin-left: 18px;">
       2. Ang sampung (araw) na taning mula sa petsang binanggit sa itaas ay natapos ng  wala sa sinumang panig ang naghain ng sinumpaang salaysay ng pagtanggi sa pag-aayos sa harap ng Tagapangulo ng Lupon ng petisyon na nagpapawalang-saysay sa  gawad ng paghahatol sa  hukuman;  at
    </p>
</div>

           <div style="font-size: 18px;text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <p style="font-size: 18px; text-indent: 0em; margin-left: 18px;">
       3. Ang matiwasay na pag-aayos/gawad ng paghahatol ay pinal at ngayon ay nararapat lang ipatupad.
    </p>
    <div style="font-size: 18px;text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    DAHIL DITO, ang (mga) maysumbong/ipinagsusumbong ay humiling na ang katumbas  na kasulatan sa pagpapatupad sa usaping ito ay ipalabas na ng Tagapangulo ng Lupon.
</div>
</div>
<br>
<input style="text-align: center; margin-left: 20px; font-size: 18px; border:none; border-bottom: 1px solid black;" type="text" name="year" id="dateInput" placeholder="Date" size="15" value="">
<p style="font-size: 18px; margin-top: 10px; margin-left: 80px;"> (Petsa) </p><br>
<script>
    // Get current date
    const currentDate = new Date();

    // Format the date as M/Day/Year
    const options = { month: 'short', day: 'numeric', year: 'numeric' };
    const formattedDate = currentDate.toLocaleDateString('en-US', options);

    // Set the formatted date as the input value
    document.getElementById('dateInput').value = formattedDate;
</script>


<div style="position: relative;">
    <br>
    <div class="form-group" style="text-align: justify; text-indent: 0em; margin-right: 20.5px; font-family: 'Times New Roman', Times, serif;">
    <div id="NamesContent" style="margin-left: 470px; margin-right: auto; min-width: 250px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <!-- PHP variables $cNames and $rspndtNames will be inserted here dynamically -->
    </div>
  


    <select id="ComplainantRespondentSelector" name="Complainant/s/Respondent/s" onchange="ComplainantRespondents()" style="border:none;  font-size: 18px; text-align: right; margin-left: 470px; margin-right: auto;" required>
        <option  style="border:none;  font-size: 18px;" value="" disabled selected>Complainant/s/Respondent/s</option>
        <option  style="border:none;  font-size: 18px;" value="Complainant">Complainant/s</option>
        <option  style="border:none; font-size: 18px;" value="Respondent">Respondent/s</option>  
    </select>
</div>

<script>
    function ComplainantRespondents() {
        var selectedOption = document.getElementById("ComplainantRespondentSelector").value;
        var cNames = '<?php echo !empty($cNames) ? $cNames : ''; ?>';
        var rspndtNames = '<?php echo !empty($rspndtNames) ? $rspndtNames : ''; ?>';

        var namesContent = document.getElementById("NamesContent");

        if (selectedOption === "Complainant") {
            // Update the content for complainant names
            namesContent.innerHTML = '<p style="font-size: 18px;">' + cNames + '</p>';
        } else if (selectedOption === "Respondent") {
            // Update the content for respondent names
            namesContent.innerHTML = '<p style="font-size: 18px;">' + rspndtNames + '</p>';
        }
    }
</script>

<form>
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
   
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
</form>
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
        filename: 'kp_form23_' + barangayCaseNumber + '.pdf', // Dynamic filename
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
</body>
</html>
    