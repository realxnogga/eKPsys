<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
    <style>
        
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
</head>
<body>
    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">


    <br>

            

                </div>
            </div>
        </div>

        <div class="rightcolumn">
            <div class="card">




        
        



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