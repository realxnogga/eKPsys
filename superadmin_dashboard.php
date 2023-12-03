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



include 'count_lupon.php';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Superadmin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
     <?php include 'functions.php';?>

  <style>

html, body {
    overflow: hidden;
    height: 100%;
    margin: 0;
}

* {
    box-sizing: border-box;
}

body {
    font-family: 'Roboto';
    color: black;
    height: 100%;
    margin: 0;
}

.row:after {
    content: "";
    display: table;
    clear: both;
}

.leftcolumn {   
    float: left;
    width: 65%;
}

.rightcolumn {
    float: left;
    width: 35%;
    padding-left: 60px;
}

.card {
    background-color: white;
    margin-top: 25px;
    min-height: 100%; 
    border-radius: 20px; 
    height: 75vh; /* Set the height to 100% of the viewport height */
    overflow: auto;
    padding-bottom: 20px; /* Add some padding to the bottom */
    transition: height 0.3s ease; /* Add a smooth transition effect for height changes */
}

.row:after {
    content: "";
    display: table;
    clear: both;
}

@media screen and (max-width: 800px) {
    .leftcolumn, .rightcolumn {   
        width: 100%;
        padding: 0;
    }
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

        input[type="searc"]:hover {
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

/* Style for the search wrapper */
.search-wrapper {
    position: relative;
    height: 43px;
    display: inline-block;
    border-radius: 10px; /* Round corners for wrapper */
    border: 1px solid #ccc; /* Thin line border */
    overflow: hidden; /* Hide overflow to maintain border-radius */
}

.search-and-controls-container {
    display: flex;
    align-items: center; /* Align items vertically */
    justify-content: flex-start; /* Align items to the start of the container */
}

/* Style for the search input field */
input[type="text"] {
    padding: 10px 20px; /* Add padding for spacing */
    border: none;
    font-size: 16px; /* Increase font size for readability */
    outline: none; /* Remove default outline */
}

/* Style for the search button */
.search-btn {
    position: absolute;
    left: 488;
    width: 49px; /* Fixed width for the button */
    height: 100%; /* Match height of the input field */
    color: white; /* White text */
    border: none;
    cursor: pointer;
    text-align: center; /* Center the icon */
    font-size: 16px; /* Match font size of the input field */
    border-radius: 0 2px 2px 0; /* Rounded right corners only */

    background-color: #4CAF50; /* Green background */
}

/* Hover effect for the search button */
.search-btn:hover {
    background-color: #3a8e3a; /* Dark green color on hover */
}
/* Style for the search wrapper */
.search-wrapper {
    width: 100%; /* Take full width of the container */
}

/* Style for the select month dropdown */
.select-and-clear-container select[name="selected_month"] {
    flex: 1; /* This makes it take the available space. Adjust or remove if needed. */
    padding: 10px;
    border-radius: 10px; /* Rounded corners to match search bar */
    border: 1px solid #ccc;
    width: 100%; /* Adjust this value to change the width */
}


/* Style for the Clear button */
input[name="clear"] {
    background-color: red; /* Red color for the Clear button */
    color: white;
    height: 43px;
    border: none; /* Remove border */
    cursor: pointer;
    padding: 10px 20px; /* Adjust padding to match search bar height */
    margin-left: 10px; /* Add margin for spacing */
    font-size: 16px; /* Match font size of the search bar */
    border-radius: 10px; /* Rounded corners to match search bar */
    vertical-align: top; /* Align with the top of search bar */
}

/* Hover effect for the Clear button */
input[name="clear"]:hover {
    background-color: #b30000; /* Darker red color on hover */
}

        /* Style for the background color */
        body {
            background-color: #e9ecf3; /* Light gray background color */
        }

        .card {
            border-radius: 20px; /* Set the radius of the card's corners to 20px */

        }

.container {
    width: 100%; /* Adjust this as needed */
    max-width: 960px; /* Example max width, adjust to match your design */
    margin: auto; /* Center the container */
}
</style>
</head>


<body style="background-color: #e9ecf3;">


<div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">

                <h3>Super Admin Dashboard</h3><br<br><hr>
                <h2>Data Showing: All Municipalities</h2><br>


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
    </div>

    
    <div class="rightcolumn">
            <div class="card">


            <h4><b>Municipality Reports</b></h4><hr>
            <h2>Shortcut</h2><br>


<form method="POST">
    <div class="search-wrapper">
        <input type="text" name="municipality" placeholder="Search Municipality" value="<?php echo $searchedMunicipality; ?>">
      <button type="submit" name="search" class="btn-light search-btn">
            <i class="fas fa-search"></i></button>
    </div><br><br>

<!-- Month and year dropdown -->
<div class="select-and-clear-container">
<select name="selected_month">
<?php
// Loop through months and years to generate options for the last 12 months
for ($i = 0; $i < 12; $i++) {
$timestamp = strtotime("-$i months");
$monthYear = date('F Y', $timestamp);
$value = date('Y-m', $timestamp);
?>
<option value="<?php echo $value; ?>"><?php echo $monthYear; ?></option>
<?php } ?>
</select>
<br><br>
<input type="submit" name="clear" value="Clear" formnovalidate>
</div>
</form>
<h1><?php echo $selectedMonth; ?></h1>
<div class="columns-container">
<table class="table table-striped">
<thead>
    <tr>
        <th style="padding: 8px; background-color: #d3d3d3;">Municipality</th>
        <th style="padding: 8px; background-color: #d3d3d3;">Admin</th>
        <th style="padding: 8px; background-color: #d3d3d3;">
            Settled
            <a href="?sort=settled_asc">&#8593;</a>
            <a href="?sort=settled_desc">&#8595;</a>
        </th>
        <th style="padding: 8px; background-color: #d3d3d3;">
            Unsettled
            <a href="?sort=unsettled_asc">&#8593;</a>
            <a href="?sort=unsettled_desc">&#8595;</a>
        </th>
    </tr>
</thead>
<tbody>
    <?php
    // Function to compare values for sorting
    function compareValues($a, $b) {
        return $a <=> $b;
    }

    // Check if sorting parameter exists
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];

        // Define the sorting order based on the parameter value
        switch ($sort) {
            case 'settled_asc':
                usort($user, function($a, $b) {
                    return compareValues($a['Settled'], $b['Settled']);
                });
                break;
            case 'settled_desc':
                usort($user, function($a, $b) {
                    return compareValues($b['Settled'], $a['Settled']);
                });
                break;
         case 'unsettled_asc':
                usort($user, function($a, $b) {
                    return compareValues($a['Unsettled'], $b['Unsettled']);
                });
                break;
            case 'unsettled_desc':
                usort($user, function($a, $b) {
                    return compareValues($b['Unsettled'], $a['Unsettled']);
                });
                break;
            default:
                // Handle default case or error
                break;
        }
    }

    // Output the sorted or default user data
    foreach ($user as $row) { ?>
        <tr>
            <td><?php echo $row['municipality_name']; ?></td>
            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
            <td><?php echo $row['Settled']; ?></td>
            <td><?php echo $row['Unsettled']; ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>
</div>
</div>
</div>


</div>
</div>

</body>
</html>
