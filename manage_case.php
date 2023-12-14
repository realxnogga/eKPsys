<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';

// Sanitize input to prevent SQL injection
$rowID = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : null;

if ($rowID === null) {
    header("Location: user_complaints.php");
    exit("Error: Row ID is missing. Please select a valid case to manage.");
}

$query = "SELECT * FROM complaints WHERE id = :rowID AND UserID = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':rowID', $rowID);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header("Location: user_complaints.php");
    exit("Error: No matching case found for the given ID.");
}

// Set session variables for the data from 'complaints' table
$_SESSION['forTitle'] = $row['ForTitle'];
$_SESSION['cNames'] = $row['CNames'];
$_SESSION['rspndtNames'] = $row['RspndtNames'];
$_SESSION['cDesc'] = $row['CDesc'];
$_SESSION['petition'] = $row['Petition'];
$_SESSION['cNum'] = $row['CNum'];

// Query the 'lupons' table to get 'punong_barangay' and 'lupon_chairman'
$luponsQuery = "SELECT punong_barangay, lupon_chairman FROM lupons WHERE user_id = :userID";
$luponsStmt = $conn->prepare($luponsQuery);
$luponsStmt->bindParam(':userID', $_SESSION['user_id']);
$luponsStmt->execute();
$luponsRow = $luponsStmt->fetch(PDO::FETCH_ASSOC);

if ($luponsRow) {
    $_SESSION['punong_barangay'] = $luponsRow['punong_barangay'];
    $_SESSION['lupon_chairman'] = $luponsRow['lupon_chairman'];
}

$currentHearing = '';
// Fetch the current hearing from the case_progress table
$fetchCurrentHearingQuery = "SELECT current_hearing FROM case_progress WHERE complaint_id = :complaintId";
$stmt = $conn->prepare($fetchCurrentHearingQuery);
$stmt->bindParam(':complaintId', $_GET['id']);
$stmt->execute();
$currentHearingResult = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentHearingResult) {
    $currentHearing = $currentHearingResult['current_hearing'];
}

if ($currentHearing === '0') {
    $currentHearingText = 'Not Set';

} else {
    $currentHearingText = $currentHearing . ' Hearing';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to update the hearing progress
    $selectedHearing = $_POST['hearing'];

    if ($selectedHearing !== '0') {
        // Update the case_progress table with the selected hearing value
        $updateHearingQuery = "UPDATE case_progress SET current_hearing = :selectedHearing WHERE complaint_id = :complaintId";
        $stmt = $conn->prepare($updateHearingQuery);
        $stmt->bindParam(':selectedHearing', $selectedHearing);
        $stmt->bindParam(':complaintId', $_GET['id']);

        if ($stmt->execute()) {
            $currentHearing = $selectedHearing;
            $currentHearingText = $selectedHearing . ' Hearing';
        } else {
         echo $currentHearingText = "Data not found. Please go back to the Complaints table.";
        }
    }
}
// Set session variables for current complaint ID and current hearing
$_SESSION['current_complaint_id'] = $_GET['id'];
$_SESSION['current_hearing'] = $currentHearing;

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
    <style>
        body, html {
    margin: 0;
    padding: 0;
    height: 100%;
}
    </style>
</head>
<link rel="stylesheet" type="text/css" href="style copy.css">
<link rel="stylesheet" type="text/css" href="manage.css">   
<body>
    <!-- Adding the select dropdown for managing hearing progress -->
<form method="POST">
    <label for="hearing">Select Hearing Progress:</label>
    <select name="hearing" id="hearing">
        <option value="0" <?php if ($currentHearing === '0') echo 'selected'; ?>>Not Set</option>
        <option value="1st" <?php if ($currentHearing === '1st') echo 'selected'; ?>>1st Hearing</option>
        <option value="2nd" <?php if ($currentHearing === '2nd') echo 'selected'; ?>>2nd Hearing</option>
        <option value="3rd" <?php if ($currentHearing === '3rd') echo 'selected'; ?>>3rd Hearing</option>
    </select>
    <input type="submit" value="Set Hearing">
</form>
  <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">
                    <a href="user_complaints.php">Back</a><h3><?php echo "Case Number:". $_SESSION['cNum']; ?>
                    <h4><?php echo "Case Title: ". $_SESSION['cNames']; ?> vs <?php echo $_SESSION['rspndtNames']; ?>
                    <h4><?php echo "Complaint:". $_SESSION['cDesc']; ?></h4></h4>
</h4>
<hr>
                  
                    <div class="columns-container">

