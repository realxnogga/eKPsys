<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $conn->prepare("SELECT mayor, region, budget, population, landarea, totalcase, numlupon, male, female, criminal, civil, others, totalNature, media, concil, arbit, totalSet, pending, dismissed, repudiated, certcourt, dropped, totalUnset, outsideBrgy FROM reports WHERE user_id = :user_id AND barangay_id = :barangay_id ORDER BY report_date DESC LIMIT 1");
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':barangay_id', $barangay_id);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

       // Assign fetched data to variables
    $mayor = $row['mayor'] ?? '';
    $region = $row['region'] ?? '';
    $budget = $row['budget'] ?? '';
    $population = $row['population'] ?? '';
    $landarea = $row['landarea'] ?? '';
    $totalc = $row['totalcase'] ?? '';
    $numlup = $row['numlupon'] ?? '';
    $male = $row['male'] ?? '';
    $female = $row['female'] ?? '';
    $criminalCount = $row['criminal'] ?? '';
    $civilCount = $row['civil'] ?? '';
    $othersCount = $row['others'] ?? '';
    $natureSum = $row['totalNature'] ?? '';
    $mediationCount = $row['media'] ?? '';
    $conciliationCount = $row['concil'] ?? '';
    $arbitrationCount = $row['arbit'] ?? '';
    $totalSettledCount = $row['totalSet'] ?? '';
    $totalOutsideCount = $row['outsideBrgy'] ?? '';
    $pendingCount = $row['pending'] ?? '';
    $dismissedCount = $row['dismissed'] ?? '';
    $repudiatedCount = $row['repudiated'] ?? '';
    $certifiedCount = $row['certcourt'] ?? '';
    $droppedCount = $row['dropped'] ?? '';
    $totalUnsetCount = $row['totalUnset'] ?? '';


$months_query = $conn->prepare("SELECT DISTINCT DATE_FORMAT(report_date, '%M %Y') AS month_year FROM reports WHERE user_id = :user_id");
$months_query->execute(['user_id' => $user_id]);
$months = $months_query->fetchAll(PDO::FETCH_ASSOC);

// Set a default value for selected_month if not set
$selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : date('F Y');


if (isset($_POST['selected_month'])) {

 $selected_month = $_POST['selected_month'];

    // Retrieve report data for the selected month
    $report_query = $conn->prepare("SELECT * FROM reports WHERE user_id = :user_id AND DATE_FORMAT(report_date, '%M %Y') = :selected_month");
    $report_query->execute(['user_id' => $user_id, 'selected_month' => $selected_month]);
    $report_data = $report_query->fetch(PDO::FETCH_ASSOC);


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

} ?>