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
    <title>kp_form9</title>
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
             <h5>Pormularyo ng KP Blg. 9</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>
            </div>

            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $currentYear = date('Y');
            ?>

<div class="form-group" style="text-align: right;"><br>
    
    <div class="input-field">
    <div style="text-align: right; margin-right: 180px;"> Usaping Barangay Blg.<?php echo $cNum; ?> </div> <br> <p> <div style="text-align: right; margin-right: 100px;">Ukol sa :  
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
        <p> (Mga) Ipinagsusumbong<br><?php echo $rspndtNames; ?></p>
    </div>
</div>

<h3 style="text-align: center;"> 
PATAWAG
</h3>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> KAY: <?php echo $rspndtNames; ?> </p>
</div>
</div>

<h3 style="text-align: center;"> 
(Mga) Ipinagsusumbong
</h3>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">Sa pamamagitan nito, kayo ay ipinatawag upang personal na humarap sa akin, kasama ang iyong mga testigo, sa ika- <input type="text" name="day" placeholder="day" size="5" required>  araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>sa ganap ng ika-<input type="time" id="time" name="time" size="5" style="border: none;">  ng umaga /hapon, upang sagutin ang sumbong ng ginawa sa harap ko, na ang sipi ay kalakip nito, para pamagitnan/papagkasunduin ang inyong (mga) alitan ng (mga) nagsusumbong.
</div>
    <br>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Sa pamamagitan nito,  kayo’y binabalaan na ang inyong pagtanggi o kusang di pagharap bilang pagtalima sa patawag na ito, kayo ay  hahadlangan na makapaghain ng ganting-sumbong na magmumula sa nasabing sumbong.  <br> <br>TUPARIN ITO, at kung hindi’y parurusahan kayo sa salang paglapastangan sa hukuman.
</div>

   <br>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Ngayong ika- <input type="text" name="day" placeholder="day" size="5" required>araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.              
</div> 


<p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value="<?php echo $punong_barangay;?>">
    Punong Barangay/Tagapangulo ng Lupon
</p>

  <h3 style="text-align: center;"> ULAT NG OPISYAL </h3>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Inihatid ko ang patawag na ito sa ipinagsusumbong na si <?php echo $rspndtNames; ?>  noong ika  <input type="text" name="day" placeholder="day" size="5" required> araw ng 
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>Inihatid ko ang patawag na ito sa ipinagsusumbong na si <?php echo $rspndtNames; ?> on the day  <input type="text" name="day" placeholder="day" size="5" required>  of
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>  , sa pamamagitan ng:  <br>
                <p> (Isulat ang (mga) pangalan ng (mga) ipinagsusumbong sa karampatan na paraan kung papaano ito ipinahatid)</p>
</div>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <p style="text-indent: 0em; margin-left: 18px;"> <input type="text" id="smmons" name="smmons" size="15">
    1. siya/sila mismo ang pinagabutan ng patawag, o  <br> <input type="text" id="smmons" name="smmons" size="15">
    2. iniabot sa kanya/kanila ang patawag at ito’y tinanggihan niyang/nillang tanggapin, o  <br> <input type="text" id="smmons" name="smmons" size="15">
    3. Iniwan ang patawag sa kanyang/kanilang tirahan at inihabilin kay<input type="text" id="name" name="name" size="15"> (Pangalan) isang taong may angkop na edad at pagpapasya na naninirahan doon, o <br> 
    <input type="text" id="smmons" name="smmons" size="15">
    4. Iniwan ang patawag sa kanyang/kanilang tanggapan/pinagtatrabahuhan at ihihabilin kay <input type="text" id="name1" name="name1" size="15">, (Pangalan) 	Isang taong nararapat mamahala doon.
    </p>
</div>

<div class="e">
<p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><input type="text" id="cmplnts" name="cmplnts" size="25">Opisyal</p>
</div>

<p>Tinanggap ng (mga) ipinagsusumbong/(mga) pinagbilinan.</p>


<div class="a">
        <p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 300px; margin-right: auto;"><input type="text" id="date" name="date" placeholder="lagda" size="25"> <input type="text" id="date" style= "margin-left:130px;" name="date" placeholder="Petsa" size="25"> (Petsa)</p>
        <p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 370px; margin-right: auto;">  (Lagda) </p> 
    </div>
    
    <div class="a">
        <p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 300px; margin-right: auto;"><input type="text" id="date" name="date" placeholder="lagda" size="25"> <input type="text" id="date" style= "margin-left:130px;" name="date" placeholder="Petsa" size="25"> (Petsa)</p>
        <p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 370px; margin-right: auto;">  (Lagda) </p> 
    </div>
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