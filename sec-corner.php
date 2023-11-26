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

$action_submitted = isset($_GET['search']);

// Prepare the search query if search form is submitted
if ($action_submitted) {
    $search_query = $_GET['search'];
    $searchUsersQuery = "SELECT u.id, u.username, u.first_name, u.last_name, u.email, u.contact_number, b.barangay_name 
                        FROM users u 
                        LEFT JOIN barangays b ON u.barangay_id = b.id 
                        WHERE u.verified = 1 
                        AND (u.first_name LIKE '%$search_query%' 
                            OR u.last_name LIKE '%$search_query%' 
                            OR b.barangay_name LIKE '%$search_query%')";

    $searchUsersStatement = $conn->prepare($searchUsersQuery);
    $searchUsersStatement->execute();
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
            <input type="text" name="search" id="search" placeholder="Search by Name or Barangay Name" class="searchInput">
            <input type="submit" value="Search" class="refresh-button"> <!-- Changed type to submit -->
        </form>
        <?php // Your code before the table structure
$verifiedUsersStatement = $conn->prepare("SELECT id, username, first_name, last_name, email, contact_number, barangay_id FROM users WHERE verified = 1");
$verifiedUsersStatement->execute();
 ?>
        <div class="card-body">
            <div id="verified-users">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Barangay Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                 
                        <?php
echo '<tbody>';

if ($action_submitted) {
    while ($verifiedUser = $searchUsersStatement->fetch(PDO::FETCH_ASSOC)) {
        // Fetch barangay name for the current user if the key exists
        $barangayName = $verifiedUser['barangay_name'] ?? '';
        if (array_key_exists('barangay_id', $verifiedUser)) {
            $barangayNameQuery = "SELECT barangay_name FROM barangays WHERE id = ?";
            $barangayStatement = $conn->prepare($barangayNameQuery);
            $barangayStatement->execute([$verifiedUser['barangay_id']]);
            $barangayName = $barangayStatement->fetchColumn();
        }

        // Displaying table rows for search results
        echo '<tr>';
        echo '<td>' . $verifiedUser['username'] . '</td>';
        echo '<td>' . $verifiedUser['first_name'] . ' ' . $verifiedUser['last_name'] . '</td>';
        echo '<td>' . $verifiedUser['email'] . '</td>';
        echo '<td>' . $verifiedUser['contact_number'] . '</td>';
        echo '<td>' . $barangayName . '</td>';
        echo '<td>';
        // Your actions/buttons for search results
        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
        echo '<input type="hidden" name="user_id" value="' . $verifiedUser['id'] . '">';
        echo '<button class="unverify-button" type="submit" name="action" value="unverify">Unverify</button>';
        echo '</form>';
        echo '</td>';
        echo '<td>';
        // Your actions/buttons for search results
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
} else {
    while ($verifiedUser = $verifiedUsersStatement->fetch(PDO::FETCH_ASSOC)) {
        // Fetch barangay name for the current user if the key exists
        $barangayName = '';
      if (isset($verifiedUser['barangay_id'])) {
            $barangayNameQuery = "SELECT barangay_name FROM barangays WHERE id = ?";
            $barangayStatement = $conn->prepare($barangayNameQuery);
            $barangayStatement->execute([$verifiedUser['barangay_id']]);
            $barangayName = $barangayStatement->fetchColumn();
        }
        // Displaying table rows for verified users
        echo '<tr>';
        echo '<td>' . $verifiedUser['username'] . '</td>';
        echo '<td>' . $verifiedUser['first_name'] . ' ' . $verifiedUser['last_name'] . '</td>';
        echo '<td>' . $verifiedUser['email'] . '</td>';
        echo '<td>' . $verifiedUser['contact_number'] . '</td>';
        echo '<td>' . $barangayName . '</td>';
        echo '<td>';
        // Your actions/buttons for verified users
        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
        echo '<input type="hidden" name="user_id" value="' . $verifiedUser['id'] . '">';
        echo '<button class="unverify-button" type="submit" name="action" value="unverify">Unverify</button>';
        echo '</form>';
        echo '</td>';
        echo '<td>';
        // Your actions/buttons for verified users
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
}
// Closing table structure
echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
