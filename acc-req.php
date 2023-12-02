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

$currentMunicipalityID = $_SESSION['municipality_id'] ?? null;

$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$accountRequestsQuery = "SELECT u.id, u.username, u.first_name, u.last_name, u.email, u.contact_number, b.barangay_name, u.verified 
                         FROM users u 
                         LEFT JOIN barangays b ON u.barangay_id = b.id 
                         WHERE u.verified = 0 
                         AND u.municipality_id = ? 
                         AND u.user_type = 'user'
                         AND (u.first_name LIKE ? OR u.last_name LIKE ? OR b.barangay_name LIKE ?)
                         ORDER BY b.barangay_name"; // Order by barangay_name for readability

$search_query_like = '%' . $search_query . '%';
$accountRequestsStatement = $conn->prepare($accountRequestsQuery);
$accountRequestsStatement->execute([$currentMunicipalityID, $search_query_like, $search_query_like, $search_query_like]);
$accountRequests = $accountRequestsStatement->fetchAll(PDO::FETCH_ASSOC);
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
                    <input type="text" name="search" id="search" placeholder="Search by Name or Barangay Name" class="searchInput">
                    <input type="submit" value="Search" class="refresh-button">
                </form>

                <?php
                echo '<div id="account-requests" style="display: block;">';

                if (!empty($accountRequests)) {
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr><th>Username</th><th>Secretary</th><th>Email</th><th>Contact Number</th><th>Barangay</th><th>Actions</th></tr></thead>';
                    echo '<tbody>';

                    foreach ($accountRequests as $user) {
                        echo '<tr>';
                        echo '<td>' . $user['username'] . '</td>';
                        echo '<td>' . $user['first_name'] . ' ' . $user['last_name'] . '</td>';
                        echo '<td>' . $user['email'] . '</td>';
                        echo '<td>' . $user['contact_number'] . '</td>';
                        echo '<td>' . $user['barangay_name'] . '</td>';
                        echo '<td>';
                        
                        if (!isset($user['verified']) || !$user['verified']) {
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

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p>There are no account requests as of the moment.</p>';
                }

                echo '</div>';
                ?>
            </div>
        </div>
    </div>
</body>
</html>
