<?php
session_start();
include 'connection.php';

include 'admin_func.php';   
include 'admin-nav.php';
include 'functions.php';
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$barangay_id = isset($_POST['barangay_id']) ? $_POST['barangay_id'] : '';


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'viewreporthandler.php';

$stmt = $conn->prepare("SELECT barangay_name FROM barangays WHERE id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangay_id);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>

    <title>Barangay Report</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
    <!-- Link Bootstrap CSS -->
    <link href="path/to/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link your custom CSS -->
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <a href="sec-corner.php">Back</a>
    <div class="container">
        <form method="POST">
            <h1>Reports of Barangay <?php echo $row['barangay_name']; ?></h1>
               <h3>Annual (<?php echo isset($selected_year) ? $selected_year : date('F, Y'); ?>)</h3>

<!-- Dropdown to select year -->
<label for="selected_year">Select Year to Display Report:</label>
<select name="selected_year" id="selected_year">
    <?php foreach ($years as $year) : ?>
        <option value="<?php echo $year['year']; ?>"><?php echo $year['year']; ?></option>
    <?php endforeach; ?>
</select>
    <input type="submit" name="submit_annual" value="Select Annual Report">

<h3>Monthly (<?php echo isset($selected_month) ? $selected_month : date('F, Y'); ?>)</h3>

<!-- Dropdown to select month -->
<label for="selected_month">Select Month to Display Report:</label>
<select name="selected_month" id="selected_month">
    <?php foreach ($months as $month) : ?>
        <option value="<?php echo $month['month_year']; ?>"><?php echo $month['month_year']; ?></option>
    <?php endforeach; ?>
</select>
    <input type="submit" name="submit_monthly" value="Select Monthly Report">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mayor">MAYOR:</label>
                        <input type="text" class="form-control" id="mayor" name="mayor" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_mayor; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $mayor;}
        else {
           echo $mayor;
        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="region">REGION:</label>
                        <input type="text" class="form-control" id="region" name="region" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_region; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $region;}
        else {
           echo $region;
        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="budget">BUDGET ALLOCATED:</label>
                        <input type="text" class="form-control" id="budget" name="budget" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_budget; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $budget;}
        else {
           echo $budget;
        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="popul">POPULATION:</label>
                        <input type="text" class="form-control" id="popul" name="population" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_population; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $population;}
        else {
           echo $population;
        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="landarea">LAND AREA:</label>
                        <input type="text" class="form-control" id="landarea" name="landarea" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_landarea; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $landarea;}
        else {
           echo $landarea;
        } ?>" >
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="totalc">TOTAL NO. OF CASES:</label>
                        <input type="number" class="form-control" id="totalc" name="totalc" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalc; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $natureSum;}
        else {
           echo $natureSum;
        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="numlup">NUMBER OF LUPONS:</label>
                        <input type="number" class="form-control" id="numlup" name="numlup" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_numlup; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $numlup;}
        else {
           echo $numlup;
        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="male">MALE:</label>
                        <input type="number" class="form-control" id="male" name="male" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_male; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $male;}
        else {
           echo $male;
        } ?>">
                    </div>

                    <div class="form-group">
                        <label for="female">FEMALE:</label>
                        <input type="number" class="form-control" id="female" name="female" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_female; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $female;}
        else {
           echo $female;
        } ?>">
                    </div>
 <div class="row">
    <div class="col-md-6">
        <b>Nature of Cases</b>
        <div class="row">
            <div class="col-md-4">
                <label for="criminal">Criminal:</label>
                <input type="number" class="form-control" id="criminal" name="criminal" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_criminal; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $criminalCount;}
        else {
           echo $criminalCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="civil">Civil:</label>
                <input type="number" class="form-control" id="civil" name="civil" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_civil; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $civilCount;}
        else {
           echo $civilCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="others">Others:</label>
                <input type="number" class="form-control" id="others" name="others" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_others; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $othersCount;}
        else {
           echo $othersCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="totalNature">Total:</label>
                <input type="number" class="form-control" id="totalNature" name="totalNature" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalNature; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $natureSum;}
        else {
           echo $natureSum;
        } ?>">
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
        } else if($selected_year && $selected_year !== date('Y')) {echo $mediationCount;}
        else {
           echo $mediationCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="conciliation">Conciliation:</label>
                <input type="number" class="form-control" id="conciliation" name="conciliation" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_conciliation; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $conciliationCount;}
        else {
           echo $conciliationCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="arbit">Arbitration:</label>
                <input type="number" class="form-control" id="arbit" name="arbit" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_arbit; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $arbitrationCount;}
        else {
           echo $arbitrationCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="totalSet">Total:</label>
                <input type="number" class="form-control" id="totalSet" name="totalSet" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalSet; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $totalSettledCount;}
        else {
           echo $totalSettledCount;
        } ?>">
            </div>
        <b>Outside the Jurisdiction of Barangay</b>
            <div class="col-md-2">
                <label for="outside"></label>
                <input type="number" class="form-control" id="outside" name="outside" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_outside; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $totalOutsideCount;}
        else {
           echo $totalOutsideCount;
        } ?>">
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
        } else if($selected_year && $selected_year !== date('Y')) {echo $pendingCount;}
        else {
           echo $pendingCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="dismissed">Dismissed:</label>
                <input type="number" class="form-control" id="dismissed" name="dismissed" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_dismissed; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $dismissedCount;}
        else {
           echo $dismissedCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="repudiated">Repudiated:</label>
                <input type="number" class="form-control" id="repudiated" name="repudiated" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_repudiated; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $repudiatedCount;}
        else {
           echo $repudiatedCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="certified">Certified to Court:</label>
                <input type="number" class="form-control" id="certified" name="certified" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_certified; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $certifiedCount;}
        else {
           echo $certifiedCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="dropped">Dropped/Withdrawn:</label>
                <input type="number" class="form-control" id="dropped" name="dropped" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_dropped; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $droppedCount;}
        else {
           echo $droppedCount;
        } ?>">
            </div>
            <div class="col-md-4">
                <label for="totalUnset">Total:</label>
                <input type="number" class="form-control" id="totalUnset" name="totalUnset" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalUnset; // Display the selected month's value
        } else if($selected_year && $selected_year !== date('Y')) {echo $totalUnsetCount;}
        else {
           echo $totalUnsetCount;
        } ?>">
         <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="barangay_id" value="<?php echo $barangay_id; ?>">
            </div>
                        </div>
        </form>
        </div>
  



</body>
</html>
