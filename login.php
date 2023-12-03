<?php 
    
include 'connection.php';
include 'functions.php';

// Check if the session key exists before accessing its value
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit;
    } elseif ($_SESSION['user_type'] === 'user') {
        header("Location: user_dashboard.php");
        exit;
    } elseif ($_SESSION['user_type'] === 'superadmin') {
        header("Location: superadmin_dashboard.php");
        exit;
    }
}
     ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    
    html, body {
    overflow: hidden;
    height: 100%;
    margin: 0;
}

* {
    box-sizing: border-box;
}

body {
    font-family: 'Roboto';
    color: black;
    height: 100%;
    margin: 0;
    background: #e9ecf3;
}

.row:after {
    content: "";
    display: table;
    clear: both;
}

.leftcolumn {   
    padding-left: 40px;
    padding-right: 0;
    float: left;
    width: 70%;
}

.rightcolumn {
    padding-right: 40px;
    float: left;
    width: 30%;
    padding-left: 15px;
}

.card {
    height: 79vh; /* Set the height to 100% of the viewport height */
    overflow: auto;
    margin-top: 90px; /* Add some padding to the bottom */
    padding-bottom: 0; /* Add some padding to the bottom */
    transition: height 0.3s ease; /* Add a smooth transition effect for height changes */
}

.row:after {
    content: "";
    display: table;
    clear: both;
}

@media screen and (max-width: 800px) {
    .leftcolumn, .rightcolumn {   
        width: 100%;
        padding: 0;
    }
}

.card {
    color: black;
    background: white; 
    border-radius: 20px;
    padding: 60px;
    margin-bottom: 10px;
    flex-basis: calc(33.33% - 20px); 
    box-sizing: border-box;
    box-shadow: 0 0 7px #16336d34;  
}

.navbar {
    background: #e9ecf3;
    margin-top: -50px; 
    color: #000000;
    padding: 0; 
    display: flex;
    justify-content: space-between; 
    align-items: center;
}

.navbar ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center; 
    
}

.navbar ul li {
    margin: 0;
    margin-right: 20px; 
}

.navbar ul li a {
    font-size: 20px;
    color: black;
    text-decoration: none;
    transition: color 0.3s ease-in-out;
}

.navbar ul li a:hover {
    color: #b41f1f;
}

.logo img {
    margin-top: 75px; 
    margin-bottom: -45px; 
    margin-left: 40px; 
    max-height: 85px; 
}

.card h2 {
    font-size: 18px;
    color: #727272;
    margin: 0;
}  

.card h3 {
    font-size: 23px;
    color: black;
    margin: 0;
} 

* {
  box-sizing: border-box;
}

.column {
  float: left;
  width: 33.33%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}



        figure {
            display: flex;
            align-items: center;
        }

        .myImage1 {
            width: 300px; /* Set the desired width */
            height: auto;
            margin-right: 20px; /* Add some spacing between image and caption */
            background-color: #16336D; /* Set the background color for the image */
            padding: 10px; /* Optional: Add padding for better appearance */
            border-radius: 20px;

        }

        .myImage2 {
            width: 300px; /* Set the desired width */
            height: auto;
            margin-right: 20px; /* Add some spacing between image and caption */
            background-color: #16336D; /* Set the background color for the image */
            padding: 10px; /* Optional: Add padding for better appearance */
            border-radius: 20px;

        }
        figcaption {
            margin: 0;
            height: 300px; /* Set the desired width */
            background-color: #16336D; /* Set the background color for the caption */
            color: #fff; /* Set the text color for better contrast */
            padding: 40px; /* Optional: Add padding for better appearance */
            border-radius: 20px;
        }

      


</style>
</head>
<body>

<div class="content">
            <div class="navbar">
                <div class="logo">
                    <img src="img/dilg-banner.png" alt="Logo">
                </div>
                <ul>
             

<li>
 
                </ul>
            </div>
            

