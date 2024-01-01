<?php
session_start();
$apptNames = $_SESSION['apptNames'] ?? [];
$linkedNames = $_SESSION['linkedNames'] ?? [];

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
               
            </div>
			
             <div style="text-align: left;">
                <h5>KP Form No. 1</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
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


                <h3 style="text-align: center;"><b>NOTICE TO CONSTITUTE THE LUPON</b></h3>

                <div style="text-align: left;">
					<p style="text-align: justify; font-size: 12px; margin-top: 0;">To All Barangay Members and All Other Persons Concerned:</p>
					<p style="text-align: justify; font-size: 12px; text-indent: 1.5em;">In compliance with Section 1(a), Chapter 7, Title One, Book III, Local Government Code of 1991 (Republic Act No. 7160), of the
					<i>Katarungang Pambarangay Law</i>, notice is hereby given to constitute the <i>Lupong Tagapamayapa</i> of this Barangay.
					The persons I am considering for appointment are the following:</p>
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


                <p style="text-align: justify; text-indent: 1.5em;">They have been chosen on the basis of their suitability for the task of conciliation considering their integrity, impartiality, independence of mind, sense of fairness and reputation for probity in view of their age, social standing in the community, tact, patience, resourcefulness, flexibility, open-mindedness and other relevant factors.
				The law provides that only those actually residing or working in the barangay who are not expressly disqualified by law are qualified to be appointed as <i>Lupon</i> members.</p>

                <form method="POST">
                    <p style="text-align: justify; text-indent: 1.5em;">
                        All persons are hereby enjoined to immediately inform me and of their opposition to or endorsement of any or all the proposed members or recommend to me other persons not included in the list but not later than the
                        <input type="text" id="day" name="day" required style="width:32px; height: 20px; size=1;" required> day of
                        <select name="month" required style="width: 93px; required>
                            <option ">Select Month</option>
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
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value="<?= strtoupper($linkedNames['punong_barangay'] ?? 'Punong Barangay') ?>">
    Punong Barangay
</p>


					<div><br><br>
                    <p class="important-warning-text" style="text-align: justify; font-size: 12px; text-indent: 1.5em;">
                    IMPORTANT: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    This notice is required to be posted in three (3) conspicuous places in the barangay for at least three (3)
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					weeks.
                    </p>
                    <p class="important-warning-text" style="text-align: justify; font-size: 12px; text-indent: 1.5em;">
                    WARNING: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Tearing or defacing this notice shall be subject to punishment according to law.
                    </p>
                    <br>
					</div>
        </div>
    </div>

</body>
</html>	