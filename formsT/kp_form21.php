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
    <title>KP. FORM 21</title>
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
            </div>

            <div style="text-align: left;">
            <h5>Pormularyo ng KP Blg. 21</h5>
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
            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>

             <h3 style="text-align: center;"><b> KATIBAYAN UPANG HADLANGAN ANG PAGDULOG SA HUKUMAN</b> </h3>
  
    <div>
    <p style="text-indent: 2.8em; text-align: justify;">
        Ito ay nagpapatunay na ag usaping nakasaad sa itaas ay ipinagwalang-saysay alinsunod sa Kautusan may petsang    

    <input type="text" name="day" placeholder="araw" size="1" required>  of
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
              para sa (mga) maysumbong 
              <label for="complainant"> </label>
            <input type="text" name="complainant" id="complainant/s" placeholder="Complainant's name"required> (pangalan) at
             <label for="complainant"> </label>
            <input type="text" name="complainant" id="complainant/ss" placeholder="Complainant's name"> (pangalan) sanhi ng sinadya o pagtangging humarap para sa pagdinig sa harap ng Punong Barangay/Pangkat ng Tagapagkasundo at dahil dito ang (mga) maysumbong ay hinahadlangang makadulog sa hukuman/tanggapan ng pamahalaan.

    </div>
      

        <p style="text-align: justify; text-indent: 2.8em; "> Ngayong ika  <input type="text" name="day" placeholder="araw" size="1" required>  araw ng
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
               
            </p>

    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 555px; margin-right: auto;">
    <input type="text" id="luponSec"  name="luponSec" style="text-align: center;style="border: none; border-bottom: 1px solid black; outline: none; size="25">
    <br>Kalihim ng Pangkat
    </p>
    <br>
</div>
</p>
<br>
    <p style="text-align: justify; margin-top: 0;">
   <br>   Pinatunayan:</p>
    <br>
    <br>
 
  
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-right: 570px; margin-left: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value ="<?php echo $punong_barangay; ?>">
  <br>  Tagapagpangulo ng Pangkat/Lupon
</p>
<br>

 <p style="text-align: justify; margin-top: 0;">
      MAHALAGA:   Kung ang gumawa ng katibayan ay kalihim ng Lupon, ang Tagapangulo ng Lupon ang magpapatunay.  Kung ang Kalihim ng Pangkat ang gumawa ng Katibayan, ang Tagapangulo ng Pangkat ang magpapatunay.</p>
</div>
   
</body>
</html>