<?php
// Fetch user data based on the logged-in user's ID
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Process form submissions for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newContactNumber = $_POST['contact_number'];
    $newEmail = $_POST['email'];
    $newUsername = $_POST['username'];

    // Check if a new password is provided
    if (!empty($_POST['new_password'])) {
        $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        // Perform SQL update to save the changes, including the new password
        $updateStmt = $conn->prepare("UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email, password = :password WHERE id = :user_id");
        $updateStmt->bindParam(':password', $newPassword, PDO::PARAM_STR); // Bind the new password
    } else {
        // Perform SQL update without changing the password
        $updateStmt = $conn->prepare("UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, contact_number = :contact_number, email = :email WHERE id = :user_id");
    }

    $updateStmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
    $updateStmt->bindParam(':first_name', $newFirstName, PDO::PARAM_STR);
    $updateStmt->bindParam(':last_name', $newLastName, PDO::PARAM_STR);
    $updateStmt->bindParam(':contact_number', $newContactNumber, PDO::PARAM_STR);
    $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
    $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        // Redirect back to the user settings page after successful update
        header("Location: user-settings.php");
        exit;
    } else {
        // Handle the case where the update fails
        $error = "Update failed. Please try again.";
    }
}

?>
