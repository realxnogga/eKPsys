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
    <title>KP FORM 13</title>
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
             <h5>Pormularyo ng KP Blg. 13</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Lungsod/Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>
                <br><br>
            </div>

            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $currentYear = date('Y');
            ?>

<div class="form-group" style="text-align: right;">

<div class="input-field"> <br>
    <!-- case num here -->
    <div style="text-align: right; margin-right: 180px;">  Usaping Barangay Blg.<?php echo $cNum; ?> </div> <br> <p> <div style="text-align: right; margin-right: 100px;">Ukol sa: 
        <!-- ForTitle here -->
         <?php echo $forTitle; ?> <br> 
</div>
</div>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
<div class="label"></div>
<div class="input-field">
    <p> (Mga) Maysumbong
        <!-- CNames here -->
        <br><?php echo $cNames; ?><br> </p>
<br><p> — laban kay/kina —</p>
</div>
</div>

<div>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
<div class="label"></div>
<div class="input-field">
    <p>(Mga) Ipinagsusumbong<br>
        <!-- RspndtNames here -->
       <?php echo $rspndtNames; ?><br> </p>
</div>
</div>

   

                <h3 style="text-align: center;"><b>SUBPOENA</b></h3>

            <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
                <div class="label"></div>
                <div class="input-field">
                    <p> KAY:<br><input type="text" name="to" id="to" size="25"> <input type="text" name="to" id="to" size="25"> <br> <input type="text" name="to" id="to" size="25"> <input type="text" name="to" id="to" size="25"></p>
            </div>
            </div>


                <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"><p style="text-align: justify; margin-left:180px;">Mga Testigo</p> 
                <p style="text-indent: 2.0em; text-align: justify;">Sa pamamagitan nito, inaatasan kayo na humarap sa akin sa ika- <input type="text" name="day" placeholder="day" size="5" required>   araw ng
                    <select name="month" required>
                        <option value="">Buwan</option>
                        <?php foreach ($months as $month): ?>
                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                        <?php endforeach; ?>
                    </select> ,
                    20
                    <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required> sa ganap na ika<input type="time" id="time" name="time" size="5" style="border: none;"> ng umaga/hapon, upang tumestigo sa pagdinig ng usaping nakasaad sa itaas.  
                  
    </div>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">   sa ganap na ika   <input type="text" name="day" placeholder="day" size="5" required>  araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
              
</div>
    <br><br>
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
</div>

</body>
<br>
<div class="blank-page">        
       
     
</div>
</html>
