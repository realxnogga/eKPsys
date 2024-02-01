<?php
session_start();
include 'connection.php';
include 'functions.php';

$usertype = $_SESSION['user_type'];

if ($usertype === "user") {
  include 'user-navigation.php';
}
elseif ($usertype === "admin") {
  include 'admin-nav.php';
}
elseif ($usertype === "superadmin") {
  include 'superadmin-navigation.php';
}

$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch the user's security questions from the database
$stmt = $conn->prepare("SELECT question1, question2, question3 FROM security WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$securityQuestions = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if security questions exist for the user
if ($securityQuestions) {
    $question1 = $securityQuestions['question1'];
    $question2 = $securityQuestions['question2'];
    $question3 = $securityQuestions['question3'];
} else {
    // Set empty values if no questions are found
    $question1 = '';
    $question2 = '';
    $question3 = '';
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
   
</head>
<br>

<body>

<div class="columns-container">
    <div class="left-column">
        <div class="settings">
            <h4><b>Account Settings</b></h4><br>
            <hr>
           <div class="row no-gutters row-bordered row-border-light">
                <!-- Sidebar -->
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action <?php echo !isset($_POST['security_settings']) ? 'active' : ''; ?>" data-toggle="list" href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action <?php echo isset($_POST['security_settings']) ? 'active' : ''; ?>" data-toggle="list" href="#account-security">Security</a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="tab-content">
                        <form id="profilePicForm" method="post" enctype="multipart/form-data">
                           <!-- Profile Picture Form -->
                                    <div class="prof-container">
                                        <img id="profilePic" src="profile_pictures/<?php echo $user['profile_picture'] ?: 'defaultpic.jpg'; ?>" alt="" class="d-block ui-w-80">
                                        <input type="file" id="fileInput" name="profile_pic" style="display: none;">
                                        <button type="button" id="uploadButton" class="upload-button">Upload a picture</button>
                                    </div>
                        </form>

                        <div class="card-body tab-pane fade <?php echo !isset($_POST['security_settings']) ? 'active show' : ''; ?>" id="account-general">
                            <h4><b>User Settings</b></h4>
                            <h6>
<?php if (!empty($message)) { ?>
    <p class="text-success"><?php echo $message; ?></p>
<?php } ?>

<?php if (!empty($error)) { ?>
    <p class="text-danger"><?php echo $error; ?></p>
<?php } ?>                            </h6>
                            <!-- General Settings -->
                            <form id="userSettingsForm" method="post" action="general_handler.php">
<div class="form-group">
                        <label for="first_name">User Name:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" ><br>
                    </div><br>
                    
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" ><br>
                    </div><br>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" ><br>
                    </div><br>
                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $user['contact_number']; ?>" ><br>
                    </div><br>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" ><br>
                    </div><br>
                    <div class="form-group">
                        <label for="new_password">New Password (leave empty to keep current password):</label>
                        <input type="password" class="form-control" pattern=".{8,}" title="Password must be at least 8 characters long" id="new_password" name="new_password"><br>
                    </div><br>    <input type="hidden" name="active_tab" value="general">
                                <button type="submit" class="save" name="general_settings">Save Changes</button>
                            </form>
                        </div>

                            <form id="securityForm" method="post" action="security_handler.php">
                        <div class="tab-pane fade <?php echo !isset($_POST['security_settings']) ? 'active show' : ''; ?>" id="account-security">
                            <h4>Security Questions</h4>
                             <h6>
<?php if (!empty($message)) { ?>
    <p class="text-success"><?php echo $message; ?></p>
<?php } ?>

<?php if (!empty($error)) { ?>
    <p class="text-danger"><?php echo $error; ?></p>
<?php } ?>     </h6>

<div class="form-group">
            <label for="question1">Security Question 1:</label>
    <select class="form-control" id="question1" name="question1" required>
            <option value="" <?php echo ($question1 == '') ? 'selected' : ''; ?>>Select a Question</option>
        <option value="1" <?php echo ($question1 == 1) ? 'selected' : ''; ?>>What is the name of your pet?</option>
        <option value="2" <?php echo ($question1 == 2) ? 'selected' : ''; ?>>What is your mother's maiden name?</option>
        <option value="3" <?php echo ($question1 == 3) ? 'selected' : ''; ?>>What city were you born in?</option>
        <option value="4" <?php echo ($question1 == 4) ? 'selected' : ''; ?>>What is your favorite book?</option>
    </select>

            <br>
            <label for="answer1">Answer:</label>
            <input type="password" class="form-control" id="answer1" name="answer1">
        </div>
        <div class="form-group">
            <label for="question2">Security Question 2:</label>
    <select class="form-control" id="question2" name="question2" required>
            <option value="" <?php echo ($question2 == '') ? 'selected' : ''; ?>>Select a Question</option>

        <option value="1" <?php echo ($question2 == 1) ? 'selected' : ''; ?>>What is the name of your pet?</option>
        <option value="2" <?php echo ($question2 == 2) ? 'selected' : ''; ?>>What is your mother's maiden name?</option>
        <option value="3" <?php echo ($question2 == 3) ? 'selected' : ''; ?>>What city were you born in?</option>
        <option value="4" <?php echo ($question2 == 4) ? 'selected' : ''; ?>>What is your favorite book?</option>
    </select>

            <br>
            <label for="answer2">Answer:</label>
            <input type="password" class="form-control" id="answer2" name="answer2">
        </div>
        <div class="form-group">
            <label for="question3">Security Question 3:</label>
    <select class="form-control" id="question3" name="question3" required>
            <option value="" <?php echo ($question3 == '') ? 'selected' : ''; ?>>Select a Question</option>

        <option value="1" <?php echo ($question3 == 1) ? 'selected' : ''; ?>>What is the name of your pet?</option>
        <option value="2" <?php echo ($question3 == 2) ? 'selected' : ''; ?>>What is your mother's maiden name?</option>
        <option value="3" <?php echo ($question3 == 3) ? 'selected' : ''; ?>>What city were you born in?</option>
        <option value="4" <?php echo ($question3 == 4) ? 'selected' : ''; ?>>What is your favorite book?</option>
    </select>

            <br>
            <label for="answer3">Answer:</label>
            <input type="password" class="form-control" id="answer3" name="answer3">
        </div>
                                <button type="submit" class="save" name="security_settings">Save Security Settings</button>
                                <input type="hidden" name="active_tab" value="security">
                        </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const uploadButton = document.getElementById('uploadButton');
        const profilePic = document.getElementById('profilePic');
        const activeTab = sessionStorage.getItem('activeTab');

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

                fetch('upload_pic.php', {
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


        if (activeTab) {
            $(".account-settings-links a[href='" + activeTab + "']").addClass("active");
            $(".tab-pane").removeClass("active show");
            $(activeTab).addClass("active show");
        }

        $(".account-settings-links a").click(function(e) {
            e.preventDefault();
            $(".account-settings-links a").removeClass("active");
            $(this).addClass("active");
            $(".tab-pane").removeClass("active show").empty(); // Empty the content of unselected tabs
            $($(this).attr("href")).addClass("active show");

            sessionStorage.setItem('activeTab', $(this).attr("href"));
        });

    });
    </script>
</body>
</html>