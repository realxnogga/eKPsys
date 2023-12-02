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

$searchedMunicipality = '';

// Handling search functionality
if (isset($_POST['search'])) {
    $searchedMunicipality = $_POST['municipality']; // Get the searched municipality
    $stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, m.municipality_name FROM users u
                            INNER JOIN municipalities m ON u.municipality_id = m.id
                            WHERE u.user_type = 'admin' AND m.municipality_name LIKE :municipality");
    $stmt->bindValue(':municipality', '%' . $searchedMunicipality . '%', PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Fetch all municipalities if no search is performed
    $stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, m.municipality_name FROM users u
                            INNER JOIN municipalities m ON u.municipality_id = m.id
                            WHERE u.user_type = 'admin'");
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Municipalities</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
    <?php include 'functions.php';?>
</head>
<hr>
<br>
<body>
    
    <h2><b>Registered Municipalities</b></h2>

    <form method="POST">
        <input type="text" name="municipality" placeholder="Search Municipality" value="<?php echo $searchedMunicipality; ?>">
        <input type="submit" name="search" value="Search">
        <input type="submit" name="clear" value="Clear" formnovalidate>
    </form>
    
    <div class="columns-container">
        <div class="left-column">
            <div class="card">
                <h4><b>Municipalities</b></h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
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
                                <td><?php echo $row['municipality_name']; ?></td>
                                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                <td><?php echo $row['contact_number']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                    <a href="ManageAccount.php?admin_id=<?php echo $row['id']; ?>" class="btn btn-primary">Manage</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
