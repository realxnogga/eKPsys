<?php
session_start();
include 'connection.php';
include 'admin-nav.php';
include 'functions.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the user has the correct user_type
if ($_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Check if the user_id parameter is set in the URL
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Fetch user data based on the provided user_id
    $stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, m.municipality_name, b.barangay_name
                            FROM users u
                            INNER JOIN municipalities m ON u.municipality_id = m.id
                            INNER JOIN barangays b ON u.barangay_id = b.id
                            WHERE u.user_type = 'user' AND u.id = :user_id");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // User not found, handle this case
        header("Location: admin_dashboard.php");
        exit;
    }
} else {
    // user_id is not provided in the URL, handle this case
    header("Location: admin_dashboard.php");
    exit;
}

// Process form submissions for updating user data
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
        $updateStmt = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email, password = :password WHERE id = :user_id");
        $updateStmt->bindParam(':password', $newPassword, PDO::PARAM_STR); // Bind the new password
    } else {
        // Perform SQL update without changing the password
        $updateStmt = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email WHERE id = :user_id");
    }

    $updateStmt->bindParam(':first_name', $newFirstName, PDO::PARAM_STR);
    $updateStmt->bindParam(':last_name', $newLastName, PDO::PARAM_STR);
    $updateStmt->bindParam(':contact_number', $newContactNumber, PDO::PARAM_STR);
    $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
    $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        // Redirect back to the admin dashboard after successful update
        header("Location: admin_dashboard.php");
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
    <meta charset="UTF-8">
    <title>Manage User Account</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
</head>
<body>
<div class="columns-container">
    <div class="left-column">
        <div class="user">
        <h4><b>Manage User Account</b></h4><br>
        <?php if (isset($error)) { ?>
            <p class="text-danger"><?php echo $error; ?></p>
        <?php } ?>
        <form method="post">
            <!-- Display user information in form fields -->
            <div class="form-group">
                <label for="municipality_name">Municipality Name:</label>
                <input type="text" class="form-control" id="municipality_name" name="municipality_name" value="<?php echo $user['municipality_name']; ?>" readonly><br>
            </div><br>
            <div class="form-group">
                <label for="barangay_name">Barangay Name:</label>
                <input type="text" class="form-control" id="barangay_name" name="barangay_name" value="<?php echo $user['barangay_name']; ?>" readonly><br>
            </div><br>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required><br>
            </div><br>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required><br>
            </div><br>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $user['contact_number']; ?>" required><br>
            </div><br>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>
            </div><br>
            <div class="form-group">
                <label for="new_password">New Password (leave empty to keep current password):</label>
                <input type="password" class="form-control" id="new_password" name="new_password"><br>
            </div><br>
            <button type="submit" class="save">Save Changes</button>
        </form>
    </div>
</div>
</div>
</body>
</html>


