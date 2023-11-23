<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';



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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Archived Barangay Complaints</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">

   
</head>
<hr><br>
<body>
<div class="columns-container">
    <div class="left-column">
        <div class="card">
        <h4><b>Archived Barangay Complaints</b></h4>

        <br>

        <form method="GET" action="" class="searchInput">
    <input type="text" name="search" id="search" placeholder="Search by Case No., Title, Complainants, or Respondents" class="searchInput">
    <input type="button" value="Search" onclick="location.href='user_complaints.php';" class="refresh-button">
</form>

        <table>
        <thead>
            <tr>
                <th>Case No.</th>
                <th>Title</th>
                <th>Complainants</th>
                <th>Respondents</th>
                <th>Date Made</th>
                <th>Actions</th>
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
                echo "<td>" . $row['Mdate'] . "</td>";
                echo "<td>";
                echo '<a href="unarchive_complaint.php?unarchive_id=' . $row['id'] . '" class="unarchive-button"><i class="fa fa-file-o"></i> Unarchive</a>';
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>


      

        </div>
    </div>
</div>
</body>
</html>
