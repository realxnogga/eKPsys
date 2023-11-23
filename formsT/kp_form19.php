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
    <title>KP. FORM 19</title>
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
                <button class="btn btn-primary print-button" onclick="window.print()">
                    <i class="fas fa-print button-icon"></i> Print
                </button>
            </div>
        
            <div style="text-align: left;">
            <h5>Pormularyo ng KP Blg. 19</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng _Laguna</h5>
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
        <p> (Mga) Ipinagsusumbong:<br><input type="text" name="respondent" id="respondent" size="30" value="<?php echo $rspndtNames;?>"><br><input type="text" name="respondent" id="respondent" size="30"> </p>
    </div>
</div>
            
        
                <h3 style="text-align: center;"><b> PAABISO NG PADINIG <br> (Ukol sa: Di-Pagharap)</b> </h3>
   <div style="margin-left: 20px; text-align: left;">
    <div>
      KAY:
      <br>
     <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
      <input type="text" name="complainant" id="complainant" size="30"><br><input type="text" name="complainant" id="complainant" size="30"> 
      <br>
      <br>
       <label style=" text-align: left; font-weight: normal;">(Mga) Ipinagsusumbong</label>
  </div>
                  
  </div>
</div>
</div>
    <div>
     <p style="text-indent: 2.8em; text-align: justify; ">
 Sa pamamagitan nito,  inaatasan ka na humarap sa akin/Pangkat sa ika-

    <input type="text" name="day" placeholder="araw" size="1" required>  araw ng
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
            sa ganap na ika-<input type="time" name="time" size="10" style="border:none">
         ng umaga/hapon upang ipaliwanag kung bakit ka di-humarap para sa pamamagitan/pag-aayos na nakatakda noong
<input type="text" name="day" placeholder="araw" size="1" required>
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
, at kung bakit ang iyong ganting – sumbong (kung meron man) na nagbuhat sa sumbong  ay di-dapat ipawalang-saysay, at kung bakit hindi dapat magpalabas ng isang paghahadlang na makapaghain ng ganting-sumbong sa hukuman/tanggapan ng pamahalaan, at ang parusang  paglapastangan sa hukuman ay di dapat gawin  sanhi ng di mo pagharap  o pagtangging humarap   sa Punong Barangay/Pangkat ng Tagapagkasundo.
<br>
<br>
    Ngayong ika-<input type="text" name="day" placeholder="araw" size="1" required>araw ng
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
              <div id="nameInput" style="display: none;">
  <input type="text" id="name" name="name" placeholder="Enter Name" oninput="updateOptionText(this.value)" onkeydown="checkEnterKey(event)">
</div>

        <br>
        <br>
        <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value ="<?php echo $punong_barangay; ?>">
  <br>  Punong Barangay/Tagapangulo ng Pangkat
</p>

<br>
    Pinaabisuhan  ngayong<input type="text" name="day" placeholder="araw" size="1" required> araw ng 
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
              
<br>
<br>
    </div>
       <br>
      <h3 style="text-align:center;">  (Mga)   Ipinagsusumbong </h3>
    <div style="text-align:center;" >
        <input type="text" placeholder=" " value="<?php echo $rspndtNames; ?>">
        <br>
        <input type="text" placeholder=" ">


    <h3 style="text-align:center;">(Mga)   Maysumbong</h3>
    <div style="text-align:center;">
        <input type="text" placeholder=" " value="<?php echo $cNames; ?>">
        <br>
        <input type="text" placeholder=" ">
    </div>
</div>
 <br>
   
      
</body>
</html>