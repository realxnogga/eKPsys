<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">

</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                </a>
                <div class="text-center">
    <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle"><br><br>
    <b><h5 class="card-title mb-9 fw-semibold">Login</h5></b>
</div>

                
                <?php
           
           // Check if the 'error' query parameter is present in the URL
           if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials') {
               // Display the error message below the input fields
               echo '<div class="alert alert-danger" role="alert">Invalid email or password. Please try again.</div>';
           }

           elseif (isset($_GET['error']) && $_GET['error'] === 'not_verified') {
               // Display the error message below the input fields
               echo '<div class="alert alert-danger" role="alert">This account is not verified yet. Please contact your Admin.</div>';
           }


           ?>

           <form action="login_handler.php" method="POST">
               <div class="form-row">
                   <div class="col">
                   <label for="exampleInputEmail1" class="form-label">Email Address</label>
                       <input type="email" class="form-control" name="email">
                   </div>
               </div><br>
               <div class="form-row">
                   <div class="col">
                   <label for="exampleInputEmail1" class="form-label">Password</label>
                       <input type="password" class="form-control" name="password">
                   </div>

               </div><br>
             <b>  <p>Don't have an account? <a href="registration.php">Sign up here</a>.</p>

                <div><input type="submit" class="btn btn-primary w-100"></div><br>

            <b>  <p> <a href="javascript:void(0);" onclick="location.href='forgot_pass.php';"  style="font-size:16px;">Forgot Password?</a></p>


       </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>