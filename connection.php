<?php
$db_host = "localhost"; // Your database host
$db_name = "eJusticeSys"; // Your database name
$username = "root"; // Your database username
$password = ""; // Your database password

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Additional PDO configurations if needed
    // $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // Handle connection error gracefully, you might want to log the error or display a user-friendly message
}
?>
