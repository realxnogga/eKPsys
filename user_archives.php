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


include 'count_lupon.php';

include 'report_handler.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Archived Barangay Complaints</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">

   <style>
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
}

.card {
    height: 75vh; /* Set the height to 100% of the viewport height */
    overflow: auto;
    padding-bottom: 20px; /* Add some padding to the bottom */
    transition: height 0.3s ease; /* Add a smooth transition effect for height changes */
}

@media screen and (min-resolution: 192dpi), screen and (min-resolution: 2dppx) {
    /* Adjust for high-density (Retina) displays */
    .card {
        height: 50vh;
    }
}

@media screen and (max-width: 1200px) {
    /* Adjust for window resolution 125% scaling */
    .card {
        height: 80vh;
    }
}

@media screen and (max-width: 960px) {
    /* Adjust for window resolution 150% scaling */
    .card {
        height: 66.67vh;
    }
}


    .form-group {
        margin-bottom: 1px;
        }

    .form-control-label {
        font-weight: bold;
    }

        input[type="text"],
        input[type="datetime-local"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 auto; /* Center the submit button */
    display: block; /* Ensure it takes up full width */
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Center align the submit button */
        .row.justify-content-end {
    display: flex;
    justify-content: center;
}

.form-group.col-sm-2 {
    text-align: center;
    margin-right: 190px; /* Add some top margin for better spacing */
}

</style>
</head>
<body>

<div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">

                    <h3>Barangay Archives</h3><br<br><hr>
                    <h2>Your files</h2><br>



        <table>
        <thead>
            <tr>
            <th style="width: 8%">Case No.</th>
            <th style="width: 15%">Title</th>
            <th style="width: 15%">Complainants</th>
            <th style="width: 15%">Respondents</th>
            <th style="width: 9%">Date Made</th>
            <th style="width: 11%">Actions</th>
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

<div class="rightcolumn">
            <div class="card">

            <h3>Shortcuts</h3><hr>
                <h2>Data Showing: All Barangay Cases</h2><br>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <!-- Add this inside the body, where you want the chart to appear -->

<!-- Add this inside the body, above the canvas and totalCases div -->
<div class="row">
    <div class="col-md-12">
        <h3 id="mayorName"></h3>
        <canvas id="casesChart" width="500" height="200"></canvas>
        <div id="totalCases" style="margin-top: 20px;"></div>

    </div>
</div>




<!-- Add this before the closing body tag -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the data for the chart
        var criminalCount = <?php echo $criminalCount; ?>;
        var civilCount = <?php echo $civilCount; ?>;
        var othersCount = <?php echo $othersCount; ?>;

        // Calculate total cases
        var totalCases = criminalCount + civilCount + othersCount;

        // Prepare data for the chart
        var data = {
            labels: ['Criminal', 'Civil', 'Others'],
            datasets: [{
                label: 'Number of Cases',
                data: [criminalCount, civilCount, othersCount],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Get the canvas element
        var ctx = document.getElementById('casesChart').getContext('2d');

        // Create the chart
        var casesChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Display total cases
        document.getElementById('totalCases').innerHTML = '<b>Total Cases:</b> ' + totalCases;
    });
</script>

<hr>


<!-- Add this inside the body, where you want the second chart to appear -->
<div class="row">
    <div class="col-md-12">
        <canvas id="unsetChart"></canvas>
    </div>
</div>

<!-- Add this before the closing body tag -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the data for the chart
        var pendingCount = <?php echo $pendingCount; ?>;
        var dismissedCount = <?php echo $dismissedCount; ?>;
        var repudiatedCount = <?php echo $repudiatedCount; ?>;
        var certifiedCount = <?php echo $certifiedCount; ?>;
        var droppedCount = <?php echo $droppedCount; ?>;
        var totalUnsetCount = <?php echo $totalUnsetCount; ?>;

        // Prepare data for the chart
        var unsetData = {
            labels: ['Pending', 'Dismissed', 'Repudiated', 'Certified to Court', 'Dropped/Withdrawn'],
            datasets: [{
                label: 'Number of Cases',
                data: [pendingCount, dismissedCount, repudiatedCount, certifiedCount, droppedCount],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        };

        // Get the canvas element for the second chart
        var unsetCtx = document.getElementById('unsetChart').getContext('2d');

        // Create the chart for the second set of data
        var unsetChart = new Chart(unsetCtx, {
            type: 'bar',
            data: unsetData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Display the total outside the chart
        var totalContainer = document.getElementById('totalUnset');
        totalContainer.innerHTML = 'Total: ' + totalUnsetCount;
    });
</script>



          




      
</div>
</div>

</body>
</html>
