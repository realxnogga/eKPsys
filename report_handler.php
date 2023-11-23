<?php 
try{

if (isset($_POST['submit'])) {
     // Retrieve user inputs
    $mayor = $_POST['mayor'];
    $region = $_POST['region'];
    $budget = $_POST['budget'];
    $population = $_POST['population'];
    $land_area = $_POST['land_area'];
    $male = $_POST['male'];
    $female = $_POST['female'];

    $totalc = $_POST['totalc'] ?? '';
    $numlup = $_POST['numlup'] ?? '';
    $criminal = $_POST['criminal'] ?? '';
    $civil = $_POST['civil'] ?? '';
    $others = $_POST['others'] ?? '';
    $totalNature = $_POST['totalNature'] ?? '';
    $mediation = $_POST['mediation'] ?? '';
    $conciliation = $_POST['conciliation'] ?? '';
    $arbit = $_POST['arbit'] ?? '';
    $totalSet = $_POST['totalSet'] ?? '';
    $pending = $_POST['pending'] ?? '';
    $dismissed = $_POST['dismissed'] ?? '';
    $repudiated = $_POST['repudiated'] ?? '';
    $certified= $_POST['certified'] ?? '';
    $dropped = $_POST['dropped'] ?? '';
    $totalUnset = $_POST['totalUnset'] ?? '';
    $outside = $_POST['outside'] ?? '';

    $user_id = $_SESSION['user_id'];
    $barangay_id = $_SESSION['barangay_id']; 

    $current_date = date('Y-m-d');

    // Query to fetch the last report date for the current user and barangay
    $last_report_query = "SELECT MAX(report_date) AS last_report_date FROM reports WHERE user_id = :user_id AND barangay_id = :barangay_id";
    $stmt = $conn->prepare($last_report_query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':barangay_id', $barangay_id); // Make sure to set the barangay_id variable
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $last_report_date = $row['last_report_date'];

    if (!$last_report_date) {
        // No report exists for this user and barangay, insert new row
$insert_query = "INSERT INTO reports (user_id, barangay_id, mayor, region, budget, population, landarea, male, female, totalcase, numlupon, criminal, civil, others, totalNature, media, concil, arbit, totalSet, pending, dismissed, repudiated, certcourt, dropped, totalUnset, outsideBrgy)
                 VALUES (:user_id, :barangay_id, :mayor, :region, :budget, :population, :land_area, :male, :female, :totalc, :numlup, :criminal, :civil, :others, :totalNature, :mediation, :conciliation, :arbit, :totalSet, :pending, :dismissed, :repudiated, :certified, :dropped, :totalUnset, :outside)";

        $stmt = $conn->prepare($insert_query);
    } else {
        if (date('Y-m', strtotime($last_report_date)) === date('Y-m')) {
            // Update existing row for the current month
            $update_query = "UPDATE reports SET mayor = :mayor, region = :region, budget = :budget, population = :population, landarea = :land_area, male = :male, female = :female, totalcase = :totalc, numlupon = :numlup, criminal = :criminal, civil = :civil, others = :others, totalNature = :totalNature, media = :mediation, concil = :conciliation, arbit = :arbit, totalSet = :totalSet, pending = :pending, dismissed = :dismissed, repudiated = :repudiated, certcourt = :certified, dropped = :dropped, totalUnset = :totalUnset, outsideBrgy = :outside 
                             WHERE user_id = :user_id AND barangay_id = :barangay_id AND report_date = :last_report_date";
            $stmt = $conn->prepare($update_query);
            $stmt->bindParam(':last_report_date', $last_report_date);
        } else {
            // Different month, create a new row
            $insert_query = "INSERT INTO reports (user_id, barangay_id, report_date, mayor, region, budget, population, landarea, male, female, totalcase, numlupon, criminal, civil, others, totalNature, media, concil, arbit, totalSet, pending, dismissed, repudiated, certcourt, dropped, totalUnset, outsideBrgy)
                 VALUES (:user_id, :barangay_id, :current_date, :mayor, :region, :budget, :population, :land_area, :male, :female, totalc, :numlup, :criminal, :civil, :others, :totalNature, :mediation, :conciliation, :arbit, :totalSet, :pending, :dismissed, :repudiated, :certified, :dropped, :totalUnset, :outside)";
            $stmt = $conn->prepare($insert_query);
        }
    }


    // Bind parameters and execute the query
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':barangay_id', $barangay_id);
$stmt->bindParam(':mayor', $mayor);
$stmt->bindParam(':region', $region);
$stmt->bindParam(':budget', $budget);
$stmt->bindParam(':population', $population);
$stmt->bindParam(':land_area', $land_area);
$stmt->bindParam(':male', $male);
$stmt->bindParam(':female', $female);
$stmt->bindParam(':totalc', $totalc);
$stmt->bindParam(':numlup', $numlup);
$stmt->bindParam(':criminal', $criminal);
$stmt->bindParam(':civil', $civil);
$stmt->bindParam(':others', $others);
$stmt->bindParam(':totalNature', $totalNature);
$stmt->bindParam(':mediation', $mediation);
$stmt->bindParam(':conciliation', $conciliation);
$stmt->bindParam(':arbit', $arbit);
$stmt->bindParam(':totalSet', $totalSet);
$stmt->bindParam(':pending', $pending);
$stmt->bindParam(':dismissed', $dismissed);
$stmt->bindParam(':repudiated', $repudiated);
$stmt->bindParam(':certified', $certified);
$stmt->bindParam(':dropped', $dropped);
$stmt->bindParam(':totalUnset', $totalUnset);
$stmt->bindParam(':outside', $outside);

    $stmt->execute();

  // Fetch the current values after processing the form submission
    $currentValuesQuery = "SELECT * FROM reports WHERE user_id = :user_id AND barangay_id = :barangay_id ORDER BY report_date DESC LIMIT 1";
     $stmtCurrentValues = $conn->prepare($currentValuesQuery);
    $stmtCurrentValues->bindParam(':user_id', $user_id);
    $stmtCurrentValues->bindParam(':barangay_id', $barangay_id);
    $stmtCurrentValues->execute(); // Execute the statement to fetch current values

$row = $stmtCurrentValues->fetch(PDO::FETCH_ASSOC); // Use $stmtCurrentValues for fetching

if ($row) {
    // Assign retrieved values to variables
    $mayor = $row['mayor'];
    $region = $row['region'];
    $budget = $row['budget'];
    $population = $row['population'];
    $land_area = $row['landarea'];
    $male = $row['male'];
    $female = $row['female'];
}
}

}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$user_id = $_SESSION['user_id'];
$barangay_id = $_SESSION['barangay_id'];

