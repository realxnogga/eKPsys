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
$formUsed = 9;

// Fetch existing row values if the form has been previously submitted
$query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed";
$stmt = $conn->prepare($query);
$stmt->bindParam(':complaintId', $complaintId);
$stmt->bindParam(':formUsed', $formUsed);
$stmt->execute();
$rowCount = $stmt->rowCount();

$currentYear = date('Y');

// Array of months
$months = array(
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
);

$currentMonth = date('F'); 
$currentDay = date('j');

$id = $_GET['formID'] ?? '';

$existingScenario = 0; 
$existingScenarioInfo = ''; 

$existOfficer = '';
// Check if formID exists in the URL
if (!empty($id)) {
    // Fetch data based on the provided formID
    $query = "SELECT appear_date, made_date, received_date, resp_date, officer, scenario, scenario_info FROM hearings WHERE id = :id";
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
        $respDate = new DateTime($row['resp_date']);

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

        $existingRespDay = $respDate->format('j');
        $existingRespMonth = $respDate->format('F');
        $existingRespYear = $respDate->format('Y');

        $existOfficer = $row['officer'];
        $existingScenario = $row['scenario'];
        $existingScenarioInfo = $row['scenario_info'];

$rspndtName1 = ''; // Default to empty strings
$rspndtName2 = '';
$rspndtName3 = '';
$rspndtName4 = '';

$existScen3 = $existingScenarioInfo; // Default to empty strings
$existScen4 = $existingScenarioInfo;


// Echo existing scenario and scenario_info in the corresponding input fields
if ($existingScenario == 1) {
    $rspndtName1 = $rspndtNames;
} elseif ($existingScenario == 2) {
    $rspndtName2 = $rspndtNames;
} elseif ($existingScenario == 3) {
    $rspndtName3 = $rspndtNames;
    $existingScenarioInfo = $row['scenario_info']; // Assign scenario_info for scenario 3
} elseif ($existingScenario == 4) {
    $rspndtName4 = $rspndtNames;
    $existingScenarioInfo = $row['scenario_info']; // Assign scenario_info for scenario 4
         }
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

    $officer = $_POST['officer'];

    $day = $_POST['day'] ?? '';
    $month = $_POST['month'] ?? '';
    $year = $_POST['year'] ?? '';
    $time = $_POST['time'] ?? '';

$scenario = null;
$scenarioInfo = null;

if (!empty($_POST['scenario_1'])) {
    $scenario = 1;
    $scenarioInfo = '';
} elseif (!empty($_POST['scenario_2'])) {
    $scenario = 2;
    $scenarioInfo = '';
} elseif (!empty($_POST['scenario_3'])) {
    $scenario = 3;
    $scenarioInfo = $_POST['scenario_3a'];
} elseif (!empty($_POST['scenario_4'])) {
    $scenario = 4;
    $scenarioInfo = $_POST['scenario_4a'];
}


$dateTimeString = "$year-$month-$day $time";
$appearTimestamp = DateTime::createFromFormat('Y-F-j H:i', $dateTimeString);


if ($appearTimestamp !== false) {
    $appearTimestamp = $appearTimestamp->format('Y-m-d H:i:s');

    // Logic to handle date and time inputs
    $madeDate = createDateFromInputs($madeDay, $madeMonth, $madeYear);
    $receivedDate = createDateFromInputs($receivedDay, $receivedMonth, $receivedYear);
    $respDate = createDateFromInputs($respDay, $respMonth, $respYear);

    // Insert or update the appear_date in the hearings table
    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, appear_date, made_date, received_date, resp_date, officer, scenario, scenario_info)
          VALUES (:complaintId, :currentHearing, :formUsed, :appearDate, :madeDate, :receivedDate, :respDate, :officer, :scenario, :scenarioInfo)
          ON DUPLICATE KEY UPDATE
          hearing_number = VALUES(hearing_number),
          form_used = VALUES(form_used),
          appear_date = VALUES(appear_date),
          made_date = VALUES(made_date),
          received_date = VALUES(received_date),
          resp_date = VALUES(resp_date),
          officer = VALUES(officer),
          scenario = VALUES(scenario),
          scenario_info = VALUES(scenario_info)
          ";


    $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':appearDate', $appearTimestamp);
    $stmt->bindParam(':madeDate', $madeDate);
    $stmt->bindParam(':receivedDate', $receivedDate);
    $stmt->bindParam(':respDate', $respDate);
    $stmt->bindParam(':officer', $officer);
    $stmt->bindParam(':scenario', $scenario);
    $stmt->bindParam(':scenarioInfo', $scenarioInfo);

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

?>

<!DOCTYPE html>
<html>
<head>
    <title>kp_form9</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        width: 30px;

    }
</style>
<body>
    <br>
    <div class="container">
        <div class="paper">
                <div class="top-right-buttons">
                <!-- Print button -->
                <button class="btn btn-primary print-button common-button" onclick="window.print()">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
               <a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>"><button class="btn common-button">
                    <i class="button-icon"></i> Back
                </button></a>
            </div>
            
             <div style="text-align: left;">
                <h5>KP Form No. 9</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
            </div>

            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $currentYear = date('Y');
            ?>

