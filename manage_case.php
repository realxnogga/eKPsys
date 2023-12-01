<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Retrieve the row ID from the URL
$rowID = isset($_GET['id']) ? $_GET['id'] : null;

if ($rowID === null) {
    echo "Error: Row ID is missing. Please select a valid case to manage.";
    header("Location: user_complaints.php");
} else {
   $query = "SELECT * FROM complaints WHERE id = :rowID AND UserID = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':rowID', $rowID);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        // Set session variables for the data from 'complaints' table
        $_SESSION['forTitle'] = $row['ForTitle'];
        $_SESSION['cNames'] = $row['CNames'];
        $_SESSION['rspndtNames'] = $row['RspndtNames'];
        $_SESSION['cDesc'] = $row['CDesc'];
        $_SESSION['petition'] = $row['Petition'];
        $_SESSION['cNum'] = $row['CNum'];

        // Query the 'lupons' table to get 'punong_barangay' and 'lupon_chairman'
        $luponsQuery = "SELECT punong_barangay, lupon_chairman FROM lupons WHERE user_id = " . $_SESSION['user_id'];
        $luponsResult = $conn->query($luponsQuery);
        $luponsRow = $luponsResult->fetch(PDO::FETCH_ASSOC);

        if ($luponsRow) {
            $_SESSION['punong_barangay'] = $luponsRow['punong_barangay'];
            $_SESSION['lupon_chairman'] = $luponsRow['lupon_chairman'];
        }
    } else {
        echo "Error: No matching case found for the given ID.";
        header("Location: user_complaints.php");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Case</title>
    <style>
   
    .modal-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); /* Dark overlay background */
        z-index: 1; /* Place it on top */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .iframe-container {
        position: relative;
        width: 60%; /* Adjust the width as needed */
        height: 100%; /* Adjust the height as needed */
    }

    iframe {
        border: none;
        width: 100%;
        height: 100%;
        background-color: white;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }



</style>
</head>

<link rel="stylesheet" type="text/css" href="style copy.css">
<link rel="stylesheet" type="text/css" href="manage.css">

<hr><br>
<body>


<div class="columns-container">
    <div class="left-column">
        <div class="card">
            
        <h4><b>Forms</b></h4><br>
  
        <h4><?php echo "Case Number:". $_SESSION['cNum']; ?><br>
        <?php echo "Case Title: ". $_SESSION['cNames']; ?> vs <?php echo $_SESSION['rspndtNames']; ?><br>
        <?php echo "Complaint:". $_SESSION['cDesc']; ?></h4><br>


    <div class="form-buttons">
        <h5>I. Complaint Forms</h5>
        <button class="open-form" data-form="kp_form7.php"><i class="fas fa-file-alt"></i> KP 7 Complaint</button>
        <button class="open-form" data-form="kp_form8.php"><i class="fas fa-file-alt"></i> KP 8 Hearing</button>
        <button class="open-form" data-form="kp_form9.php"><i class="fas fa-file-alt"></i> KP 9 Summons</button><br><br>

        <h5>II. Mediation Forms</h5>
        <button class="open-form" data-form="kp_form11.php"><i class="fas fa-file-alt"></i> KP 11 Notice to Chosen Pangkat Member</button>
        <button class="open-form" data-form="kp_form12.php"><i class="fas fa-file-alt"></i> KP 12 Notice of Hearing</button>
        <button class="open-form" data-form="kp_form13.php"><i class="fas fa-file-alt"></i> KP 13 Subpoena</button>
        <button class="open-form" data-form="kp_form14.php"><i class="fas fa-file-alt"></i> KP 14 Agreement For Arbitration</button>
        <button class="open-form" data-form="kp_form15.php"><i class="fas fa-file-alt"></i> KP 15 Arbitration Award</button>
        <button class="open-form" data-form="kp_form16.php"><i class="fas fa-file-alt"></i> KP 16 Amicable Settlement</button>
        <button class="open-form" data-form="kp_form17.php"><i class="fas fa-file-alt"></i> KP 17 Repudiation</button><br><br>
        
        <h5>III. Administration Forms</h5>
        <button class="open-form" data-form="kp_form1.php"><i class="fas fa-file-alt"></i> KP 1 Notice To Constitute The Lupon</button>
        <button class="open-form" data-form="kp_form2.php"><i class="fas fa-file-alt"></i> KP 2 Appointment</button>
        <button class="open-form" data-form="kp_form3.php"><i class="fas fa-file-alt"></i> KP 3 Notice Of Appointment</button>
        <button class="open-form" data-form="kp_form4.php"><i class="fas fa-file-alt"></i> KP 4 List Of Appointed Lupon Members</button>
        <button class="open-form" data-form="kp_form5.php"><i class="fas fa-file-alt"></i> KP 5 Oath Of Office</button>
        <button class="open-form" data-form="kp_form6.php"><i class="fas fa-file-alt"></i> KP 6 Withdrawal Of Appointment</button><br><br>

        <h5>IV. Execution Forms</h5>
        <button class="open-form" data-form="kp_form23.php"><i class="fas fa-file-alt"></i> KP 23 Motion For Execution</button>
        <button class="open-form" data-form="kp_form24.php"><i class="fas fa-file-alt"></i> KP 24 Notice Of Hearing (MfE)</button>
        <button class="open-form" data-form="kp_form25.php"><i class="fas fa-file-alt"></i> KP 25 Notice Of Execution</button><br><br>

        <h5>V. Certification Forms</h5>
        <button class="open-form" data-form="kp_form20.php"><i class="fas fa-file-alt"></i> KP 20 Certification To File Action</button>
        <button class="open-form" data-form="kp_form20A.php"><i class="fas fa-file-alt"></i> KP 20-A Certification To File Action</button>
        <button class="open-form" data-form="kp_form20B.php"><i class="fas fa-file-alt"></i> KP 20-B Certification To File Action</button>
        <button class="open-form" data-form="kp_form21.php"><i class="fas fa-file-alt"></i> KP 21 Certification To Bar Action</button>
        <button class="open-form" data-form="kp_form22.php"><i class="fas fa-file-alt"></i> KP 22 Certification To Bar Counterclaim</button>
        <button class="open-form" data-form="kp_form10.php"><i class="fas fa-file-alt"></i> KP 10 Notice For Constitution Of Pangkat</button>
        <button class="open-form" data-form="kp_form18.php"><i class="fas fa-file-alt"></i> KP 18 Notice Of Hearing (Re: Failure To Appear)</button>
        <button class="open-form" data-form="kp_form19.php"><i class="fas fa-file-alt"></i> KP 19 Notice Of Hearing (Re: Failure To Appear)</button>
    </div>

    <div class="modal-container" id="modal-container">
        <div class="iframe-container">
            <iframe id="form-iframe" src="" sandbox="allow-same-origin allow-scripts allow-modals"></iframe>
        </div>
    </div>

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


</div>
</div>
</div>

</body>
</html>