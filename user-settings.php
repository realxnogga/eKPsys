<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}
include 'upload_pic.php';

include 'update_user.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
   
</head>
<hr><br>

<body>

<div class="columns-container">
    <div class="left-column">
        <div class="settings">
        <h4><b>Account Settings</b></h4><br>

    <div class="row no-gutters row-bordered row-border-light">
        <div class="col-md-3 pt-0">
          <div class="list-group list-group-flush account-settings-links">
            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
        </div>
    </div>

   <div class="col-md-9">
                    <div class="tab-content">
            <form id="profilePicForm" method="post" enctype="multipart/form-data">
                        <div class="tab-pane fade active show" id="account-general">

                           <!-- Profile Picture Form -->
                <div class="prof-container">
                    <img id="profilePic" src="profile_pictures/<?php echo $user['profile_picture'] ?: 'defaultpic.jpg'; ?>" alt="" class="d-block ui-w-80">
                    <input type="file" id="fileInput" style="display: none;">
                    <button type="button" id="uploadButton" class="upload-button">Upload a picture</button>
                </div>
         
            <br>

                            </div>

              <hr class="border-light m-0">
              <div class="card-body">
<h4><b>User Settings</b></h4><br>
                <?php if (isset($error)) { ?>
                    <p class="text-danger"><?php echo $error; ?></p>
                <?php } ?>
                    <div class="form-group">
                        <label for="first_name">User Name:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required><br>
                    </div><br>
                    
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required><br>
                    </div><br>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required><br>
                    </div><br>
                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $user['contact_number']; ?>" required><br>
                    </div><br>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>
                    </div><br>
                    <div class="form-group">
                        <label for="new_password">New Password (leave empty to keep current password):</label>
                        <input type="password" class="form-control" id="new_password" name="new_password"><br>
                    </div><br>
                    <button type="submit" class="save">Save Changes</button>
                </form>
                    

        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const uploadButton = document.getElementById('uploadButton');
        const profilePicForm = document.getElementById('profilePicForm');
        const profilePic = document.getElementById('profilePic');

        // Handle button click to trigger file input
        uploadButton.addEventListener('click', function() {
            fileInput.click();
        });

        // Handle file input change
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(file);

                // Upload the file using Fetch API
                const formData = new FormData();
                formData.append('profile_pic', file);

                fetch('upload-pic.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok.');
                    }
                    return response.text();
                })
                .then(data => {
                    // Handle the response
                    console.log('Upload successful:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });
</script>
    
</body>
</html>
