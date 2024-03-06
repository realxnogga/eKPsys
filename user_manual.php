<?php
session_start();
include 'connection.php';
include 'index-navigation.php';
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Manual</title>
    <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<style>
    .card {
        box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
        border-radius: 15px;
    }
</style>
</head>

<body style="background-color: #E8E8E7">

<div class="container-fluid">
    <a href="user_dashboard.php" class="btn btn-dark m-1">Back to Dashboard</a>
    <br><br>

    <div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
            <div>
                <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
            </div>
        </div>    
        <br>   
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1">Register/Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#content2">User Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content3">Lupon</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab4" data-bs-toggle="tab" href="#content4">Complaints</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab5" data-bs-toggle="tab" href="#content5">Archives</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab6" data-bs-toggle="tab" href="#content6">Reports</a>
            </li>
        </ul>
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="content1">
                <h5 class="card-title mb-9 fw-semibold">User Manual - Tab 1 Content</h5>
                <!-- Add your tab content here -->
            </div>
            <div class="tab-pane fade" id="content2">
                <h5 class="card-title mb-9 fw-semibold">User Manual - Tab 2 Content</h5>
                <!-- Add your tab content here -->
            </div>
            <div class="tab-pane fade" id="content3">
                <h5 class="card-title mb-9 fw-semibold">User Manual - Tab 3 Content</h5>
                <!-- Add your tab content here -->
            </div>
            <div class="tab-pane fade" id="content4">
                <h5 class="card-title mb-9 fw-semibold">User Manual - Tab 4 Content</h5>
                <!-- Add your tab content here -->
            </div>
            <div class="tab-pane fade" id="content5">
                <h5 class="card-title mb-9 fw-semibold">User Manual - Tab 5 Content</h5>
                <!-- Add your tab content here -->
            </div>
            <div class="tab-pane fade" id="content6">
                <h5 class="card-title mb-9 fw-semibold">User Manual - Tab 6 Content</h5>
                <!-- Add your tab content here -->
            </div>
        </div>
    </div>
</div>


</body>
</html>
