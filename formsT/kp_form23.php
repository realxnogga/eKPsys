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
            <h5>Pormularyo ng KP Blg. 23</h5>
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
> <br><br> <p>Ukol sa: <input type="text" name="for" id="for" size="30" value="<?php echo $forTitle;?>"> <br> 
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
           

                <h3 style="text-align: center;"><b>PANUKALA SA PAGPAPATUPAD</b>
 </h3>
         <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
           
                <p> Ang (mga) maysumbong/ipinagsusumbong ay nagpahayag ng mga sumusunod: </p>
    <div>

   <div style="text-align: justify; text-indent: 0em; margin-left: 38.5px;"> 1. Noong <input type="text" name="day" placeholder="araw" size="1" required>
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
            ng mga panig sa usaping ito ay (petsa) lumagda sa isang  matiwasay na pag-aayos/ tumanggap ng gawad ng paghahatol na ibinigay ng Tagapangulo ng Lupon/Pangkat ng Tagapagkasundo; 
           
</div>
<br>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <p style="text-indent: 0em; margin-left: 18px;">
       2. Ang sampung (araw) na taning mula sa petsang binanggit sa itaas ay natapos ng  wala sa sinumang panig ang naghain ng sinumpaang salaysay ng pagtanggi sa pag-aayos sa harap ng Tagapangulo ng Lupon ng petisyon na nagpapawalang-saysay sa  gawad ng paghahatol sa  hukuman;  at


    </p>
</div>
</div>
<br>
           <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <p style="text-indent: 0em; margin-left: 18px;">
       3. Ang matiwasay na pag-aayos/gawad ng paghahatol ay pinal at ngayon ay nararapat lang ipatupad.

    </p>
    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    DAHIL DITO, ang (mga) maysumbong/ipinagsusumbong ay humiling na ang katumbas  na kasulatan sa pagpapatupad sa usaping ito ay ipalabas na ng Tagapangulo ng Lupon.
</div>
</div>
<br>
<br>
<br>
             <input type="text" name="year" placeholder="Petsa" size="15" value="">
        

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