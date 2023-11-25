<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'admin_func.php';   
include 'admin-nav.php';
include 'functions.php';

$action_submitted = isset($_POST['action']);

// Process the "Unverify" action if submitted
if ($action_submitted && $_POST['action'] === 'unverify' && isset($_POST['user_id'])) {

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secretaries Corner</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
</head>
<hr><br>
<body>
<div class="columns-container">
    <div class="left-column">
        <div class="card">
        <h4><b>Barangay Secretaries</b></h4><br>
        <form method="GET" action="" class="searchInput">
            <input type="text" name="search" id="search" placeholder="Search by Case No., Title, Complainants, or Respondents" class="searchInput">
            <input type="button" value="Search" class="refresh-button">
        </form>

        <?php
        if (!$action_submitted && !empty($barangays)) {
    echo '<div class="card-body">';
echo '<div id="verified-users">';
echo '<table class="table table-bordered">';
echo '<thead><tr><th>ID</th><th>Username</th><th>User Name</th><th>Email</th><th>Contact Number</th><th>Barangay Name</th><th>Actions</th></tr></thead>';
echo '<tbody>';

$verifiedUsersQuery = "SELECT id, username, first_name, last_name, email, contact_number, barangay_id FROM users WHERE verified = 1";
$verifiedUsersStatement = $conn->prepare($verifiedUsersQuery);
$verifiedUsersStatement->execute();

while ($verifiedUser = $verifiedUsersStatement->fetch(PDO::FETCH_ASSOC)) {
    // Fetch barangay name for the current user
    $barangayNameQuery = "SELECT barangay_name FROM barangays WHERE id = ?";
    $barangayStatement = $conn->prepare($barangayNameQuery);
    $barangayStatement->execute([$verifiedUser['barangay_id']]);
    $barangayName = $barangayStatement->fetchColumn();

    echo '<tr>';
    echo '<td>' . $verifiedUser['id'] . '</td>';
    echo '<td>' . $verifiedUser['username'] . '</td>';
    echo '<td>' . $verifiedUser['first_name'] . ' ' . $verifiedUser['last_name'] . '</td>';
    echo '<td>' . $verifiedUser['email'] . '</td>';
    echo '<td>' . $verifiedUser['contact_number'] . '</td>';
    echo '<td>' . $barangayName . '</td>';
    echo '<td>';
    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<input type="hidden" name="user_id" value="' . $verifiedUser['id'] . '">';
    echo '<button class="unverify-button" type="submit" name="action" value="unverify">Unverify</button>';
    echo '</form>';


    echo '</td>';
        echo '<td>';
echo '<form method="post" action="admin_viewreport.php">';
echo '<input type="hidden" name="user_id" value="' . $verifiedUser['id'] . '">';
// Fetch barangay_id and include it as a hidden input
$barangayIdQuery = "SELECT barangay_id FROM users WHERE id = ?";
$barangayStatement = $conn->prepare($barangayIdQuery);
$barangayStatement->execute([$verifiedUser['id']]);
$barangayId = $barangayStatement->fetchColumn();
echo '<input type="hidden" name="barangay_id" value="' . $barangayId . '">';
echo '<button class="btn-success" type="submit" name="viewreport">View Report</button>';
echo '</form>';




    echo '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';
        }
        ?>

        </div>
    </div>
</div>
</body>
</html>
