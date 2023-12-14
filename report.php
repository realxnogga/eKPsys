<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}
include 'count_lupon.php';

include 'report_handler.php';


?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
</head>

<style>
    .custom-modal-dialog {
    max-width: 800px; /* Adjust the width as needed */
    width: 90%; /* Adjust to your preference */
  }


body, html {
    margin: 0;
    padding: 0;
    height: 100%;
}

.card {
    height: 75vh; /* Set the height to 100% of the viewport height */
    width: 160vh; /* Set the height to 100% of the viewport height */

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

<body>

<div class="row">
    <div class="leftcolumn">
        <div class="card">
            <h3>Report Overview</h3>
            <br>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reportModal">
  View Report
</button><br>
            <table>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td><b>MAYOR:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_mayor : $mayor; ?></td>
                    <td><b>REGION:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_region : $region; ?></td>
                </tr>
                <tr>
                    <td><b>BUDGET ALLOCATED:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_budget : $budget; ?></td>
                    <td><b>POPULATION:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_population : $population; ?></td>
                </tr>
                <tr>
                    <td><b>LAND AREA:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_landarea : $landarea; ?></td>
                    <td><b>TOTAL NO. OF CASES:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_totalc : $natureSum; ?></td>
                </tr>
                <tr>
                    <td><b>NUMBER OF LUPONS:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_numlup : $numlup; ?></td>
                    <td><b>MALE:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_male : $male; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <!-- Add similar rows for other fields -->
                    <td><b>FEMALE:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_female : $female; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Criminal:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_criminal : $criminalCount; ?></td>
                    <td><b>Civil:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_civil : $civilCount; ?></td>
                </tr>
                <tr>
                    <td><b>Others:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_others : $othersCount; ?></td>
                    <td><b>Total:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_totalNature : $natureSum; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Mediation:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_mediation : $mediationCount; ?></td>
                    <td><b>Conciliation:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_conciliation : $conciliationCount; ?></td>
                </tr>
                <tr>
                    <td><b>Arbitration:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_arbit : $arbitrationCount; ?></td>
                    <td><b>Total:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_totalSet : $totalSettledCount; ?></td>
                </tr>
                <tr>
                    <td><b>Outside the Jurisdiction:</b></td>
                    <td colspan="3"><?php echo $selected_month && $selected_month !== date('F Y') ? $s_outside : $totalOutsideCount; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Pending:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_pending : $pendingCount; ?></td>
                    <td><b>Dismissed:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_dismissed : $dismissedCount; ?></td>
                </tr>
                <tr>
                    <td><b>Repudiated:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_repudiated : $repudiatedCount; ?></td>
                    <td><b>Certified to Court:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_certified : $certifiedCount; ?></td>
                </tr>
                <tr>
                    <td><b>Dropped/Withdrawn:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_dropped : $droppedCount; ?></td>
                    <td><b>Total:</b></td>
                    <td><?php echo $selected_month && $selected_month !== date('F Y') ? $s_totalUnset : $totalUnsetCount; ?></td>
                </tr>
                <!-- You can also add a loop for dynamic generation of rows if you have many fields -->

            </table>
            <br>
            <form method="post" action="">
                <!-- Your form elements here -->
                <input type="submit" name="submit" value="Update">
                
            </form>
            <div class="modal fade" id="reportModal" name="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered custom-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reportModalLabel" name="reportModalLabel">Monthly Report</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php include 'reports_table.php'; ?>
      </div>
    </div>
  </div>
</div>
            
        </div>
    </div>
</div>

</body>
</html>
