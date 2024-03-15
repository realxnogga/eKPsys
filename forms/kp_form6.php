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
               
            </div>
            
			
            <div style="text-align: left;">
                <h5>KP Form No. 6</h5>
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

                <h3 style="text-align: center;"><b>WITHDRAWAL OF APPOINTMENT</b></h3>

                <div style="text-align: left;">
				<br><p style="text-align: justify; font-size: 12px; margin-top: 0;">TO:
    <input type="text" id="recipient" name="recipient" list="nameList" required style="width:200px; height: 20px;">
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
</p>
				<p style="text-align: justify; font-size: 12px; text-indent: 1.5em;">After due hearing and with the concurrence of a majority of
				all the <i>Lupong Tagapamayapa</i> members of this Barangay, your appointment as member thereof is hereby withdrawn effective upon receipt
				hereof, on the following ground/s: </p>
				
				<!-- Use PHP to set the checkbox status based on some condition -->
        <?php
            $isChecked = false; // Replace this with your own condition to determine if the checkbox should be checked or not
        ?>
        <!-- Create the checkbox with PHP -->
        <input type="checkbox" name="my_checkbox" <?php if ($isChecked) echo "checked"; ?>>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		incapacity to discharge the duties of your office as shown by
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
		unsuitability by reason of <input type="text" id="day" name="day" required style="width:330px; height: 20px; size="1" required>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(Check whichever is applicable and detail or specify the act/s or
		omission/s constituting
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		the ground/s for withdrawal.)<br><br><br>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

    <div style="position: relative;">
    <style>
        #canvas {
            border: 1px solid lightgray;
            float: right;
            
        }
		
		#canvas1 {
            border: 1px solid lightgray;
            float: right;
            
        }
    </style>
	<body>
    <canvas id="canvas" width="190" height="80"></canvas>
    <script src="signature.js"></script>
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 12px;" size="25" value="<?= strtoupper($linkedNames['punong_barangay'] ?? 'Punong Barangay') ?>">
    Punong Barangay/Lupon Chairman
</p>

<script>
    // Function to select the text when clicked
    const positionInput = document.getElementById('positionInput');
    positionInput.addEventListener('click', function() {
        this.select();
    });
