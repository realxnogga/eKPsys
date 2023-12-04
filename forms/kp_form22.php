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
    <title>KP. FORM 22</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">

</head>
<body>
    <br>
    <div class="container">
        <div class="paper">
                 <div class="top-right-buttons">
                <!-- Print button -->
                <button class="btn btn-primary print-button common-button" onclick="window.print()">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
            </div>

        
            <div style="text-align: left;">
            <h5>KP Form No. 22</h5>
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
        <p> Respondent/s:<br><input type="text" name="respondent" id="respondent" size="30" value="<?php echo $rspndtNames; ?>"><br><input type="text" name="respondent" id="respondent" size="30"> </p>
    </div>
</div>
          

          
                <h3 style="text-align: center;"><b> CERTIFICATION TO BAR COUNTERCLAIM</b></h3>
        <div style="text-align: left;">
            
           
    </div>

    <div>
    <p style="text-indent: 2.8em; text-align: justify;">
    This is to certify that after prior notice and hearing,              <label for="respondents"> </label>
            <input type="text" name="Respondent's" id="Respondent/ss" placeholder="Respondent/s name" required> (name) and
             <label for="complainant"> </label>
            <input type="text" name="Respondent's" id="Respondent/s" placeholder="Respondent/s name" > (name)
have been found to have willfully failed or refused to appear without justifiable reason before the Punong Barangay/Pangkat ng
Tagapagkasundo and therefore respondent/s is/are barred from filing his/their counterclaim (if any) arising from the complaint in
court/government office.
 </div>


          <p style="text-align: justify; text-indent: 2.8em; "> This<input type="text" name="day" placeholder="day" size="1" required> day of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
               
            </p>

     <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 555px; margin-right: auto;">
    <input type="text" id="luponSec"  name="luponSec" style="text-align: center;style="border: none; border-bottom: 1px solid black; outline: none; size="25">
   <br> Lupon Secretary/Pangkat Secretary
    </p>
    <br>
</div>
</p>
<br>
    <p style="text-align: justify; margin-top: 0;">
    Attested:</p>
   
    <div style="position: relative; text-align: left;"><br>
  

    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-right: 570px; margin-left: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value ="<?php echo $punong_barangay; ?>">
   <br> Lupon Chairman/Pangkat Chairman
</p>
<br>

<p style="text-align: justify; ">IMPORTANT: If Lupon Secretary makes the certification, the Lupon Chairman attests. If the Pangkat Secretary makes the certification,
the Pangkat Chairman attests.</p>
             
  </body>
</html>