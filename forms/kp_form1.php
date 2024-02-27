<?php
session_start();
$apptNames = $_SESSION['apptNames'] ?? [];
?>

<?php
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
$formUsed = 10;

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
        $appearDate = new DateTime($row['appear_date']);
        $appear_day = $appearDate->format('j');

        $appear_month = $appearDate->format('F');
        $appear_year = $appearDate->format('Y');
        $appear_time = $appearDate->format('H:i'); // Format for the time input

        $madeDate = new DateTime($row['made_date']);
        $receivedDate = new DateTime($row['received_date']);

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

    $day = $_POST['day'] ?? '';
    $month = $_POST['month'] ?? '';
    $year = $_POST['year'] ?? '';
    $time = $_POST['time'] ?? '';

$dateTimeString = "$year-$month-$day $time";
$appearTimestamp = DateTime::createFromFormat('Y-F-j H:i', $dateTimeString);


if ($appearTimestamp !== false) {
    $appearTimestamp = $appearTimestamp->format('Y-m-d H:i:s');

    // Logic to handle date and time inputs
    $madeDate = createDateFromInputs($madeDay, $madeMonth, $madeYear);
    $receivedDate = createDateFromInputs($receivedDay, $receivedMonth, $receivedYear);

    // Insert or update the appear_date in the hearings table
    $query = "INSERT INTO hearings (complaint_id, hearing_number, form_used, appear_date, made_date, received_date)
              VALUES (:complaintId, :currentHearing, :formUsed, :appearDate, :madeDate, :receivedDate)
              ON DUPLICATE KEY UPDATE
              hearing_number = VALUES(hearing_number),
              form_used = VALUES(form_used),
              appear_date = VALUES(appear_date),
              made_date = VALUES(made_date),
              received_date = VALUES(received_date)";


     $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId);
    $stmt->bindParam(':currentHearing', $currentHearing);
    $stmt->bindParam(':formUsed', $formUsed);
    $stmt->bindParam(':appearDate', $appearTimestamp);
    $stmt->bindParam(':madeDate', $madeDate);
    $stmt->bindParam(':receivedDate', $receivedDate);
    
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
    <title>KP Form 1 English</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- here angle the link for responsive paper -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
