<?php
session_start();
include 'connection.php';
// include('header.php');

include 'superadmin-navigation.php';
// include 'admin-nav.php';
 include 'functions.php';

// Check if the user is a superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

// Fetch the data from your database and assign it to $user
// Replace the following lines with your actual database query
$stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, m.municipality_name FROM users u
                        INNER JOIN municipalities m ON u.municipality_id = m.id
                        WHERE u.user_type = 'admin'");
$stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'report_handler.php';


$searchInput = isset($_GET['search']) ? $_GET['search'] : '';

$userID = $_SESSION['user_id'];

$query = "SELECT * FROM complaints WHERE UserID = '$userID' AND IsArchived = 0";

if (!empty($searchInput)) {

    $query .= " AND (CNum LIKE '%$searchInput%' OR ForTitle LIKE '%$searchInput%' OR CNames LIKE '%$searchInput%' OR RspndtNames LIKE '%$searchInput%')";
}

    $query .= " ORDER BY MDate DESC";

$result = $conn->query($query);

include 'add_handler.php';



$selectedMonth = ''; // Initialize the variable

$searchedMunicipality = '';

// Handling search functionality
if (isset($_POST['search'])) {
    $searchedMunicipality = $_POST['municipality']; // Get the searched municipality

    // Get the selected month from the dropdown
    $selectedMonth = $_POST['selected_month'];
        $selectedMonth = date('F Y', strtotime($selectedMonth)); // Convert selected month to Month Year format

    $stmt = $conn->prepare("
        SELECT u.id, u.municipality_id, u.first_name, u.last_name, m.municipality_name,
        COALESCE(SUM(r.totalSet), 0) AS Settled,
        COALESCE(SUM(r.totalUnset), 0) AS Unsettled
        FROM users u
        INNER JOIN municipalities m ON u.municipality_id = m.id
        LEFT JOIN barangays b ON m.id = b.municipality_id
        LEFT JOIN reports r ON b.id = r.barangay_id AND DATE_FORMAT(r.report_date, '%Y-%m') = :selectedMonth
        WHERE u.user_type = 'admin' 
        AND m.municipality_name LIKE :municipality
        GROUP BY u.id
    ");

    $stmt->bindValue(':municipality', '%' . $searchedMunicipality . '%', PDO::PARAM_STR);
    $stmt->bindValue(':selectedMonth', $selectedMonth, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
   $currentMonth = date('Y-m'); // Get current year and month in YYYY-MM format

$stmt = $conn->prepare("
    SELECT u.id, u.municipality_id, u.first_name, u.last_name, m.municipality_name,
    COALESCE(SUM(r.totalSet), 0) AS Settled,
    COALESCE(SUM(r.totalUnset), 0) AS Unsettled
    FROM users u
    INNER JOIN municipalities m ON u.municipality_id = m.id
    LEFT JOIN barangays b ON m.id = b.municipality_id
    LEFT JOIN reports r ON b.id = r.barangay_id AND DATE_FORMAT(r.report_date, '%Y-%m') = :currentMonth
    WHERE u.user_type = 'admin' 
    AND m.municipality_name LIKE :municipality
    GROUP BY u.id
");
$stmt->bindValue(':municipality', '%' . $searchedMunicipality . '%', PDO::PARAM_STR);
$stmt->bindValue(':currentMonth', $currentMonth, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <!-- Add this script tag to include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  
  <style>
   .scrollable-card-body {
            max-height: 400px; /* Set the maximum height for the card body */
            overflow-y: auto; /* Enable vertical scrolling */
            scrollbar-width: thin; /* Specify a thin scrollbar */
            scrollbar-color: transparent transparent; /* Set scrollbar color to transparent */
        }

        /* For Webkit browsers like Chrome and Safari */
        .scrollable-card-body::-webkit-scrollbar {
            width: 8px; /* Set the width of the scrollbar */
        }

        .scrollable-card-body::-webkit-scrollbar-thumb {
            background-color: transparent; /* Set scrollbar thumb color to transparent */
        }
</style>

</head>

<body style="background-color: #eeeef6">
  <!--  Body Wrapper -->
 
      <div class="container-fluid">
       




    


                     
      </div>
 
</body>

</html>