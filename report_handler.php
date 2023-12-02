<?php 

 $user_id = $_SESSION['user_id'] ?? '';
    $barangay_id = $_SESSION['barangay_id'] ?? '';
try{

if (isset($_POST['submit'])) {
     // Retrieve user inputs
    $mayor = $_POST['mayor'];
    $region = $_POST['region'];
    $budget = $_POST['budget'];
    $population = $_POST['population'];
    $landarea = $_POST['landarea'];
    $male = $_POST['male'];
    $male = intval($male); 
    $female = $_POST['female'];
$female = intval($female); 
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
                     VALUES (:user_id, :barangay_id, :mayor, :region, :budget, :population, :landarea, :male, :female, :totalc, :numlup, :criminal, :civil, :others, :totalNature, :mediation, :conciliation, :arbit, :totalSet, :pending, :dismissed, :repudiated, :certified, :dropped, :totalUnset, :outside)";

    $stmt = $conn->prepare($insert_query);
} else {
    if (date('Y-m', strtotime($last_report_date)) === date('Y-m')) {
        // Update existing row for the current month
        $update_query = "UPDATE reports SET mayor = :mayor, region = :region, budget = :budget, population = :population, landarea = :landarea, male = :male, female = :female, totalcase = :totalc, numlupon = :numlup, criminal = :criminal, civil = :civil, others = :others, totalNature = :totalNature, media = :mediation, concil = :conciliation, arbit = :arbit, totalSet = :totalSet, pending = :pending, dismissed = :dismissed, repudiated = :repudiated, certcourt = :certified, dropped = :dropped, totalUnset = :totalUnset, outsideBrgy = :outside 
                         WHERE user_id = :user_id AND barangay_id = :barangay_id AND report_date = :last_report_date";

        $stmt = $conn->prepare($update_query);
        $stmt->bindParam(':last_report_date', $last_report_date);
    } else {
        // Different month, create a new row
        $current_date = date('Y-m-d');
        $insert_query = "INSERT INTO reports (user_id, barangay_id, report_date, mayor, region, budget, population, landarea, male, female, totalcase, numlupon, criminal, civil, others, totalNature, media, concil, arbit, totalSet, pending, dismissed, repudiated, certcourt, dropped, totalUnset, outsideBrgy)
                         VALUES (:user_id, :barangay_id, :current_date, :mayor, :region, :budget, :population, :landarea, :male, :female, :totalc, :numlup, :criminal, :civil, :others, :totalNature, :mediation, :conciliation, :arbit, :totalSet, :pending, :dismissed, :repudiated, :certified, :dropped, :totalUnset, :outside)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bindParam(':current_date', $current_date);
    }
}


    // Bind parameters and execute the query
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':barangay_id', $barangay_id);
$stmt->bindParam(':mayor', $mayor);
$stmt->bindParam(':region', $region);
$stmt->bindParam(':budget', $budget);
$stmt->bindParam(':population', $population);
$stmt->bindParam(':landarea', $landarea);
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
    $landarea = $row['landarea'];
    $male = $row['male'];
    $female = $row['female'];
}
}

}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


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
$landarea = $row['landarea'] ?? '';
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



$months_query = $conn->prepare("SELECT DISTINCT DATE_FORMAT(report_date, '%M %Y') AS month_year FROM reports WHERE user_id = :user_id");
$months_query->execute(['user_id' => $user_id]);
$months = $months_query->fetchAll(PDO::FETCH_ASSOC);

// Set a default value for selected_month if not set
$selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : date('F Y');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

}
 ?>