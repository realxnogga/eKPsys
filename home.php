<?php
include 'connection.php';
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>

<title>Home</title>

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
</head>
<body>
    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">

                    <h3>Barangay Complaints</h3><br<br><hr>
                    <h2>Your files</h2>        
                    

                </div>
            </div>
        </div>

        <div class="rightcolumn">
            <div class="card">

                <h3>Add a complaint</h3><hr>
                <h2>KP Form 7</h2>        


 



</body>
</html>