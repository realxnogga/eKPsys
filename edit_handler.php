<?php
$successMessage = "";
$complaint = array(); // Initialize an empty array to store complaint data
$complaintId = isset($_GET['id']) ? $_GET['id'] : null;

if ($complaintId) {
    // Check if the complaint ID is provided in the URL
    // Add code to query the database and retrieve the complaint data based on the $complaintId
    $query = "SELECT * FROM complaints WHERE id = :complaintId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':complaintId', $complaintId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $complaint = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if (isset($_POST['submit'])) {
    // Retrieve the logged-in user's UserID and BarangayID
    $userID = $_SESSION['user_id'];
    $barangayID = $_SESSION['barangay_id'];

    // Sanitize and validate user input
    $caseNum = $_POST['CNum'];
    $forTitle = $_POST['ForTitle'];
    $complainants = $_POST['CNames'];
    $respondents = $_POST['RspndtNames'];
    $complaintDesc = $_POST['CDesc'];
    $petition = $_POST['Petition'];
    $madeDate = $_POST['MDate'];
    $receivedDate = $_POST['RDate'];
    $pangkat = $_POST['Pangkat'];
    $caseType = $_POST['CType'];
    $cStatus = $_POST['CStatus']; 
    $cMethod = $_POST['CMethod']; 
    
 if ($cStatus === 'Others') {
        // If 'Outside the Jurisdiction' is selected, set the Case Method value to null or an empty string
        $cMethod = null; // Or $cMethod = ''; depending on how you handle null values in the database
    }
    
    // Update the complaint in the 'complaints' table using an UPDATE query
    $stmt = $conn->prepare("UPDATE complaints SET CNum = :caseNum, ForTitle = :forTitle, CNames = :complainants, RspndtNames = :respondents, CDesc = :complaintDesc, Petition = :petition, MDate = :madeDate, RDate = :receivedDate, Pangkat = :pangkat, CType = :caseType, CStatus = :cStatus, CMethod = :cMethod WHERE id = :complaintId");



$stmt->bindParam(':caseNum', $caseNum, PDO::PARAM_STR);
    $stmt->bindParam(':forTitle', $forTitle, PDO::PARAM_STR);
    $stmt->bindParam(':complainants', $complainants, PDO::PARAM_STR);
    $stmt->bindParam(':respondents', $respondents, PDO::PARAM_STR);
    $stmt->bindParam(':complaintDesc', $complaintDesc, PDO::PARAM_STR);
    $stmt->bindParam(':petition', $petition, PDO::PARAM_STR);
    $stmt->bindParam(':madeDate', $madeDate, PDO::PARAM_STR);
    $stmt->bindParam(':receivedDate', $receivedDate, PDO::PARAM_STR);
    $stmt->bindParam(':pangkat', $pangkat, PDO::PARAM_STR);
    $stmt->bindParam(':caseType', $caseType, PDO::PARAM_STR);
    $stmt->bindParam(':complaintId', $complaintId, PDO::PARAM_INT);
    $stmt->bindParam(':cStatus', $cStatus, PDO::PARAM_STR);
    $stmt->bindParam(':cMethod', $cMethod, PDO::PARAM_STR);

    $updateSuccessful = $stmt->execute();

    if ($updateSuccessful) {
        // Update was successful
        $successMessage = '<div class="alert alert-success" role="alert">
                Complaint Updated Successfully!
              </div>';

        // Redirect the user back to the edit page with the updated complaint data
        header("Location: edit_complaint.php?id=$complaintId");
        exit;
    } else {
        // Update failed
        $successMessage = '<div class="alert alert-danger" role="alert">
                Failed to Update Complaint. Check Code.
              </div>';
    }
}
?>
