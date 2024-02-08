<?php
session_start();
$linkedNames = $_SESSION['linkedNames'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>kp_form5</title>
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
                <h5>KP Form No. 5</h5>
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

                <script>
                    var yearInput = document.getElementById('year');

                    yearInput.addEventListener('keyup', function(event) {
                        if (event.keyCode === 38) {
                            event.preventDefault();
                            var year = parseInt(yearInput.value);
                            yearInput.value = year + 1;
                        }
                    });

                    yearInput.addEventListener('keyup', function(event) {
                        if (event.keyCode === 40) {
                            event.preventDefault();
                            var year = parseInt(yearInput.value);
                            yearInput.value = year - 1;
                        }
                    });
                </script>

                <h3 style="text-align: center;"><b>OATH OF OFFICE</b></h3>

                <div style="text-align: left;">
				<p style="text-align: justify; font-size: 12px; text-indent: 1.5em;">Pursuant to Chapter 7, Title One, Book II, Local Government Code of 1991 (Republic Act No. 7160), I

 <input type="text" id="recipient" name="recipient" list="nameList" required style="width: 20%; border: none; border-bottom: 1px solid black; margin-right: 0;"></p>
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
                    , being duly
					qualified and having been duly appointed MEMBER of the <i>Lupong Tagapamayapa</i> of this Barangay, do hereby solemnly swear (or
					affirm) that I will faithfully and conscientiously discharge to the best of my ability, my duties and functions as such member and as member of the <i>Pangkat ng Tagapagkasundo</i> in which I may be chosen to serve; that I will bear true faith and allegiance to the
					Republic of the Philippines; that I will support and defend its Constitution and obey the laws, legal orders and decrees promulgated by
					its duly constituted authorities; and that I voluntarily impose upon myself this obligation without any mental reservation or purpose of
					evasion.
				</p>
				</div>

		<div style="position: relative;"><br>
		<p style="text-align: justify; text-indent: 1.5em;">
		SO HELP ME GOD. (In case of affirmation the last sentence will be omitted.)</p>

	<body>

    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="pngbrgy" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none;" size="25">
	Member
	</p>
	
	<form method="POST">
                    <p style="text-align: justify; text-indent: 1.5em;">
                       SUBSCRIBED AND SWORN to (or AFFIRMED) before me this
                        <input type="text" id="day" name="day" required style="width:32px; height: 20px"; size="1" required> day of
                        <select name="month" required style="width: 93px"; required>
                            <option value="">Select Month</option>
                            <?php foreach ($months as $month): ?>
                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                            <?php endforeach; ?>
                        </select>,
                        20 <input type="text" name="year" required style="width: 25px; height: 20px"; size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
                    </p>
                </form><br><br><br>
	
	<canvas id="canvas1" width="190" height="80" style="float: right";></canvas>
    <script src="signature.js"></script>
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value="<?= strtoupper($linkedNames['punong_barangay'] ?? 'Punong Barangay') ?>">
    Punong Barangay
</p>

    </div>
    </div>
    <div class="blank-page"></div>
    </body>
        </div><br><br><br><br><br> 
		
	
</body>
</html>	