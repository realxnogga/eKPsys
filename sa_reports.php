<?php
session_start();
include 'connection.php';
include 'superadmin-navigation.php';
include 'functions.php';

// Check if the user is a superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}
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
    <title>Municipality Reports</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">

    <style>
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
}

.card {
    height: 75vh; /* Set the height to 100% of the viewport height */
    width: 154vh; /* Set the height to 100% of the viewport height */

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
    width: 40%; /* Take full width of the container */
}

/* Style for the select month dropdown */
.select-and-clear-container select[name="selected_month"] {
    flex: 1; /* This makes it take the available space. Adjust or remove if needed. */
    padding: 10px;
    border-radius: 10px; /* Rounded corners to match search bar */
    border: 1px solid #ccc;
    width: 40%; /* Adjust this value to change the width */
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
<body>
    

    <div class="columns-container">
        <div class="left-column">
            <div class="card">

                <h4><b>Municipality Reports</b></h4><hr><br>

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
    </select><br><br>

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
</div>
</body>
</html>
