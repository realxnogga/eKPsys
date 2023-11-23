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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Superadmin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
     <?php include 'functions.php';?>

    <!-- <style>
        .container {
            padding: 20px;
        }
    </style> -->
</head>
<hr>
<br>
<body>
    
    <h2><b>Super Admin Dashboard</b></h2>
    <br>
    <br>
<!-- <div class="columns-container">
    <div class="left-column">
        <div class="card">
        <h4><b>Municipalities</b></h4>

        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Municipality</th>
                    <th>Admin</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user as $row) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['municipality_name']; ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td><?php echo $row['contact_number']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="ManageAccount.php?admin_id=<?php echo $row['id']; ?>" class="btn btn-primary">Manage Account</a>
                            <button class="btn btn-success">Request Reports</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div> -->

</body>
</html>
