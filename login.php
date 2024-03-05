<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">

  <style>
    body,
    html {
      height: 100%;
      margin: 0;
    }

    .card {
      box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
      border-radius: 15px;
      height: 100%; /* Set a fixed height for the card */
    }

    .page-wrapper {
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Style for slideshow container */
    .slideshow-container {
      max-width: 100%; /* Adjust the width to fit the card */
      position: relative;
      margin: auto;
    }

    /* Style for images in the slideshow */
    .mySlides img {
      max-width: 100%; /* Ensure image width doesn't exceed the container */
      height: auto;    /* Maintain aspect ratio */
      animation: fade 1.5s ease-in-out; /* Add fade animation */
      border-radius: 15px;

    }

    /* Style for caption text */
    .caption {
      position: absolute;
      bottom: 0;
      width: 100%;
      text-align: center;
      background-color: rgba(0, 0, 0, 0.5);
      color: #fff;
      padding: 10px;
      border-radius: 15px;

    }

    @keyframes fade {
      from {
        opacity: 0.4;
      }
      to {
        opacity: 1;
      }
    }
  </style>
</head>

<body style="background-color: #E8E8E7">
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Parent Container with Flexbox -->
    <div class="d-flex align-items-center justify-content-center w-100 h-100">
      <div class="row justify-content-center w-100">
        <!-- New Card (Aligned on the Left) with Adjusted Width -->
        <div class="col-md-8 col-lg-6 col-xxl-6">
          <div class="card mb-0">
            <div class="overlay"></div> <!-- Black overlay -->
            <div class="card-body">
              <!-- Content for the new card goes here -->
              <div class="text-center">
                <div class="slideshow-container">
                  <!-- Slides -->
                  <div class="mySlides">
                    <img src="img/s1.jpg" alt="Slide 1">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s2.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s3.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s4.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s5.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s6.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s7.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s8.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s9.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s10.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s11.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s12.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s13.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s14.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s15.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s16.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>

                  <div class="mySlides">
                    <img src="img/s17.jpg" alt="Slide 2">
                    <div class="caption">DILG Cluster A and the Developers of the E-KP System</div>
                  </div>
                  <!-- Add more slides as needed -->
                </div>
              </div>
              <!-- ... (form and other content for the new card) ... -->
            </div>
          </div>
        </div>

        <!-- Existing Login Card (Aligned on the Right) -->
        <div class="col-md-8 col-lg-6 col-xxl-4">
          <div class="card mb-0">
            <div class="overlay"></div> <!-- Black overlay -->
            <div class="card-body">
              <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100"></a>
              <div class="text-center">
                <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;"
                  class="align-middle"><br><br>
                <b><h5 class="card-title mb-9 fw-semibold">Login</h5></b>
              </div>
              <?php
                // Check if the 'error' query parameter is present in the URL
                if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials') {
                    // Display the error message below the input fields
                    echo '<div class="alert alert-danger" role="alert">Invalid email or password. Please try again.</div>';
                } elseif (isset($_GET['error']) && $_GET['error'] === 'not_verified') {
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
                <b><p>Don't have an account? <a href="registration.php">Sign up here</a>.</p></b>
                <div><input type="submit" class="btn btn-primary w-100"></div><br>
                <b><p><a href="javascript:void(0);" onclick="location.href='forgot_pass.php';"
                      style="font-size:16px;">Forgot Password?</a></p></b>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    let slideIndex = 0;

    function showSlides() {
      let i;
      const slides = document.getElementsByClassName("mySlides");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1;
      }
      slides[slideIndex - 1].style.display = "block";
      setTimeout(showSlides, 3000); // Change slide every 3 seconds
    }

    // Call the showSlides function to start the slideshow
    showSlides();
  </script>
</body>

</html>
