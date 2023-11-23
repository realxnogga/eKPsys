<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header.php'); ?>
    <title>Forgot Password</title>
</head>

<body>
    <div class="card" style="width: 30rem;">
        <div class="card-header">Forgot Password</div>
        <div class="card-body">
            <?php
            if (isset($_GET['error']) && $_GET['error'] === 'email_not_found') {
                echo '<div class="alert alert-danger" role="alert">There is no email registered with this email. Please check your email.</div>';
            }
            ?>
            <form action="forgotpass_handler.php" method="POST">
                <div class="form-row">
                    <div class="col">
                        <input type="email" class="form-control" placeholder="Enter your email" name="email">
                    </div>
                </div><br>
                <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
    </div>
    <!-- Footer -->
    <?php include('footer.php'); ?>
</body>

</html>
