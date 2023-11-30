<?php
include 'connection.php';
include('header.php');

session_start(); // Starting the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in 'users' table
    $check_email_query = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user_row) {
        echo "This email is not yet registered into the system. Please check your spelling.";
    } else {
        $user_id = $user_row['id'];

        // Check if security questions exist for the user
        $check_security_query = "SELECT * FROM security WHERE user_id = :user_id";
        $stmt = $conn->prepare($check_security_query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $security_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$security_row) {
            echo "This user has not yet set their Security Questions, therefore unable to reset the password. Please request an admin to reset your password.";
        } else {
            // Storing user_id in session
            $_SESSION['user_id'] = $user_id;

            // Redirecting without user_id in URL
            header("Location: verify_account.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
</head>
<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="email" placeholder="Email" name="email" required>
        <input type="submit" value="Search">
    </form>
    <?php include('footer.php'); ?>
</body>
</html>
