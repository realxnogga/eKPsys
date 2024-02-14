<?php
session_start();
include 'connection.php';
include 'index-navigation.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Check if the dropdown form is submitted
if (isset($_POST['view_logs'])) {
    $selected_date = $_POST['selected_date'];
    $query = "SELECT user_id, timestamp, activity FROM user_logs WHERE user_id = :user_id AND DATE(timestamp) = :selected_date ORDER BY timestamp DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':selected_date', $selected_date);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Fetch today's date logs by default
    $query = "SELECT user_id, timestamp, activity FROM user_logs WHERE user_id = :user_id AND DATE(timestamp) = CURDATE() ORDER BY timestamp DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Logs</title>
    <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body style="background-color: #eeeef6">

<div class="container-fluid">
    <!-- Row 1 -->
    <div class="card">
        <div class="card-body">
            <!-- Your existing HTML content -->

            <h5 class="card-title mb-9 fw-semibold">User Activity Logs</h5>    <hr><?>


<b>
<form method="post" class="mb-3">
<label for="selected_date">Select Date:</label>
<div class="d-flex">
    <input type="date" class="form-control" name="selected_date" id="selected_date" value="<?php echo date('Y-m-d'); ?>">
    <input type="submit" class="btn btn-dark m-1" name="view_logs" value="Go" class="ml-2">
</div>
</form>

        

            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Timestamp</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $row) {
                        echo "<tr>
                                <td>{$row['timestamp']}</td>
                                <td>{$row['activity']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    // Optionally, you can add JavaScript for better user experience
    $(document).ready(function () {
        // Add your JavaScript code here
    });
</script>

</body>

</html>
