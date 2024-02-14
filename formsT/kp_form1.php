<?php
session_start();
$apptNames = $_SESSION['apptNames'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>kp_form1</title>
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
                <h5>Pormularyo ng KP Blg. 1</h5>
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


                <h3 style="text-align: center;"><b>PAABISO TUNGKOL SA PAGBUO NG LUPON</b></h3>

                <div style="text-align: left;">
					<p style="text-align: justify; font-size: 12px; margin-top: 0;">Sa lahat ng mga Kasapi ng Barangay at lahat ng iba pang kinauukulan:</p>
					<p style="text-align: justify; font-size: 12px; text-indent: 1.5em;">Sa pagtalima sa Seksyon 1 (a. Kabanata 7, Pamagat Isa, Aklat III ng kodigo ng Pamahalaang lokal ng 1991 (Batas ng Republika Blg. 7160), ng Batas ng Katarungang Pambarangay, ang paabiso ay dito’y ibinibigay upang bumuo ng Lupong Tagapamayapa ng Barangay na ito. Ang mga taong isasaalangalang ko para sa paghirang ay ang mga sumusunod:</p>
						<div style="display: flex;">
    <div style="flex: 1; margin-left: 145px;">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <?php $nameKey = "name$i"; ?>
            <p style="margin: 0;"><?php echo $i; ?>. <input type="text" name="appointed_lupon_<?php echo $i; ?>" value="<?php echo $apptNames[$nameKey] ?? ''; ?>" style="width: 210px; margin-bottom: 5px;"></p>
        <?php endfor; ?>
    </div>

        <div style="flex: 1;">
        <?php for ($i = 11; $i <= 20; $i++): ?>
            <?php $nameKey = "name$i"; ?>
            <p style="margin: 0;"><?php echo $i; ?>. <input type="text" name="appointed_lupon_<?php echo $i; ?>" value="<?php echo $apptNames[$nameKey] ?? ''; ?>" style="width: 210px; margin-bottom: 5px;"></p>
        <?php endfor; ?>
    </div>
</div>

	</div>

			<script>
function openAndLoadForm(formSrc, punongBarangayValue, luponChairmanValue) {
        const iframe = document.getElementById('kp-form-iframe');
        iframe.src = `${formSrc}?punong_barangay=${punongBarangayValue}&lupon_chairman=${luponChairmanValue}`;

        const modal = document.getElementById('kp-form-modal');
        modal.style.display = 'block';
    }

    document.getElementById('open-kp-form1').addEventListener('click', function() {
        openAndLoadForm('forms/kp_form1.php', '<?= strtoupper($apptNames['punong_barangay'] ?? '') ?>', '<?= strtoupper($apptNames['lupon_chairman'] ?? '') ?>');
    });

				function resetFields() {

			document.getElementById('day').value = "";
        

			var inputs = document.querySelectorAll('.paper div[style="display: flex;"] input[type="text"]');

				inputs.forEach(function(input) {
            input.value = "";
				});
			}
			</script>


                <p style="text-align: justify; text-indent: 1.5em;">Sila ay pinipili batay sa kanilang kaangkupan para sa tungkulin ng pagkakasundo na isinaalang-alang ang kanilang katapatan, walang kinikilingan, kalayaan ng pag-iisip, pagkamakatarungan, reputasyon sa pagkamatapat batay sa kanilang edad, katayuang pang lipunan, pagkamatiyaga, pagkamaparaan, madaling makibagay, malawak ang pag-iisip at iba pang kaugnay na dahilan. Ayon sa batas, iyon lamang tunay na naninirahan o nagtratrabaho sa barangay na hindi hayagang inaalisan ng karapatan ng batas ang nararapat na hirangin bilang kasapi ng Lupon.</p>

                <form method="POST">
                    <p style="text-align: justify; text-indent: 1.5em;">
                    Ang lahat ng tao ay inaanyayahan na kagyat na ipabatid sa aking ang kanilang pagsalungat kaya o pag-iindorso sa sinuman o lahat ng mga pinanukalang mga kasapi o magrekomenda sa akin ng iba pang mga tao na hindi kabilang sa talaan ni hindi lalampas ng 
                        <input type="text" id="day" name="day" required style="width:32px; height: 20px; size=1;" required> araw ng 
                        <select name="month" required style="width: 93px; required>
                            <option ">Pumili ng buwan</option>
                            <?php foreach ($months as $month): ?>
                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                            <?php endforeach; ?>
                        </select>,
                        20
                        <input type="text" name="year" required style="width: 25px; height: 20px; size=1;" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
                        (the last day for posting this notice).
                    </p>
                </form>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

    
	<body>
    <br>
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value="<?= strtoupper($apptNames['punong_barangay'] ?? 'Punong Barangay') ?>">
    Punong Barangay
</p>


					<div><br><br>
                    <i><p class="important-warning-text" style="text-align: justify; font-size: 12px; text-indent: 1.5em;">
                    MAHALAGA:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Ang paabisong ito ay kinakailangang ipaskel sa tatlong (3) hayag na lugar sa barangay ng di kukulangin sa 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					tatlong (3) linggo.
                    </p>
                    <p class="important-warning-text" style="text-align: justify; font-size: 12px; text-indent: 1.5em;">
                    BABALA:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Ang pagpunit o pagsira ng pabatid na ito ay sasailalim ng parusa nang naaayon sa batas.
                    </p></i>
                    <br>
					</div>
        </div>
    </div>

</body>
</html>	