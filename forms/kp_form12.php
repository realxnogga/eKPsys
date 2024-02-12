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
    $existingMadeDay = date('j', strtotime($existingMadeDate));
    $existingMadeMonth = date('F', strtotime($existingMadeDate));
    $existingMadeYear = date('Y', strtotime($existingMadeDate));

    $existingReceivedDay = date('j', strtotime($existingReceivedDate));
    $existingReceivedMonth = date('F', strtotime($existingReceivedDate));
    $existingReceivedYear = date('Y', strtotime($existingReceivedDate));
} else {
    // If no row found, populate with present date as placeholders
    $existingMadeDay = date('j');
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
    } else {
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
    
</head>
<style>
.profile-img{
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
</style>
<body>
    <br>
    <div class="paper">
            <div class="top-right-buttons">
                <!-- Print button -->
                <button class="btn btn-primary print-button common-button" onclick="window.print()">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
                <button class="btn btn-success download-button common-button" id="downloadButton">
                    <i class="fas fa-file button-icon"></i> Download
                </button>
                <br>
                <a href="../manage_case.php?id=<?php echo $_SESSION['current_complaint_id']; ?>">
                    <button class="btn common-button">
                        <i class="button-icon"></i> Back
                    </button>
                </a>
            </div>

            <div style="text-align: left; font-family: 'Times New Roman', Times, serif;">
                <h5 style="font-size: 14px; font-weight: bold;">KP Form No. 8</h5>
    <div style="position: relative; height: 1px; margin-right: 0px;">
    <img src="<?php echo $profilePicture; ?>" alt="Descriptive Text" style="position: absolute; top: 50px; left: 50%; transform: translate(-50%, -50%); width: 100px;">
</div>
<div><br><br><br><br><br><br><br>
        <h5 style="text-align: center; font-size: 18px;">Republic of the Philippines</h5>
        <h5 style="text-align: center; font-size: 18px;">Province of Laguna</h5>
        <h5 style="text-align: center; font-size: 18px;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
        <h5 style="text-align: center; font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
        <h5 style="text-align: center; font-size: 18px;">OFFICE OF THE PUNONG BARANGAY</h5>
</div>

<?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $currentYear = date('Y');
            ?>

            

<br>
<h3 style="text-align: center; font-family: 'Times New Roman', Times, serif; font-size: 18px; font-weight: bold;">NOTICE OF HEARING</h3>
<h3 style="text-align: center; font-family: 'Times New Roman', Times, serif; font-size: 18px; font-weight: bold;">(MEDIATION PROCESS)</h3>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <br><br><p style="font-size: 18px;; font-family: 'Times New Roman', Times, serif">
        TO: <span style="border-bottom: 1px ridge black; font-size: 18px;">
    <?php echo !empty($cNames) ? nl2br(htmlspecialchars($cNames)) : '&nbsp;'; ?></span>
<div style="text-align: left; margin-left: 80.5px;">
    <p style="font-size: 18px; margin-top: -10px; font-family: 'Times New Roman', Times, serif;">Complainant/s</p>
</div>
<form method="POST">
    <div style="text-align: justify; text-indent: 2em; font-size: 18px;; font-family: 'Times New Roman', Times, serif">
        You are hereby required to appear before me on the
        <input type="number" name="day" placeholder="day" style="font-size: 18px; border: none; border-bottom: 1px solid black;" min="1" max="31" value="<?php echo $appear_day; ?>" required> day of
        <select name="month" style="font-size: 18px;" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="font-size: 18px;" value=""<?php echo $appear_month; ?> <?php echo ($m === $appear_month) ? 'selected' : ''; ?>><?php echo $appear_month; ?></option>
        <?php else: ?>
            <option style="font-size: 18px;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>" style="font-size: 18px; width: 40px;"> at
        <input type="time" id="time" name="time" size="5" style="font-size: 18px; border: none; border-bottom: 1px solid black;" value="<?php echo $appear_time; ?>" required> o'clock in the morning/afternoon for the hearing of your complaint.
    </div>

    <div style="text-align: justify; text-indent: 2em; font-size: 18px; font-family: 'Times New Roman', Times, serif;">
        This
        <input type="number" name="made_day" placeholder="day" style="font-size: 18px; border: none; border-bottom: 1px solid black;" min="1" max="31" value="<?php echo $existingMadeDay; ?>">
        of
        <select name="made_month" style="font-size: 18px;" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>" style="font-size: 18px; width: 40px;">.
            <br><br><br>
            <div style="text-align: right;">
                <div style="min-width: 250px; border-bottom: 1px solid black; display: inline-block; text-align: center; right: 25px; font-size: 18px; position: relative;">
                <div class="barangay-official" style="font-size: 18px;">
  <?php echo $punong_barangay; ?>
</div>
    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center; font-size: 18px; position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); font-weight: normal;"><br><br><br>Punong Barangay/Lupon Chairman</label>
    </div></div></span><br><br><br>

       <br><br><div style="text-align: justify; text-indent: 2em; font-size: 18px;">
       Notified this
            <input type="number" name="received_day" placeholder="day" style="font-size: 18px; border: none; border-bottom: 1px solid black;" min="1" max="31" value="<?php echo $existingReceivedDay ?? ''; ?>">
            of
            <select name="received_month" style="font-size: 18px;" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option value="<?php echo $existingReceivedMonth; ?>" <?php echo ($m === $existingReceivedMonth) ? 'selected' : ''; ?>><?php echo $existingReceivedMonth; ?></option>
        <?php else: ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
<input type="number" name="received_year" placeholder="year" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>" style="font-size: 18px; width: 40px;">.
        </div>

        <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
                         <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button">
                            </form>
                            <br>
                            <br>
                            <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><?php echo $punong_barangay; ?><br>_________________<br>
                                <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center;">Punong Barangay</label>
                            </p>
                        </div>
                    </div> <br>
                </div>
            </div>
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

            // Remove borders for all input types and select
            var inputFields = document.querySelectorAll('input, select');
            inputFields.forEach(function (field) {
                field.style.border = 'none';
            });

            var pdfContent = document.querySelector('.paper');
            var downloadButton = document.getElementById('downloadButton');

            // Hide the download button
            downloadButton.style.display = 'none';

            // Use html2pdf to generate a PDF
            html2pdf(pdfContent, {
                margin: 10,
                filename: 'your_page.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
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