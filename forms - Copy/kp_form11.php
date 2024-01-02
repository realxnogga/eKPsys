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
    <title>kp_form11</title>
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
             <h5>Pormularyo ng KP Blg. 11</h5>
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

       

<div class="form-group" style="text-align: right;"> <br>

<div style="text-align: right; margin-right: 180px;"> Usaping Barangay Blg.<?php echo $cNum; ?> </div> <br> <p> <div style="text-align: right; margin-right: 100px;">Ukol sa : 
                <!-- ForTitle here -->
                 <?php echo $forTitle; ?> <br> 
        </div>
    </div>

    <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
        <div class="label"></div>
        <div class="input-field">
            <p> (Mga) Maysumbong
                <!-- CNames here -->
                <br><?php echo $cNames; ?><br> </p>
    <br><p> — laban kay/kina  —</p>
</div>
</div>

<div>
<div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
    <div class="label"></div>
    <div class="input-field">
        <p> (Mga) Ipinagsusumbong<br><?php echo $rspndtNames; ?></p>
    </div>
</div>
   

                <h3 style="text-align: center;"><b>PAABISO  SA NAPILING KASAPI NG PANGKAT</b></h3>

               <div class="e" style="text-align: right;">
    <input type="text" name="day" placeholder="Day" size="2" required> of
    <select name="month" required>
        <option value="">Buwan</option>
        <?php foreach ($months as $month): ?>
            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
        <?php endforeach; ?>
    </select>,
    20
    <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
</div>


            <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
                <div class="label"></div>
                <div class="input-field">
                    <p> KAY:<br><input type="text" name="to" id="to" size="30"> </p>
            </div>
            </div>


                <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> 
                <p> Sa pamamagitan ng paabisong ito, ikaw ay pinasasabihan  na napili kang kasapi ng Pangkat ng Tagapagkasundo upang   matiwasay na pagkasunduin  ang alitan sa pagitan ng panig na usaping nasasaad sa itaas. </p>
                </div>
                <br><br>


    
                <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><?php echo $punong_barangay; ?><br>_________________<br>
                    <label id="punongbrgy" name="punongbrgy" size="25" style="text-align: center;">Punong Barangay/Tagapangulo ng Lupon</label>



            <form method="POST">
                <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Tinanggap ngayong ika-<input type="text" name="day" placeholder="day" size="2" required>  araw ng
                <select name="month" required>
                    <option value="">Buwan</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
                </div>


       <div style="position: relative;">
                    <br>

        <canvas id="canvas1" width="190" height="60"></canvas>
      
        <script src="signature.js"></script>
                    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;"><input type="text" id="cmplnts" name="cmplnts" size="25">Kasapi ng Pangkat</p>
        </div>
       

            </form>

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
