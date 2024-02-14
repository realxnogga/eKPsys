<?php
session_start();
include_once("connection.php");
include 'index-navigation.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

include 'add_handler.php';

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaints</title>
    <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />

</head>

<body style="background-color: #eeeef6">


<div class="container-fluid">
<a href="user_dashboard.php" class="btn btn-outline-dark m-1">Back to Dashboard</a>
<br><br>

        <!--  Row 1 -->
            <div class="card">
              <div class="card-body">
                    
                  <div class="d-flex align-items-center">
    <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
    <div>
        <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
    </div></div>    
    <br>   

                     <h5 class="card-title mb-9 fw-semibold">Add Complaint</h5><hr>
                   <b>



    <?php echo $successMessage; // Display success message here ?>
 
    <form action="" method="post">
        <b>
        <div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
          <label class="form-control-label px-3">Case No.<span class="text-danger">*</span></label>
          <!-- Set the Case Number input field value -->
          <input type="text" class="form-control" id="CNum" name="CNum" placeholder="MMYY - Case No." value="<?php echo $caseNum; ?>" onblur="validate(1)" >
      </div>
<div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">For:<span class="text-danger">*</span></label>
<input type="text" class="form-control" id="ForTitle" name="ForTitle" placeholder="Enter Title" onblur="validate(2)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Complainants:<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="CNames" name="CNames" placeholder="Enter name of complainants" onblur="validate(3)" required>
    </div>
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Respondents:<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="RspndtNames" name="RspndtNames" placeholder="Enter name of respondents" onblur="validate(4)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-12 flex-column d-flex">
        <label class="form-control-label px-3">Complaint:<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="CDesc" name="CDesc" placeholder="" onblur="validate(5)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-12 flex-column d-flex">
        <label class="form-control-label px-3">Petition:<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="Petition" name="Petition" placeholder="" onblur="validate(6)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
 <div class="form-group col-sm-6 flex-column d-flex">
    <label class="form-control-label px-3">Made:<span class="text-danger">*</span></label>
    <input type="datetime-local" class="form-control" id="Mdate" name="Mdate" onblur="validate(7)" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
</div>

    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Received:</label>
        <input type="date" class="form-control" id="RDate" name="RDate" onblur="validate(8)" >
    </div>
</div>

<div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Case Type:<span class="text-danger">*</span></label>
        <select name="CType" class="form-select">
            <option value="Civil">Civil</option>
            <option value="Criminal">Criminal</option>
            <option value="Others">Others</option>
        </select>
    </div>
</div><br>
    <div class="form-group col-2">
        <input type="submit" name="submit" value="Submit" class="btn btn-primary m-1">
</div>


            
            
   

  

      
    </div></div>
      

              </div>

              
            </div>
          </div></b>
                    
          </div>
        </div>
       
       
          
    </div>
  </div>

</body>

</html>
