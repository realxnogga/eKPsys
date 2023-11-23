<?php 
// Initialize the linkedNames array
$linkedNames = array();

// Check if the user has a row in the lupons table
$checkRowQuery = "SELECT user_id FROM lupons WHERE user_id = :user_id";
$checkRowStmt = $conn->prepare($checkRowQuery);
$checkRowStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$checkRowStmt->execute();
$rowExists = $checkRowStmt->fetchColumn();

// If the row doesn't exist, create a new row for the user
if (!$rowExists) {
    $createRowQuery = "INSERT INTO lupons (user_id) VALUES (:user_id)";
    $createRowStmt = $conn->prepare($createRowQuery);
    $createRowStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $createRowStmt->execute();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Ensure that only unique values are saved
    if (isset($_POST['linked_name']) && is_array($_POST['linked_name'])) {
        $linkedNames = array_unique($_POST['linked_name']);

        // Reorganize the array so that it starts from 1 and has no gaps
        $linkedNames = array_values($linkedNames);

        // Fill any missing values with null
        $linkedNames = array_pad($linkedNames, 20, null);
    } else {
        // Handle the case where $_POST['linked_name'] doesn't exist or is not an array
        // You might want to define a default behavior here, like initializing it with empty values
        $linkedNames = array_pad([], 20, null);
    }

    // Get the values of "Punong Barangay" and "Lupon Chairman" from POST
    $punongBarangay = $_POST['punong_barangay'];
    $luponChairman = $_POST['lupon_chairman'];

    try {
        // Use prepared statements to update the database
        $stmt = $conn->prepare("UPDATE lupons SET 
                                name1 = :name1, name2 = :name2, name3 = :name3, name4 = :name4, name5 = :name5, 
                                name6 = :name6, name7 = :name7, name8 = :name8, name9 = :name9, name10 = :name10,
                                name11 = :name11, name12 = :name12, name13 = :name13, name14 = :name14, name15 = :name15,
                                name16 = :name16, name17 = :name17, name18 = :name18, name19 = :name19, name20 = :name20,
                                punong_barangay = :punong_barangay, lupon_chairman = :lupon_chairman
                                WHERE user_id = :user_id");

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        for ($i = 1; $i <= 20; $i++) {
            $paramName = ":name" . $i;
            $stmt->bindParam($paramName, $linkedNames[$i - 1], PDO::PARAM_STR);
        }
        $stmt->bindParam(':punong_barangay', $punongBarangay, PDO::PARAM_STR);
        $stmt->bindParam(':lupon_chairman', $luponChairman, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
// Fetch linked names, Punong Barangay, and Lupon Chairman for the current user
$linkedNamesQuery = "SELECT name1, name2, name3, name4, name5, name6, name7, name8, name9, name10,
                         name11, name12, name13, name14, name15, name16, name17, name18, name19, name20,
                         punong_barangay, lupon_chairman
                     FROM lupons
                     WHERE user_id = :user_id";
$linkedNamesStmt = $conn->prepare($linkedNamesQuery);
$linkedNamesStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$linkedNamesStmt->execute();
$linkedNames = $linkedNamesStmt->fetch(PDO::FETCH_ASSOC);

// Set these values in sessions
$_SESSION['linkedNames'] = $linkedNames;



?>