<div class="form-buttons">
    <h5>Forms Used</h5>
    <?php

    $currentHearing = $_SESSION['current_hearing'];
    $complaintId = $_SESSION['current_complaint_id'];
    // Assuming $complaintId is your current complaint ID and $currentHearing is the selected hearing
    $formButtons = array(
        'KP 7' => 7, // Map the button text to the form_used value
        'KP 8' => 8, 
        'KP 9' => 9, 
        'KP 10' => 10, 
        'KP 11' => 11, 
        'KP 12' => 12, 
        'KP 13' => 13, 
        'KP 14' => 14, 
        'KP 15' => 15, 
        'KP 16' => 16, 
        'KP 17' => 17, 
        'KP 18' => 18, 
        'KP 19' => 19, 
        'KP 20' => 20, 
        'KP 20 - A' => '20 - A', 
        'KP 20 - B' => '20 - B', 
        'KP 21' => 21, 
        'KP 22' => 22, 
        'KP 23' => 23, 
        'KP 24' => 24, 
        'KP 25' => 25
    );

     $formCount = array();

    foreach ($formButtons as $buttonText => $formUsed) {
        // Query to fetch the forms with the same complaint_id, form_used, and hearing_number
        $query = "SELECT * FROM hearings WHERE complaint_id = :complaintId AND hearing_number = :currentHearing AND form_used = :formUsed";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':complaintId', $complaintId);
        $stmt->bindParam(':currentHearing', $currentHearing);
        $stmt->bindParam(':formUsed', $formUsed);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count the occurrences of each form type
        $formCount[$formUsed] = count($results);

        // Display buttons with proper naming for multiple occurrences
        for ($i = 1; $i <= $formCount[$formUsed]; $i++) {
            $formIdentifier = ($formCount[$formUsed] > 1) ? " ($i)" : "";
            echo '<button class="open-form" data-form="kp_form' . $formUsed . '.php"><i class="fas fa-file-alt"></i> ' . $buttonText . $formIdentifier . ' </button>';
        }
    }
    ?>
</div>


  <h2>Forms</h2>
    <div class="form-buttons">
        <h5>KP Forms</h5>
        <a href="forms/kp_form7.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 7 </button></a>
        <a href="forms/kp_form8.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 8 </button></a>
        <a href="forms/kp_form9.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 9 </button></a>
        <a href="forms/kp_form10.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 10 </button></a>
        <a href="forms/kp_form11.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 11 </button></a>
        <a href="forms/kp_form12.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 12 </button></a>
        <a href="forms/kp_form13.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 13 </button></a>
        <a href="forms/kp_form14.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 14   </button></a>
        <a href="forms/kp_form15.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 15 </button></a>
        <a href="forms/kp_form16.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 16 </button></a>
        <a href="forms/kp_form17.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 17 </button></a>
        <a href="forms/kp_form18.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 18 </button></a>
        <a href="forms/kp_form19.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 19 </button></a>
        <a href="forms/kp_form20.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 20 </button></a>
        <a href="forms/kp_form20A.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 20-A </button></a>
        <a href="forms/kp_form20B.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 20-B </button></a>
        <a href="forms/kp_form21.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 21 </button></a>
        <a href="forms/kp_form22.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 22</button></a>
        <a href="forms/kp_form23.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 23 </button></a>
        <a href="forms/kp_form24.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 24 </button></a>
        <a href="forms/kp_form25.php"><button class="open-form"><i class="fas fa-file-alt"></i> KP 25 </button></a>
        

    </div>

    <div class="modal-container" id="modal-container">
        <div class="iframe-container">
            <iframe id="form-iframe" name="form-iframe" src="" sandbox="allow-same-origin allow-scripts allow-modals"></iframe>
        </div>
    </div>
</div>

</div>
<!-- // left column end -->


    <script>
    const openFormButtons = document.querySelectorAll('.open-form');
    const modalContainer = document.getElementById('modal-container');
    const formIframe = document.getElementById('form-iframe');

    openFormButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const formSrc = 'forms/' + button.getAttribute('data-form');
            modalContainer.style.display = 'flex';
            formIframe.src = formSrc;

            // Add an event listener to close the modal when clicking outside
            modalContainer.addEventListener('click', (event) => {
                if (event.target === modalContainer) {
                    closeFormView();
                }
            });
        });
    });

    // Close the document view when pressing the "Esc" key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeFormView();
        }
    });

    function closeFormView() {
        modalContainer.style.display = 'none';
        formIframe.src = '';
    }
</script>
            

</body>
</html>