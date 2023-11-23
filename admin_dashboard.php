<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'admin_func.php';   
include 'admin-nav.php';
include 'functions.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">

    
</head>
<hr><br>
<body>
<div class="columns-container">
    <div class="left-column">
        <div class="card">
        <h4><b>Dashboard</b></h4><br>




</div>
</div>
</div>
</body>
</html>

<script src="populateBrgyscript.js"></script>