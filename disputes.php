<?php
$servername = "localhost"; // Change to your MySQL server hostname if needed
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "ejusticesys"; // Replace with your database name

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Calculate counts for settled cases
$sqlSettled = "SELECT
    SUM(CASE WHEN selected_method = 'mediation' THEN 1 ELSE 0 END) AS mediation_count,
    SUM(CASE WHEN selected_method = 'conciliation' THEN 1 ELSE 0 END) AS conciliation_count,
    SUM(CASE WHEN selected_method = 'arbitration' THEN 1 ELSE 0 END) AS arbitration_count
    FROM case_report WHERE settlement_status = 'settled'";
$resultSettled = $conn->query($sqlSettled);
$rowSettled = $resultSettled->fetch_assoc();

// Calculate counts for unsettled cases
$sqlUnsettled = "SELECT
    SUM(CASE WHEN selected_method = 'pending' THEN 1 ELSE 0 END) AS pending_count,
    SUM(CASE WHEN selected_method = 'dismissed' THEN 1 ELSE 0 END) AS dismissed_count,
    SUM(CASE WHEN selected_method = 'certified' THEN 1 ELSE 0 END) AS certified_count,
    SUM(CASE WHEN selected_method = 'repudiated' THEN 1 ELSE 0 END) AS repudiated_count,
    SUM(CASE WHEN selected_method = 'withdrawn' THEN 1 ELSE 0 END) AS withdrawn_count
    FROM case_report WHERE settlement_status = 'unsettled'";
$resultUnsettled = $conn->query($sqlUnsettled);
$rowUnsettled = $resultUnsettled->fetch_assoc();

// Calculate counts for different case types
$sqlCaseTypeCounts = "SELECT
    CASE WHEN case_type = 'criminal' THEN 'Criminal Cases'
         WHEN case_type = 'civil' THEN 'Civil Cases'
         WHEN case_type = 'other' THEN 'Other Cases'
         ELSE 'Unknown' END AS case_type,
    COUNT(*) AS count
    FROM case_report
    GROUP BY case_type";
$resultCaseTypeCounts = $conn->query($sqlCaseTypeCounts);

// Initialize variables for total counts
$totalCriminalCases = 0;
$totalCivilCases = 0;
$totalOtherCases = 0;

// Calculate the total counts for each case type
while ($rowCaseType = $resultCaseTypeCounts->fetch_assoc()) {
    if ($rowCaseType['case_type'] === 'Criminal Cases') {
        $totalCriminalCases += $rowCaseType['count']; // Increment the count
    } elseif ($rowCaseType['case_type'] === 'Civil Cases') {
        $totalCivilCases += $rowCaseType['count']; // Increment the count
    } elseif ($rowCaseType['case_type'] === 'Other Cases') {
        $totalOtherCases += $rowCaseType['count']; // Increment the count
    }
}


// Calculate the total cases count
$totalCases = $totalCriminalCases + $totalCivilCases + $totalOtherCases;

// Calculate counts for cases outside the jurisdiction
$sqlOutsideJurisdiction = "SELECT
    SUM(CASE WHEN outside_jurisdiction = 1 THEN 1 ELSE 0 END) AS outside_jurisdiction_count
    FROM case_report";
$resultOutsideJurisdiction = $conn->query($sqlOutsideJurisdiction);
$rowOutsideJurisdiction = $resultOutsideJurisdiction->fetch_assoc();
$outsideJurisdictionCount = $rowOutsideJurisdiction["outside_jurisdiction_count"];

// Fetch counts for case types from the database
$sqlFetchCaseCounts = "SELECT case_type, case_count FROM case_report";
$resultCaseCounts = $conn->query($sqlFetchCaseCounts);
$caseCounts = array();

while ($rowCaseCount = $resultCaseCounts->fetch_assoc()) {
    $caseCounts[$rowCaseCount['case_type']] = $rowCaseCount['case_count'];
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nature of Disputes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            vertical-align: bottom; /* Align the numbers at the bottom of their respective cells */
        }
    </style>
</head>
<body>
    <h1>Case Report</h1>
    <table>
        <tr>
            <th>Case Type</th>
            <th>Count</th>
        </tr>
        <tr>
    <td>Criminal Cases</td>
    <td><?php echo isset($caseCounts['criminal']) ? $caseCounts['criminal'] : 0; ?></td>
</tr>
<tr>
    <td>Civil Cases</td>
    <td><?php echo isset($caseCounts['civil']) ? $caseCounts['civil'] : 0; ?></td>
</tr>
<tr>
    <td>Other Cases</td>
    <td><?php echo isset($caseCounts['other']) ? $caseCounts['other'] : 0; ?></td>
</tr>
<tr>
    <td>Total Cases</td>
    <td>
        <?php
        $totalCases = (isset($caseCounts['criminal']) ? $caseCounts['criminal'] : 0) +
                      (isset($caseCounts['civil']) ? $caseCounts['civil'] : 0) +
                      (isset($caseCounts['other']) ? $caseCounts['other'] : 0);
        echo $totalCases;
        ?>
    </td>
</tr>
        <tr>
            <td>Mediation (Settled)</td>
            <td><?php echo $rowSettled["mediation_count"]; ?></td>
        </tr>
        <tr>
            <td>Conciliation (Settled)</td>
            <td><?php echo $rowSettled["conciliation_count"]; ?></td>
        </tr>
        <tr>
            <td>Arbitration (Settled)</td>
            <td><?php echo $rowSettled["arbitration_count"]; ?></td>
        </tr>
        <tr>
            <td>Total Settled Cases</td>
            <td><?php echo $rowSettled["mediation_count"] + $rowSettled["conciliation_count"] + $rowSettled["arbitration_count"]; ?></td>
        </tr>
        <tr>
            <td>Pending (Unsettled)</td>
            <td><?php echo $rowUnsettled["pending_count"]; ?></td>
        </tr>
        <tr>
            <td>Dismissed (Unsettled)</td>
            <td><?php echo $rowUnsettled["dismissed_count"]; ?></td>
        </tr>
        <tr>
            <td>Certified (Unsettled)</td>
            <td><?php echo $rowUnsettled["certified_count"]; ?></td>
        </tr>
        <tr>
            <td>Repudiated (Unsettled)</td>
            <td><?php echo $rowUnsettled["repudiated_count"]; ?></td>
        </tr>
        <tr>
            <td>Withdrawn  (Unsettled)</td>
            <td><?php echo $rowUnsettled["withdrawn_count"]; ?></td>
        </tr>
        <tr>
            <td>Total Unsettled Cases</td>
            <td><?php echo $rowUnsettled["pending_count"] + $rowUnsettled["dismissed_count"] + $rowUnsettled["certified_count"] + $rowUnsettled["repudiated_count"] + $rowUnsettled["withdrawn_count"]; ?></td>
        </tr>
        <tr>
            <td>Outside The Jurisdiction of Barangay</td>
            <td><?php echo $outsideJurisdictionCount; ?></td>
        </tr>
        <!-- Add this code after the row for "Outside The Jurisdiction of Barangay" -->
        <tr>
    <td>Total Cases</td>
    <td><?php echo $rowSettled["mediation_count"] + $rowSettled["conciliation_count"] + $rowSettled["arbitration_count"] + $rowUnsettled["pending_count"] + $rowUnsettled["dismissed_count"] + $rowUnsettled["certified_count"] + $rowUnsettled["repudiated_count"] + $rowUnsettled["withdrawn_count"]; ?></td>
</tr>

    </table>
    <a href="amicable_settlement.php">Back to CASE TYPE</a>
</body>
</html>
