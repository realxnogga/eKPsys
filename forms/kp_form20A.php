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
    <title>KP FORM 20-A</title>
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
                <h5>KP Form No. 20 - A</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
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

  <div style="text-align: left;">
            <p style="text-align: justify; margin-top: 0;">This is to certify that:</p>
            <!-- <p style="text-align: justify; text-indent: 1.5em;">1. There has been a personal confrontation between the parties before the Punong Barangay/Pangkat ng Tagapagkasundo; </p> -->
            <div class="form-group" style="text-align: justify;">
   <div class="checkbox"style="text-align: left;text-indent: 1.5em;">
        
        <label for="checkbox1"style="text-indent: 0em; margin-left: 2px;">
        1. There has been a personal confrontation between the parties before the Punong Barangay but mediation failed; </label>
    </p></div>
</div>
 <div class="checkbox"style="text-align: left;text-indent: 1.5em;">
        
        <label for="checkbox1"style="text-indent: 0em; margin-left: 2px;">
        2. The Pangkat ng Tagapagkasundo was constituted but the personal confrontation before the Pangkat likewise did not
result into a settlement; and </label>
    </p>
</div>
            <!-- <p style="text-align: justify; text-indent: 1.5em;">2. A settlement was reached;</p> -->
            <p style="text-align: justify; text-indent: 0em; margin-left: 38.5px;">3. Therefore, the corresponding complaint for the dispute may now be filed in court/government office.
</p>
            <br>

            <div style="text-align: justify; text-indent: 0em; margin-left: 38.5px;"> This <input type="text" name="day" placeholder="day" size="1" required>  of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
              
            </p>

        </form>
</div>

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div style="position: relative;"><br>
   

   <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
   <input type="text" id="luponSec"  name="luponSec" style="text-align: center;style="border: none; border-bottom: 1px solid black; outline: none; size="25">
   Pangkat Secretary
   </p>
   <br>
</div>
       ATTESTED:
<br>
<br>
<p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 50px;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: left;">Lupon Chairman</label>
</p>
                </div>
         
           </div>
        </div><br>
          <br>
        <br>
        <br>
    </div>
    <br>
</p>
</div>
<br>
       
  </body>
</html>