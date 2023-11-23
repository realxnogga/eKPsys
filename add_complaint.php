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
    <title>Welcome, User!</title>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<style>
        .back-button {
            background-color: #007bff; 
            color: #fff; 
            border: none; 
            padding: 10px 20px;
            text-decoration: none; 
            font size: 16px; 
            cursor: pointer; 
            border-radius: 5px;
            transition: background-color 0.3s ease; 
        }

        .back-button:hover {
            background-color: #0056b3; 
        }

        canvas {
            border: 1px solid lightgray;
            float: right;
            
        }  
        body{color: #000;overflow-x: hidden;height: 100%; background-repeat: no-repeat;background-size: 100% 100%}.card{padding: 30px 40px;margin-top: 60px;margin-bottom: 60px;border: none !important;box-shadow: 0 6px 12px 0 rgba(0,0,0,0.2)}.blue-text{color: #00BCD4}.form-control-label{margin-bottom: 0}input, textarea, button{padding: 8px 15px;border-radius: 5px !important;margin: 5px 0px;box-sizing: border-box;border: 1px solid #ccc;font-size: 18px !important;font-weight: 300}input:focus, textarea:focus{-moz-box-shadow: none !important;-webkit-box-shadow: none !important;box-shadow: none !important;border: 1px solid #00BCD4;outline-width: 0;font-weight: 400}.btn-block{text-transform: uppercase;font-size: 15px !important;font-weight: 400;height: 43px;cursor: pointer}.btn-block:hover{color: #fff !important}button:focus{-moz-box-shadow: none !important;-webkit-box-shadow: none !important;box-shadow: none !important;outline-width: 0}
    </style>
<body>
    <h2>Add a Complaint</h2>

<?php
    // Display the user's username here
    $fname = $_SESSION['first_name'];
    $lname = $_SESSION['last_name'];
    echo "<h2>Welcome, $fname $lname!</h2>";
    
    ?>
<a href="user_complaints.php"><button class="btn">Back to Complaints Table</button></a>
   <div class="container-fluid px-1 py-5 mx-auto">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
           
            <h2>Add Complaint</h2>
            <div class="card">

                    <?php echo $successMessage; // Display success message here ?>

    <form action="" method="post">
        <br>
        <h3>KP FORM 7</h3><br>
        <div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
          <label class="form-control-label px-3">Case No.<span class="text-danger"> *</span></label>
          <!-- Set the Case Number input field value -->
          <input type="text" id="CNum" name="CNum" placeholder="MMYY - Case No." value="<?php echo getNextCaseNumber($conn); ?>" onblur="validate(1)" >
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