</script><br><br>
			<p style="text-align: justify; text-indent: 4em;">CONFORME (Signatures): </p>
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
			
			<form method="POST">
			 <p style="text-align: justify; text-indent: 4em;">
                    Received this
                    <input type="text" id="day" name="day" required style="width:32px; height: 20px; size="1" required>
					day of <select name="month" required style="width: 93px; required>
                            <option value="">Select Month</option>
                            <?php foreach ($months as $month): ?>
                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                            <?php endforeach; ?>
                        </select>,
                        20
                        <input type="text" name="year" required style="width: 25px; height: 20px; size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
                    </p>
                </form>
	
	<canvas id="canvas1" width="190" height="80" style="float: right";></canvas>
    <script src="signature.js"></script>
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="pngbrgy" name="pngbrgy" style="border: none; border-bottom: 1px solid black; outline: none;" size="25">
	Signature
	</p><br><br><br><br><br><br>
	<p style="text-align: justify; font-size: 12px; margin-top: 0;"> NOTE:
	<p style="text-align: justify; font-size: 12px; text-indent: 1.5em;">The members of the <i>Lupon</i> conforming to the withdrawal must personally affix their signatures or thumb marks on the pertinent spaces above.
	The withdrawal must be conformed to by more than one-half of the total number of members of the <i>Lupon</i> including the Punong Barangay and the member concerned.</p>
	
    <div class="blank-page"></div>
    </body>
        </div><br><br><br><br><br><br><br><br>
		
		<!-- New arrow buttons -->
		<div style="position: fixed; bottom: 20px; right: 20px; display: flex; flex-direction: column;">
        <!-- Button to go to the top of the form -->
        <button class="btn btn-dark arrow-button" onclick="goToTop()">
            <i class="fas fa-arrow-up"></i>
        </button>
        <!-- Button to go to the bottom of the form -->
        <button class="btn btn-secondary arrow-button" onclick="goToBottom()">
            <i class="fas fa-arrow-down"></i>
        </button>
		</div>
		<script>
        // Function to scroll to the top of the form
        function goToTop() {
            window.scrollTo(0, 0);
        }
        
        // Function to scroll to the bottom of the form
        function goToBottom() {
            window.scrollTo(0, document.body.scrollHeight);
        }
    </script>
	
	<script>
 document.addEventListener('DOMContentLoaded', function() {
        const recipientInput = document.getElementById('recipient');
        const nameList = document.getElementById('nameList'); // The datalist element
        const namesArray = <?php echo json_encode($linkedNames); ?>; // Your PHP array of names
        
        // Function to update the datalist with matching names
        function updateNameList() {
            const inputValue = recipientInput.value.toLowerCase();
            nameList.innerHTML = ''; // Clear the existing options
            
            // Filter the names array for matches
            const matchingNames = namesArray.filter(name => name.toLowerCase().includes(inputValue));
            
            // Create and append options to the datalist
            matchingNames.forEach(name => {
                const option = document.createElement('option');
                option.value = name;
                nameList.appendChild(option);
            });
        }
        
        // Event listener for input changes
        recipientInput.addEventListener('input', updateNameList);
        
        // Trigger the update when the page loads
        updateNameList();
    });


        
    document.addEventListener("DOMContentLoaded", function() {
        // Get the canvas elements and buttons
        var canvas = document.getElementById("canvas");
        var canvas1 = document.getElementById("canvas1");
        var clearBtn = document.getElementById("clearBtn");
        var saveBtn = document.getElementById("saveBtn");
        var ctx = canvas.getContext("2d");
        var ctx1 = canvas1.getContext("2d");

        // Set initial drawing states
        var isDrawing = false;
        var isDrawing1 = false;

        // Set drawing styles
        ctx.lineWidth = 2;
        ctx.strokeStyle = "#000";
        ctx1.lineWidth = 2;
        ctx1.strokeStyle = "#000";

        // Function to start drawing
        function startDrawing(e) {
            if (e.target === canvas) {
                isDrawing = true;
                ctx.beginPath();
                ctx.moveTo(e.offsetX, e.offsetY);
            } else if (e.target === canvas1) {
                isDrawing1 = true;
                ctx1.beginPath();
                ctx1.moveTo(e.offsetX, e.offsetY);
            }
        }

        // Function to draw
        function draw(e) {
            if (isDrawing) {
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
            } else if (isDrawing1) {
                ctx1.lineTo(e.offsetX, e.offsetY);
                ctx1.stroke();
            }
        }

        // Function to stop drawing
        function stopDrawing() {
            isDrawing = false;
            isDrawing1 = false;
        }

        // Function to clear the canvases
        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx1.clearRect(0, 0, canvas1.width, canvas1.height);
        }

        // Function to save the signatures as images
        function saveSignature(canvas, fileName) {
            var imgData = canvas.toDataURL();
            var link = document.createElement("a");
            link.href = imgData;
            link.download = fileName;
            link.click();
        }

        // Event listeners for both canvases
        canvas.addEventListener("mousedown", startDrawing);
        canvas1.addEventListener("mousedown", startDrawing);

        canvas.addEventListener("mousemove", draw);
        canvas1.addEventListener("mousemove", draw);

        canvas.addEventListener("mouseup", stopDrawing);
        canvas1.addEventListener("mouseup", stopDrawing);

        canvas.addEventListener("mouseout", stopDrawing);
        canvas1.addEventListener("mouseout", stopDrawing);

        // Event listeners for buttons
        clearBtn.addEventListener("click", clearCanvas);

        saveBtn.addEventListener("click", function() {
            saveSignature(canvas, "signature.png");
            saveSignature(canvas1, "signature1.png");
        });
    });
</script>
	<div class="bottom-right-buttons">
             <button id="clearBtn"class="btn btn-danger clear-button">Clear signature</button></div><br><br>
</body>
</html>	