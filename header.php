

<head>
  <link rel="icon" href="img/dilg.ico" type="image/ico">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="icon" href="img/dilg-logo.ico" type="image/x-icon">
<style>
  .navbar1 {
    font-size: 13px;
    padding-top: 0;
    padding-bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center; 
    height: 30px;
    color: #ffffff; 
    font-size: 14px; 
  }
  .navbar2 {
    height: 40px;
  }  
  .navbar {
    display: flex;
    top: -16px;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    background-color: white;
    padding: 10px 20px;
    position: relative;
    z-index: 1;
  }
  .navbar-logo {
    width: 360px; 
    height: 53px;
  }
  .navbar-logo img {
    width: 100%;
    height: auto;
  }             
  .search-bar-container {
    position: relative;
    display: inline-block;
  }
  .search-bar {
    padding-right: 50px;
  }
  .search-icon {
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    color: #A8A8A8;
  }
  .navbar-links {
    display: flex;
    align-items: center;
  }   
  .navbar-link {
    margin-right: 35px;
    color: #000;
  }
  .navbar-link:hover {
    color: red;
    text-decoration: underline;
  }
</style>
</head>

<body>
<!--navbar1-->
<navbar1 class="navbar1 navbar-danger" style="background: linear-gradient(to right, #660000 0%, #ff0000 50%) left,
linear-gradient(to left, #660000 0%, #ff0000 50%) right, #ff0000; background-size: 50% 100%, 50% 100%, auto; background-repeat: no-repeat; height: 35px">
    <span class="navbar1-text">Department of the Interior and Local Government</span>
</navbar1>

<!--navbar2-->
  <nav class="navbar2 navbar-expand-lg" style="background-color: #002D62;">
  <a class="nav-link" href="home.php">
  <div class style="color: white;">Cluster A | E-Justice System</div></nav>

<!--navbar3-->
<div class="navbar">
    <div class="navbar-logo">
        <img src="img/dilg-banner.png" alt="Logo">
    </div>
    <div class="navbar-links">
        <a class="navbar-link" href="about-us.php"><b>About</b></a>
        <a class="navbar-link" href="registration.php"><b>Register</b></a>
        <div class="search-bar-container">
        <input class="search-bar" type="text" placeholder="Search...">
        <i class="fas fa-search search-icon"></i></div>
        <i class="fas fa-user-circle navbar-user-icon" style="color:red; margin-left: 20px; margin-right: 8px"></i>
        <a class="navbar-link" href="login.php"><b>Sign In</b></a>
		<li class="breadcrumb-item active" aria-current="logout.php">
      <?php if (isset($_SESSION['user_id'])) {
    echo '<a class="nav-link" href="logout.php" style="margin-left: -17px; color: #000; font-weight: bold;" onmouseover="this.style.color=\'red\'" onmouseout="this.style.color=\'#000\'">Logout</a>';
    echo '</li>';

} ?>

</div>
</div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="script.js"></script>

</body>