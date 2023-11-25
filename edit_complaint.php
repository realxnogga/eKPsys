<?php
session_start();
include_once("connection.php");
include 'user-navigation.php';
include 'functions.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

include 'edit_handler.php';

// Step 1: Query the user's "lupons" table
$userID = $_SESSION['user_id'];
// Corrected SQL query based on the actual column name
$luponsQuery = "SELECT name1, name2, name3, name4, name5, name6, name7, name8, name9, name10, name11, name12, name13, name14, name15, name16, name17, name18, name19, name20 FROM lupons WHERE user_id = :userID";

$stmt = $conn->prepare($luponsQuery);
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();

$luponsData = $stmt->fetch(PDO::FETCH_ASSOC);
$luponsArray = [];

// Create an array of lupons' names
for ($i = 1; $i <= 20; $i++) {
    $fieldName = 'name' . $i;
    if (!empty($luponsData[$fieldName])) {
        $luponsArray[] = $luponsData[$fieldName];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Complaint</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
<style>


/* Style the form */
form {
    border-radius: 5px;
    padding: 20px;
}

/* Style labels and input fields */
label {
    display: block;
}

input[type="text"],
input[type="date"],
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border-radius: 3px;
}

/* Add styles for required fields */
.text-danger {
    color: red;
    font-weight: bold;
}

/* Style the submit button */
input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

</style>
</head>


<hr><br>
<body>
  
<div class="columns-container">
    <div class="left-column">
        <div class="card">
    <h4><b>Edit information</b></h4>

    <div class="container-fluid px-1 py-5 mx-auto">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                    <?php echo $successMessage; // Display success message here ?>
                    <form action="" method="post">
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Case No.<span class="text-danger"> *</span></label>

                                <input type="text" id="CNum" name="CNum" placeholder="Case No. - Blotter No. - MMYY" onblur="validate(1)" required value="<?php echo $complaint['CNum']; ?>">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">For:<span class="text-danger"> *</span></label>
                                <input type="text" id="ForTitle" name="ForTitle" placeholder="Enter Name" onblur="validate(2)" required value="<?php echo $complaint['ForTitle']; ?>">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Complainants:<span class="text-danger"> *</span></label>
                                <input type="text" id="CNames" name="CNames" placeholder="Enter name of complainants" onblur="validate(3)" required value="<?php echo $complaint['CNames']; ?>">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Respondents:<span class="text-danger"> *</span></label>
                                <input type="text" id="RspndtNames" name="RspndtNames" placeholder="Enter name of respondents" onblur="validate(4)" required value="<?php echo $complaint['RspndtNames']; ?>">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-12 flex-column d-flex">
                                <label class="form-control-label px-3">Complain<span class="text-danger"> *</span></label>
                                <input type="text" id="CDesc" name="CDesc" placeholder="" onblur="validate(5)" required value="<?php echo $complaint['CDesc']; ?>">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-12 flex-column d-flex">
                                <label class="form-control-label px-3">Petition<span class="text-danger"> *</span></label>
                                <input type="text" id="Petition" name="Petition" placeholder="" onblur="validate(6)" required value="<?php echo $complaint['Petition']; ?>">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Made:<span class="text-danger"> *</span></label>
                                <input type="datetime-local" id="Mdate" name="Mdate"onblur="validate(7)" value="<?php echo date('Y-m-d\TH:i'); ?>">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Received:</label>
                                <input type="date" id="RDate" name="RDate" onblur="validate(8)" value="<?php echo $complaint['RDate']; ?>">
                            </div>
                        </div>
<div class="row justify-content-between text-left">
 <div class="form-group col-12 flex-column d-flex">
  <label class="form-control-label px-3">Pangkat:<span class="text-danger"></span></label>
  <input type="text" id="Pangkat" name="Pangkat" placeholder="Enter name of Punong Barangay" oninput="showDropdown()" value="<?php echo $complaint['Pangkat']; ?>">
  <!-- Apply the custom class to the dropdown container -->
  <div id="pangkatDropdown"></div>
</div>

</div>
<div class="row justify-content-between text-left">

                        <div class="row justify-content-between text-left">
                            
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Case Status:<span class="text-danger"> *</span></label>
        <select name="CStatus" id="cStatusSelect">
            <option value="Settled" <?php if ($complaint['CStatus'] === 'Settled') echo 'selected'; ?>>Settled</option>
            <option value="Unsettled" <?php if ($complaint['CStatus'] === 'Unsettled') echo 'selected'; ?>>Unsettled</option>
            <option value="Others" <?php if ($complaint['CStatus'] === 'Others') echo 'selected'; ?>>Outside the Jurisdiction</option>
            
        </select>
    </div>
<input type="hidden" id="hiddenCMethod" name="hiddenCMethod" value="<?php echo $complaint['CMethod']; ?>">

<div class="form-group col-sm-6 flex-column d-flex">
    <label class="form-control-label px-3">Case Method:<span class="text-danger"> *</span></label>
    <select name="CMethod" id="CMethodSelect">
        <?php
        $methodOptions = [];

        if ($complaint['CStatus'] === 'Settled') {
            $methodOptions = ['Mediation', 'Conciliation', 'Arbitration'];
        } else if ($complaint['CStatus'] === 'Unsettled') {
            $methodOptions = ['Pending', 'Dismissed', 'Repudiated', 'Certified to File Action in Court', 'Dropped/Withdrawn'];
        }

        foreach ($methodOptions as $option) {
            echo '<option value="' . $option . '"';
            if ($complaint['CMethod'] === $option) {
                echo ' selected';
            }
            echo '>' . $option . '</option>';
        }

        if ($complaint['CStatus'] === 'Others') {
            echo '<option value="" selected disabled hidden>Select Method</option>';
        }
        ?>
    </select>
</div>

</div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Case Type:<span class="text-danger"> *</span></label>
                                <select name="CType">
                                    <option value="Civil" <?php if ($complaint['CType'] === 'Civil') echo 'selected'; ?>>Civil</option>
                                    <option value="Criminal" <?php if ($complaint['CType'] === 'Criminal') echo 'selected'; ?>>Criminal</option>
                                    <option value="Others" <?php if ($complaint['CType'] === 'Others') echo 'selected'; ?>>Others</option>
                                </select>
                            </div>
                        </div>

                        
                        <div class="row justify-content-end">
                            <div class="form-group col-sm-2">
                                <input type="submit" name="submit" value="Update">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
       var luponsArray = <?php echo json_encode($luponsArray); ?>;





document.addEventListener('DOMContentLoaded', function () {
    var hiddenCMethod = document.getElementById('hiddenCMethod');
    var cMethodSelect = document.getElementById('CMethodSelect');
    var cStatusSelect = document.getElementById('cStatusSelect');

    // Function to update Case Method options based on Case Status
    function updateMethodOptions(selectedStatus) {
        var methodOptions = [];

        if (selectedStatus === 'Settled') {
            methodOptions = ['Mediation', 'Conciliation', 'Arbitration'];
        } else if (selectedStatus === 'Unsettled') {
            methodOptions = ['Pending', 'Dismissed', 'Repudiated', 'Certified to File Action in Court', 'Dropped/Withdrawn'];
        }

        cMethodSelect.innerHTML = ''; // Clear previous options

        methodOptions.forEach(function (option) {
            var optionElement = document.createElement('option');
            optionElement.value = option;
            optionElement.textContent = option;
            cMethodSelect.appendChild(optionElement);
        });

        // Set the selected option based on the hidden input value
        cMethodSelect.value = hiddenCMethod.value;
    }

    // Event listener to handle changes in Case Status
    cStatusSelect.addEventListener('change', function () {
        var selectedStatus = cStatusSelect.value;

        if (selectedStatus === 'Others') {
            cMethodSelect.style.display = 'none';
            cMethodSelect.value = null;
            hiddenCMethod.value = null; // Reset hidden value
        } else {
            cMethodSelect.style.display = 'block';
            updateMethodOptions(selectedStatus);
        }
    });

    // Initial setup
    var initialStatus = cStatusSelect.value;
    if (initialStatus !== 'Others') {
        updateMethodOptions(initialStatus);
    } else {
        cMethodSelect.style.display = 'none';
        hiddenCMethod.value = null; // Reset hidden value
    }
});


</script>
<script src="edit_script.js"></script>



</body>
</html>
