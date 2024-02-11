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
$formUsed = 11;


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
$existOfficer = '';

$id = $_GET['formID'] ?? '';

if (!empty($id)) {
    // Fetch data based on the provided formID
    $query = "SELECT received_date, officer FROM hearings WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Extract and format the timestamp values
     
        $receivedDate = new DateTime($row['received_date']);
       
        $existingReceivedDay = $receivedDate->format('j');
        $existingReceivedMonth = $receivedDate->format('F');
        $existingReceivedYear = $receivedDate->format('Y');

        $existOfficer = $row['officer'];

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs

    $receivedDay = $_POST['received_day'] ?? '';
    $receivedMonth = $_POST['received_month'] ?? '';
    $receivedYear = $_POST['received_year'] ?? '';
    $officer = $_POST['officer'];

    $receivedDate = createDateFromInputs($receivedDay, $receivedMonth, $receivedYear);

    // Check if there's an existing form_used = 14 within the current_hearing of the complaint_id
    $query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND form_used = :formUsed AND hearing_number = :currentHearing";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->execute();
    $existingForm14Count = $stmt->rowCount();



    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, received_date, officer)
              VALUES (:complaintId, :currentHearing, :formUsed, :receivedDate, :officer)
              ON DUPLICATE KEY UPDATE
              hearing_number = VALUES(hearing_number),
              form_used = VALUES(form_used),
              received_date = VALUES(received_date),
                        officer = VALUES(officer)";


     $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':receivedDate', $receivedDate);
    $stmt->bindParam(':officer', $officer);
    
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

// Prepare a new query to fetch 'punong_barangay', 'lupon_chairman', and 'name1' to 'name20' based on 'user_id'
$luponQuery = "SELECT name1, name2, name3, name4, name5, name6, name7, name8, name9, name10,
                        name11, name12, name13, name14, name15, name16, name17, name18, name19, name20
                    FROM lupons
                    WHERE user_id = :user_id AND appoint = 0";
$luponStmt = $conn->prepare($luponQuery);
$luponStmt->bindParam(':user_id', $_SESSION['user_id']);
$luponStmt->execute();

// Fetch the lupon data
$luponData = $luponStmt->fetch(PDO::FETCH_ASSOC);

// Check if lupon data is fetched successfully
if ($luponData) {
    $names = [];
    for ($i = 1; $i <= 20; $i++) {
        $name = $luponData["name$i"];
        if (!empty($name)) {
            $names[] = $name;
        }
    }
} else {
    // If no data found, you can handle it accordingly (e.g., provide default values or display an error message)
    $names = [];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>kp_form11</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
    
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
                <a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>"><button class="btn common-button">
                    <i class="button-icon"></i> Back
                </button></a>
            </div>
            
             <div style="text-align: left;">
                <h5>KP Form No. 11</h5>
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

           
<div class="form-group" style="text-align: right;"> <br>

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
   

                <h3 style="text-align: center;"><b>NOTICE TO CHOSEN PANGKAT MEMBER</b></h3>
                <form method="POST">
               <div class="e" style="text-align: right;">
              <?php

// Get the current date
$currentDate = date('F d, Y');

// Print the formatted date
echo $currentDate;

?>

            </div>


            <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
                <div class="label"></div>
                <div class="input-field">
                    <p> TO:<br><input type="text" name="to" id="to" size="30"> </p>
            </div>
            </div>


                <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> 
                <p>Notice is hereby given that you have been chosen member of the Pangkat ng Tagapagkasundo amicably conciliate the dispute between the par in the above-entitled case. </p>
                </div>
                <br><br>


    
                <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center;">Punong Barangay</label>



            <form method="POST">
                <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Received this<input type="text" name="received_day" placeholder="day" size="5" value="<?php echo $existingReceivedDay ?? ''; ?>">  of
                <select name="received_month" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo isset($existingReceivedYear) ? $existingReceivedYear : date('Y'); ?>">.
</div>


       <div style="position: relative;">
                    <br>
                    </div>
                    <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button">
                    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
<input type="text" name="officer" size="25" value="<?php echo $existOfficer; ?>" required list="officerList"> Pangkat Member</p>
<datalist id="officerList">
    <?php foreach ($names as $name): ?>
        <option value="<?php echo $name; ?>">
    <?php endforeach; ?>
</datalist>
                    </p>
       

            </form>

            
                
            </div>
        </div>

</body>
<br>
<div class="blank-page">        
       
          
</div>
</html>
