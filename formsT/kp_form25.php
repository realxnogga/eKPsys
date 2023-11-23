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
    <title>kp_form25</title>
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
            <h5>Pormularyo ng KP Blg. 25</h5>
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


<form method="post" action="<?php ($_SERVER["PHP_SELF"]);?>"> 


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

                <h3 style="text-align: center;"><b> PAABISO  UKOL SA PAGPAPATUPAD</b><br>

 </h3>
 <br>
        <div style="display: flex;">
  <div style="text-align: justify;">
    <!-- Content for the left column -->
  </div>



<div>
    <p style="text-indent: 2.0em; text-align: justify;">
    SAPAGKAT,   noong 

    <input type="text" name="day" placeholder="araw" size="1" required>  araw ng
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
                isang matiwasay na pag-aayos ang nilagdaan ng mga panig sa usaping binabanggit sa itaas  (o isang gawad ng paghahatol ang ibinigay ng Punong Barangay / Pangkat  ng Tagapagkasundo);; <br> <br>
SAPAGKAT, ang mga tuntunin at mga kondisyon ng pag-aayos, ang bahaging nagbibigay desisyon ng gawad ay mababasa tulad ng sumusunod:
<br><input type="text" name="sumusunod1" id="sumusunod1" size="50"><br><input type="text" name="sumusunod" id="sumusunod" size="50"><br><input type="text" name="sumusunod2" id="sumusunod2" size="50"><br><input type="text" name="sumusunod3" id="sumusunod3" size="50">

 <p style="text-indent: 2.0em; text-align: justify;">
 SAPAGKAT, ang mga tuntunin at mga kondisyon ng pag-aayos, ang bahaging nagbibigay desisyon ng gawad ay mababasa tulad ng sumusunod:
 SAPAGKAT, ang obligadong panig

<select id="ComplainantRespondent" name="ComplainantRespondent" onchange="toggleInputField()" required>
  <option value="" disabled selected>Complainant/s/Respondent/s</option>
  <option value="Complainant">Complainant/s Name</option>
  <option value="Respondent">Respondent/s Name</option>
</select>
ay hindi pa kusang-loob na tumutupad sa binanggit na pag-aayos/gawad ng paghahatol, sa loob ng limang (5) araw mula sa petsa ng pagdinig sa panukala sa pagpapatupad;
<div id="nameInput" style="display: none;">
  <input type="text" id="name" name="name" placeholder="Enter Name" oninput="updateOptionText(this.value)" onkeydown="checkEnterKey(event)">
</div>

<p id="selectedOptionLabel" style="display: none;"></p>


 <p style="text-indent: 2.0em; text-align: justify;">
 DAHIL DITO, sa pangalan ng Lupong Tagapamayapa at sa kapangyarihang ibinigay sa akin at ng Lupon sa pamamagitan ng 
 Batas  at mga Alintuntunin  ng Katarungang Pambarangay, akin  gagawin  upang maisakatuparan mula  sa mga kalakal at mga personal na ari-arian  ni    
<select id="ComplainantRespondent" name="ComplainantRespondent" onchange="toggleInputField()" required>
  <option value="" disabled selected>Complainant/s/Respondent/s</option>
  <option value="Complainant">Complainant/s Name</option>
  <option value="Respondent">Respondent/s Name</option>
</select>
ang halagang   _________________ pinagkasunduan sa nasabing 
	(Ilahad ang halaga ng pag-aayos o gawad)
nasabing  matiwasay na pag-aayos  (o sa inihatol sa nasabing gawad sa paghahatol),  maliban kung ang kusang-loob na pagtupad  sa nasabing pag-aayos o gawad ay ginawa sa
  sandaling matanggap ito.

<div id="nameInput" style="display: none;">
  <input type="text" id="name" name="name" placeholder="Enter Name" oninput="updateOptionText(this.value)" onkeydown="checkEnterKey(event)">
</div>

<p id="selectedOptionLabel" style="display: none;"></p>

            </p>

    </p></div>
</div>

            <div style="text-align: justify; text-indent: 0em; margin-left: 30px;"> Nilagdaan ngayong ika <input type="text" name="day" placeholder="araw" size="1" required>  araw ng
                <select name="month" required>
                    <option value="">Pumili ng buwan</option>
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

    <div style="position: relative;">
        <br>
        <br>
        <br>
     <<p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value ="<?php echo $punong_barangay; ?>">
    <br>Punong Barangay
</p>
        <br>
      
</div>
 <p style="text-indent: 2.0em; text-align: justify;">
 Binigyan  ng sipi: </p>
  <br>
 

  <div style="display: flex; justify-content: center;">
  <div style="margin-right: 50px; flex: 1;">
  
      <br>
     <input type="text" name="complainant" id="complainant" size="50" value="<?php echo $cNames; ?>">
    <p style="text-align: center;">(Mga) Maysumbong</p>
  </div>
  <div style="margin-left: 50px; flex: 1;">
    
    <br>   
     <input type="text" name="complainant" id="complainant" size="50"value="<?php echo $rspndtNames; ?>">
    <p style="text-align: center;">(Mga) Ipinagsusumbong</p>
    <br>
  </div>  
<br>

  </body>
</html>