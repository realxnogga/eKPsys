<?php
$successMessage = "";

// Function to get the next available Case Number
function getNextCaseNumber($conn) {
    // Get the last used Case Number
    $query = "SELECT MAX(CNum) AS lastCaseNumber FROM complaints";
    $result = $conn->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $lastCaseNumber = $row['lastCaseNumber'];

    // If no Case Number exists, start with "01"
    if (!$lastCaseNumber) {
        return date('my') . '-01';
    }

    // Extract the Year and Case Number parts
    $lastYearCase = explode('-', $lastCaseNumber);
    $lastYear = $lastYearCase[0];
    $lastCase = $lastYearCase[1];

    // Check if the Year part matches the current year
    $currentYear = date('my');
    if ($lastYear === $currentYear) {
        // Increment the Case Number part
        $caseNumber = intval($lastCase);
        $caseNumber++;
        return $lastYear . '-' . sprintf('%02d', $caseNumber);
    } else {
        // Start with "01" for the new year
        return $currentYear . '-01';
    }
}

if (isset($_POST['submit'])) {
    // Retrieve the logged-in user's UserID and BarangayID
    $userID = $_SESSION['user_id'];
    $barangayID = $_SESSION['barangay_id'];
    // Get the next available Case Number
    $caseNum = getNextCaseNumber($conn);

    // Sanitize and validate user input
    $forTitle = $_POST['ForTitle'];
    $complainants = $_POST['CNames'];
    $respondents = $_POST['RspndtNames'];
    $complaintDesc = $_POST['CDesc'];
    $petition = $_POST['Petition'];
    $madeDate = $_POST['Mdate'];
    $receivedDate = $_POST['RDate'];
    $caseType = $_POST['CType'];

    // Insert the complaint into the 'complaints' table with default values
    $stmt = $conn->prepare("INSERT INTO complaints (UserID, BarangayID, CNum, ForTitle, CNames, RspndtNames, CDesc, Petition, Mdate, RDate, CType, CStatus, CMethod) VALUES (:userID, :barangayID, :caseNum, :forTitle, :complainants, :respondents, :complaintDesc, :petition, :madeDate, :receivedDate, :caseType, 'Unsettled', 'Pending')");

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':barangayID', $barangayID, PDO::PARAM_INT);
    $stmt->bindParam(':caseNum', $caseNum, PDO::PARAM_STR);
    $stmt->bindParam(':forTitle', $forTitle, PDO::PARAM_STR);
    $stmt->bindParam(':complainants', $complainants, PDO::PARAM_STR);
    $stmt->bindParam(':respondents', $respondents, PDO::PARAM_STR);
    $stmt->bindParam(':complaintDesc', $complaintDesc, PDO::PARAM_STR);
    $stmt->bindParam(':petition', $petition, PDO::PARAM_STR);
    $stmt->bindParam(':madeDate', $madeDate, PDO::PARAM_STR);
    $stmt->bindParam(':receivedDate', $receivedDate, PDO::PARAM_STR);
    $stmt->bindParam(':caseType', $caseType, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Complaint submitted successfully
        $successMessage = '<div class="alert alert-success" role="alert">
                Complaint Submitted Successfully!
              </div>';
    } else {
        // Failed to submit complaint
        $successMessage = '<div class="alert alert-danger" role="alert">
                Failed to Submit Complaint. Check Code.
              </div>';
    }
}

?>
