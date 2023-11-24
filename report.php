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


$months_query = $conn->prepare("SELECT DISTINCT DATE_FORMAT(report_date, '%M %Y') AS month_year FROM reports WHERE user_id = :user_id");
$months_query->execute(['user_id' => $user_id]);
$months = $months_query->fetchAll(PDO::FETCH_ASSOC);

// Set a default value for selected_month if not set
$selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : date('F Y');

// Check if a month is selected
if (isset($_POST['selected_month'])) {
    $selected_month = $_POST['selected_month'];

    // Retrieve report data for the selected month
    $report_query = $conn->prepare("SELECT * FROM reports WHERE user_id = :user_id AND DATE_FORMAT(report_date, '%M %Y') = :selected_month");
    $report_query->execute(['user_id' => $user_id, 'selected_month' => $selected_month]);
    $report_data = $report_query->fetch(PDO::FETCH_ASSOC);

    // Populate variables with selected month's data
    // Modify these lines to match your database column names
    $s_mayor = $report_data['mayor'] ?? '';
    $s_region = $report_data['region'] ?? '';
    $s_budget = $report_data['budget'] ?? '';
    $s_population = $report_data['population'] ?? '';
    $s_landarea = $report_data['landarea'] ?? '';
    $s_male = $report_data['male'] ?? '';
    $s_female = $report_data['female'] ?? '';
    $s_totalc = $report_data['totalcase'] ?? '';
    $s_numlup = $report_data['numlupon'] ?? '';
    $s_criminal = $report_data['criminal'] ?? '';
    $s_civil = $report_data['civil'] ?? '';
    $s_others = $report_data['others'] ?? '';
    $s_totalNature = $report_data['totalNature'] ?? '';
    $s_mediation = $report_data['media'] ?? '';
    $s_conciliation = $report_data['concil'] ?? '';
    $s_arbit = $report_data['arbit'] ?? '';
    $s_totalSet = $report_data['totalSet'] ?? '';
    $s_pending = $report_data['pending'] ?? '';
    $s_dismissed = $report_data['dismissed'] ?? '';
    $s_repudiated = $report_data['repudiated'] ?? '';
    $s_dropped = $report_data['dropped'] ?? '';
    $s_totalUnset = $report_data['totalUnset'] ?? '';
    $s_outside = $report_data['outsideBrgy'] ?? '';
    $s_certified = $report_data['certcourt'] ?? '';


} else {
    // If no month is selected, display the current month's data (or default behavior)
    // Fetch and display the most recent report data
    // Modify this query according to your needs
    $default_report_query = $conn->prepare("SELECT * FROM reports WHERE user_id = :user_id ORDER BY report_date DESC LIMIT 1");
    $default_report_query->execute(['user_id' => $user_id]);
    $default_report_data = $default_report_query->fetch(PDO::FETCH_ASSOC);

    // Populate variables with default data (current month's data or most recent)
    // Modify these lines to match your database column names
    $s_mayor = $default_report_data['mayor']  ?? '';
    $s_region = $default_report_data['region']  ?? '';
    $s_budget = $default_report_data['budget']  ?? '';
    $s_population = $default_report_data['population'] ?? '';
    $s_landarea = $default_report_data['landarea'] ?? '';
    $s_male = $default_report_data['male'] ?? '';
    $s_female = $default_report_data['female'] ?? '';
    $s_totalc = $default_report_data['totalcase'] ?? '';
    $s_numlup = $default_report_data['numlupon'] ?? '';
    $s_criminal = $default_report_data['criminal'] ?? '';
    $s_civil = $default_report_data['civil'] ?? '';
    $s_others = $default_report_data['others'] ?? '';
    $s_totalNature = $default_report_data['totalNature'] ?? '';
    $s_mediation = $default_report_data['media'] ?? '';
    $s_conciliation = $default_report_data['concil'] ?? '';
    $s_arbit = $default_report_data['arbit'] ?? '';
    $s_totalSet = $default_report_data['totalSet'] ?? '';
    $s_pending = $default_report_data['pending'] ?? '';
    $s_dismissed = $default_report_data['dismissed'] ?? '';
    $s_repudiated = $default_report_data['repudiated'] ?? '';
    $s_dropped = $default_report_data['dropped'] ?? '';
    $s_totalUnset = $default_report_data['totalUnset'] ?? '';
    $s_outside = $default_report_data['outsideBrgy'] ?? '';
    $s_certified = $default_report_data['certcourt'] ?? '';

}
?>
<!DOCTYPE html>
<html>
<head>

    <title>Reports</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
    <!-- Link Bootstrap CSS -->
    <link href="path/to/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link your custom CSS -->
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .custom-modal-dialog {
    max-width: 800px; /* Adjust the width as needed */
    width: 90%; /* Adjust to your preference */
  }
