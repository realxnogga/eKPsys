<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    
    include 'connection.php';
    include('header.php');
     session_start();

     if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit; 
  }

    elseif (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'user') {
    header("Location: user_dashboard.php");
    exit;
  }

    elseif (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'superadmin') {
    header("Location: superadmin_dashboard.php");
    exit;
  }


     ?>
    <title>Login</title>
</head>
<title>Login</title>
</head>
<style>
     .rectangle-container {
            top: -20px;
            position: relative;
            width: 100%;
            height: 430px; /* Adjust the height as needed */
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
  }

  .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(5px); /* Apply blur effect */
            z-index: -1; /* Place behind other content */
  }
  .clear-image {
            top: 0;
            left: 20;
            width: 80%;
            height: 100%;
            object-fit: cover;
  } 
  .card {
    position: relative;
    top: 50px;
    left: 36%;
    transform: translate(-50%);
    max-width: 380px; 
    height: 505px;  
    background: #ffffff;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    margin-bottom: 120px;
  }

  .custom-button {
    background-color: #16336d;
    color: white;
    border: none;
  }
  
  .slideshow-card {
    position: relative;
    width: 100%;
    max-width: 380px;
    margin: -576px 0 0 50px; 
    padding: 35px;
    left: 65%;
    transform: translateX(-50%);
    background-color: #F0F0F0;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 120px;
}


.slideshow {
    width: 100%;
    height: 435px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    }
.slideshow img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    animation: fade 5s infinite;
    }
.slideshow-controls {
    position: relative; 
    }
.slideshow-controls button {
    position: absolute; 
    top: 50%; 
    right: 0; 
    transform: translateY(-50%);
    
    background-color: darkred;
    color: white;
    border: none;
    padding: 5px 15px;
    cursor: pointer;
    transition: background-color 0.3s;
    }

.slideshow-controls button:hover {
    background-color: red;
    }

@keyframes fade {
    0% { opacity: 0; }
    20% { opacity: 1; }
    80% { opacity: 1; }
    100% { opacity: 0; }
    }
</style>
<body>
    <!-- Form -->
    <div class="card" style="width: 25rem;">
        <div class="card-header"><h3>Login to your account</h3></div>
        <div class="card-body">
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
                        <input type="email" class="form-control" placeholder="Email" name="email">
                    </div>
                </div><br>
                <div class="form-row">
                    <div class="col">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>

                </div><br>
                <div class="form-group">
        <label for="rememberMe">Remember Me</label>
        <input type="checkbox" id="rememberMe" name="rememberMe">
    </div>
                 <div style="text-align: right;"><input type="submit" class="btn custom-button btn-primary" style="width: 100px;" value="Log in"></div>
             </form>
             <br>
                <div style="text-align: center; font-size:12px;"><p>Don't have an account? <a href="javascript:void(0);" onclick="location.href='registration.php';">Register here</a>.</p>

				<p><a href="javascript:void(0);" onclick="location.href='forgotpass.php';"  style="font-size:12px;">Forgot Password?</a></div>
        </div>
    </div>
	<div class="slideshow-card">
    <div class="slideshow">
        <div class="slide">
            <h2 style="margin-top: 10; font-weight: bold; line-height: 1.5;">Department of Interior and Local Government</h2>
            <p style="line-height: 2.0;">The Department of the Interior and Local Government (DILG) is a government agency responsible for supervising local government units and promoting peace and order, public safety, and effective local governance in the Philippines.</p>
        </div>
        <div class="slide">
            <img src="img/mission.png" alt="Slideshow Image 1">
        </div>
        <div class="slide">
            <img src="img/vision.png" alt="Slideshow Image 2">
        </div>
        <div class="slide">
            <img src="img/values.png" alt="Slideshow Image 3">
        </div>
    </div>
    <div class="slideshow-controls">
        <button onclick="nextSlide()"> &#10095;</button>
    </div>
</div>
<div class="rectangle-container">
    <img class="background-image" src="img/dilg_2.jpg" alt="Background Blurred Image">
    <img class="clear-image" src="img/dilg_1.jpg" alt="Clear Image">
</div>



	
	
	
	

<script>
    var slideIndex = 0;
    var slides = document.getElementsByClassName("slide");

    function showSlide(n) {
        if (n < 0) {
            slideIndex = slides.length - 1;
        } else if (n >= slides.length) {
            slideIndex = 0;
        }

        for (var i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        slides[slideIndex].style.display = "block";
    }

    function prevSlide() {
        showSlide(slideIndex -= 1);
    }

    function nextSlide() {
        showSlide(slideIndex += 1);
    }

    showSlide(slideIndex);
</script>

<script>
    let slideIndex = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.slideshow img');
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
        }
        slides[index].style.display = 'block';
    }

    function prevSlide() {
        slideIndex--;
        if (slideIndex < 0) {
            slideIndex = 2;
        }
        showSlide(slideIndex);
    }

    function nextSlide() {
        slideIndex++;
        if (slideIndex > 2) {
            slideIndex = 0;
        }
        showSlide(slideIndex);
    }

    window.addEventListener('load', function() {
        showSlide(slideIndex);
    });
</script>
	
	

    <!-- Footer -->
    <?php include('footer.php'); ?>

</body>

</html>