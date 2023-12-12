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
    <title>kpform_15</title>
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
            <h5>Pormularyo ng KP Blg. 15</h5>
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

   

<h3 style="text-align: center;"> 
<b>GAWAD NG PAGHAHATOL</b>
</h3>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">   Matapos marinig ang mga salaysay na ipinaayag at maingat na pagsusuri ng katibayan na iniharap sa usaping ito, iginagawad ang mga sumusunod:             
    </div>
   
    <br>

    <div class="a"><br><br> <input type="text" id="abtr" name="abtr" size="40" > <br><input type="text" id="abtr" name="abtr" size="40" ><br><input type="text" id="abtr" name="abtr" size="40" >
</div>
<br>
<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Ginawa ngayong ika-<input type="text" name="day" placeholder="araw" size="1" required>  araw ng 
                <select name="month" required style="width: 60px;">
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.              
</div>
<p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value ="<?php echo $punong_barangay; ?>">
   <br> Punong Barangay/Tagapangulo ng Pangkat
</p>

    <div class="a">
    <p><input type="text" id="mmbr" name="mmbr" size="30"> <br> Kasapi </p>
      <p><input type="text" id="mmbr" name="mmbr" size="30"> <br> Kasapi </p>
</div>
<br>

  <div class="d">
    <p>PINATUNAYAN: <br> <input type="text" id="attsd" name="attsd" size="30"></p>
    <p><b> Punong Barangay/Kalihim ng Lupon </b></p><br>
    <p>●Lalagdaan ng sinuman sa gumawa ng gawad ng paghahatol.</p>
    <p>●Lalagdaan ng Punong Barangay kung ang gawad ay ginawa ng Tagapangulo ng Pangkat, at ng kalihim ng Lupon, kung ang gawad ay ginawa ng Punong Barangay</p>
  </div>        
</body>
</html>
