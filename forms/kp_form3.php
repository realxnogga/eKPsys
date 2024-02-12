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
                <h5>KP Form No. 3</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
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

                <h3 style="text-align: center;"><b>NOTICE OF APPOINTMENT</b></h3>

                <div style="text-align: left;">
<br><br><br>				
<input type="text" id="recipient" name="recipient" list="nameList" required style="width:250px; height: 20px; border: none;  font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none; size= 1;"></p>
<input type="text" id="recipient" name="recipient" list="nameList" required style="width:250px;  height: 20px; border: none;  font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none; size= 1;"></p>
<input type="text" id="recipient" name="recipient" list="nameList" required style="width:250px; height: 20px; border: none;  font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none; size= 1;"></p>


    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>


				<br><p style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif;">Sir/Madam: </p>
				<p style="text-align: justify; font-size: 18px; text-indent: 1.5em; font-family: 'Times New Roman', Times, serif;">Please be informed that you have been appointed by the Punong Barangay as a MEMBER OF THE LUPONG TAGAPAMAYAPA,
					effective upon taking your oath of office, and until a new Lupon is constituted on the third year following your appointment. You may
					take your oath of office before the Punong Barangay on
				<input type="text" id="recipient" name="recipient" required style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif; width: 20%; border: none; border-bottom: 1px solid black; margin-right: 0;">.
				</p><br><br><br><br>
				</div>

			<script>
				function resetFields() {
				// Clear the value of the day input field
			document.getElementById('day').value = "";
        
				// Get all input elements within the specified div
			var inputs = document.querySelectorAll('.paper div[style="display: flex;"] input[type="text"]');
        
				// Clear the value of each input field
				inputs.forEach(function(input) {
            input.value = "";
				});
			}
			</script>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

    <div style="position: relative;"><br>

		<p style="text-align: center; margin-left: 470px; margin-right: auto;  font-size: 18px; font-family: 'Times New Roman', Times, serif;">Very truly yours, </p>
	<body>
    <p class="important-warning-text" style="text-align: center; font-size: 18px; margin-left: 470px; margin-right: auto;">
    <input type="text" id="pngbrgy" name="pngbrgy" style="border: none;  font-size: 18px; font-family: 'Times New Roman', Times, serif; border-bottom: 1px solid black; outline: none;" size="25">
	Barangay Secretary
	</p>
    </div>
    </div>

    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: relative; right: -980px; top: -850px;">
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
 
        <script>
document.getElementById('downloadButton').addEventListener('click', function () {
    var buttonsToHide = document.querySelectorAll('.top-right-buttons button');
    var saveButton = document.querySelector('input[name="saveForm"]');
    var inputFields = document.querySelectorAll('input[type="text"], input[type="number"], select');
    var pdfContent = document.querySelector('.paper');

    // Hide buttons and remove borders for download
    buttonsToHide.forEach(function (button) { button.style.visibility = 'hidden'; });
    saveButton.style.visibility = 'hidden';
    inputFields.forEach(function (field) { field.style.border = 'none'; });

    // Generate PDF and initiate a download
    html2pdf().from(pdfContent).set({
        margin: 10,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, logging: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    }).save().then(function () {
        // PDF download initiated
    }).catch(function (error) {
        // Handle any errors that occurred during PDF generation
        console.error('Failed to generate PDF: ', error);
    }).finally(function() {
        // Make sure buttons are shown again after PDF generation
        buttonsToHide.forEach(function (button) { button.style.visibility = 'visible'; });
        saveButton.style.visibility = 'visible';
        inputFields.forEach(function (field) { field.style.border = '1px solid #ccc'; }); // Or whatever your default style is
    });
});

    </script>
</div>        
</div>
</body>
</html>