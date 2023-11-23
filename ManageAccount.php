<?php
session_start();
include 'connection.php';
// include 'header.php';
include 'superadmin-navigation.php';
 // include 'admin-nav.php';
 include 'functions.php';

// Check if the user is a superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

// Check if the admin user ID is provided in the URL
if (isset($_GET['admin_id'])) {
    $adminId = $_GET['admin_id'];

    // Fetch admin user data based on the provided ID
    $stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, u.password, m.municipality_name FROM users u
                            INNER JOIN municipalities m ON u.municipality_id = m.id
                            WHERE u.user_type = 'admin' AND u.id = :admin_id");
    $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
    $stmt->execute();
    $adminUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$adminUser) {
        // Admin user not found, handle this case
        header("Location: superadmin_dashboard.php");
        exit;
    }
} else {
    // Admin user ID is not provided in the URL, handle this case
    header("Location: superadmin_dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newContactNumber = $_POST['contact_number'];
    $newEmail = $_POST['email'];

    // Check if a new password is provided
    if (!empty($_POST['new_password'])) {
        $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        // Perform SQL update to save the changes, including the new password
        $updateStmt = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email, password = :password WHERE id = :admin_id");
        $updateStmt->bindParam(':password', $newPassword, PDO::PARAM_STR); // Bind the new password
    } else {
        // Perform SQL update without changing the password
        $updateStmt = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email WHERE id = :admin_id");
    }

    $updateStmt->bindParam(':first_name', $newFirstName, PDO::PARAM_STR);
    $updateStmt->bindParam(':last_name', $newLastName, PDO::PARAM_STR);
    $updateStmt->bindParam(':contact_number', $newContactNumber, PDO::PARAM_STR);
    $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
    $updateStmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        // Redirect back to the superadmin dashboard after successful update
        header("Location: superadmin_dashboard.php");
        exit;
    } else {
        // Handle the case where the update fails
        $error = "Update failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Account</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
     <?php include 'functions.php';?>
</head>
<hr>
<br>
<body>
   <div class="columns-container">
    <div class="left-column">
        <div class="card">
        <h4><b>Manage Account</b></h4>
        <?php if (isset($error)) { ?>
            <p class="text-danger"><?php echo $error; ?></p>
        <?php } ?>
        <form method="post">
            
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $adminUser['first_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $adminUser['last_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $adminUser['contact_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $adminUser['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password (leave empty to keep current password):</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>
</div>
</body>
</html>