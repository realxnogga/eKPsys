<?php
include 'connection.php'; // Ensure the database connection is established here

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_pic'])) {
    $userId = $_SESSION['user_id'];
    $uploadDir = 'profile_pictures/';

    // Get the uploaded file details
    $file = $_FILES['profile_pic'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];

    // Get image dimensions
    $imageSize = getimagesize($fileTmpName);
    $imageWidth = $imageSize[0];
    $imageHeight = $imageSize[1];
    echo "Uploaded file: " . $fileName;

    // Check file type and aspect ratio
    if (($file['type'] == 'image/jpeg' || $file['type'] == 'image/png') && $imageWidth === $imageHeight) {
        // Move the uploaded file to the profile pictures directory
        $destination = $uploadDir . $fileName;
        if (move_uploaded_file($fileTmpName, $destination)) {
            // Update the 'users' table with the file path/reference for this user
            $updateStmt = $conn->prepare("UPDATE users SET profile_picture = :profile_pic WHERE id = :user_id");
            $updateStmt->bindParam(':profile_pic', $destination, PDO::PARAM_STR);
            $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            if ($updateStmt->execute()) {
                // Consider returning a JSON response indicating success
                $response = [
                    'success' => true,
                    'message' => 'Profile picture uploaded and updated successfully.'
                ];
                echo json_encode($response);
            } else {
                // Consider returning a JSON response indicating failure
                $response = [
                    'success' => false,
                    'message' => 'Failed to update profile picture in the database.'
                ];
                echo json_encode($response);
            }
        } else {
            // Consider returning a JSON response indicating failure
            $response = [
                'success' => false,
                'message' => 'Failed to move uploaded file to the designated folder.'
            ];
            echo json_encode($response);
        }
    } else {
        // Consider returning a JSON response indicating file type or aspect ratio error
        $response = [
            'success' => false,
            'message' => 'File type should be JPG or PNG, and the image should be square (1:1 aspect ratio).'
        ];
        echo json_encode($response);
    }
} else {
    // Consider returning a JSON response indicating no file uploaded or invalid request
    $response = [
        'success' => false,
        'message' => 'No file uploaded or invalid request.'
    ];
    echo json_encode($response);
}

?>
