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

?>


<!DOCTYPE html>
<html>
<head>
    <title>kp_form7</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
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
    h5 {
        margin: 0;
        padding: 0;
    }
</style>
</head>
<body>
    <div class="container">
    <div class="paper">
    <div class="top-right-buttons">
    <!-- Print button -->
    <button class="btn btn-primary print-button common-button" onclick="window.print()" style="position: relative; right: 450px; top: -20px;">
    <i class="fas fa-print button-icon"></i> Print
    </button>

    <a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>" style="position: relative; left: -1400px; top: -55px;">
    <button class="btn common-button">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</a>
</div>
</body>
<br>




            
            <div style="text-align: left; font-family: 'Times New Roman', Times, serif;">
    <h5 style="font-size: 12px;">Pormularyo ng KP Blg. 7</h5>
    <h5 style="text-align: center; font-size: 16px;">Republika ng Pilipinas</h5>
    <h5 style="text-align: center; font-size: 16px;">Lalawigan ng Laguna</h5>
    <h5 style="text-align: center; font-size: 16px;">Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
    <h5 style="text-align: center; font-size: 16px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5><br>
    <h5 style="text-align: center; font-size: 16px; font-weight: bold;">TANGGAPAN NG LUPONG TAGAPAMAYAPA</h5>
</div>

                <?php
                $months = [
                    'Enero', 'Pebrero', 'Marso', 'Abril', 'Mayo', 'Hunyo', 'Hulyo', 'Agosto', 'Setyembre', 'Oktubre', 'Nobyembre', 'Disyembre'];

                $currentYear = date('Y');
                ?>
   
                
   <br>
   <br>
   
                
   <div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif;">
    <div class="input-field" style="float: right; width: 50%;">
<!-- case num here -->
<p style="text-align: left; font-size: 16px; margin-left: 30px; margin-bottom: 0;">
    Usaping Barangay Blg. <span style="min-width: 178px; font-size: 16px; border-bottom: 1px solid black; display: inline-block;"><?php echo !empty($cNum) ? $cNum : '&nbsp;'; ?></span>
</p>
        <p style="text-align: left; font-size: 16px; font-size: 16px; margin-left: 30px; margin-top: 0;">
        Ukol sa: <span style="border-bottom: 1px solid black; font-size: 16px;"><?php echo !empty($forTitle) ? nl2br(htmlspecialchars($forTitle)) : '&nbsp;'; ?></span>

</p>

    </div>
</div>

<div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field" style="font-size: 16px;">
<!-- CNames here -->
<div style="min-width: 250px; font-size: 16px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($cNames) ? $cNames : '&nbsp;'; ?>
</div>
<p style="font-size: 16px;">(Mga) Maysumbong</p>
        <p style="font-size: 16px;">- laban kay/kina -</p>
    </div>
</div>

<div class="form-group" style="text-align: justify; font-family: 'Times New Roman', Times, serif; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field;">
<!-- RspndtNames here -->
<div style="min-width: 250px; font-size: 16px; border-bottom: 1px solid black; display: inline-block;">
    <?php echo !empty($rspndtNames) ? $rspndtNames : '&nbsp;'; ?>
</div>
<p style="font-size: 16px;"><i>(Mga) Ipinagsusumbong</i></p>

    </div>
</div> 

                    <h3 style="text-align: center; font-family: 'Times New Roman', Times, serif; font-size: 16px; font-weight: bold;">SUMBONG</h3>

                    <div style="text-align: justify; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-indent: 0em; margin-left: 20.5px;"> 
                    <p style="font-size: 16px;">AKO/KAMI, ay nagrereklamo laban sa mga ipinagsusumbong na binanggit sa itaas dahil sa paglabag ng aking/aming mga karapatan at kapakanan sa sumusunod na pamamaraan:
                        <div class="a"><p style="text-align: left; font-size: 16px; font-size: 16px; margin-left: 2px; margin-top: 0;">
       <span style="border-bottom: 1px solid black; font-size: 16px;"><?php echo !empty($cDesc) ? nl2br(htmlspecialchars($cDesc)) : '&nbsp;'; ?></span>
                        
                        

  <br>
