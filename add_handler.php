<?php
$successMessage = "";
$userID = $_SESSION['user_id'];
$barangayID = $_SESSION['barangay_id'];


// Get the last used Case Number
$query = "SELECT CNum AS lastCaseNumber FROM complaints WHERE UserID = :userID ORDER BY Mdate DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$lastCaseNumber = $row ? $row['lastCaseNumber'] : null;

// If no Case Number exists, start with "01"
if (!$lastCaseNumber) {
    $caseNum = date('my') . '-01';
} else {
    // Extract the parts of the last case number
    $parts = explode('-', $lastCaseNumber);
    
    if (count($parts) === 2) {
        $lastMonthYear = $parts[0];
        $lastCase = intval($parts[1]);

        $currentMonthYear = date('my');
        $currentCase = ($lastMonthYear === $currentMonthYear) ? $lastCase + 1 : 1;

        // Format the case number with leading zeros
        $caseNum = $currentMonthYear . '-' . sprintf('%02d', $currentCase);
    } else {
        // Handle unexpected format of $lastCaseNumber
        $caseNum = date('my') . '-01';
    }
}

if (isset($_POST['submit'])) {
 
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
        // Get the ID of the last inserted complaint
    $lastInsertedId = $conn->lastInsertId();

    // Insert into case_progress table for the new complaint with default values
    $stmtCaseProgress = $conn->prepare("INSERT INTO case_progress (complaint_id, current_hearing) VALUES (:complaintId, '0')");
    $stmtCaseProgress->bindParam(':complaintId', $lastInsertedId, PDO::PARAM_INT);

    if ($stmtCaseProgress->execute()) {
        // Case progress updated successfully
        $successMessage = '<div class="alert alert-success" role="alert">
            Complaint Submitted Successfully!
        </div>';
    } else {
        // Failed to update case progress
        $successMessage = '<div class="alert alert-danger" role="alert">
            Failed to Update Case Progress. Contact Devs.
        </div>';
    }

    } else {
        // Failed to submit complaint
        $successMessage = '<div class="alert alert-danger" role="alert">
                Failed to Submit Complaint. Contact Devs.
              </div>';
    }
}

?>