</head>
<style>
    .profile-img {
        width: 3cm;
    }

    /* Hide the number input arrows for WebKit browsers like Chrome, Safari */
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

    /* Regular screen styles for text inputs */
    input[type="text"], input[type="number"] {
        border: none;
        border-bottom: 1px solid black;
        font-family: 'Times New Roman', Times, serif;
        font-size: 18px;
        text-align: left;
        outline: none;
        width: auto; /* Adjust width as necessary */
    }

    h3, h5 {
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
            height: auto;
        }

        .paper[layout="landscape"] {
            width: 29.7cm;
            height: auto;
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

    /* Consolidated Print styles */
    @media print {
        body, html, .container, .paper {
            background: white;
            margin: 0;
            padding: 0;
            box-shadow: none;
            width: auto;
        }
        
        .paper {
            padding-left: 2.54cm; /* 1 inch */
            padding-right: 2.54cm; /* 1 inch */
        }

        input[type="text"], input[type="number"], select {
            border: none !important;
            border-bottom: 1px solid black !important;
            color: black !important;
            background-color: white !important;
            display: inline-block !important;
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        
        input[type="text"]:after, input[type="number"]:after {
            content: "";
            display: block;
            margin-top: -1px;
            border-bottom: 1px solid black;
        }

        /* Hide elements that should not be printed */
        .btn, .top-right-buttons {
            display: none !important;
    }
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
    <a href="../user_lupon.php?id=<?php echo $_SESSION['current_complaint_id']; ?>">
        <button class="btn common-button" style="position:fixed; right: 20px; top: 177px;">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </a>
    </div>
    <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 1</b></h5>
<div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
<div style="display:inline-block;text-align: center;">
<img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $citylogo; ?>" alt="City Logo" style="height: 80px; width: 80px;">
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
<h5 class="header" style="font-size: 18px; margin-top: 5px;">OFFICE OF THE PUNONG BARANGAY</h5>
</div>
<br>
<br>
            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>

<div style="text-align: right;">
<?php
$currentDate = date('F d, Y');
$fontSize = '18px'; 
$fontFamily = 'Times New Roman'; 
echo "<p style='font-size: $fontSize; font-family: $fontFamily;'>$currentDate</p>";
?>
                <script>
                    var yearInput = document.getElementById('year');

                    yearInput.addEventListener('keyup', function(event) {
                        if (event.keyCode === 38) {
                            event.preventDefault();
                            var year = parseInt(yearInput.value);
                            yearInput.value = year + 1;
                        }
                    });

                    yearInput.addEventListener('keyup', function(event) {
                        if (event.keyCode === 40) {
                            event.preventDefault();
                            var year = parseInt(yearInput.value);
                            yearInput.value = year - 1;
                        }
                    });
                </script>

<h3 style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: bold;">
<br>NOTICE TO CONSTITUTE THE LUPON</h3>

<br><br><div style="text-align: left;">
                    <p style="font-family: 'Times New Roman', Times, serif; font-size: 18px;">To All Barangay Members and All Other Persons Concerned:</p>
                    <p style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">In compliance with Section 1(a), Chapter 7, Title One, Book III, Local Government Code of 1991 (Republic Act No. 7160), of the
                    <i>Katarungang Pambarangay Law</i>, notice is hereby given to constitute the <i>Lupong Tagapamayapa</i> of this Barangay.
                    The persons I am considering for appointment are the following:</p>
                        <div style="display: flex;">
    <div style="flex: 1; margin-left: 70px;">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <?php $nameKey = "name$i"; ?>
            <p style="margin: 0; font-family: 'Times New Roman', Times, serif; font-size: 18px;"><?php echo $i; ?>. <input type="text" name="appointed_lupon_<?php echo $i; ?>" value="<?php echo $apptNames[$nameKey] ?? ''; ?>" style="width: 250px; margin-bottom: 5px;font-family: 'Times New Roman', Times, serif; font-size: 18px;"></p>
        <?php endfor; ?>
    </div>

        <div style="flex: 1;">
        <?php for ($i = 11; $i <= 20; $i++): ?>
            <?php $nameKey = "name$i"; ?>
            <p style="margin: 0; font-family: 'Times New Roman', Times, serif; font-size: 18px;"><?php echo $i; ?>. <input type="text" name="appointed_lupon_<?php echo $i; ?>" value="<?php echo $apptNames[$nameKey] ?? ''; ?>" style="width: 250px; margin-bottom: 5px; font-family: 'Times New Roman', Times, serif; font-size: 18px;"></p>
        <?php endfor; ?>
    </div>
</div>

            <script>
function openAndLoadForm(formSrc, punongBarangayValue, luponChairmanValue) {
        const iframe = document.getElementById('kp-form-iframe');
        iframe.src = `${formSrc}?punong_barangay=${punongBarangayValue}&lupon_chairman=${luponChairmanValue}`;

        const modal = document.getElementById('kp-form-modal');
        modal.style.display = 'block';
    }

    document.getElementById('open-kp-form1').addEventListener('click', function() {
        openAndLoadForm('forms/kp_form1.php', '<?= strtoupper($apptNames['punong_barangay'] ?? '') ?>', '<?= strtoupper($apptNames['lupon_chairman'] ?? '') ?>');
    });

                function resetFields() {

            document.getElementById('day').value = "";
        

            var inputs = document.querySelectorAll('.paper div[style="display: flex;"] input[type="text"]');

                inputs.forEach(function(input) {
            input.value = "";
                });
            }
            </script>


                <br><br><p style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">They have been chosen on the basis of their suitability for the task of conciliation considering their integrity, impartiality, independence of mind, sense of fairness and reputation for probity in view of their age, social standing in the community, tact, patience, resourcefulness, flexibility, open-mindedness and other relevant factors.
                The law provides that only those actually residing or working in the barangay who are not expressly disqualified by law are qualified to be appointed as <i>Lupon</i> members.</p>

                <form method="POST">
                    <p style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">
                        All persons are hereby enjoined to immediately inform me and of their opposition to or endorsement of any or all the proposed members or recommend to me other persons not included in the list but not later than the
    <input type="number" name="day" placeholder="day" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black;" min="1" max="31" value="<?php echo $appear_day; ?>" required>
    ,<select name="month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
        <?php foreach ($months as $m): ?>
            <option style="font-size: 18px; text-align: center;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="number" name="year" placeholder="year" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; width: 60px;" min="2000" max="2099" value="<?php echo date('Y'); ?>" required>
(the last day for posting this notice).</form></div>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
    <body>
    <br><br><br><br>
<p class="important-warning-text" style="font-family: 'Times New Roman', Times, serif; text-align: center; font-size: 18px; margin-left: 450px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="font-family: 'Times New Roman', Times, serif; border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 18px;" size="25" value=" <?php echo $punong_barangay; ?>">
    <p style="font-family: 'Times New Roman', Times, serif; text-align: center; font-size: 18px; margin-top: 15px; margin-left: 450px;">Punong Barangay</p>
</p>

<script>

    const positionInput = document.getElementById('positionInput');
    positionInput.addEventListener('click', function() {
        this.select();
    });
</script>
<div style="text-align: left; font-family: 'Times New Roman', Times, serif; font-size: 18px;">
    <div style="margin-bottom: 0;"><br><br>
        <span style="font-weight: normal; display: inline-block; width: 120px; font-size: 18px; text-indent: 2em;">IMPORTANT:</span>
        <span style="display: inline; font-size: 18px; margin-left: 180px; text-align: left; vertical-align: top;">This notice is required to be posted in three (3) conspicuous</span>
        <span style="display: inline; font-size: 18px; margin-left: 303px; text-align: left; vertical-align: top;">places in the barangay for at least three (3) weeks.</span>
    </div>
    <div style="margin-top: 20px;">
        <span style="font-weight: normal; display: inline-block; width: 140px; font-size: 18px; text-indent: 2em;">WARNING:</span>
        <span style="display: inline; font-size: 18px; margin-left: 160px; text-align: left; vertical-align: top;">Tearing or defacing this notice shall be subject to punishment</span>
        <span style="display: inline; font-size: 18px; margin-left: 303px; text-align: left; vertical-align: top;">according to law.</span>
    </div>
</div>
</form>
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
        
        // Hide the specified buttons
        buttonsToHide.forEach(function (button) {
            button.style.display = 'none';
        });

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
            filename: 'kp_form1_' + barangayCaseNumber + '.pdf', // Dynamic filename
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

            // Show the other buttons after PDF generation
            buttonsToHide.forEach(function (button) {
                button.style.display = 'inline-block';
            });

            // Restore borders for all input types and select
            inputFields.forEach(function (field) {
                field.style.border = ''; // Use an empty string to revert to the default border
            });
        });
    });
</script>

</div>
</div>
</body>
</html>
    