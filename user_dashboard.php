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

</head>
<hr><br>

<body>

<div class="columns-container">
    <div class="left-column">
        <div class="card">
        <h4><b>Dashboard</b></h4>





        </div>
    </div>
</div>

    
</body>
</html>
