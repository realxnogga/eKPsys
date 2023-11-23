<div class="sidebar">

<ul class="list-group">
<br><br><br>

<div class="welcome-container">
<?php
    // Display the user's username here
    $fname = $_SESSION['first_name'];
    $lname = $_SESSION['last_name'];
    echo "<h2><b>Welcome,</b></h2>";
?>
</div>

<div class="name-container">
<?php
    echo "<h2><b>$fname $lname</b></h2>";
?>
</div>


<br>

<br><br>

    <h4><b>Menu</b></h4><br>
        <li><a href="user_dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
        <li><a href="acc-req.php"><i class="fa fa-users" style="font-size: 14px;"></i> Account Requests</a></li>
        <li><a href="sec-corner.php"><i class="fa fa-user-check" style="font-size: 13px;"></i> Secretaries Corner</a></li><br><br><br>
        <li><a href="#"><i class="fa fa-wrench"></i> Settings</a>
        <li><a href="#"><i class="fa fa-question-circle"></i> Help Center</a>
</ul>
</div>

<div class="content">
<div class="navbar">
    <div class="logo">
        <img src="img copy/dilg-logo.png" alt="Logo">
    </div>
    <ul>
    <li>
<a href="#" style="position: relative; display: inline-block;">
<i class="fa fa-bell"></i> 
</a>
</li>

        <li>
<a href="#" style="position: relative; display: inline-block;">
<i class="fa fa-clock-o"></i> 
</a>
</li>

<li>
<a href="logout.php" style="position: relative; display: inline-block;">
<i class="fa fa-share-square-o"></i> 
<span></span> 
</a>
</li>
    </ul>
</div>