<?php
session_start();
$linkedNames = $_SESSION['linkedNames'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>kp_form20b</title>
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
                <h5>KP Form No. 20 - B</h5>
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

                <h3 style="text-align: center;"><b>CERTIFICATION TO FILE ACTION </b></h3>
        <div style="text-align: left;">
            <p style="text-align: justify; margin-top: 0;">This is to certify that:</p>
            <!-- <p style="text-align: justify; text-indent: 1.5em;">1. There has been a personal confrontation between the parties before the Punong Barangay/Pangkat ng Tagapagkasundo; </p> -->
                    <div class="form" style="text-align: left;">
    <div class="checkbox" style="text-align: left;text-indent: 1.5em;">
        <input type="checkbox" id="checkbox1" name="confrontationCheckbox">
        <label for="checkbox1"style="text-indent: 0em; margin-left: 2px;">
     1. There was a personal confrontation between the parties before the Punong Barangay but mediation failed;

    </p></div>
</div>
            <div class="form" style="text-align: left;">
    <div class="checkbox" style="text-align: left;text-indent: 1.5em;">
        <input type="checkbox" id="checkbox1" name="confrontationCheckbox">
        <label for="checkbox1"style="text-indent: 0em; margin-left: 2px;">
        2. The Punong Barangay set the meeting of the parties for the constitution of the Pangkat;

    </p>
</div>
                    <div class="form" style="text-align: left;">
    <div class="checkbox" style="text-align: left;text-indent: 1.5em;">
        <input type="checkbox" id="checkbox1" name="confrontationCheckbox">
        <label for="checkbox1"style="text-indent: 0em; margin-left: 2px;">3. The respondent willfully failed or refused to appear without justifiable reason at the conciliation proceedings before the
Pangkat; and
</p>
</div>
 <p style="text-align: justify; text-indent: 0em; margin-left: 38px;">4. Therefore, the corresponding complaint for the dispute may now be filed in court/government office.</p>

            

            <div style="text-align: justify; text-indent: 0em; margin-left: 38.5px;"> This <input type="text" name="day" placeholder="day" size="1" required>  of
                <select name="month" required>
                    <option value="">Select Month</option>
                    <?php foreach ($months as $month): ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php endforeach; ?>
                </select>,
                20
                <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>
              
            </p>

        </form>
</div>

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <div style="position: relative;"><br>
    <style>
        #canvas {
            border: 1px solid lightgray;
            float: right;
        }
        #canvas1{
           border: 1px solid lightgray;
            float: left;  
        }
    </style>
  <canvas id="canvas" width="190" height="80"></canvas>

    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
    <input type="text" id="luponSec"  name="luponSec" style="text-align: center;style="border: none; border-bottom: 1px solid black; outline: none; size="25">
    Pangkat Secretary
    </p>
    <br>
</div>
</p>
<br>
    <p style="text-align: justify; margin-top: 0;">
        ATTESTED:</p>
    <br>
    <br>
    <div style="position: relative; text-align: left;"><br>
  
  <canvas id="canvas1" width="190" height="80"></canvas>
    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-right: 570px; margin-left: auto;">
    <input type="text" id="luponChair" name="luponChair" style="text-align: center;style="border: none; border-bottom: 1px solid black; outline: none;size="25">
    Pangkat Chairman
    </p>
<br>
   <br>
<br>
<br>
<br>
</div>
</div>
                </div>
            </div>
        </div><br>
       
    </div>
<br><!-- New arrow buttons -->
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
  </body>
</html>