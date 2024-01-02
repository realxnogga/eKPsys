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
    <title>KP FORM 20-A</title>
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
             <h5>Pormularyo ng KP Blg. 20-A</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Lungsod/Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>
            </div>

            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>

<div class="form-group" style="text-align: right;">

<div class="input-field"> <br>
    <!-- case num here -->
    <div style="text-align: right; margin-right: 180px;"> Usaping Barangay Blg.<?php echo $cNum; ?> </div> <br> <p> <div style="text-align: right; margin-right: 100px;">Ukol sa: 
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
      

             
                <h3 style="text-align: center;"><b>  KATIBAYAN UPANG MAKADULOG SA HUKUMAN</b> </h3>

  <div style="text-align: left;">
            <p style="text-align: justify; margin-top: 0;">Ito ay nagpapatunay  na:</p>
            <!-- <p style="text-align: justify; text-indent: 1.5em;">1. There has been a personal confrontation between the parties before the Punong Barangay/Pangkat ng Tagapagkasundo; </p> -->
            <div class="form-group" style="text-align: justify;">
   <div class="checkbox"style="text-align: left;text-indent: 1.5em;">
        
        <label for="checkbox1"style="text-indent: 0em; margin-left: 2px;">
        1. Magkaroon ng personal na paghaharap sa pagitan ng mga panig sa harap ng Punong Barangay subalit nabigo ang pamamagitan; </label>
    </p></div>
</div>
 <div class="checkbox"style="text-align: left;text-indent: 1.5em;">
        
        <label for="checkbox1"style="text-indent: 0em; margin-left: 2px;">
        2. Ang Pangkat ng Tagapagkasundo ay binuo subalit ang personal na paghaharap sa harap ng Pangkat ay hindi rin humantong sa pag-aayos; at</label>
    </p>
</div>
            <!-- <p style="text-align: justify; text-indent: 1.5em;">2. A settlement was reached;</p> -->
            <p style="text-align: justify; text-indent: 0em; margin-left: 38.5px;">3. Dahil  dito, ang kaukulang sumbong para  sa alitan ay maaari nang ihain sa hukuman/tanggapan ng pamahalaan.
</p>
            <br>

            <div style="text-align: justify; text-indent: 0em; margin-left: 38.5px;"> Ngayong ika -  <input type="text" name="day" placeholder="day" size="1" required>  araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
              
            </p>

        </form>
</div>

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div style="position: relative;"><br>
   

   <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
   <input type="text" id="luponSec"  name="luponSec" style="text-align: center;style="border: none; border-bottom: 1px solid black; outline: none; size="25">
   Kalihim ng Lupon
   </p>
   <br>
</div>
       PINATUNAYAN:
<br>
<br>
<p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 50px;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: left;">Pangulo ng Lupon</label>
</p>
                </div>
         
           </div>
        </div><br>
          <br>
        <br>
        <br>
    </div>
    <br>
</p>
</div>
<br>
       
  </body>
</html>