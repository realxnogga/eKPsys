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
    <title>KP FORM 17</title>
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
             <h5>Pormularyo ng KP Blg. 17</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Lungsod/Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>
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
    <p> (Mga) Maysumbong:
        <!-- CNames here -->
        <br><?php echo $cNames; ?><br> </p>
<br><p> -laban kay/kina-</p>
</div>
</div>

<div>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
<div class="label"></div>
<div class="input-field">
    <p> (Mga) Ipinagsusumbong:<br>
        <!-- RspndtNames here -->
       <?php echo $rspndtNames; ?><br> </p>
</div>
</div>

<h3 style="text-align: center;"><b>PAGTANGGI</b></h3>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">Sa pamamagitan nito’y itinatangi ko/naming ang pag-aayos/kasunduan sa paghahatol sapagkat ang akin/aming pag-sang-ayon ay walang saysay dahilan sa: <br>
(Lagyan ng tsek ang angkop)
    </div>
    <br>

    [ ] – Panlilinlang (Ipaliwanag)  <div class="a">
  <textarea id="name" name="name" style="width: 760px; box-sizing: border-box; overflow-y: hidden;"></textarea>
  <br>
</div> 
[ ]- Karahasan (Ipaliwanag) <div class="a">
  <textarea id="name" name="name" style="width: 760px; box-sizing: border-box; overflow-y: hidden;"></textarea>
  <br>
</div>
[ ]- Pananakot (Ipaliwanag) <div class="a">
  <textarea id="name" name="name" style="width: 760px; box-sizing: border-box; overflow-y: hidden;"></textarea>
  <br>
</div> <br>


    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">Ngayong ika- <input type="text" name="day" placeholder="day" size="1" required> araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.              
</div> 

<div class="d">
    <div style="text-align: right; font-size: 12px; margin-right: 50px;"><br>
    <p><br>(Mga) Maysumbong <br> <br><br><p class="important-warning-text" style="text-align: right; font-size: 12px; margin-right: 570px; margin-right: auto;"><?php echo $cNames; ?> <br>_____________________
            <id="cmplnts" name="cmplnts" size="25"  style="text-align: right;"></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
    <p>(Mga) Ipinagsusumbong <br> <br><br><p class="important-warning-text" style="text-align: right; font-size: 12px; margin-right: 570px; margin-right: auto;"><?php echo $rspndtNames; ?> <br>_____________________
            <id="rspndt" name="rspndt" size="25"  style="text-align: right;"></p><br>
  </div>
<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> NILAGDAAN at PINANUMPAAN sa harap ko ngayong ika- <input type="text" name="day" placeholder="day" size="1" required> araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.              
</div><br>
<p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center;">Punong Barangay/Tagapangulo ng Pangkat</label>
</p>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">Tinangap at inihain ngayong ika- <input type="text" name="day" placeholder="day" size="1" required> araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.              
</div><br>


        <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center;">Punong Barangay</label>
</p>
  <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">*Ang hindi pagtanggi sa pag-aayos o kasunduan ng paghahatol ng tagapamagitan sa loob ng taning na panahon, alinsunod sa itinakdang sampung (10) araw ay ipapalagay na isang pagtatakwil sa karapatang tumutol batay sa nasabing kadahilanan. 
    </div>       
</div>
</html>
