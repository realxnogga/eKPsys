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
    <title>KP FORM 14</title>
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
                <h5>KP Form No. 14</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
            </div>

            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

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

   

<h3 style="text-align: center;"><b>AGREEMENT FOR ARBITRATION</b></h3>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"><p style="text-indent: 2.0em; text-align: justify;">We hereby agree to submit our dispute for arbitration to the Punong Barangay/<i>Pangkat ng Tagapagkasundo</i> (Please cross out whichever is not applicable) and bind ourselves to comply with the award that may be rendered thereon. We have made this
    agreement freely with a full understanding of its nature and consequences.              
    </div>
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Entered into this<input type="text" name="day" placeholder="day" size="5" required> day of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
              
</div>
                    </div></div>    
<div class="d">
    <div style="text-align: left; font-size: 12px; margin-left: 100px;"><br>
    <p><br>Complainant/s <br> <br><br><p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 570px; margin-left: auto;"><?php echo $cNames; ?> <br>_____________________
            <id="cmplnts" name="cmplnts" size="25"  style="text-align: left;"></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
    <p>Respondent/s <br> <br><br><p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 570px; margin-left: auto;"><?php echo $rspndtNames; ?> <br>_____________________
            <id="rspndt" name="rspndt" size="25"  style="text-align: left;"></p><br><br><br><br>
                    </div>
  <p>ATTESTATION</p>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> I hereby certify that the foregoing Agreement for Arbitration was entered into by the parties freely and voluntarily, after I had explained to them the nature and the consequences of such agreement.
</div><br><br>
<p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center;">Punong Barangay</label>
</p>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                
            </div>
        </div>
</body>
<br>
<div class="blank-page">        
       
     
</div>
</html>
