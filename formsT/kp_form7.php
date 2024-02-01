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
    <br>
    <div class="container">
        <div class="paper">
                <div class="top-right-buttons">
                <!-- Print button -->
                <button class="btn btn-primary print-button common-button" onclick="window.print()">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
                            <!-- Download button -->
    <button class="btn btn-success download-button common-button" onclick="downloadPage()">
            <i class="fas fa-download button-icon"></i> Download
                </button>
                <script>
function downloadPage() {
    var pageContent = document.documentElement.outerHTML;
    var blob = new Blob([pageContent], { type: 'text/html' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'page.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
</script>
</body>
                <a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>"><button class="btn common-button">
                    <i class="button-icon"></i> Back
                </button></a>

            </div>
            
             <div style="text-align: left;">
             <h5 style="font-size: 8px;">Pormularyo ng KP Blg. 7</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5><br>
                <h5 style="text-align: center;"><b>TANGGAPAN NG LUPONG TAGAPAMAYAPA</b></h5>
            </div>
                <?php
                $months = [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                $currentYear = date('Y');
                ?>
   
                
  
    <div class="form-group" style="text-align: right;">

        <div class="input-field"> <br><br>
            <!-- case num here -->
            <div style="text-align: right;">  Usaping Barangay Blg.<?php echo $cNum; ?> </div>
            <p> <div style="text-align: right;">Ukol sa : 
            <!-- ForTitle here -->
            <?php echo $forTitle; ?> <br> 
        </div>
    </div>

    <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
        <div class="label"></div>
        <div class="input-field">
            <p> (Mga) Maysumbong	
                <!-- CNames here -->
                <br><?php echo $cNames; ?><br> </p>
        <br><p>  — laban kay/kina —</p>
    </div>
    </div>

    <div>
    <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
        <div class="label"></div>
        <div class="input-field">
            <p> (Mga) Ipinagsusumbong<br>
                <!-- RspndtNames here -->
               <?php echo $rspndtNames; ?><br> </p>
        </div>
    </div>

       

                    <h3 style="text-align: center;"><b>SUMBONG</b></h3>

                    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> 
                    <p>AKO/KAMI, ay nagrereklamo laban sa mga ipinagsusumbong na binanggit sa itaas dahil sa paglabag ng aking/aming mga karapatan at kapakanan sa sumusunod na pamamaraan: 
                        <div class="a">
  <textarea id="name" name="name" style="width: 700px; box-sizing: border-box; overflow-y: hidden;"><?php echo $cDesc; ?></textarea>
  <br>
</div>

                </p>
                    <p>DAHIL DITO, AKO/KAMI, na nakikiusap na ipagkakaloob sa akin/amin ang sumusunod na (mga) kalunasan nang naaalinsunod sa batas at/o pagkamakatuwiran: <div class="a">
  <textarea id="name" name="name" style="width: 700px; box-sizing: border-box; overflow-y: hidden;"><?php echo $petition; ?></textarea>
  <br>
</div>

<form id="formId" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    Ginawa ngayong ika- 
        <input type="number" name="made_day" placeholder="day" min="1" max="31" value="<?php echo isset($existingMadeDay) ? $existingMadeDay : ''; ?>">
        araw ng 
        <select name="made_month">
            <option value="">Buwan</option>
            <?php foreach ($months as $m): ?>
                <option value="<?php echo $m; ?>" <?php echo isset($existingMadeMonth) && $existingMadeMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
            <?php endforeach; ?>
        </select>,
        <input type="number" name="made_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingMadeYear) ? $existingMadeYear : ''; ?>">
    </div>
    <div style="position: relative;">
        <br>
        <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;" >
            <!-- CName here but All Capital Letters --><br><br><br><p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <?php echo $cNames; ?><br>
     _________________
    <label id="cmplnts" name="cmplnts" size="25" style="text-align: center;">(mga) Maysumbong</label>
</p>

    </div>
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    Tinanggap at inihain ngayong  
<input type="number" name="received_day" placeholder="day" min="1" max="31" value="<?php echo isset($existingReceivedDay) ? $existingReceivedDay : ''; ?>">
araw ng 
        <select name="received_month">
            <option value="">Buwan</option>
            <?php foreach ($months as $m): ?>
                <option value="<?php echo $m; ?>" <?php echo isset($existingReceivedMonth) && $existingReceivedMonth === $m ? 'selected' : ''; ?>><?php echo $m; ?></option>
            <?php endforeach; ?>
        </select>,
        <input type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : ''; ?>">
    </div>
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button">
</form>
<br>
<br>
                    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center;">Punong Barangay/Kalihim ng Lupon</label>
</p>
                </div>
            </div>
        </div> <br>
   </div>     
    </body>
</div> 

</html>
