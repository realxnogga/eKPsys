<?php

$db_host = "localhost"; // Hostname
$db_name = "eJusticeSys"; // Database name
$username = "root"; // Database username
$password = ""; // Database password

try {
    // Establish a connection to the database using PDO
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $username, $password);
    
    // Set PDO to throw exceptions on error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Display an error message if connection fails
    echo "Connection failed: " . $e->getMessage();
    exit(); // Terminate script
}
?>