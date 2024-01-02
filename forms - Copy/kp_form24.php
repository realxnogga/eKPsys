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
    <title>KP. FORM 24</title>
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
            <h5>Pormularyo ng KP Blg. 24</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Lungsod/Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG  LUPONG TAGAPAMAYAPA</h5>
                <br><br>
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
    <p>(Mga) Ipinagsusumbong:<br>
        <!-- RspndtNames here -->
       <?php echo $rspndtNames; ?><br> </p>
</div>
</div>


                <h3 style="text-align: center;"><b>PAABISO  NG  PAGDINIG<br>
                (Ukol sa: Panukala sa Pagpapatupad)  </b> </h3>

        <div style="display: flex;">
  <div style="text-align: left;">
  </div>

  <div style="margin-left: 20px; text-align: left;">
    <div>
    <div class="label"></div>
    <div class="input-field">
        <p>   KAY:  <br><?php echo $cNames; ?>
<input type="text" name="to" id="to" size="25" style="border: none; margin-left: 10px;">
<?php echo $rspndtNames; ?><br>
May Sumbong
<input type="text" name="to" id="to" size="35" style="border: none; margin-left: 20px;">
Isinumbong

</div>
</div>
    
    </div>
  </div>
</div>



<div>
    <br>

    <p style="text-indent: 2.8em; text-align: justify; ">
    Sa pamamagitan nito’y inaatasan kang humarap sa sakin sa ika <input type="text" name="day" placeholder="day" size="1" required> araw  ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required> , sa ganap ng ika <input type="time" name="time" size="10" style="border:none">
                ng umaga/hapon/gabi para sa pagdinig ng panukala sa pagpapatupad, na kung saan ang sipi ay kalakip dito, na inihain ni <select id="ComplainantRespondent" name="ComplainantRespondent" onchange="toggleInputField()" required>
  <option value="" disabled selected>Mga may sumbong/Mga Ipinagsusumbong</option>
  <option value="Complainant">Complainant/s Name</option>
  <option value="Respondent">Respondent/s Name</option>
</select>

<div id="nameInput" style="display: none;">
  <input type="text" id="name" name="name" placeholder="Enter Name" oninput="updateOptionText(this.value)" onkeydown="checkEnterKey(event)">
</div>

<p id="selectedOptionLabel" style="display: none;"></p>

           <p style="text-align: justify; text-indent: 0em; margin-left: 38.5px;">(Petsa) <input type="text" name="day" placeholder="day" size="1" required>  araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
               
            </p>

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>


        <br>
        <br>
        <br>
        <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center;">Tagapagpangulo ng Pangkat/Lupon</label>
</p>

<br>
<div style="text-align: left; text-indent: 0em; ">

<br>
Pinaabisuhan ngayong ika <input type="text" name="day" placeholder="day" size="1" required> araw ng
                <select name="month" required>
                    <option value="">Buwan </option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.       
            </p>

</div>
<div class="d">
    <div style="text-align: left; font-size: 12px; margin-left: 50px;"><br>
    <p><br>(Mga) May Sumbong <br> <br><br><p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 570px; margin-left: auto;"><?php echo $cNames; ?> <br>_____________________
            <id="cmplnts" name="cmplnts" size="25"  style="text-align: left;"></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
    <p>(Mga) Isinumbong <br> <br><br><p class="important-warning-text" style="text-align: left; font-size: 12px; margin-left: 570px; margin-left: auto;"><?php echo $rspndtNames; ?> <br>_____________________
            <id="rspndt" name="rspndt" size="25"  style="text-align: left;"></p><br><br>
  </div>

  </body>
</html>