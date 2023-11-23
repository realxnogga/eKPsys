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
                <h5>Pormularyo ng KP Blg. 5</h5>
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

               

                <h3 style="text-align: center;"><b>PANUNUMPA SA KATUNGKULAN</b></h3>

                <div style="text-align: left;">
				<p style="text-align: justify; font-size: 12px; text-indent: 1.5em;">Bilang pag-alinsunod sa Kabanata 7, Pamagat Isa, Aklat II, ng kodigo ng Pamahalaang Lokal ng 1991 (Batas ng Republika Blg. 7160), Ako si 

 <input type="text" id="recipient" name="recipient" list="nameList" required style="width: 20%; border: none; border-bottom: 1px solid black; margin-right: 0;">, na karapat-dapat at karampatang hinirang na KASAPI ng Lupong Tagapamayapa ng Barangay na ito, ay taimtim na nanunumpa (o naninindigan) na tutuparin ko nang buong husay at katapatan, sa abot aking kakayahan, ang aking mga tungkulin at gawain bilang kasapi  at bilang  kasapi ng  Pangkat  ng Tagapagsundo,  kung saan ako’y napili upang magligkod; na ako’y tunay na mananalig at magiging  matapat sa Republika ng Pilipinas; na aking itataguyod at ipagtatanggol ang Saligang Batas; at susunding ang mga batas, mga utos na ayon sa batas, at mga atas  na pinaiiral ng mga sadyang itinakdang may kapangyarihan nito; at kusang-loob kong babalikatin ang pananagutang ito nnang walang anumang pasubali o hangaring umiwas.
                </p>
   
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
        


                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

    <div style="position: relative;"><br>
		<p style="text-align: justify; text-indent: 1.5em;">
		  KASIHAN NAWA  AKO NG  DIYOS.  (Laktawan ang huling pangungusap kung naninindigan).</p>
    
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="pngbrgy" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none;" size="25">
	            <br> Kasapi
	</p>
	
	<form method="POST">
                    <p style="text-align: justify; text-indent: 1.5em;">
                       NILAGDAAN at PINANUMPAAN (o PINANININDIGAN) sa harap ko ngayong ika- 
                        <input type="text" id="day" name="day" required style="width:32px; height: 20px; size="1" required> araw ng 
                        <select name="month" required style="width: 93px; required>
                            <option value="">Pumili ng buwan</option>
                            <?php foreach ($months as $month): ?>
                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                            <?php endforeach; ?>
                        </select>,
                        20 <input type="text" name="year" required style="width: 25px; height: 20px; size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
                    </p>
                </form><br><br><br>
	
	
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value="<?= strtoupper($linkedNames['punong_barangay'] ?? 'Punong Barangay') ?>">
   <br> Punong Barangay
</p>

    </div>
    </div>
	
</body>
</html>	