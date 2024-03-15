<?php
session_start();
include 'connection.php';
include 'index-navigation.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}


$user_id = $_SESSION['user_id'] ?? '';
$barangay_id = $_SESSION['barangay_id'] ?? '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Retrieve form data
    $report_date = $_POST['report_date'];
    $mayor = $_POST['mayor'];
    $region = $_POST['region'];
    $budget = $_POST['budget'];
    $population = $_POST['population'];
    $totalcase = $_POST['totalcase'];
    $numlupon = $_POST['numlupon'];
    $male = $_POST['male'];
    $female = $_POST['female'];
    $landarea = $_POST['landarea'];
    $criminal = $_POST['criminal'];
    $civil = $_POST['civil'];
    $others = $_POST['others'];
    $totalNature = $_POST['totalNature'];
    $media = $_POST['media'];
    $concil = $_POST['concil'];
    $arbit = $_POST['arbit'];
    $totalSet = $_POST['totalSet'];
    $pending = $_POST['pending'];
    $dismissed = $_POST['dismissed'];
    $repudiated = $_POST['repudiated'];
    $certcourt = $_POST['certcourt'];
    $dropped = $_POST['dropped'];
    $totalUnset = $_POST['totalUnset'];
    $outsideBrgy = $_POST['outsideBrgy'];

    // Check if a report already exists for the specified month and year
    $existing_report_query = "SELECT * FROM reports WHERE user_id = :user_id AND barangay_id = :barangay_id AND MONTH(report_date) = MONTH(:report_date) AND YEAR(report_date) = YEAR(:report_date)";
    $stmt = $conn->prepare($existing_report_query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':barangay_id', $barangay_id);
    $stmt->bindParam(':report_date', $report_date);
    $stmt->execute();
    $existing_report = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_report) {
        // Report already exists for the specified month and year
        $message = "A report already exists for " . date('F Y', strtotime($report_date));
    } else {
        // Insert new row into the reports table
        $insert_query = "INSERT INTO reports (user_id, barangay_id, report_date, mayor, region, budget, population, totalcase, numlupon, male, female, landarea, criminal, civil, others, totalNature, media, concil, arbit, totalSet, pending, dismissed, repudiated, certcourt, dropped, totalUnset, outsideBrgy)
                         VALUES (:user_id, :barangay_id, :report_date, :mayor, :region, :budget, :population, :totalcase, :numlupon, :male, :female, :landarea, :criminal, :civil, :others, :totalNature, :media, :concil, :arbit, :totalSet, :pending, :dismissed, :repudiated, :certcourt, :dropped, :totalUnset, :outsideBrgy)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $stmt->bindParam(':report_date', $report_date);
        $stmt->bindParam(':mayor', $mayor);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':budget', $budget);
        $stmt->bindParam(':population', $population);
        $stmt->bindParam(':totalcase', $totalcase);
        $stmt->bindParam(':numlupon', $numlupon);
        $stmt->bindParam(':male', $male);
        $stmt->bindParam(':female', $female);
        $stmt->bindParam(':landarea', $landarea);
        $stmt->bindParam(':criminal', $criminal);
        $stmt->bindParam(':civil', $civil);
        $stmt->bindParam(':others', $others);
        $stmt->bindParam(':totalNature', $totalNature);
        $stmt->bindParam(':media', $media);
        $stmt->bindParam(':concil', $concil);
        $stmt->bindParam(':arbit', $arbit);
        $stmt->bindParam(':totalSet', $totalSet);
        $stmt->bindParam(':pending', $pending);
        $stmt->bindParam(':dismissed', $dismissed);
        $stmt->bindParam(':repudiated', $repudiated);
        $stmt->bindParam(':certcourt', $certcourt);
        $stmt->bindParam(':dropped', $dropped);
        $stmt->bindParam(':totalUnset', $totalUnset);
        $stmt->bindParam(':outsideBrgy', $outsideBrgy);

        if ($stmt->execute()) {
            $message = "Report added successfully";
        } else {
            $message = "Failed to add report";
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports</title>
    <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <style>
        .card {
            box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }
    </style>
</head>

<body style="background-color: #E8E8E7">

    <div class="container-fluid">
        <a href="reports.php" class="btn btn-primary">Back to Reports tab</a>
        <br><br>

        <!--  Row 1 -->
        <div class="row">
            <div class="col-lg-7 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">

                                <div class="d-flex align-items-center">
                                    <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
                                    <div>
                                        <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
                                    </div>
                                </div>
                                <br>
                      
                                <h5 class="card-title mb-9 fw-semibold">Add Existing Report </h5>
                                <h6 class="text-success"> <?php if(isset($message)) { echo $message; } ?></h6> 

                                <div style="display: flex; align-items: center;">

                                    <form method="POST">
                                        <div>
                                            <label for="report_date">Report Date:</label>
                                            <input style=" width:100%;" type="date" class="form-control" id="report_date" name="report_date" value="" required>
                                        </div>
                                   
                                        <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="mayor">Mayor:</label>
            <input type="text" class="form-control" id="mayor" name="mayor" value="" required>
        </div>
        <div class="form-group">
            <label for="budget">Budget:</label>
            <input type="text" class="form-control" id="budget" name="budget" value="" required>
        </div>
        <div class="form-group">
            <label for="totalcase">Total Case:</label>
            <input type="number" class="form-control" id="totalcase" name="totalcase" value="" required>
        </div>
        <div class="form-group">
            <label for="numlupon">Number of Lupons:</label>
            <input type="number" class="form-control" id="numlupon" name="numlupon" value="" required>
        </div>
        <div class="form-group">
            <label  for="landarea">Land Area:</label>
            <input style=" width:210%;"  type="text" class="form-control" id="landarea" name="landarea" value="" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="region">Region:</label>
            <input  type="text" class="form-control" id="region" name="region" value="" required>
        </div>
        <div class="form-group">
            <label  for="population">Population:</label>
            <input  type="text" class="form-control" id="population" name="population" value="" required>
        </div>
        <div class="form-group">
            <label for="male">Male:</label>
            <input  type="number" class="form-control" id="male" name="male" value="" required>
        </div>
        <div class="form-group">
            <label  for="female">Female:</label>
            <input  type="number" class="form-control" id="female" name="female" value="" required>
        </div>
        
    </div>
</div>
<br>

<div class="row">
<b>NATURE OF CASES</b>
    <div class="col-md-6">
  
        <div class="form-group">
            <label for="criminal">Criminal:</label>
            <input type="number" class="form-control" id="criminal" name="criminal" value="" required>
        </div>
        <div class="form-group">
            <label for="others">Others:</label>
            <input type="number" class="form-control" id="others" name="others" value="" required>
        </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
            <label for="civil">Civil:</label>
            <input type="number" class="form-control" id="civil" name="civil" value="" required>
        </div>
      
        <div class="form-group">
            <label for="totalNature">Total Nature:</label>
            <input type="number" class="form-control" id="totalNature" name="totalNature" value="" required>
        </div>
    </div>
</div>

                                        <br>
                                        <div class="row">
                                        <b>ACTION TAKEN - SETTLED</b>
    <div class="col-md-6">
 
        <div class="form-group">
            <label for="media">Mediation:</label>
            <input type="number" class="form-control" id="media" name="media" value="" required>
        </div>
        <div class="form-group">
            <label for="arbit">Arbitration:</label>
            <input type="number" class="form-control" id="arbit" name="arbit" value="" required>
        </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
            <label for="concil">Conciliation:</label>
            <input type="number" class="form-control" id="concil" name="concil" value="" required>
        </div>
       
        <div class="form-group">
            <label for="totalSet">Total Settled:</label>
            <input type="number" class="form-control" id="totalSet" name="totalSet" value="" required>
        </div>
    </div>
</div>

                                        <br>
                                        <div class="row">
                                        <b>ACTION TAKEN - UNSETTLED</b>
    <div class="col-md-6">

        <div class="form-group">
            <label for="pending">Pending:</label>
            <input type="number" class="form-control" id="pending" name="pending" value="" required>
        </div>
        <div class="form-group">
            <label for="repudiated">Repudiated:</label>
            <input type="number" class="form-control" id="repudiated" name="repudiated" value="" required>
        </div>
        <div class="form-group">
            <label for="dropped">Dropped:</label>
            <input type="number" class="form-control" id="dropped" name="dropped" value="" required>
        </div>
        <div class="form-group">
            <label for="outsideBrgy">Outside Barangay:</label>
            <input style=" width:210%;"  type="number" class="form-control" id="outsideBrgy" name="outsideBrgy" value="" required>
        </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
            <label for="dismissed">Dismissed:</label>
            <input type="number" class="form-control" id="dismissed" name="dismissed" value="" required>
        </div>
        <div class="form-group">
            <label for="certcourt">Certified Court:</label>
            <input type="number" class="form-control" id="certcourt" name="certcourt" value="" required>
        </div>
      
        <div class="form-group">
            <label for="totalUnset">Total Unset:</label>
            <input type="number" class="form-control" id="totalUnset" name="totalUnset" value="" required>
        </div>
      
    </div>
</div>
<br>
                                        <input type="submit" class="btn btn-dark m-1" name="submit" value="Submit">
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

