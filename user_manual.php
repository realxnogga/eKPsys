<?php
session_start();
include 'connection.php';
include 'index-navigation.php';
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Manual</title>
    <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .card {
            box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }
        .card img {
            max-width: 70%;
            max-height: auto;
            margin-right: 10px;
        }
        #search-bar {
            margin-top: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        #search-input {
            margin-right: 10px; /* Adjust the margin as needed */
        }   
        .highlight {
            background-color: yellow;
        }
    </style>
</head>

<body style="background-color: #E8E8E7">
    <div class="container-fluid">
        <a href="user_dashboard.php" class="btn btn-dark m-1">Back to Dashboard</a>
        <br><br>

        <div class="card">
            <div class="card-body">
                <!-- Add the search bar -->
                    <div id="search-bar">
                        <label for="search-input">Search: </label>
                        <input type="text" id="search-input" class="form-control" onkeydown="if (event.key === 'Enter') search()">
                        <button type="button" onclick="search()">Go</button>
                    </div>

                <ul class="nav nav-tabs" id="myTabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1">Register/Login</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#content2">User Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content3">Lupon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab4" data-bs-toggle="tab" href="#content4">Complaints</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab5" data-bs-toggle="tab" href="#content5">Archives</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab6" data-bs-toggle="tab" href="#content6">Reports</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="content1">
                <h2 id="section1">1. Register</h2>
                    <b>
                    <p>To register, go to the link <a href="https://ekpsystem.online/ekpsys/registration.php" target="_blank">https://ekpsystem.online/ekpsys/registration.php</a>.</p>
                    <img src="img/img1.png"><br><br>
                    <p>1. Select your Municipality.</p>
                    <p>2. For username, enter "brgy" and then your barangay name. (Ex. <span style="color: red;">brgybatongmalake</span>)</p>
                    <p>3. On first name, enter the word "Barangay" and last name is your barangay name. (Ex. <span style="color: red;">Barangay Batong Malake</span>)</p>
                    <img src="img/img2.png"><br>
                    <p>4. Enter your email in this format: "clustera" underscore your barangay, underscore "ekp" (Ex. <span style="color: red;">clustera_batongmalake_ekp@gmail.com</span>)</p>
                    <img src="img/img3.png"><br>
                    <p>5. Enter your '11' digit number.</p>
                    <img src="img/img4.png"><br>
                    <p>6. Enter a password with minimum of '8' characters including uppercase (A-Z), lowercase (a-z), number (0-9), and special character (!@#$%^&*).</p>
                    <img src="img/img5.png"><br>
                    <p>7. Select your position. For user, choose 'Barangay Secretary' if an admin, choose 'C/LMGOOs'.</p>
                    <img src="img/img6.png"><br><br>
                    <p>8. When done filling up the form, click the 'Register' button.</p>
                <h2 id="section2">2. Login</h2>
                    <p>To login, go to the link <a href="https://ekpsystem.online/ekpsys/login.php" target="_blank">https://ekpsystem.online/ekpsys/registration.php</a>.</p>
                    <img src="img/img7.png"><br><br>
                    </b>
                    </div>
                    <div class="tab-pane fade" id="content2">
                        <!-- ... your existing content ... -->
                    </div>
                    <div class="tab-pane fade" id="content3">
                        <!-- ... your existing content ... -->
                    </div>
                    <div class="tab-pane fade" id="content4">
                        <!-- ... your existing content ... -->
                    </div>
                    <div class="tab-pane fade" id="content5">
                        <!-- ... your existing content ... -->
                    </div>
                    <div class="tab-pane fade" id="content6">
                        <!-- ... your existing content ... -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function search() {
            var searchTerm = $('#search-input').val().toLowerCase();
            var paragraphsAndHeadings = $('p, h2');

            // Remove previous highlights
            $('.highlight').removeClass('highlight');

            for (var i = 0; i < paragraphsAndHeadings.length; i++) {
                var text = $(paragraphsAndHeadings[i]).text();
                var updatedText = text;

                // Check if the paragraph or heading contains the search term
                if (text.toLowerCase().includes(searchTerm)) {
                    // Highlight all occurrences of the searched word
                    updatedText = updatedText.replace(new RegExp(searchTerm, 'gi'), function(match) {
                        return '<span class="highlight">' + match + '</span>';
                    });
                }

                // Update the paragraph or heading content
                $(paragraphsAndHeadings[i]).html(updatedText);
            }

            // Scroll to the first paragraph or heading containing the search term
            var firstMatchingElement = $('p:contains(' + searchTerm + '), h2:contains(' + searchTerm + ')').first();
            if (firstMatchingElement.length > 0) {
                $('html, body').animate({
                    scrollTop: firstMatchingElement.offset().top - 100
                }, 500);
            }
        }
    </script>
</body>
</html>
