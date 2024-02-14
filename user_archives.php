<?php
session_start();
include 'connection.php';
include 'index-navigation.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Retrieve user-specific archived complaints from the database
$userID = $_SESSION['user_id'];
$query = "SELECT * FROM complaints WHERE UserID = '$userID' AND IsArchived = 1";
$result = $conn->query($query);

// Handle unarchiving of complaints
if (isset($_GET['unarchive_id'])) {
    $unarchiveID = $_GET['unarchive_id'];
    
    // Update the complaint's IsArchived status to unarchive it
    $unarchiveQuery = "UPDATE complaints SET IsArchived = 0 WHERE id = '$unarchiveID'";
    $conn->query($unarchiveQuery);
    
    // Redirect back to the user_archives.php page after unarchiving
    header("Location: user_archives.php");
    exit;
}


include 'count_lupon.php';

include 'report_handler.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Archives</title>
    <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />

</head>

<body style="background-color: #eeeef6">


<div class="container-fluid">
<a href="user_dashboard.php" class="btn btn-outline-dark m-1">Back to Dashboard</a>
<br><br>

        <!--  Row 1 -->
            <div class="card">
              <div class="card-body">
                    
                  <div class="d-flex align-items-center">
    <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
    <div>
        <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
    </div></div>    
    <br>   

                     <h5 class="card-title mb-9 fw-semibold">Barangay Complaint Archives</h5><hr>
                   <b>  
 <br>
                   <form method="GET" action="" class="searchInput">
    <div style="display: flex; align-items: center;">
        <input type="text" class="form-control" name="search" id="search" placeholder="Search by Case No., Title, Complainants, or Respondents" class="searchInput" style="flex: 1; margin-right: 5px;">
        <input type="button" class="btn btn-dark m-1" value="Search" onclick="location.href='user_complaints.php';" class="refresh-button">
    </div>
</form>

  
<table class="table table-striped">
                    <thead class="thead-dark">
            <tr>
            <th style="width: 10%">No.</th>
            <th style="width: 10%">Title</th>
            <th style="width: 10%">Complainants</th>
            <th style="width: 10%">Respondents</th>
            <th style="width: 10%">Date</th>
            <th style="width: 10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['CNum'] . "</td>";
                echo "<td>" . $row['ForTitle'] . "</td>";
                echo "<td>" . $row['CNames'] . "</td>";
                echo "<td>" . $row['RspndtNames'] . "</td>";
                echo "<td>" . date('Y-m-d', strtotime($row['Mdate'])) . "</td>";
                echo "<td>";
                echo '<a href="unarchive_complaint.php?unarchive_id=' . $row['id'] . '" class="btn btn-sm btn-danger"><i class="fa fa-file-o"></i> Unarchive</a>';
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
      
    </div></div>
      

              </div>

              
            </div>
          </div></b>
                    
          </div>
        </div>
       
       
          
    </div>
  </div>

</body>

</html>
