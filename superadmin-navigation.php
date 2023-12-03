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
                    <li><a href="superadmin_dashboard.php"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="registeredMuni.php"><i class="fa-solid fa-landmark"></i> Registered Municipalities</a></li>
                    <li><a href="sa_reports.php"><i class="fa fa-file-alt fa-lg"></i> Reports</a></li>
                    <!-- <li><a href="user_lupon.php"><i class="fa fa-users"></i> Lupon</a></li><br><br><br> -->
                    <li><a href="user-settings.php"><i class="fa fa-wrench"></i> Settings</a>
            </ul>
        </div>
        
        <div class="content">
            <div class="navbar">
                <div class="logo">
                    <img src="img/dilg-banner.png" alt="Logo">
                </div>
                <ul>
                <li>
<li>
  <a href="logout.php" style="position: relative; display: inline-block;">
    <i class="fa fa-share-square-o"></i> 
    <span></span> 
  </a>
</li>
                </ul>
            </div>