<div class="row">
  <div class="leftcolumn">
    <div class="card">
        
 
    <h3>DILG | UPDATES</h3><br>

   
    <figure>
    <img class="myImage1" src="img/2.jpg" alt="Your Image Description">

    <figcaption><b>AMNESTY TO REBELS AND INSURGENTS GROUP</b><br><hr>DILG Secretary applauds and welcomes the decision on granting amnesty to former rebels and insurgents group, as it creates a conducive environment for reconciliation and social transformation.<br><br>#DILGNatin
</figcaption>
</figure>






    <figure>
    <img class="myImage2" src="img/1.jpg" alt="Your Image Description">

    <figcaption><b>LOOK | DILG Secretary Benhur Abalos, Jr. on November 27, 2023. Monday, led the turn-over of some P2-million worth of hygiene products to the BJMP at the Manila City Jail Male Dormitory.</b><br><hr>“Sa inyong lahat, itong araw na ito ay simbolo ng puso, ng pagkakaisa. Andito ang Reckitt Benckiser Group, walang hiningi, nagbigay pa ng 2 milyong worth na hygiene kits at marami pang ibibigay. Napakalaking bagay nito sa pag-iwas natin sa sakit,” Abalos told inmates.<br><br>The hygiene kits which were donated by Reckitt Benckiser Group will be distributed to different jail facilities to help maintain cleanliness and ensure good hygiene among inmates.


</figcaption>
</figure>


<br>
<hr>
<br>

    

      <h3>E-KATARUNGAN: A WEB-BASED LOCAL GOVERNMENT UNIT CIVIL CASE REPORT SYSTEM FOR THE DILG CLUSTER A OF THE PROVINCE OF LAGUNA</h3><br>

      <h2>Welcome to the heart of innovation! Our dedicated team of developers is passionate about transforming ideas into cutting-edge solutions. We are a group of six dynamic individuals who thrive on challenges and believe in the power of technology to shape a better future.</h2><br><hr><br>

      <h3>Our Mission:</h3><br>

      <h2>Our mission is centered around revolutionizing the way barangays manage information. We are dedicated to providing solutions that streamline administrative processes for barangay secretaries, enhance data analysis capabilities, and contribute to more efficient governance. Our focus encompasses three key objectives</h2><br>
        
        <b>► Information Management Module:</b>
        We are committed to developing a robust information management module designed exclusively for barangay secretaries. This module will empower them to effortlessly store and organize new complaints, ensuring a systematic and efficient approach to handling community concerns.<br><br>

        <b>► Reports Module for Comprehensive Analysis:</b>
        Our team is working diligently on a reports module that goes beyond traditional data summaries. This module will provide users with the ability to easily generate insightful reports on a weekly, monthly, or annual basis. These reports will offer a comprehensive view of data trends, enabling barangay officials to make informed decisions and plan strategically for the future.<br><br>

        <b>► ISO 25010 Beta Testing with DILG Cluster A:</b>
        We are taking our commitment further by conducting beta testing with various barangays included in the DILG Cluster A. Our goal is to ensure that our solutions meet the highest standards of quality and performance. Through rigorous testing based on ISO 25010, we aim to deliver a product that not only meets but exceeds the expectations of our users, providing a seamless and reliable experience.<br><br><hr><br>

        <h3>Our Expertise:</h3><br>

        <h2>With expertise in Web and Mobile Application Development we have successfully delivered this project. Our skills are complemented by a commitment to staying up-to-date with industry trends and adopting best practices.</h2><br><hr><br>

        <h3>Meet the team:</h3><br>

        <h2>Get to know the brains behind this project. Our team is composed of talented individuals with diverse backgrounds and skill sets.</h2><br>
        
     




    </div>
  </div> <!-- Close leftcolumn here -->
  
  <div class="rightcolumn">
    <div class="card">
    <h3>LOGIN</h3><hr>

      
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

				<p><a href="javascript:void(0);" onclick="location.href='forgot_pass.php';"  style="font-size:12px;">Forgot Password?</a></div>
        </div>
    </div>
	

    </div>
  </div>
</div>

</body>
</html>
