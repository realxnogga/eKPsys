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
                <h5>KP Form No. 7</h5>
                <h5 style="text-align: center;">Republic of the Philippines</h5>
                <h5 style="text-align: center;">Province of Laguna</h5>
                <h5 style="text-align: center;">CITY/MUNICIPALITY OF <?php echo $_SESSION['municipality_name']; ?></h5>
                <h5 style="text-align: center;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
                <h5 style="text-align: center;">OFFICE OF THE PUNONG BARANGAY</h5>
            </div>
                <?php
                $months = [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                $currentYear = date('Y');
                ?>
   
                
    <form method="post" action="<?php ($_SERVER["PHP_SELF"]);?>"> 

    <div class="form-group" style="text-align: right;">

        <div class="input-field"> 
            <!-- case num here -->
            Barangay Case No.<input type="text" name="barangayCaseNo" pattern="\d{3}-\d{3}-\d{4}" maxlength="15" placeholder="Case No. - Blotter No. - MMYY" style="width: 30%;"
            value="<?php echo $cNum; ?>"> <br><br> <p>For: 
                <!-- ForTitle here -->
                 <input type="text" name="for" id="for" size="30" value="<?php echo $forTitle; ?>"> <br> 
        </div>
    </div>

    <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
        <div class="label"></div>
        <div class="input-field">
            <p> Complainants:
                <!-- CNames here -->
                <br><input type="text" name="complainant" id="complainant" size="30" value="<?php echo $cNames; ?>"><br> </p>
        <br><p> — against —</p>
    </div>
    </div>

    <div>
    <div class="form-group" style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">
        <div class="label"></div>
        <div class="input-field">
            <p> Respondents:<br>
                <!-- RspndtNames here -->
                <input type="text" name="respondent" id="respondent" size="30" value="<?php echo $rspndtNames; ?>"><br> </p>
        </div>
    </div>

       

                    <h3 style="text-align: center;"><b>COMPLAINT</b></h3>

                    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> 
                    <p>I/WE hereby complain against above named respondent/s for violating my/our rights and interests in the following manner: <input type="text" id="complain" name="complain" style="text-align: left;" size="110" value="<?php echo $cDesc; ?>"></p>
                    <p>THEREFORE, I/WE pray that the following relief/s be granted to me/us in accordance with law and/or equity: <input type="text" id="petition" name="petition" style="text-align: left;" size="110" value="<?php echo $petition; ?>"></p>
                    </div>

                <form method="POST">
                    <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;">Made this 
    <!-- MDate 'day' here -->
    <input type="text" name="day" placeholder="day" size="6" required value="<?php echo $day; ?>"> of
    <!-- Change this to input type and MDate 'month' here  -->
        <select name="month" required style="width: 70px;">
        <option value="">Select Month</option>
        <?php foreach ($months as $m): ?>
            <option value="<?php echo $m; ?>" <?php echo ($m === $month) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endforeach; ?>
    </select>,
    <!-- MDate Year here, change the input type code to much necessary -->
    <input type="text" name="year" placeholder="year" size="1" value="<?php echo $year; ?>" pattern="[0-9]{2}" required>.
</div>

           <div style="position: relative;">
                        <br>
                        <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">
                        <!-- CName here but All Capital Letters -->
                        <input type="text" id="cmplnts" name="cmplnts" size="25" value="<?php echo $cNames; ?>" style="text-align: center;">Complainant/s</p>
            </div>
           
            <div style="text-align: justify; text-indent: 0em; margin-left: 20.5px;"> Received and filed this <input type="text" name="day" placeholder="day" size="6" required>  of
                    <select name="month" required>
                        <option value="">Select Month</option>
                        <?php foreach ($months as $month): ?>
                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                        <?php endforeach; ?>
                    </select>,
                    20
                    <input type="text" name="year" placeholder="year" size="1" value="<?php echo substr($currentYear, -2); ?>" pattern="[0-9]{2}" required>.
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

    <script src="signature.js"></script>

                    <p class="important-warning-text" style="text-align: center; font-size: 12px; margin-left: 570px; margin-right: auto;">_____________________<input type="text" id="pngbrgy" name="pngbrgy" size="25" value="<?php echo $punong_barangay; ?>" style="text-align: center;">
                    Punong Barangay</p>
                </div>
            </div>
        </div> <br>
   </div>     


    </body>
<div class="blank-page">        
       
</div> 
</html>
