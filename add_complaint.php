<?php
session_start();
include_once("connection.php");
include 'user-navigation.php';
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

include 'add_handler.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Complaint</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
    <style>
        
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        
        .card {
            height: 75vh; /* Set the height to 100% of the viewport height */
            overflow: auto;
            padding-bottom: 20px; /* Add some padding to the bottom */
            transition: height 0.3s ease; /* Add a smooth transition effect for height changes */
        }
        
        @media screen and (min-resolution: 192dpi), screen and (min-resolution: 2dppx) {
            /* Adjust for high-density (Retina) displays */
            .card {
                height: 50vh;
            }
        }
        
        @media screen and (max-width: 1200px) {
            /* Adjust for window resolution 125% scaling */
            .card {
                height: 80vh;
            }
        }
        
        @media screen and (max-width: 960px) {
            /* Adjust for window resolution 150% scaling */
            .card {
                height: 66.67vh;
            }
        }
        
                /* Center align the submit button */
        .row.justify-content-end {
            display: flex;
            justify-content: center;
        }
        
        .form-group.col-sm-2 {
            text-align: center;
            margin-right: 190px; /* Add some top margin for better spacing */
        }
        
            
            </style>
</head>

<body>         
<div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">
    <?php echo $successMessage; // Display success message here ?>
    <div class="form-group col-2">

<a href="user_complaints.php" class="btn btn-outline-primary m-1">Back</a></div>
    <form action="" method="post">
        <br>
        <h3>KP FORM 7</h3><br>
        <div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
          <label class="form-label">Case No.<span class="text-danger"> *</span></label>
          <!-- Set the Case Number input field value -->
          <input type="text" class="form-control" id="CNum" name="CNum" placeholder="MMYY - Case No." value="<?php echo $caseNum; ?>" onblur="validate(1)" >
      </div>
<div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-label">For:<span class="text-danger"> *</span></label>
<input type="text" class="form-control" id="ForTitle" name="ForTitle" placeholder="Enter Name" onblur="validate(2)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-label">Complainants:<span class="text-danger"> *</span></label>
        <input type="text" class="form-control" id="CNames" name="CNames" placeholder="Enter name of complainants" onblur="validate(3)" required>
    </div>
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-label">Respondents:<span class="text-danger"> *</span></label>
        <input type="text" class="form-control" id="RspndtNames" name="RspndtNames" placeholder="Enter name of respondents" onblur="validate(4)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-12 flex-column d-flex">
        <label class="form-label">Complaint<span class="text-danger"> *</span></label>
        <input type="text" class="form-control" id="CDesc" name="CDesc" placeholder="" onblur="validate(5)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-12 flex-column d-flex">
        <label class="form-label">Petition<span class="text-danger"> *</span></label>
        <input type="text" class="form-control" id="Petition" name="Petition" placeholder="" onblur="validate(6)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
 <div class="form-group col-sm-6 flex-column d-flex">
    <label class="form-label">Made:<span class="text-danger"> *</span></label>
    <input type="datetime-local" class="form-control" id="Mdate" name="Mdate" onblur="validate(7)" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
</div>

    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-label">Received:</label>
        <input type="date" class="form-control" id="RDate" name="RDate" onblur="validate(8)" >
    </div>
</div>

<div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-label">Case Type:<span class="text-danger"> *</span></label>
        <select name="CType" class="form-select">
            <option value="Civil">Civil</option>
            <option value="Criminal">Criminal</option>
            <option value="Others">Others</option>
        </select>
    </div>
</div>
<div class="row justify-content-end">
    <div class="form-group col-2">
        <input type="submit" name="submit" value="Submit" class="btn btn-primary m-1">
    </div>
</div>


</div>
        </div>
    </div>
</body>
</html>
