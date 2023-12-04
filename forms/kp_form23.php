<?php
session_start();
$forTitle = $_SESSION['forTitle'] ?? '';
$cNames = $_SESSION['cNames'] ?? '';
$rspndtNames = $_SESSION['rspndtNames'] ?? '';
$cDesc = $_SESSION['cDesc'] ?? '';
$petition = $_SESSION['petition'] ?? '';
$cNum = $_SESSION['cNum'] ?? '';

$day = $_SESSION['day'] ?? '';
$month = $_SESSION['month'] ?? '';
$year = $_SESSION['year'] ?? '';

$punong_barangay = $_SESSION['punong_barangay'] ?? '';

?>
<!DOCTYPE html>
<html>
<head>
    <title>KP. FORM 23</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
</head>
<body>
    <br>
    <div class="container">
        <div class="paper">
                  <div class="top-right-buttons">

                <button class="btn btn-primary print-button common-button" onclick="window.print()">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
            </div>

        
            <div style="text-align: left;">
            <h5>KP Form No. 24</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
                <br><br>
            </div>

            <?php
            $months = [
              'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>

<div class="form-group" style="text-align: right;">

    <div class="input-field">
    Barangay Case No.<input type="text" name="barangayCaseNo" pattern="\d{3}-\d{3}-\d{4}" maxlength="15" value ="<?php echo $cNum; ?>" style="width: 30%;"
> <br><br> <p>For: <input type="text" name="for" id="for" size="30" value="<?php echo $forTitle;?>"> <br> 
    </div>
</div>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p>Complainant/s:<br><input type="text" name="complainant" id="complainant" size="30" value="<?php echo $cNames; ?>"><br><input type="text" name="complainant" id="complainant" size="30"> </p>
    <br><p>   — against —</p>
</div>
</div>

<div>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> Respondent/s<br><input type="text" name="respondent" id="respondent" size="30" value="<?php echo $rspndtNames; ?>"><br><input type="text" name="respondent" id="respondent" size="30"> </p>
    </div>
</div>
           

                <h3 style="text-align: center;"><b>MOTION FOR EXECUTION</b>
 </h3>
         <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
           
                <p> Complainant/s/Respondent/s state as follows: </p>
    <div>

   <div style="text-align: justify; text-indent: 0em; margin-left: 38.5px;"> 1. On <input type="text" name="day" placeholder="day" size="1" required>
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
                (Date) the parties in this case signed an amicable settlement/received the arbitration award rendered by
the Lupon/Chairman/Pangkat ng Tagapagkasundo;
           
</div>
<br>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <p style="text-indent: 0em; margin-left: 18px;">
       2. The period of ten (10) days from the above-stated date has expired without any of the parties filing a sworn statement of
repudiation of the settlement before the Lupon Chairman a petition for nullification of the arbitration award in court; and

    </p>
</div>
</div>
<br>
           <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <p style="text-indent: 0em; margin-left: 18px;">
       3. The amicable settlement/arbitration award is now final and executory.

    </p>
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    WHEREFORE, Complainant/s/Respondent/s request that the corresponding writ of execution be issued by the Lupon Chairman in
this case.
</div>
</div>
<br>
<br>
<br>
             <input type="text" name="year" placeholder="Date" size="15" value="">
        

    <div style="position: relative;">
        <br>
        <br>
        <br>
       <hr style="border-top: 1px solid black; width: 30%; margin-left: 530px;">

         <select id="Complainant/s/Respondent/s"name="Complainant/s/Respondent/s" onchange="ComplainantRespondents()" style="text-align: right; margin-left: 580px; margin-right: auto;"required>
        <option value="" disabled selected>Complainant/s/Respondent/s</option>
        <option value="Complainant">Complainant/s</option>
        <option value="Respondent">Respondent/s</option>  
    </select>
        </div>

  </body>
</html>