</div>

                </p>
                    <p style="font-size: 16px;">DAHIL DITO, AKO/KAMI, na nakikiusap na ipagkakaloob sa akin/amin ang sumusunod na (mga) kalunasan nang naaalinsunod sa batas at/o pagkamakatuwiran: <div class="a">
  <span style="border-bottom: 1px solid black; font-size: 16px;"><?php echo !empty($petition) ? nl2br(htmlspecialchars($petition)) : '&nbsp;'; ?></span>
  <br>
</div>

<form id="formId" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div style="text-align: justify; font-family: 'Times New Roman', Times, serif; text-indent: 0em; font-size: 16px; margin-left: 20.5px; font-weight: bold">
    <br>Ginawa ngayong ika- 
    <span style="border-bottom: 1px solid black; font-size: 16px;"><?php echo !empty($existingMadeDay) ? nl2br(htmlspecialchars($existingMadeDay)) : '&nbsp;'; ?></span> araw ng 
        <select name="made_month" style="font-size: 16px;">  
    <option value="">Buwan</option>
    <?php foreach ($months as $m): ?>
        <option value="<?php echo $m; ?>" <?php echo isset($existingMadeMonth) && $existingMadeMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
    <?php endforeach; ?>
</select>
        </select>,
        <input type="number" name="made_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : ''; ?>" style="font-size: 16px; width: auto; display: inline-block;">
<span style="font-size: 16px; display: inline-block; margin-left: -38px;">.</span>

    </div>
    <div style="position: relative;">
        <br>
        <p class="important-warning-text" style="text-align: center; font-family: 'Times New Roman', Times, serif; font-size: 24px; margin-left: 570px; margin-right: auto;" >
        <div style="text-align: right;">
        <div style="min-width: 250px; border-bottom: 1px solid black; display: inline-block; text-align: center; font-size: 16px; position: relative;">
    <?php echo $cNames; ?>
    <br> <!-- Add a line break to move the next element to a new line -->
    <label id="cmplnts" name="cmplnts" size="25" style="text-align: center; font-size: 16px; position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); font-weight: normal;"><br><br>(mga) Maysumbong</label>
    </div>
</div></p></span>

    </div>
    <br><br><div style="text-align: justify; font-family: 'Times New Roman', Times, serif; text-indent: 0em; font-size: 16px; margin-left: 20.5px;">
    Tinanggap at inihain ngayong  
    <span style="border-bottom: 1px solid black; font-size: 16px;"><?php echo !empty($existingReceivedDay) ? nl2br(htmlspecialchars($existingReceivedDay)) : '&nbsp;'; ?></span>
araw ng 
<select name="received_month" style="font-size: 16px;">
    <option value="">Buwan</option>
    <?php foreach ($months as $m): ?>
        <span style="border-bottom: 1px solid black; font-size: 16px;"><?php echo !empty($existingReceivedMonth) ? nl2br(htmlspecialchars($existingReceivedDay)) : '&nbsp;'; ?></span>        <option value="<?php echo $m; ?>" <?php echo isset($existingReceivedMonth) && $existingReceivedMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
    <?php endforeach; ?>
</select>
        </select>,
        <input type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : ''; ?>" style="font-size: 16px;">
        <span style="font-size: 16px; display: inline-block; margin-left: -38px;">.</span>
    </div>
</form>
<br>
<br>
<div style="text-align: right;">
    <div style="min-width: 250px; border-bottom: 1px solid black; display: inline-block; text-align: center; font-size: 16px;">
        <?php echo $punong_barangay; ?>
    </div>
    <br> <!-- Add a line break to move the next element to a new line -->
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; min-width: 250px; font-family: 'Times New Roman', Times, serif; font-size: 16px; font-weight: normal;"><i>Punong Barangay/Kalihim ng Lupon</i></label>

</div>

                </div>
            </div>
        </div> <br>
   </div>     
    </body>
</div> 

</html>
