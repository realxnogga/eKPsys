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
    <title>KP. FORM 21</title>
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
            </div>

            <div style="text-align: left;">
            <h5>KP Form No. 21</h5>
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

<div class="input-field"> <br>
    <!-- case num here -->
    <div style="text-align: right; margin-right: 180px;"> Barangay Case No.<?php echo $cNum; ?> </div> <br> <p> <div style="text-align: right; margin-right: 100px;">For: 
        <!-- ForTitle here -->
         <?php echo $forTitle; ?> <br> 
</div>
</div>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
<div class="label"></div>
<div class="input-field">
    <p> Complainants:
        <!-- CNames here -->
        <br><?php echo $cNames; ?><br> </p>
<br><p> — against —</p>
</div>
</div>

<div>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
<div class="label"></div>
<div class="input-field">
    <p> Respondents:<br>
        <!-- RspndtNames here -->
       <?php echo $rspndtNames; ?><br> </p>
</div>
</div>


             <h3 style="text-align: center;"><b> CERTIFICATION TO FILE ACTION</b> </h3>
  
    <div>
    <p style="text-indent: 2.8em; text-align: justify;">
    This is to certify that the above-captioned case was dismissed pursuant to the Order dated <input type="text" name="day" placeholder="day" size="1" required>  of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
                for complainant/s
              <label for="complainant"> </label>
            <input type="text" name="complainant" id="complainant/s" placeholder="Complainant's name"required> (name) and
            <label for="complainant"> </label>
            <input type="text" name="complainant" id="complainant/ss" placeholder="Complainant's name">(name) willful failure or refusal to appear for hearing before the Punong Barangay/Pangkat
ng Tagapagkasundo and therefore complainant/s is/are barred from filing an action in court/government office.
    </div>
      

        <p style="text-align: justify; text-indent: 2.8em; "> This  <input type="text" name="day" placeholder="day" size="1" required>  day of
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
    <br>Lupon Secretary/Pangkat Secretary
    </p>
    <br>
</div>
</p>
<br>
    <p style="text-align: justify; margin-top: 0;">
   <br>  Attested:</p>
    <br>
    <br>
 
  
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-right: 570px; margin-left: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value ="<?php echo $punong_barangay; ?>">
  <br>  Lupon Chairman/Pangkat Chairman
</p>
<br>

 <p style="text-align: justify; margin-top: 0;">
 IMPORTANT: If Lupon Secretary makes the certification, the Lupon Chairman attests. If the Pangkat Secretary makes the certification,
the Pangkat Chairman attests. </p>
</div>
   
</body>
</html>