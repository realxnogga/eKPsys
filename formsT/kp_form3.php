<?php
session_start();
$linkedNames = $_SESSION['linkedNames'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>kp_form3</title>
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
             <h5>Pormularyo ng KP Blg. 3</h5>
                <h5 style="text-align: center;">Republika ng Pilipinas</h5>
                <h5 style="text-align: center;">Lalawigan ng Laguna</h5>
                <h5 style="text-align: center;">Bayan ng <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">TANGGAPAN NG PUNONG BARANGAY</h5>
            </div>            <?php
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

               

                <h3 style="text-align: center;"><b>PAABISO NG PAGHIHIRANG</b></h3>

                <div style="text-align: left;">
				
<input type="text" id="recipient" name="recipient" list="nameList" required style="width:200px; height: 20px; size= 1;"></p>
<input type="text" id="recipient" name="recipient" list="nameList" required style="width:200px; height: 20px; size= 1;"></p>
<input type="text" id="recipient" name="recipient" list="nameList" required style="width:200px; height: 20px; size= 1;"></p>


    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>


				<br><p style="text-align: justify; font-size: 12px; margin-top: 0;">Ginoo/Gng: </p>
				<p style="text-align: justify; font-size: 12px; text-indent: 1.5em;">Ipinababatid sa iyo na ikaw ay hinihirang ng Punong Barangay bilang kasapi ng Lupong Tagapamayapa, na magkakabisa sa sandaling makapanumpa sa tungkulin, at hanggang ang bagong Lupon ay mabuo sa ikatlong taon kasunod ng iyong pakakahirang. Maari kang manumpa sa iyong tungkulin sa harap ng Punong Barangay sa 
				<input type="text" id="recipient" name="recipient" required style="width: 20%; border: none; border-bottom: 1px solid black; margin-right: 0;">.
				</p><br><br><br><br>
				</div>

		
                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

    <div style="position: relative;"><br>

		<p style="text-align: center; margin-left: 570px; margin-right: auto;">Tapat na Sumasainyo, </p>
	<body>
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="pngbrgy" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none;" size="25">
	Kalihim ng Barangay
	</p>
    </div>
    </div>
    <div class="blank-page"></div>
    </body>
        </div><br><br><br><br><br> 
		


</body>
</html>	