<div class="form-group" style="text-align: right;"><br>
    
    <div class="input-field">
    <div style="text-align: right; margin-right: 180px;"> Barangay Case No.<?php echo $cNum; ?> </div> <br> <p> <div style="text-align: right; margin-right: 100px;">For: 
                <!-- ForTitle here -->
                 <?php echo $forTitle; ?> <br> 
        </div>
    </div>

    <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
        <div class="label"></div>
        <div class="input-field">
            <p> Complainants:
                <!-- CNames here -->
                <br><?php echo $cNames; ?><br> </p>
    <br><p> — against —</p>
</div>
</div>

<div>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> Respondents:<br><?php echo $rspndtNames; ?></p>
    </div>
</div>

<h3 style="text-align: center;"> 
SUMMONS
</h3>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> TO: <?php echo $rspndtNames; ?> </p>
</div>
</div>

<h3 style="text-align: center;"> 
Respondents
</h3>
<form method="POST">

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">You are hereby required to appear before me on the <input type="number" name="day" placeholder="day" min="1" max="31" value="<?php echo $appear_day; ?>" required>  of
     <select name="month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $appear_month; ?>" <?php echo ($m === $appear_month) ? 'selected' : ''; ?>><?php echo $appear_month; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
                <input type="number" name="year" placeholder="year" min="<?php echo date('Y'); ?>" max="<?php echo date('Y') + 100; ?>" value="<?php echo date('Y'); ?>" required> at <input type="time" id="time" name="time" size="5" style="border: none;" value="<?php echo $appear_time; ?>" required> o'clock in the morning/afternoon then and there to answer to a complaint made before me, copy of which is attached hereto, for mediation/conciliation of your dispute with complainant/s.
</div>
    <br>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> You are hereby warned that if you refuse or willfully fail to appear in obedience to this summons, you may be barred from filing any counterclaim arising from said complaint. <br> <br>FAIL NOT or else face punishment as for contempt of court.
</div>

   <br>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> This <input type="number" name="made_day" placeholder="day" min="1" max="31" value="<?php echo $existingMadeDay; ?>">
 day of
                <select name="made_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
                <input type="number" name="made_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>">.              
</div> 


<p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value="<?php echo $punong_barangay;?>">
    Punong Barangay
</p>

  <h3 style="text-align: center;"> OFFICER'S RETURN </h3>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> I served this summons upon respondent <?php echo $rspndtNames; ?> on the  <input type="number" name="received_day" placeholder="day" min="1" max="31" value="<?php echo $existingReceivedDay ?? ''; ?>">
 day of
                <select name="received_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
                <input type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>">, and upon respondent <?php echo $rspndtNames; ?> on the day
                <input type="number" name="resp_day" placeholder="day" min="1" max="31" value="<?php echo $existingRespDay ?? ''; ?>"> of
    <select name="resp_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingRespMonth; ?>" <?php echo ($m === $existingRespMonth) ? 'selected' : ''; ?>><?php echo $existingRespMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
                <input type="number" name="resp_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>">  by: <br>
                <p> (Write name/s of respondent/s before mode by which he/they was/were served.)</p>
</div>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <p style="text-indent: 0em; margin-left: 18px;">
        <input type="text" id="scenario1" name="scenario_1" size="15" value="<?php echo ($existingScenario == 1) ? $rspndtName1 : ''; ?>"> 1. handing to him/them said summons in person, or <br>
        <input type="text" id="scenario2" name="scenario_2" size="15" value="<?php echo ($existingScenario == 2) ? $rspndtName2 : ''; ?>"> 2. handing to him/them said summons and he/they refused to receive it, or <br>
        <input type="text" id="scenario3" name="scenario_3" size="15" value="<?php echo ($existingScenario == 3) ? $rspndtName3 : ''; ?>"> 3. leaving said summons at his/their dwelling with
        <input type="text" id="scenario3a" name="scenario_3a" size="15" value="<?php echo ($existingScenario == 3) ? $existScen3 : ''; ?>"> (name) a person of suitable age and discretion residing therein, or <br> 
        <input type="text" id="scenario4" name="scenario_4" size="15" value="<?php echo ($existingScenario == 4) ? $rspndtName4 : ''; ?>"> 4. leaving said summons at his/their office/place of business with
        <input type="text" id="scenario4a" name="scenario_4a" size="15" value="<?php echo ($existingScenario == 4) ? $existScen4 : ''; ?>">, (name) a competent person in charge thereof.
    </p>
</div>


<div class="e">
<p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><input type="text" name="officer" size="25" value="<?php echo $existOfficer; ?>" required>Officer</p>
</div>

<p>Received by Respondent/s representative/s:</p>


    <div class="a">
        <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><input type="text" id="date" name="date" placeholder="Date" size="25"></p>
</div>

<?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button">
</form>

           
                </div>
            </div>
        </div>

<br>           
</div>
</body>

</html>