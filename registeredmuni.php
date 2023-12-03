<?php
session_start();
include 'connection.php';
include 'superadmin-navigation.php';
include 'functions.php';

// Check if the user is a superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

$searchedMunicipality = '';

// Handling search functionality
if (isset($_POST['search'])) {
    $searchedMunicipality = $_POST['municipality']; // Get the searched municipality
    $stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, m.municipality_name FROM users u
                            INNER JOIN municipalities m ON u.municipality_id = m.id
                            WHERE u.user_type = 'admin' AND m.municipality_name LIKE :municipality");
    $stmt->bindValue(':municipality', '%' . $searchedMunicipality . '%', PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Fetch all municipalities if no search is performed
    $stmt = $conn->prepare("SELECT u.id, u.municipality_id, u.first_name, u.last_name, u.contact_number, u.email, m.municipality_name FROM users u
                            INNER JOIN municipalities m ON u.municipality_id = m.id
                            WHERE u.user_type = 'admin'");
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Municipalities</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <?php include 'functions.php';?>
    <style>
/* Style for the search wrapper */
.search-wrapper {
    position: relative;
    display: inline-block;
    width: 540px; /* Adjust width as needed */
    border-radius: 10px; /* Round corners for wrapper */
    border: 1px solid #ccc; /* Thin line border */
    overflow: hidden; /* Hide overflow to maintain border-radius */
}

/* Style for the search input field */
input[type="text"] {
    width: 100%; /* Take full width of the wrapper */
    padding: 10px 20px; /* Add padding for spacing */
    border: none; 
    font-size: 16px; /* Increase font size for readability */
    outline: none; /* Remove default outline */

}

/* Style for the search button */
.search-btn {
    position: absolute;
    right: 0;
    top: 0;
    width: 50px; /* Fixed width for the button */
    height: 100%; /* Match height of the input field */
    color: white; /* White text */
    border: none;
    cursor: pointer;
    text-align: center; /* Center the icon */
    font-size: 16px; /* Match font size of the input field */
    border-radius: 0 2px 2px 0; /* Rounded right corners only */
}

/* Specific style for the Clear button */
input[name="clear"] {
    background-color: red; /* Red color for the Clear button */
    color: white;
    border-radius: 5px;
    margin-left: 10px; /* Add margin for spacing */
    padding: 6px 12px;
    border: none;
    cursor: pointer;
}

/* Style for the search button */
.search-btn {
    background-color: #4CAF50; /* Green background */
}

/* Hover effect for the search button */
.search-btn:hover {
    background-color: #3a8e3a; /* Dark green color on hover */
}


/* Style for the Clear button */
input[name="clear"] {
    background-color: red; /* Red color for the Clear button */
    color: white;
    border: none; /* Remove border */
    cursor: pointer;
    padding: 10px 20px; /* Adjust padding to match search bar height */
    margin-left: 10px; /* Add margin for spacing */
    font-size: 16px; /* Match font size of the search bar */
    border-radius: 10px; /* Rounded corners to match search bar */
    vertical-align: top; /* Align with the top of search bar */
}

/* Hover effect for the Clear button */
input[name="clear"]:hover {
    background-color: #b30000; /* Darker red color on hover */
}


        /* Style for the background color */
        body {
            background-color: #e9ecf3; /* Light gray background color */
        }

        .card {
            border-radius: 20px; /* Set the radius of the card's corners to 20px */

        }

.container {
    width: 100%; /* Adjust this as needed */
    max-width: 960px; /* Example max width, adjust to match your design */
    margin: auto; /* Center the container */
}

/* Style for the search wrapper */
.search-wrapper {
    width: 93%; /* Take full width of the container */
}

.municipality-column {
    width: 21%; /* Adjust the width as needed */
}

.admin-column {
    width: 23%; /* Adjust the width as needed */
}

.contact-column {
    width: 23%; /* Adjust the width as needed */
}

.email-column {
    width: 23%; /* Adjust the width as needed */
}

.actions-column {
    width: 10%; /* Reduce the width as needed */
}
</style>
</head>
<body>

    <div class="columns-container">
        <div class="left-column">
            <div class="card">
    <h4><b>Registered Municipalities</b></h4><hr><br>

<form method="POST" class="search-form">
    <div class="search-wrapper">
        <input type="text" name="municipality" placeholder="Search Municipality" value="<?php echo $searchedMunicipality; ?>">
        <button type="submit" name="search" class="btn-light search-btn">
            <i class="fas fa-search"></i>
        </button>
    </div>

    <input type="submit" name="clear" value="Clear" formnovalidate>

</form>



                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th class="municipality-column" style="padding: 8px; background-color: #d3d3d3;">Municipality</th>
                        <th class="admin-column" style="padding: 8px; background-color: #d3d3d3;">Admin</th>
                        <th class="contact-column" style="padding: 8px; background-color: #d3d3d3;">Contact Number</th>
                        <th class="email-column" style="padding: 8px; background-color: #d3d3d3;">Email</th>
                        <th class="actions-column" style="padding: 8px; background-color: #d3d3d3;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $row) { ?>
                            <tr>
                                <td><?php echo $row['municipality_name']; ?></td>
                                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                <td><?php echo $row['contact_number']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                <a href="ManageAccount.php?admin_id=<?php echo $row['id']; ?>" class="btn btn-secondary">
                    <i class="fas fa-cog"></i> Manage
                </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