$stmt = $conn->prepare("SELECT mayor, region, budget, population, landarea, totalcase, numlupon, male, female, criminal, civil, others, totalNature, media, concil, arbit, totalSet, pending, dismissed, repudiated, certcourt, dropped, totalUnset, outsideBrgy FROM reports WHERE user_id = :user_id AND barangay_id = :barangay_id ORDER BY report_date DESC LIMIT 1");
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':barangay_id', $barangay_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Assign fetched data to variables for populating the form fields
$mayor = $row['mayor'] ?? '';
$region = $row['region'] ?? '';
$budget = $row['budget'] ?? '';
$population = $row['population'] ?? '';
$land_area = $row['landarea'] ?? '';
$totalc = $row['totalcase'] ?? '';
$numlup = $_SESSION['linkedNamesCount'] ?? ''; // Update $numlup to reflect the linked names count


$male = $row['male'] ?? '';
$female = $row['female'] ?? '';
$criminal = $row['criminal'] ?? '';
$civil = $row['civil'] ?? '';

$natureOfCasesQuery = "SELECT 
                            SUM(CASE WHEN CType = 'Criminal' AND isArchived = 0 THEN 1 ELSE 0 END) AS criminal_count,
                            SUM(CASE WHEN CType = 'Civil' AND isArchived = 0 THEN 1 ELSE 0 END) AS civil_count,
                            SUM(CASE WHEN CType = 'Others' AND isArchived = 0 THEN 1 ELSE 0 END) AS others_count
                        FROM complaints 
                        WHERE UserID = :user_id AND BarangayID = :barangay_id AND MONTH(Mdate) = MONTH(NOW())";

