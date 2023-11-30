<?php
session_start();
include_once("connection.php");
include 'header.php';

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
</head>

<body>
  
           

                    <?php echo $successMessage; // Display success message here ?>

    <form action="" method="post">
        <br>
        <h3>KP FORM 7</h3><br>
        <div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
          <label class="form-control-label px-3">Case No.<span class="text-danger"> *</span></label>
          <!-- Set the Case Number input field value -->
          <input type="text" id="CNum" name="CNum" placeholder="MMYY - Case No." value="<?php echo $caseNum; ?>" onblur="validate(1)" >
      </div>
<div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">For:<span class="text-danger"> *</span></label>
<input type="text" id="ForTitle" name="ForTitle" placeholder="Enter Name" onblur="validate(2)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Complainants:<span class="text-danger"> *</span></label>
        <input type="text" id="CNames" name="CNames" placeholder="Enter name of complainants" onblur="validate(3)" required>
    </div>
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Respondents:<span class="text-danger"> *</span></label>
        <input type="text" id="RspndtNames" name="RspndtNames" placeholder="Enter name of respondents" onblur="validate(4)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-12 flex-column d-flex">
        <label class="form-control-label px-3">Complaint<span class="text-danger"> *</span></label>
        <input type="text" id="CDesc" name="CDesc" placeholder="" onblur="validate(5)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-12 flex-column d-flex">
        <label class="form-control-label px-3">Petition<span class="text-danger"> *</span></label>
        <input type="text" id="Petition" name="Petition" placeholder="" onblur="validate(6)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
 <div class="form-group col-sm-6 flex-column d-flex">
    <label class="form-control-label px-3">Made:<span class="text-danger"> *</span></label>
    <input type="datetime-local" id="Mdate" name="Mdate" onblur="validate(7)" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
</div>

    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Received:</label>
        <input type="date" id="RDate" name="RDate" onblur="validate(8)" >
    </div>
</div>

<div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Case Type:<span class="text-danger"> *</span></label>
        <select name="CType">
            <option value="Civil">Civil</option>
            <option value="Criminal">Criminal</option>
            <option value="Others">Others</option>
        </select>
    </div>
</div>
<div class="row justify-content-end">
    <div class="form-group col-sm-2">
        <input type="submit" name="submit" value="Submit">
    </div>
</div>


</body>
</html>
