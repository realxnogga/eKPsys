<?php
include 'connection.php';

session_start(); // Starting the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in 'users' table
    $check_email_query = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user_row) {
        echo "This email is not yet registered into the system. Please check your spelling.";
    } else {
        $user_id = $user_row['id'];

        // Check if security questions exist for the user
        $check_security_query = "SELECT * FROM security WHERE user_id = :user_id";
        $stmt = $conn->prepare($check_security_query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $security_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$security_row) {
            echo "This user has not yet set their Security Questions, therefore unable to reset the password. Please request an admin to reset your password.";
        } else {
            // Storing user_id in session
            $_SESSION['user_id'] = $user_id;

            // Redirecting without user_id in URL
            header("Location: verify_account.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>


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
    padding-right: 40px; /* Add padding to the right for better spacing */
    width: 100%;
    margin: 0 auto; /* Center the element horizontally */
}


.card {
    height: 83vh; /* Set the height to 100% of the viewport height */
    overflow: auto;
    margin-top: 70px; /* Add some padding to the bottom */
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
        



    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="email" placeholder="Email" name="email" required>
        <input type="submit" value="Search">
    </form>


    </div>
  </div> <!-- Close leftcolumn here -->
</body>
</html>
