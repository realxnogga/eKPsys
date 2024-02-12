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
$formUsed = 16;

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
  $message = "There is already an existing KP Form 16 in this current hearing.";
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
    <title>KP. FORM 16</title>
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
    h5{
        margin:0;
        padding:0;
    }
    #buttons {
        position: fixed;
        top: 20px;
        right: 20px;
    }
    @media print {
        #nameR {
            resize: none; /* Disable resizing */
        }

        #nameR::after {
            content: none; /* Hide the resize handle icon */
        }
    }
    </style>
</head>
<body>
<div class="container">
        <div class="paper">
                <div class="top-right-buttons">
                <!-- Print button -->

            </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 16 </b></h5>

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
              'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>
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

<form method="POST">
<h3 style="text-align: center; style= font-size: 18px;"><b style= "font-size: 18px;">AMMICABLE SETTLEMENT</b></h3>

    <div style="text-align: justify; text-indent: 2em; margin-left: 1px; font-size: 18px;">We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:            
    </div>
    <br>

    <div class="a">
<div id="nameR" name="nameR" style="text-decoration: underline; width: 700px; margin-left: 20.5px; height: auto; border: none; overflow-y: hidden; resize: vertical; font-size: 18px; white-space: pre-line;" contenteditable="true"> Type here...
</div>

</div>

</div>


<p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-left: 1px; text-indent: 1em;"> and bind ourselves to comply honestly and faithfully with the above terms of settlement. </p>

<div style="font-size: 18px; font-family: 'Times New Roman', Times, serif;text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Enter into this <input type="text" name="made_day" placeholder="day" size="5" value="<?php echo $existingMadeDay ?? ''; ?>" required> day of
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
</form></div><br>
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


  <div class="e">
    <p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-left: 1px; text-indent: 1em; ">ATTESTATION</p>
    <p style="font-size: 18px;font-family: 'Times New Roman', Times, serif; text-align: justify; text-indent: 2em; margin-left: 1px;">I hereby certify that the foregoing amicable settlement was entered into by the parties freely and 
    voluntarily, after I had explained to them the nature and consequence of such settlement.</p>
  </div><br><br>

  <p class="important-warning-text" style="font-size: 18px; text-align: center; margin-left: 490px;  font-family: 'Times New Roman', Times, serif;">
    <span style="min-width: 182px; font-size: 18px; border-bottom: 1px solid black; display: inline-block;">
        <?php echo !empty($punong_barangay) ? $punong_barangay : '&nbsp;'; ?>
    </span>
    <label style="font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: normal;">Punong Barangay/Pangkat Chairman</span>
</p>

<form>

                                  
<?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <button class="btn btn-primary print-button common-button" onclick="window.print()" style="position: relative; right: -785px; top: -980px;">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
            
    

</form>

        <a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>">
    <button class="btn common-button" style="margin-left: -125px; margin-top: -2030px;">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</a>
</body>
<br>
<div class="blank-page">        
       
</div>
</html>
