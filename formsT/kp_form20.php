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
    <title>KP. FORM 20</title>
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
            <h5>Pormularyo ng KP Blg. 20</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Lungsod/Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>
                <br><br>
            </div>

            <?php
            $months = [
                'Enero', 'Pebrero', 'Marso', 'Abril', 'Mayo', 'Hunyo', 'Hulyo', 'Agosto', 'Setyembre', 'Oktubre', 'November', 'Disyembre'
            ];

            $currentYear = date('Y');
            ?>

         <div class="form-group" style="text-align: right;">

    <div class="input-field">
    Usaping Barangay Blg.<input type="text" name="barangayCaseNo" pattern="\d{3}-\d{3}-\d{4}" maxlength="15" value ="<?php echo $cNum; ?>" style="width: 30%;"
> <br><br> <p>Ukol sa: <input type="text" name="for" id="for" size="30"value="<?php echo $forTitle;?>"> <br> 
    </div>
</div>

<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p>(Mga) Maysumbong:<br><input type="text" name="complainant" id="complainant" size="30" value="<?php echo $cNames; ?>"><br><input type="text" name="complainant" id="complainant" size="30"> </p>
    <br><p>  -laban kay/kina-</p>
</div>
</div>

<div>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> (Mga) Ipinagsusumbong:<br><input type="text" name="respondent" id="respondent" size="30" value="<?php echo $rspndtNames; ?>"><br><input type="text" name="respondent" id="respondent" size="30"> </p>
    </div>
</div>
           

         
                <h3 style="text-align: center;"><b> KATIBAYAN UPANG MAKADULOG SA HUKUMAN</b> </h3>

<div style="text-align: left;">
            <p style="text-align: justify; margin-top: 0;">Ito ay nagpapatunay  na:</p>
          
            <div class="form" style="text-align: left;">
    <div class="checkbox" style="text-align: left;text-indent: 1.5em;">
        <input type="checkbox" id="checkbox1" name="confrontationCheckbox">
        <label for="checkbox1"style="text-indent: 0em; margin-left: 2px;">1. Nagkaroon ng personal na paghaharap sa pagitan ng mga panig sa harap ng Punong Barangay/Pangkat ng Tagapagkasundo;</label>
    </div>

</div>
 <div class="form" style="text-align: left;">
    <div class="checkbox"style="text-align: left;text-indent: 1.5em;">
        <input type="checkbox" id="checkbox1" name="confrontationCheckbox">
        <label for="checkbox1"style="text-indent: 0em; margin-left: 2px;">2. Nagkaroon ng pag-aayos; </label>
    </div>
<p style="text-align: justify; text-indent: 0em; margin-left: 38.5px;"> 3. Ang kasunduan sa pag-aayos ay tinanggihan sa isang salaysay na pinanumpaan sa harap ng Punong Barangay sa pamamagitan ng  <input type="text" name="name" id="name" placeholder=" "required> sa kadahilanan ng<input type="text" name="name" id="name" placeholder=" "required>;at</p>
            <p style="text-align: justify; text-indent: 0em; margin-left: 38px;"> 4. Dahil dito, ang kaukulang sumbong para sa alitan ay maaari ngayong ihain sa hukuman/tanggapan ng pamahalaan.</p>    
<br>
<p style="text-align: justify; text-indent: 0em; margin-left: 38.5px;">Ngayong ika -<input type="text" name="day" placeholder="araw" size="1" required> araw ng
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
               
            </p>
</div>
</div>

<br>
<br>
 <div style="position: relative;"><br>


    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="luponSec" name="luponSec" style="text-align: center; style="border: none; border-bottom: 1px solid black; outline: none;" size="25">
 <br> Kalihim ng Lupon
    </p>
    <br>
</div>
</p>
<br>
    <p style="text-align: justify; margin-top: 0;">
        Pinatunayan: </p>
    <br>
    <br>
    <div style="position: relative; text-align: left;"><br>
  
 
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-right: 570px; margin-left: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value ="<?php echo $punong_barangay; ?>">
   <br> Pangulo ng Lupon
</p>
</body>
</html>