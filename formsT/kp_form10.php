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
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $currentYear = date('Y');
            ?>


<br><br><br>
<h3 style="text-align: center;"> 
PAABISO UKOL SA PAGBUBUO NG PANGKAT
</h3>
<br>        
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> KAY:  <br><?php echo $cNames; ?>
<input type="text" name="to" id="to" size="25" style="border: none; margin-left: 10px;">
<?php echo $rspndtNames; ?><br>
C(Mga) Maysumbong
<input type="text" name="to" id="to" size="35" style="border: none; margin-left: 20px;">
(Mga) Ipinagsusumbong

</div>
</div>

<div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">Sa pamamagitan nito, kayo ay inaatasan na humarap sa akin sa ika- <input type="text" name="day" placeholder="day" size="5" required>  araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>sa ganap na ika- <input type="time" id="time" name="time" size="5" style="border: none;"> ng umaga/hapon para sa pagbubuo ng Pangkat ng Tagapagkasundo, na siyang magkakasundo ng iyong alitan.
                 Kung sakali’t di ninyo mapagkasunduan ang kasapian ng Pangkat, o mabigo kayong humarap sanasabing patsa para sa pagbubuo ng Pangkat, 
                 aking titiyakin ang kasapian nito sa pamamagitan ng palabunutan.
</div>
    <br>

    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Ngayong ika-  <input type="text" name="day" placeholder="day" size="5" required> araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.              
</div> 
<br><br><br>

<p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 0; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value="<?php echo $punong_barangay;?>">
    <br>
    <span style="margin-left: 50px;">Punong Barangay</span>
</p>


<br><br><br>
  <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Tinanggap at inihain ngayong  <input type="text" name="day" placeholder="day" size="5" required> araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select> ,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.              
</div> 
<br> <br>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> <br><?php echo $cNames; ?>
<input type="text" name="to" id="to" size="25" style="border: none; margin-left: 10px;">
<?php echo $rspndtNames; ?><br>
(Mga) Maysumbong	
<input type="text" name="to" id="to" size="35" style="border: none; margin-left: 20px;">
(Mga) Ipinagsusumbong

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

</body>
<br>
<div class="blank-page">        
       
          
</div>
</html>
    