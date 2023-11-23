<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

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
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social-links">Social links</a>
        </div>
    </div>

    <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane fade active show" id="account-general">

            <div class="card-body media align-items-center">
            
            <div class="prof-container">
                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="d-block ui-w-80">
                <button class="upload-button">Upload a picture</button>
            </div>     

            <br>

                </div>

              <hr class="border-light m-0">

              <div class="card-body">
                <div class="form-group">
                  <label class="form-label">Username</label>
                  <input type="text" class="form-control mb-1" value="<?php echo htmlspecialchars($row['username']); ?>">
                </div><br>

                <div class="form-group">
                  <label class="form-label">First Name</label>
                  <input type="text" class="form-control mb-1" value="<?php echo htmlspecialchars($row['first_name']); ?>">
                </div><br>

                 <div class="form-group">
                  <label class="form-label">Last Name</label>
                  <input type="text" class="form-control mb-1" value="<?php echo htmlspecialchars($row['last_name']); ?>">
                </div><br>

                <div class="form-group">
                  <label class="form-label">E-mail</label>
                  <input type="text" class="form-control mb-1" value="<?php echo htmlspecialchars($row['email']); ?>">
                </div><br>

                <div class="form-group">
                  <label class="form-label">Contact Number</label>
                  <input type="text" class="form-control mb-1" value="<?php echo htmlspecialchars($row['contact_number']); ?>">
                </div><br>
                
              </div>
              </div>

              <div class="tab-pane fade" id="account-change-password">
              <div class="card-body pb-2">

                <div class="form-group">
                  <label class="form-label">Current password</label>
                  <input type="password" class="form-control">
                </div><br>

                <div class="form-group">
                  <label class="form-label">New password</label>
                  <input type="password" class="form-control">
                </div><br>

                <div class="form-group">
                  <label class="form-label">Repeat new password</label>
                  <input type="password" class="form-control">
                </div><br>

              </div>
      
            </div>

            <div class="tab-pane fade" id="account-social-links">
              <div class="card-body pb-2">

                <div class="form-group">
                  <label class="form-label">Twitter</label>
                  <input type="text" class="form-control" value="https://twitter.com/user">
                </div><br>

                <div class="form-group">
                  <label class="form-label">Facebook</label>
                  <input type="text" class="form-control" value="https://www.facebook.com/user">
                </div><br>

                <div class="form-group">
                  <label class="form-label">Google+</label>
                  <input type="text" class="form-control" value="">
                </div><br>

                <div class="form-group">
                  <label class="form-label">Instagram</label>
                  <input type="text" class="form-control" value="https://www.instagram.com/user">
                </div><br>

              </div>
            </div>

            <div class="text-right mt-3">
                <button type="button" class="save">Save changes</button>&nbsp;
            </div>

                    

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Activate the clicked tab and deactivate others
        $(".account-settings-links a").click(function(e) {
            e.preventDefault();
            $(".account-settings-links a").removeClass("active");
            $(this).addClass("active");
            $(".tab-pane").removeClass("active show");
            $($(this).attr("href")).addClass("active show");
        });
    });
</script>
    
</body>
</html>
