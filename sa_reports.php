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
    <?php include 'functions.php';?>
</head>
<hr>
<br>
<body>
    
    <h2><b>Municipality Reports</b></h2>

    <form method="POST">
    <input type="text" name="municipality" placeholder="Search Municipality" value="<?php echo $searchedMunicipality; ?>">

    <!-- Month and year dropdown -->
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

    <input type="submit" name="search" value="Search">
    <input type="submit" name="clear" value="Clear" formnovalidate>
</form>
<h1><?php echo $selectedMonth; ?></h1>
<div class="columns-container">
    <div class="left-column">
        <div class="card">
            <h4><b>Municipalities</b></h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Municipality</th>
                        <th>Admin</th>
                        <th>
                            Settled
                            <a href="?sort=settled_asc">&#8593;</a>
                            <a href="?sort=settled_desc">&#8595;</a>
                        </th>
                        <th>
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
</body>
</html>
