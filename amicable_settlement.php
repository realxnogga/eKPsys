<?php
$servername = "localhost"; // Change to your MySQL server hostname if needed
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "ejusticesys"; // Replace with your database name

// Initialize variables
$settlementStatus = "";
$selectedMethod = "";
$outsideJurisdiction = 0; // Default value

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the form was submitted
    if (isset($_POST["submit"])) {
        // Determine the settlement status
        $settlementStatus = $_POST["settlementStatus"];

        // Check if the checkbox is checked and set the value accordingly
        $outsideJurisdiction = isset($_POST["outsideJurisdiction"]) ? 1 : 0;

        // Initialize the selected method based on the settlement status
        if ($settlementStatus === "settled") {
            $selectedMethod = $_POST["settledMethod"];
        } elseif ($settlementStatus === "unsettled") {
            $selectedMethod = $_POST["unsettledMethod"]; // Set the selected method for unsettled cases
        }

        // Create a connection to the MySQL database
        $conn = new mysqli($servername, $username, $password, $database);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert the settlement status, selected method, and outside jurisdiction into the database
        $sql = "INSERT INTO case_report (settlement_status, selected_method, outside_jurisdiction) VALUES ('$settlementStatus', '$selectedMethod', '$outsideJurisdiction')";

        if ($conn->query($sql) === TRUE) {
            echo "Data inserted successfully.";
        } else {
            echo "Error inserting data: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amicable Settlement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Amicable Settlement</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label>Select Settlement Status:</label>
            <div>
    <input type="radio" name="settlementStatus" value="settled" id="settledRadio" onchange="toggleOptions()" checked>
    <label for="settledRadio">Settled</label>
</div>
<div>
    <input type="radio" name="settlementStatus" value="unsettled" id="unsettledRadio" onchange="toggleOptions()">
    <label for="unsettledRadio">Unsettled</label>
</div>


            <!-- Inside the settled section -->
            <label for="settledMethod">Select Settlement Method:</label>
            <select name="settledMethod" id="settledMethod">
                <option value="mediation">Mediation</option>
                <option value="conciliation">Conciliation</option>
                <option value="arbitration">Arbitration</option>
            </select>

            <!-- Inside the unsettled section -->
            <label for="unsettledMethod">Select Unsettled Method:</label>
            <select name="unsettledMethod" id="unsettledMethod">
                <option value="pending">Pending</option>
                <option value="dismissed">Dismissed</option>
                <option value="repudiated">Repudiated</option>
                <option value="certified">Certified to File Action in Court</option>
                <option value="withdrawn">Withdrawn</option>
            </select>

            <label for="outsideJurisdiction">Outside the jurisdiction of barangay:</label>
            <input type="checkbox" name="outsideJurisdiction" id="outsideJurisdiction" value="1" onchange="toggleOptions()">

            <input type="submit" name="submit" value="Submit" id="submitButton">
        </form>
        <a href="reports.php">View Report</a>
    </div>

    <script>
    function toggleOptions() {
        const settlementStatus = document.querySelector('input[name="settlementStatus"]:checked').value;
        const outsideJurisdictionCheckbox = document.getElementById("outsideJurisdiction");
        const settledMethod = document.getElementById("settledMethod");
        const unsettledMethod = document.getElementById("unsettledMethod");

        if (outsideJurisdictionCheckbox.checked) {
            // If outsideJurisdiction checkbox is checked, disable and reset settlement status and method
            settledMethod.disabled = true;
            unsettledMethod.disabled = true;
            document.querySelector('input[name="settlementStatus"]:checked').checked = false;
        } else {
            // If outsideJurisdiction checkbox is unchecked, enable options
            settledMethod.disabled = (settlementStatus !== "unsettled");
            unsettledMethod.disabled = (settlementStatus !== "unsettled");
        }
    }
</script>

</body>
</html>
