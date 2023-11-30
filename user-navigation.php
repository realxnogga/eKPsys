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

                <h4><b>Menu</b></h4><br>
                    <li><a href="user_dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li><a href="user_lupon.php"><i class="fa fa-users"></i> Lupon</a></li>

                    <li><a href="user_complaints.php"><i class="fa fa-bullhorn"></i> Complaints</a></li>
                    <li><a href="user_archives.php"><i class="fa fa-folder-open"></i> Archives</a></li>

                    <li><a href="report.php"><i class="fa fa-files-o"></i> Reports</a></li><br><br><br>
                    <li><a href="user-settings.php"><i class="fa fa-wrench"></i> Settings</a>
                    <li><a href="lupon.php"><i class="fa fa-question-circle"></i> Help Center</a>
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