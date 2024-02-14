<div class="sidebar">

            <ul class="list-group">
            <br><br><br>

            <div class="welcome-container">
            <?php
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

                <h4><b>Menu</b></h4><br><br>
                    <li><a href="user_dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li><a href="user_lupon.php"><i class="fa fa-users"></i> Lupon</a></li>

                    <li><a href="user_complaints.php"><i class="fa fa-bullhorn"></i> Complaints</a></li>
                    <li><a href="user_archives.php"><i class="fa fa-folder-open"></i> Archives</a></li>

                    <li><a href="report.php"><i class="fa fa-files-o"></i> Reports</a></li>
                    

                    <li><a href="user-settings.php"><i class="fa fa-wrench"></i> Settings</a>

                    <li><a href="user_logs.php"><i class="fa fa-list"></i> User Logs</a></li>

            </ul>
        </div>
        
        <div class="content">
            <div class="navbar">
                <div class="logo">
                    <img src="img/dilg-banner.png" alt="Logo">
                </div>
                <ul>
             

<li>

  <a href="logout.php" style="position: relative; display: inline-block;">
    <i class="fa fa-share-square-o"></i> 
    <span></span> 
  </a>
</li>
                </ul>
            </div>