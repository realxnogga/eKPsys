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
    <title>kp_form7</title>
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
                <h5>Pormularyo ng KP Blg. 7</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG PUNONG BARANGAY</h5>
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

       

                    <h3 style="text-align: center;"><b>SUMBONG</b></h3>

                    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> 
                    <p>AKO/KAMI, ay nagrereklamo laban sa mga ipinagsusumbong na binanggit sa itaas dahil sa paglabag ng aking/aming mga karapatan at kapakanan sa sumusunod na pamamaraan: <input type="text" id="complain" name="complain" style="text-align: left;" size="110" value="<?php echo $cDesc; ?>"></p>
                    <p>DAHIL DITO, AKO/KAMI, na nakikiusap na ipagkakaloob sa akin/amin ang sumusunod na (mga) kalunasan nang naaalinsunod sa batas at/o pagkamakatuwiran: <input type="text" id="petition" name="petition" style="text-align: left;" size="110" value="<?php echo $petition; ?>"></p>
                    </div>

                <form method="POST">
                    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">Ginawa ngayong ika-  
                    <?php $currentDate = date('d'); echo  $currentDate;?> araw ng 
                    <?php
// Get the current month in English
$currentMonth = date('F');

// Define an array for English to Tagalog month names mapping
$monthTranslations = array(
    'January' => 'Enero',
    'February' => 'Pebrero',
    'March' => 'Marso',
    'April' => 'Abril',
    'May' => 'Mayo',
    'June' => 'Hunyo',
    'July' => 'Hulyo',
    'August' => 'Agosto',
    'September' => 'Setyembre',
    'October' => 'Oktubre',
    'November' => 'Nobyembre',
    'December' => 'Disyembre'
);

// Translate the current month to Tagalog
$translatedMonth = $monthTranslations[$currentMonth];

// Output the translated month
echo $translatedMonth;
?>
,
                    <?php $currentYear = date('Y'); echo  $currentYear;?>.
</div>

           <div style="position: relative;">
                        <br>
                        <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
                        <!-- CName here but All Capital Letters -->
                        <input type="text" id="cmplnts" name="cmplnts" size="25" value="<?php echo $cNames; ?>" style="text-align: center;"><br>(mga) Maysumbong</p>
            </div>
           
            <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> 	Tinanggap at inihain ngayong  <?php $currentDate = date('d'); echo  $currentDate;?>  araw ng 
            <?php
// Get the current month in English
$currentMonth = date('F');

// Define an array for English to Tagalog month names mapping
$monthTranslations = array(
    'January' => 'Enero',
    'February' => 'Pebrero',
    'March' => 'Marso',
    'April' => 'Abril',
    'May' => 'Mayo',
    'June' => 'Hunyo',
    'July' => 'Hulyo',
    'August' => 'Agosto',
    'September' => 'Setyembre',
    'October' => 'Oktubre',
    'November' => 'Nobyembre',
    'December' => 'Disyembre'
);

// Translate the current month to Tagalog
$translatedMonth = $monthTranslations[$currentMonth];

// Output the translated month
echo $translatedMonth;
?>
,
                    <?php $currentYear = date('Y'); echo  $currentYear;?>.
            </div>

                </form>

                    <?php if (!empty($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
<br>
<br>

 

<p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value ="<?php echo $punong_barangay; ?>">
   <br> Punong Barangay/Kalihim ng Lupon
</p>
              
    </body>
</html>
