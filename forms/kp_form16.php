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
?>

<!DOCTYPE html>
<html>
<head>
    <title>KP FORM 16</title>
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
            <h5>KP Form No. 16</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
                <br><br>
            </div>

            <?php
            $months = [
              'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>

<div class="form-group" style="text-align: right;">

<div class="input-field"> <br>
    <!-- case num here -->
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
    <p> Respondents:<br>
        <!-- RspndtNames here -->
       <?php echo $rspndtNames; ?><br> </p>
</div>
</div>
        </div>

<h3 style="text-align: center;"><b>AMICABLE SETTLEMENT</b></h3>
<form method="POST">
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
        We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:            
    </div>
<textarea name="settle" style="width: 760px; box-sizing: border-box; overflow-y: hidden;" required><?php echo isset($existingSettlement) ? $existingSettlement : ''; ?></textarea>
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <p> and bind ourselves to comply honestly and faithfully with the above terms of settlement. </p>
        Enter into this
        <input type="number" name="made_day" placeholder="day" min="1" max="31" value="<?php echo isset($existingMadeDay) ? $existingMadeDay : ''; ?>">
        day of
        <select name="made_month">
            <option value="">Select Month</option>
            <?php foreach ($months as $m): ?>
                <option value="<?php echo $m; ?>" <?php echo isset($existingMadeMonth) && $existingMadeMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
            <?php endforeach; ?>
        </select>,
        <input type="number" name="made_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : ''; ?>">
    </div>
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button">
</form>
<div>
    <div style="text-align: left; font-size: 12px; margin-left: 100px;">
    <p><br>Complainant/s <br> <br><br><p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 570px; margin-left: auto;"><?php echo $cNames; ?> <br>_____________________
            <id="cmplnts" name="cmplnts" size="25"  style="text-align: left;"></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
    <p>Respondent/s <br> <br><br><p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 570px; margin-left: auto;"><?php echo $rspndtNames; ?> <br>_____________________
            <id="rspndt" name="rspndt" size="25"  style="text-align: left;"></p><br>
                    </div>
  <div class="e">
    <p>ATTESTATION</p>
    <p>I hereby certify that the foregoing amicable settlement was entered into by the parties freely and voluntarily, after I had
explained to them the nature and consequence of such settlement.</p>
  </div><br><br>
  <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center;">Punong Barangay/Pangkat Chairman</label>
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

</body>
<br>
       
</div>
</html>
