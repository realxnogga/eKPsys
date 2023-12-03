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

body, html {
    margin: 0;
    padding: 0;
    height: 100%;
}

.card {
    height: 75vh; /* Set the height to 100% of the viewport height */
    overflow: auto;
    padding-bottom: 20px; /* Add some padding to the bottom */
    transition: height 0.3s ease; /* Add a smooth transition effect for height changes */
}

@media screen and (min-resolution: 192dpi), screen and (min-resolution: 2dppx) {
    /* Adjust for high-density (Retina) displays */
    .card {
        height: 50vh;
    }
}

@media screen and (max-width: 1200px) {
    /* Adjust for window resolution 125% scaling */
    .card {
        height: 80vh;
    }
}

@media screen and (max-width: 960px) {
    /* Adjust for window resolution 150% scaling */
    .card {
        height: 66.67vh;
    }
}


    .form-group {
        margin-bottom: 1px;
        }

    .form-control-label {
        font-weight: bold;
    }

        input[type="text"],
        input[type="datetime-local"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 auto; /* Center the submit button */
    display: block; /* Ensure it takes up full width */
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Center align the submit button */
.row.justify-content-end {
    display: flex;
    justify-content: center;
}

.form-group.col-sm-2 {
    text-align: center;
    margin-right: 190px; /* Add some top margin for better spacing */
}

</style>

<body>

<div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">
                <h3>Barangay Lupon</h3><br<br><hr>
                    <h2>...</h2>   
                    

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
            Punong Barangay: <input type="text" name="punong_barangay" class='lupon-input' value="<?= strtoupper($linkedNames['punong_barangay'] ?? '') ?>">
        </div>

         <!-- Input for Lupon Chairman -->
         <div>
            Lupon Chairman: <input type="text" name="lupon_chairman" class='lupon-input' value="<?= strtoupper($linkedNames['lupon_chairman'] ?? '') ?>">
        </div>
        <div>
                <button type="submit" id="save-button" name="save">Save</button>
                <button type="button" id="clear-button" name="clear">Clear All</button>
            </div>
        </form>






                    

                </div>
            </div>
        </div>

        <div class="rightcolumn">
            <div class="card">

            <h3>KP Forms</h3><br<br><hr>
                    <h2>1-6</h2>        
                    
                    <br>
                    <button id="englishforms" class="btn btn-dark">English</button>
                    <button id="tagalogforms" class="btn btn-light">Tagalog</button><br><br>

                    <button id="open-kp-form1" class="one-button"><i class="fas fa-file-alt"></i> KP 1</button>
                    <button id="open-kp-form2" class="one-button"><i class="fas fa-file-alt"></i> KP 2</button>
                    <button id="open-kp-form3" class="one-button"><i class="fas fa-file-alt"></i> KP 3</button>
                    <button id="open-kp-form4" class="one-button"><i class="fas fa-file-alt"></i> KP 4</button>
                    <button id="open-kp-form5" class="one-button"><i class="fas fa-file-alt"></i> KP 5</button>
                    <button id="open-kp-form6" class="one-button"><i class="fas fa-file-alt"></i> KP 6</button>


                    <div id="kp-form-modal" class="modal">
                        <iframe id="kp-form-iframe" class="kp-form-iframe" src="" sandbox="allow-same-origin allow-scripts allow-modals"></iframe>
                    </div>

                    <script>
    document.getElementById('englishforms').addEventListener('click', function() {
    // Change the English button color to dark brown
    this.classList.remove('btn-light');
    this.classList.add('btn-dark');

    // Change the Tagalog button color to light brown
    document.getElementById('tagalogforms').classList.remove('btn-dark');
    document.getElementById('tagalogforms').classList.add('btn-light');
});

document.getElementById('tagalogforms').addEventListener('click', function() {
    // Change the Tagalog button color to dark brown
    this.classList.remove('btn-light');
    this.classList.add('btn-dark');

    // Change the English button color to light brown
    document.getElementById('englishforms').classList.remove('btn-dark');
    document.getElementById('englishforms').classList.add('btn-light');
  
});
</script>    


<script src="lupon_script.js"></script>


            </div>
        </div>
    </div>




<script>

const card = document.querySelector('.card');

function adjustCardHeight() {
    const isFullscreen = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement;

    if (isFullscreen) {
        card.style.height = '100vh'; // Set height to 100% of the viewport height in fullscreen
    } else {
        card.style.height = '75vh'; // Set the initial height when exiting fullscreen
    }
}

document.addEventListener('fullscreenchange', adjustCardHeight);
document.addEventListener('webkitfullscreenchange', adjustCardHeight);
document.addEventListener('mozfullscreenchange', adjustCardHeight);
document.addEventListener('MSFullscreenChange', adjustCardHeight);

</script>



</body>
</html>