$stmtNature = $conn->prepare($natureOfCasesQuery);
$stmtNature->bindParam(':user_id', $user_id);
$stmtNature->bindParam(':barangay_id', $barangay_id);
$stmtNature->execute();
$rowNature = $stmtNature->fetch(PDO::FETCH_ASSOC);

// Assign counts to variables
$criminalCount = $rowNature['criminal_count'] ?? 0;
$civilCount = $rowNature['civil_count'] ?? 0;
$othersCount = $rowNature['others_count'] ?? 0;

$natureSum = $criminalCount + $civilCount + $othersCount;

$actionSettledQuery = "SELECT 
                            COUNT(CASE WHEN CStatus = 'Settled' AND CMethod = 'Mediation' AND isArchived = 0 THEN 1 END) AS mediation_count,
                            COUNT(CASE WHEN CStatus = 'Settled' AND CMethod = 'Conciliation' AND isArchived = 0 THEN 1 END) AS conciliation_count,
                            COUNT(CASE WHEN CStatus = 'Settled' AND CMethod = 'Arbitration' AND isArchived = 0 THEN 1 END) AS arbitration_count,
                            COUNT(CASE WHEN CStatus = 'Settled' AND isArchived = 0 THEN 1 END) AS total_settled_count
                        FROM complaints 
                        WHERE UserID = :user_id AND BarangayID = :barangay_id AND MONTH(Mdate) = MONTH(NOW())";
            
$stmtSettled = $conn->prepare($actionSettledQuery);
$stmtSettled->bindParam(':user_id', $user_id);
$stmtSettled->bindParam(':barangay_id', $barangay_id);
$stmtSettled->execute();
$rowSettled = $stmtSettled->fetch(PDO::FETCH_ASSOC);

// Assign counts to variables
$mediationCount = $rowSettled['mediation_count'] ?? 0;
$conciliationCount = $rowSettled['conciliation_count'] ?? 0;
$arbitrationCount = $rowSettled['arbitration_count'] ?? 0;
$totalSettledCount = $rowSettled['total_settled_count'] ?? 0;

$actionUnsettledQuery = "SELECT 
                            COUNT(CASE WHEN CStatus = 'Unsettled' AND CMethod = 'Pending' AND isArchived = 0 THEN 1 END) AS pending_count,
                            COUNT(CASE WHEN CStatus = 'Unsettled' AND CMethod = 'Dismissed' AND isArchived = 0 THEN 1 END) AS dismissed_count,
                            COUNT(CASE WHEN CStatus = 'Unsettled' AND CMethod = 'Repudiated' AND isArchived = 0 THEN 1 END) AS repudiated_count,
                            COUNT(CASE WHEN CStatus = 'Unsettled' AND CMethod = 'Certified to File Action in Court' AND isArchived = 0 THEN 1 END) AS certified_count,
                            COUNT(CASE WHEN CStatus = 'Unsettled' AND CMethod = 'Dropped/Withdrawn' AND isArchived = 0 THEN 1 END) AS dropped_count,
                            COUNT(CASE WHEN CStatus = 'Unsettled' AND isArchived = 0 THEN 1 END) AS total_unset_count,
                            COUNT(CASE WHEN CStatus = 'Others' AND isArchived = 0 THEN 1 END) AS total_outside_count
                        FROM complaints 
                        WHERE UserID = :user_id AND BarangayID = :barangay_id AND MONTH(Mdate) = MONTH(NOW())";
                   
$stmtUnsettled = $conn->prepare($actionUnsettledQuery);
$stmtUnsettled->bindParam(':user_id', $user_id);
$stmtUnsettled->bindParam(':barangay_id', $barangay_id);
$stmtUnsettled->execute();
$rowUnsettled = $stmtUnsettled->fetch(PDO::FETCH_ASSOC);

// Assign counts to variables
$pendingCount = $rowUnsettled['pending_count'] ?? 0;
$dismissedCount = $rowUnsettled['dismissed_count'] ?? 0;
$repudiatedCount = $rowUnsettled['repudiated_count'] ?? 0;
$certifiedCount = $rowUnsettled['certified_count'] ?? 0;
$droppedCount = $rowUnsettled['dropped_count'] ?? 0;
$totalUnsetCount = $rowUnsettled['total_unset_count'] ?? 0;

$totalOutsideCount =$rowUnsettled['total_outside_count'] ?? 0;



 ?>