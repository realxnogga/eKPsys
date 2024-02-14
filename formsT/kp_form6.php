<?php
session_start();
$linkedNames = $_SESSION['linkedNames'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>kp_form6</title>
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
               <a href="../user_lupon.php" class="btn btn-primary print-button common-button">Back</a>
               
            </div>
            
			
            <div style="text-align: left;">
            <h5>Pormularyo ng KP Blg. 6</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG PUNONG BARANGAY</h5>
            </div>
            <?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>

            <div style="text-align: right;">
                <select id="monthInput" name="month" required style="width: 93px; height: 19px; border: 1px solid black;">
                    <?php
                    $currentMonth = date('F');
                    foreach ($months as $index => $month) {
                        $monthNumber = $index + 1;
                        $selected = ($month == $currentMonth) ? 'selected' : '';
                        echo '<option value="' . $monthNumber . '" ' . $selected . '>' . $month . '</option>';
                    }
                    ?>
                </select>
                <input type="text" id="day" name="day" required style="width: 25px; height: 19px; border: 1px solid black;">
                <label for="day">,</label>
                <input type="text" id="year" name="year" required style="width: 50px; border: none;" value="<?php echo $currentYear; ?>">

            

                <h3 style="text-align: center;"><b>PAGBAWI NG PAGHIRANG</b></h3>

                <div style="text-align: left;">
				<br><p style="text-align: justify; font-size: 12px; margin-top: 0;">TO:
    <input type="text" id="recipient" name="recipient" list="nameList" required style="width:200px; height: 20px;">
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
</p>
				<p style="text-align: justify; font-size: 12px; text-indent: 1.5em;"> Matapos ang karampatang pagdinig at sa pagsang-ayon ng nakararami sa lahat ng mga Kasapi ng Lupong Tagapamayapa ng Barangay na ito, ang paghirang sa iyo bilang Kasapi nito ay binabawi na magkakabisa sa sandaling tanggapin ito, batay sa sumusunod na kadahilanan/mga kadahilanan: </p>
				
				<!-- Use PHP to set the checkbox status based on some condition -->
        <?php
            $isChecked = false; // Replace this with your own condition to determine if the checkbox should be checked or not
        ?>
        <!-- Create the checkbox with PHP -->
        <input type="checkbox" name="my_checkbox" <?php if ($isChecked) echo "checked"; ?>>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        kawalan ng kakayahan sa pagtupad ng mga tungkulin ng inyong tanggapan na 
                  ipinakita sa pamamagitan ng
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="day" name="day" required style="width:330px; height: 20px; size="1" required>.</p>
		
		<!-- Use PHP to set the checkbox status based on some condition -->
        <?php
            $isChecked = false; // Replace this with your own condition to determine if the checkbox should be checked or not
        ?>
        <!-- Create the checkbox with PHP -->
        <input type="checkbox" name="my_checkbox" <?php if ($isChecked) echo "checked"; ?>>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		hindi naangkop sa dahilan ng  <input type="text" id="day" name="day" required style="width:330px; height: 20px; size="1" required>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(Markahan kung alin ang angkop at ipaliwanag o tiyakin ang kilos/mga kilos o 
      pagkukulang/mga  pagkukulang  na  siyang 
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		kadahilanan/mga  kadahilanan sa 
      pagbawi.) <br><br><br>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

	<body>
   
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value="<?= strtoupper($linkedNames['punong_barangay'] ?? 'Punong Barangay') ?>">
    Punong Barangay/ Kalihim ng Lupon
</p>

<br><br>
			<p style="text-align: justify; text-indent: 4em;">SUMASANG-AYON </p>
					<div style="display: flex;">
                <div style="flex: 1; margin-left: 95px;">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <?php $formattedIndex = sprintf("%02d", $i); ?>
                        <p style="margin: 0;"><?php echo $formattedIndex; ?>. <input type="text" name="appointed_lupon_<?php echo $formattedIndex; ?>" style="width: 210px; margin-bottom: 5px;"></p>
                    <?php endfor; ?>
                </div>
                <div style="flex: 1; margin-left: 10px;">
                    <?php for ($i = 7; $i <= 11; $i++): ?>
						<?php $formattedIndex = sprintf("%02d", $i); ?>
                        <p style="margin: 0;"><?php echo $formattedIndex; ?>. <input type="text" name="appointed_lupon_<?php echo $formattedIndex; ?>" style="width: 210px; margin-bottom: 5px;"></p>
                    <?php endfor; ?>
                </div>
            </div>
        </div><br><br>
				</div>

			
			<form method="POST">
			 <p style="text-align: justify; text-indent: 4em;">
             Tinanggap ngayong ika - 
                    <input type="text" id="day" name="day" required style="width:32px; height: 20px; size="1" required>
					araw ng <select name="month" required style="width: 93px; required>
                            <option value="">Pumili ng buwan</option>
                            <?php foreach ($months as $month): ?>
                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                            <?php endforeach; ?>
                        </select>,
                        20
                        <input type="text" name="year" required style="width: 25px; height: 20px; size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
                    </p>
                </form>
	
	
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="pngbrgy" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none;" size="25">
	(Lagda)
	</p><br><br><br><br><br><br>
	<p style="text-align: justify; font-size: 12px; margin-top: 0;"> BIGYAN – PANSIN:
	<p style="text-align: justify; font-size: 12px; text-indent: 1.5em;"> Ang mga kasapi ng lupon na sumasang-ayon sa pagbawi ay kailangang personal na lumagda p magkintal ng hinlalaki  sa kinauukulang  mga patlang sa itaas.  Ang pagbawi ay dapat sang-ayunan ng mahigit sa kalahati ng kabuuang bilag ng mga kasapi ng lupon kabilang ang Punong Barangay at ang kinauukulang kasapi.</p>
	
    <div class="blank-page"></div>
    </body>
        </div><br><br><br><br><br><br><br><br>
		
		
</body>
</html>	