<?php
include 'connection.php';
include('header.php');

session_start(); // Starting the session
// Check if the session key exists before accessing its value
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
        exit;
}
$errors = [];

$questions = [
    1 => "What is the name of your pet?",
    2 => "What is your mother's maiden name?",
    3 => "What city were you born in?",
    4 => "What is your favorite book?"
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve user inputs
    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];

    // Retrieve security answers for the user from the database
    $get_answers_query = "SELECT answer1, answer2, answer3 FROM security WHERE user_id = :user_id";
    $stmt = $conn->prepare($get_answers_query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $security_answers = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validate answers
    if (
        $security_answers &&
        password_verify($answer1, $security_answers['answer1']) &&
        password_verify($answer2, $security_answers['answer2']) &&
        password_verify($answer3, $security_answers['answer3'])
    ) {
         $_SESSION['verification_complete'] = true; // Set a session variable upon successful verification
    header("Location: reset_pass.php"); // Redirect to reset password page
    exit;
    } else {
        // Prepare error message for incorrect answers
        $errors[] = "One or more answers are incorrect. Please try again.";
    }
}

// Display security questions
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $get_questions_query = "SELECT question1, question2, question3 FROM security WHERE user_id = :user_id";
    $stmt = $conn->prepare($get_questions_query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $security_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$security_row) {
        // Security questions not found for this user
        $errors[] = "Security questions not found for this user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify Account</title>
</head>
<body>
    <h2>Verify Your Account</h2>
    <?php
    // Display error messages
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
    ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php if (isset($security_row)) : ?>
            <label><?php echo $questions[$security_row['question1']]; ?></label>
            <input type="text" name="answer1" required><br>

            <label><?php echo $questions[$security_row['question2']]; ?></label>
            <input type="text" name="answer2" required><br>

            <label><?php echo $questions[$security_row['question3']]; ?></label>
            <input type="text" name="answer3" required><br>

            <input type="submit" value="Verify Answers">
        <?php endif; ?>
    </form>
    <a href="logout.php">Cancel</a>
</body>
</html>
<script>
window.addEventListener('beforeunload', function(event) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'logout.php', false); // Update this URL to match your logout script
    xhr.send();
});
</script>