</style>
<body>
<hr><br>
<body>
    <div class="container">
        <form method="POST">
        <h2>Monthly Report (<?php echo isset($selected_month) ? $selected_month : date('F, Y'); ?>)</h2>

          <!-- Dropdown to select month -->
        <label for="selected_month">Select Month to Display Report:</label>
        <select name="selected_month" id="selected_month">
            <?php foreach ($months as $month) : ?>
                <option value="<?php echo $month['month_year']; ?>"><?php echo $month['month_year']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Select">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mayor">MAYOR:</label>
                        <input type="text" class="form-control" id="mayor" name="mayor" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_mayor; // Display the selected month's value
        } else {echo $mayor;} ?>">
                    </div>
                    <div class="form-group">
                        <label for="region">REGION:</label>
                        <input type="text" class="form-control" id="region" name="region" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_region; // Display the selected month's value
        } else {echo $region;} ?>">
                    </div>
                    <div class="form-group">
                        <label for="budget">BUDGET ALLOCATED:</label>
                        <input type="text" class="form-control" id="budget" name="budget" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_budget; // Display the selected month's value
        } else {echo $budget;} ?>">
                    </div>
                    <div class="form-group">
                        <label for="popul">POPULATION:</label>
                        <input type="text" class="form-control" id="popul" name="population" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_population; // Display the selected month's value
        } else {echo $population;} ?>">
                    </div>
                    <div class="form-group">
                        <label for="landarea">LAND AREA:</label>
                        <input type="text" class="form-control" id="landarea" name="landarea" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_landarea; // Display the selected month's value
        } else {echo $landarea;} ?>" >
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="totalc">TOTAL NO. OF CASES:</label>
                        <input type="number" class="form-control" id="totalc" name="totalc" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalc; // Display the selected month's value
        } else {echo $natureSum;} ?>">
                    </div>
                    <div class="form-group">
                        <label for="numlup">NUMBER OF LUPONS:</label>
                        <input type="number" class="form-control" id="numlup" name="numlup" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_numlup; // Display the selected month's value
        } else {echo $numlup;} ?>">
                    </div>
                    <div class="form-group">
                        <label for="male">MALE:</label>
                        <input type="number" class="form-control" id="male" name="male" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_male; // Display the selected month's value
        } else {echo $male;} ?>">
                    </div>

                    <div class="form-group">
                        <label for="female">FEMALE:</label>
                        <input type="number" class="form-control" id="female" name="female" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_female; // Display the selected month's value
        } else {echo $female;} ?>">
                    </div>
 <div class="row">
    <div class="col-md-6">
        <b>Nature of Cases</b>
        <div class="row">
            <div class="col-md-4">
                <label for="criminal">Criminal:</label>
                <input type="number" class="form-control" id="criminal" name="criminal" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_criminal; // Display the selected month's value
        } else {echo $criminalCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="civil">Civil:</label>
                <input type="number" class="form-control" id="civil" name="civil" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_civil; // Display the selected month's value
        } else {echo $civilCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="others">Others:</label>
                <input type="number" class="form-control" id="others" name="others" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_others; // Display the selected month's value
        } else {echo $othersCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="totalNature">Total:</label>
                <input type="number" class="form-control" id="totalNature" name="totalNature" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalNature; // Display the selected month's value
        } else {echo $natureSum;} ?>">
            </div>

        </div>
    </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <b>Action Taken - Settled</b>
        <div class="row">   
            <div class="col-md-4">
                <label for="mediation">Mediation:</label>
               <input type="number" class="form-control" id="mediation" name="mediation" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_mediation; // Display the selected month's value
        } else {echo $mediationCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="conciliation">Conciliation:</label>
                <input type="number" class="form-control" id="conciliation" name="conciliation" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_conciliation; // Display the selected month's value
        } else {echo $conciliationCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="arbit">Arbitration:</label>
                <input type="number" class="form-control" id="arbit" name="arbit" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_arbit; // Display the selected month's value
        } else {echo $arbitrationCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="totalSet">Total:</label>
                <input type="number" class="form-control" id="totalSet" name="totalSet" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalSet; // Display the selected month's value
        } else {echo $totalSettledCount;} ?>">
            </div>
        <b>Outside the Jurisdiction of Barangay</b>
            <div class="col-md-2">
                <label for="outside"></label>
                <input type="number" class="form-control" id="outside" name="outside" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_outside; // Display the selected month's value
        } else {echo $totalOutsideCount;} ?>">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <b>Action Taken - Unsettled</b>
        <div class="row">
            <div class="col-md-4">
                <label for="pending">Pending:</label>
                <input type="number" class="form-control" id="pending" name="pending" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_pending; // Display the selected month's value
        } else {echo $pendingCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="dismissed">Dismissed:</label>
                <input type="number" class="form-control" id="dismissed" name="dismissed" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_dismissed; // Display the selected month's value
        } else {echo $dismissedCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="repudiated">Repudiated:</label>
                <input type="number" class="form-control" id="repudiated" name="repudiated" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_repudiated; // Display the selected month's value
        } else {echo $repudiatedCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="certified">Certified to Court:</label>
                <input type="number" class="form-control" id="certified" name="certified" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_certified; // Display the selected month's value
        } else {echo $certifiedCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="dropped">Dropped/Withdrawn:</label>
                <input type="number" class="form-control" id="dropped" name="dropped" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_dropped; // Display the selected month's value
        } else {echo $droppedCount;} ?>">
            </div>
            <div class="col-md-4">
                <label for="totalUnset">Total:</label>
                <input type="number" class="form-control" id="totalUnset" name="totalUnset" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalUnset; // Display the selected month's value
        } else {echo $totalUnsetCount;} ?>">
            </div>
                            <input type="submit" name="submit" value="Update">
                        </div>
        </form>
        </div>
  

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reportModal">
  View Report
</button>

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




</body>
</html>
