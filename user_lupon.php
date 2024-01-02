<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

include 'lupon_handler.php';


?>
<!DOCTYPE html>
<html>
<head>
    <title>Barangay Lupon</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
</head>
<style>
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); /* Dark overlay background */
}

/* CSS for the iframe container */
.kp-form-iframe {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 1000px; /* Adjust the width as needed */
    height: 800px; /* Adjust the height as needed */
    background-color: white;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

.card {
    height: 75vh; /* Set the height to 100% of the viewport height */
    overflow: auto;
    padding-bottom: 20px; /* Add some padding to the bottom */
    transition: height 0.3s ease; /* Add a smooth transition effect for height changes */
}

input {
    width: 240px;
}
</style>
<body>
<div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">
                <h3>Barangay Lupon</h3><br><br><hr>

<form method="post">
        <div class="column">
    <!-- Input boxes for names with numbers (01-05) -->
    <?php
    for ($i = 1; $i <= 5; $i++) {
        $iFormatted = str_pad($i, 2, '0', STR_PAD_LEFT); // Add leading 0
        $nameKey = "name$i";
        $nameValue = $linkedNames[$nameKey] ?? '';
        echo "<div>$iFormatted. <input type='text' name='linked_name[]' class='lupon-input' value='$nameValue' placeholder='Name $iFormatted'></div>";
    }
    ?>
</div>

<div class="column">
    <!-- Input boxes for names with numbers (06-10) -->
    <?php
    for ($i = 6; $i <= 10; $i++) {
        $iFormatted = str_pad($i, 2, '0', STR_PAD_LEFT); // Add leading 0
        $nameKey = "name$i";
        $nameValue = $linkedNames[$nameKey] ?? '';
        echo "<div>$iFormatted. <input type='text' name='linked_name[]' class='lupon-input' value='$nameValue' placeholder='Name $iFormatted'></div>";
    }
    ?>
</div>

<div class="column">
    <!-- Input boxes for names with numbers (11-15) -->
    <?php
    for ($i = 11; $i <= 15; $i++) {
        $iFormatted = str_pad($i, 2, '0', STR_PAD_LEFT); // Add leading 0
        $nameKey = "name$i";
        $nameValue = $linkedNames[$nameKey] ?? '';
        echo "<div>$iFormatted. <input type='text' name='linked_name[]' class='lupon-input' value='$nameValue' placeholder='Name $iFormatted'></div>";
    }
    ?>
</div>

<div class="column">
    <!-- Input boxes for names with numbers (16-20) -->
    <?php
    for ($i = 16; $i <= 20; $i++) {
        $iFormatted = str_pad($i, 2, '0', STR_PAD_LEFT); // Add leading 0
        $nameKey = "name$i";
        $nameValue = $linkedNames[$nameKey] ?? '';
        echo "<div>$iFormatted. <input type='text' name='linked_name[]' class='lupon-input' value='$nameValue' placeholder='Name $iFormatted'></div>";
    }
    ?>
</div>

        <div>
 <input type="text" name="punong_barangay" class='lupon-input' value="<?= strtoupper($linkedNames['punong_barangay'] ?? '') ?>">
            Punong Barangay
        </div>

         <!-- Input for Lupon Chairman -->
         <div>
             <input type="text" name="lupon_chairman" class='lupon-input' value="<?= strtoupper($linkedNames['lupon_chairman'] ?? '') ?>">
            Lupon Chairman
        </div>
        <div>
                <button type="submit" id="save-button" name="save">Appoint</button>
                <button type="submit" id="save-button" name="appoint">Notice</button>

                <button type="button" id="clear-button" name="clear">Clear All</button>
            </div>
        </form>

         </div>
            </div>
        </div>

        <div class="rightcolumn">
            <div class="card">

            <h3>KP Forms</h3><br><br><hr>
                    <h2>1-6</h2>        
                    
                    <br>

                    <button id="open-kp-form1" class="one-button"><i class="fas fa-file-alt"></i> KP 1</button>
                    <button id="open-kp-form2" class="one-button"><i class="fas fa-file-alt"></i> KP 2</button>
                    <button id="open-kp-form3" class="one-button"><i class="fas fa-file-alt"></i> KP 3</button>
                    <button id="open-kp-form4" class="one-button"><i class="fas fa-file-alt"></i> KP 4</button>
                    <button id="open-kp-form5" class="one-button"><i class="fas fa-file-alt"></i> KP 5</button>
                    <button id="open-kp-form6" class="one-button"><i class="fas fa-file-alt"></i> KP 6</button>

                    <div id="kp-form-modal" class="modal">
                        <iframe id="kp-form-iframe" class="kp-form-iframe" src="" sandbox="allow-same-origin allow-scripts allow-modals"></iframe>
                    </div>
<script src="lupon_script.js"></script>
            </div>
        </div>
    </div>
</body>
</html>
