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
        .card {
            height: 700px; /* Set a fixed height for the card */
            overflow: auto; /* Enable scrolling within the fixed height */
        }

    </style>
</head>
<body>
    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">

                    <h3>Summary</h3><br<br><hr>
                    <h2>Monthly Report (<?php echo isset($selected_month) ? $selected_month : date('F, Y'); ?>)</h2>

                    
                    

                </div>
            </div>
        </div>

        <div class="rightcolumn">
            <div class="card">

                <h3>Updates</h3><hr>
                
            </div>
        </div>
    </div>
</body>
</html>
