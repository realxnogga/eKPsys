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
    <title>kp_form10</title>
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
                <h5>Pormularyo ng KP Blg. 10</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>
            </div>
              <?php
            $months = [
                'Enero', 'Pebrero', 'Marso', 'Abril', 'Mayo', 'Hunyo', 'Hulyo', 'Agosto', 'Setyembre', 'Oktubre', 'November', 'Disyembre'
            ];

            $currentYear = date('Y');
            ?>


<div class="form-group" style="text-align: right;">


        <div class="input-field"> 
            <!-- case num here -->
            Usaping Barangay Blg. <input type="text" name="barangayCaseNo" pattern="\d{3}-\d{3}-\d{4}" maxlength="15" value ="<?php echo $cNum; ?>" style="width: 30%;"
            value="<?php echo $cNum; ?>"> <br><br> <p>Ukol sa : 
                <!-- ForTitle here -->
                 <input type="text" name="for" id="for" size="30" value="<?php echo $forTitle;?>"> <br> 
        </div>
    </div>

    <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
        <div class="label"></div>
        <div class="input-field">
            <p> (Mga) Maysumbong	
                <!-- CNames here -->
                <br><input type="text" name="complainant" id="complainant" size="30" value="<?php echo $cNames; ?>"><br> </p>
        <br><p> — laban kay/kina —</p>
    </div>
    </div>

    <div>
    <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
        <div class="label"></div>
        <div class="input-field">
            <p> (Mga) Ipinagsusumbong<br>
                <!-- RspndtNames here -->
                <input type="text" name="respondent" id="respondent" size="30" value="<?php echo $rspndtNames; ?>"><br> </p>
        </div>
    </div>


<h3 style="text-align: center;"> 
PAABISO UKOL SA PAGBUBUO NG PANGKAT
</h3>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> KAY: <br><input type="text" name="to" id="to" size="25"value="<?php echo $cNames; ?>"> <input type="text" name="to" id="to" size="25" value="<?php echo $rspndtNames; ?>"> <br><input type="text" name="to" id="to" size="25"> <input type="text" name="to" id="to" size="25"> 
        <br> (Mga) Maysumbong		      (Mga) Ipinagsusumbong</p>
</div>
</div>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Sa pamamagitan nito, kayo ay inaatasan na humarap sa akin sa ika- <input type="text" name="day" placeholder="araw" size="5" required> araw ng 
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="taon" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required> sa ganap na ika- <input type="time" id="time" name="time" size="5" style="border:none"> ng umaga/hapon para sa pagbubuo ng Pangkat ng Tagapagkasundo, na siyang magkakasundo ng iyong alitan.
                 Kung sakali’t di ninyo mapagkasunduan ang kasapian ng Pangkat, o mabigo kayong humarap sanasabing patsa para sa pagbubuo ng Pangkat, 
                 aking titiyakin ang kasapian nito sa pamamagitan ng palabunutan.
</div>
    <br>
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value ="<?php echo $punong_barangay; ?>">
    <br>Punong Barangay
</p>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Ngayong ika-  <input type="text" name="day" placeholder="araw" size="5" required> araw ng
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="taon" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.              
</div> 

   
   


 
<br> <br>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> KAY:  <br><input type="text" name="to" id="to" size="25"value="<?php echo $cNames; ?>"> <input type="text" name="to" id="to" size="25" value="<?php echo $rspndtNames; ?>"> <br><input type="text" name="to" id="to" size="25" > <input type="text" name="to" id="to" size="25">
        <br> (Mga) Maysumbong		      (Mga) Ipinagsusumbong</p>
    </div>

</div>


                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
   
       
</body>

</html>
    