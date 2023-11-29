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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Requests</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
</head>
<hr><br>
<body>
<div class="columns-container">
    <div class="left-column">
        <div class="card">
        <h4><b>Account Requests</b></h4><br>

        <form method="GET" action="" class="searchInput">
            <input type="text" name="search" id="search" placeholder="Search by Case No., Title, Complainants, or Respondents" class="searchInput">
            <input type="button" value="Search" onclick="location.href='user_complaints.php';" class="refresh-button">
        </form>



        <?php

echo '<div id="account-requests" style="display: block;">';

// Check if there are any account requests
$hasAccountRequests = false;

foreach ($barangays as $barangay) {
    // Fetch user info for the current barangay from the database
    $stmt = $conn->prepare("SELECT id, username, first_name, last_name, email, contact_number, barangay_id, verified
                           FROM users WHERE barangay_id = (SELECT id FROM barangays WHERE barangay_name = :barangay_name) AND verified = 0");
    $stmt->bindParam(':barangay_name', $barangay, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($users)) {
        $hasAccountRequests = true;
        break;
    }
}

if ($hasAccountRequests) {
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>ID</th><th>Username</th><th>Secretary</th><th>Email</th><th>Contact Number</th><th>Barangay</th><th>Actions</th></tr></thead>';
    echo '<tbody>';
    
    foreach ($barangays as $barangay) {
        // Fetch user info for the current barangay from the database
        $stmt = $conn->prepare("SELECT id, username, first_name, last_name, email, contact_number, barangay_id, verified
                               FROM users WHERE barangay_id = (SELECT id FROM barangays WHERE barangay_name = :barangay_name) AND verified = 0");
        $stmt->bindParam(':barangay_name', $barangay, PDO::PARAM_STR);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            echo '<tr>';
            echo '<td>' . $user['id'] . '</td>';
            echo '<td>' . $user['username'] . '</td>';
            echo '<td>' . $user['first_name'] . ' ' . $user['last_name'] . '</td>';
            echo '<td>' . $user['email'] . '</td>';
            echo '<td>' . $user['contact_number'] . '</td>';
            echo '<td>' . $barangay . '</td>';
            echo '<td>';
            
            if (!$user['verified']) {
                echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
                echo '<input type="hidden" name="user_id" value="' . $user['id'] . '">';
                echo '<button class="verify-button" type="submit" name="action" value="verify">Verify</button>';
                echo '<button class="deny-button" type="submit" name="action" value="deny">Deny</button>';
                echo '</form>';
            } else {
                echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
                echo '<input type="hidden" name="user_id" value="' . $user['id'] . '">';
                echo '<button class="btn btn-danger" type="submit" name="action" value="unverify">Unverify</button>';
                echo '</form>';
            }
            echo '<a href="UserManageAccount.php?user_id=' . $user['id'] . '" class="acc-button">Manage Account</a>';

            echo '</td>';
            echo '</tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';

}

else {
    echo '<p>There are no account requests as of the moment.</p>';
}
    
echo '</div>';

?>


</div>
</div>
</div>
</body>
</html>

<script src="populateBrgyscript.js"></script>