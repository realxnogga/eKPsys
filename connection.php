<?php
$db_host = "localhost"; // Your database host
$db_name = "u681296935_ejusticesys"; // Your database name
$username = "u681296935_adminDILG"; // Your database username
$password = "Darkify18!"; // Your database password

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // Handle connection error gracefully, you might want to log the error or display a user-friendly message
}
?>
