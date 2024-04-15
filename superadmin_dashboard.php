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
   .card {
  box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
  border-radius: 15px;
}
.custom-card {
      margin-bottom: 20px;
    }
.card-text-center {
      text-align: center;
    }
    .alaminos-card {
      text-align: center;
      /* background-image: url('img/settled.png'); */
      background-color: red;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      .bay-card {
      text-align: center;
      /* background-image: url('img/unsettled.png'); */
      background-color: blue;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      .biñan-card {
      text-align: center;
      /* background-image: url('img/pending.png'); */
      background-color: yellow;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      .cabuyao-card {
      text-align: center;
      /* background-image: url('img/settled.png'); */
      background-color: pink;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      .calamba-card {
      text-align: center;
      /* background-image: url('img/unsettled.png'); */
      background-color: purple;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      .calauan-card {
      text-align: center;
      /* background-image: url('img/pending.png'); */
      background-color: orange;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      .baños-card {
      text-align: center;
      /* background-image: url('img/settled.png'); */
      background-color: green;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      .pablo-card {
      text-align: center;
      /* background-image: url('img/unsettled.png'); */
      background-color: maroon;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      .pedro-card {
      text-align: center;
      /* background-image: url('img/pending.png'); */
      background-color: lightblue;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      .rosa-card {
      text-align: center;
      /* background-image: url('img/pending.png'); */
      background-color: grey;
      background-size: cover;
      background-position: center;
      width: 100%;
      }
      
</style>

</head>

<body style="background-color: #eeeef6">
  <!--  Body Wrapper -->
 
      <div class="container-fluid">
       
      <div class="row">
    <div class="col-md-4">
      <div class="card alaminos-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                      Alaminos
                    </h5>          <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                      <?php
                      if ($selected_month && $selected_month !== date('F Y')) {
                        echo $s_totalSet; // Display the selected month's value
                      } else {
                        echo $totalSettledCount;
                      }
                      ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bay-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
                    Bay</h5>
                    <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
      <?php
      if ($selected_month && $selected_month !== date('F Y')) {
          echo $s_totalUnset; // Display the selected month's value
      } else {
          echo $totalUnsetCount;
      }
      ?>
  </p>
                          </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card biñan-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
          Biñan
                    </h5>
                    <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                    <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_pending; // Display the selected month's value
        } else {echo $pendingCount;} ?>
  </p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="card cabuyao-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                      Cabuyao
                    </h5>          <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                      <?php
                      if ($selected_month && $selected_month !== date('F Y')) {
                        echo $s_totalSet; // Display the selected month's value
                      } else {
                        echo $totalSettledCount;
                      }
                      ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card calamba-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
                    Calamba</h5>
                    <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
      <?php
      if ($selected_month && $selected_month !== date('F Y')) {
          echo $s_totalUnset; // Display the selected month's value
      } else {
          echo $totalUnsetCount;
      }
      ?>
  </p>
                          </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card calauan-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
          Calauan
                    </h5>
                    <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                    <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_pending; // Display the selected month's value
        } else {echo $pendingCount;} ?>
  </p>
        </div>
      </div>
    </div>
  </div>
    <div class="row">
    <div class="col-md-4">
      <div class="card baños-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                      Los Baños
                    </h5>          <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                      <?php
                      if ($selected_month && $selected_month !== date('F Y')) {
                        echo $s_totalSet; // Display the selected month's value
                      } else {
                        echo $totalSettledCount;
                      }
                      ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card pablo-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
                    San Pablo</h5>
                    <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
      <?php
      if ($selected_month && $selected_month !== date('F Y')) {
          echo $s_totalUnset; // Display the selected month's value
      } else {
          echo $totalUnsetCount;
      }
      ?>
  </p>
                          </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card pedro-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
          San Pedro
                    </h5>
                    <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                    <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_pending; // Display the selected month's value
        } else {echo $pendingCount;} ?>
  </p>
        </div>
      </div>
    </div>
  </div>





  <div class="row">
    
    <div class="col-md-4">
      <div class="card rosa-card">
        <div class="card-body">
          <!-- Card content goes here -->
          <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
                    Santa Rosa</h5>
                    <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
      <?php
      if ($selected_month && $selected_month !== date('F Y')) {
          echo $s_totalUnset; // Display the selected month's value
      } else {
          echo $totalUnsetCount;
      }
      ?>
  </p>
                          </div>
      </div>
    </div>
    
  </div>
  



    


                     
      </div>
 
</body>

</html>