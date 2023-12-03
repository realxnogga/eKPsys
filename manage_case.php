<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Retrieve the row ID from the URL
$rowID = isset($_GET['id']) ? $_GET['id'] : null;

if ($rowID === null) {
    echo "Error: Row ID is missing. Please select a valid case to manage.";
    header("Location: user_complaints.php");
} else {
   $query = "SELECT * FROM complaints WHERE id = :rowID AND UserID = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':rowID', $rowID);
$stmt->bindParam(':userID', $_SESSION['user_id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        // Set session variables for the data from 'complaints' table
        $_SESSION['forTitle'] = $row['ForTitle'];
        $_SESSION['cNames'] = $row['CNames'];
        $_SESSION['rspndtNames'] = $row['RspndtNames'];
        $_SESSION['cDesc'] = $row['CDesc'];
        $_SESSION['petition'] = $row['Petition'];
        $_SESSION['cNum'] = $row['CNum'];

        // Query the 'lupons' table to get 'punong_barangay' and 'lupon_chairman'
        $luponsQuery = "SELECT punong_barangay, lupon_chairman FROM lupons WHERE user_id = " . $_SESSION['user_id'];
        $luponsResult = $conn->query($luponsQuery);
        $luponsRow = $luponsResult->fetch(PDO::FETCH_ASSOC);

        if ($luponsRow) {
            $_SESSION['punong_barangay'] = $luponsRow['punong_barangay'];
            $_SESSION['lupon_chairman'] = $luponsRow['lupon_chairman'];
        }
    } else {
        echo "Error: No matching case found for the given ID.";
        header("Location: user_complaints.php");
    }
}


$searchInput = isset($_GET['search']) ? $_GET['search'] : '';

$userID = $_SESSION['user_id'];

$query = "SELECT * FROM complaints WHERE UserID = '$userID' AND IsArchived = 0";

if (!empty($searchInput)) {

    $query .= " AND (CNum LIKE '%$searchInput%' OR ForTitle LIKE '%$searchInput%' OR CNames LIKE '%$searchInput%' OR RspndtNames LIKE '%$searchInput%')";
}

    $query .= " ORDER BY MDate DESC";

$result = $conn->query($query);

include 'add_handler.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
    <style>
        
        body, html {
    margin: 0;
    padding: 0;
    height: 100%;
}

.card {
    height: 75vh; /* Set the height to 100% of the viewport height */
    overflow: auto;
    padding-bottom: 20px; /* Add some padding to the bottom */
    transition: height 0.3s ease; /* Add a smooth transition effect for height changes */
}

@media screen and (min-resolution: 192dpi), screen and (min-resolution: 2dppx) {
    /* Adjust for high-density (Retina) displays */
    .card {
        height: 50vh;
    }
}

@media screen and (max-width: 1200px) {
    /* Adjust for window resolution 125% scaling */
    .card {
        height: 80vh;
    }
}

@media screen and (max-width: 960px) {
    /* Adjust for window resolution 150% scaling */
    .card {
        height: 66.67vh;
    }
}


    .form-group {
        margin-bottom: 1px;
        }

    .form-control-label {
        font-weight: bold;
    }

        input[type="text"],
        input[type="datetime-local"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 auto; /* Center the submit button */
    display: block; /* Ensure it takes up full width */
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Center align the submit button */
.row.justify-content-end {
    display: flex;
    justify-content: center;
}

.form-group.col-sm-2 {
    text-align: center;
    margin-right: 190px; /* Add some top margin for better spacing */
}
    </style>
</head>

<link rel="stylesheet" type="text/css" href="style copy.css">
<link rel="stylesheet" type="text/css" href="manage.css">
    
<body>
    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">

                    <a href="user_complaints.php">Back</a><br><br><h3><?php echo "Case Number:". $_SESSION['cNum']; ?><br>
                    <h4><?php echo "Case Title: ". $_SESSION['cNames']; ?> vs <?php echo $_SESSION['rspndtNames']; ?><br>
                    <h4><?php echo "Complaint:". $_SESSION['cDesc']; ?></h4><br></h4>
</h4>
<hr>

                    <h2>Forms</h2><br><br>

                    <div class="columns-container">
            
  


    <div class="form-buttons">
        <h5>I. Complaint Forms</h5>
        <button class="open-form" data-form="kp_form7.php"><i class="fas fa-file-alt"></i> KP 7 Complaint</button>
        <button class="open-form" data-form="kp_form8.php"><i class="fas fa-file-alt"></i> KP 8 Hearing</button>
        <button class="open-form" data-form="kp_form9.php"><i class="fas fa-file-alt"></i> KP 9 Summons</button><br><br>

        <h5>II. Mediation Forms</h5>
        <button class="open-form" data-form="kp_form11.php"><i class="fas fa-file-alt"></i> KP 11 Notice to Chosen Pangkat Member</button>
        <button class="open-form" data-form="kp_form12.php"><i class="fas fa-file-alt"></i> KP 12 Notice of Hearing</button>
        <button class="open-form" data-form="kp_form13.php"><i class="fas fa-file-alt"></i> KP 13 Subpoena</button>
        <button class="open-form" data-form="kp_form14.php"><i class="fas fa-file-alt"></i> KP 14 Agreement For Arbitration</button>
        <button class="open-form" data-form="kp_form15.php"><i class="fas fa-file-alt"></i> KP 15 Arbitration Award</button>
        <button class="open-form" data-form="kp_form16.php"><i class="fas fa-file-alt"></i> KP 16 Amicable Settlement</button>
        <button class="open-form" data-form="kp_form17.php"><i class="fas fa-file-alt"></i> KP 17 Repudiation</button><br><br>
        
        <h5>III. Administration Forms</h5>
        <button class="open-form" data-form="kp_form1.php"><i class="fas fa-file-alt"></i> KP 1 Notice To Constitute The Lupon</button>
        <button class="open-form" data-form="kp_form2.php"><i class="fas fa-file-alt"></i> KP 2 Appointment</button>
        <button class="open-form" data-form="kp_form3.php"><i class="fas fa-file-alt"></i> KP 3 Notice Of Appointment</button>
        <button class="open-form" data-form="kp_form4.php"><i class="fas fa-file-alt"></i> KP 4 List Of Appointed Lupon Members</button>
        <button class="open-form" data-form="kp_form5.php"><i class="fas fa-file-alt"></i> KP 5 Oath Of Office</button>
        <button class="open-form" data-form="kp_form6.php"><i class="fas fa-file-alt"></i> KP 6 Withdrawal Of Appointment</button><br><br>

        <h5>IV. Execution Forms</h5>
        <button class="open-form" data-form="kp_form23.php"><i class="fas fa-file-alt"></i> KP 23 Motion For Execution</button>
        <button class="open-form" data-form="kp_form24.php"><i class="fas fa-file-alt"></i> KP 24 Notice Of Hearing (MfE)</button>
        <button class="open-form" data-form="kp_form25.php"><i class="fas fa-file-alt"></i> KP 25 Notice Of Execution</button><br><br>

        <h5>V. Certification Forms</h5>
        <button class="open-form" data-form="kp_form20.php"><i class="fas fa-file-alt"></i> KP 20 Certification To File Action</button>
        <button class="open-form" data-form="kp_form20A.php"><i class="fas fa-file-alt"></i> KP 20-A Certification To File Action</button>
        <button class="open-form" data-form="kp_form20B.php"><i class="fas fa-file-alt"></i> KP 20-B Certification To File Action</button>
        <button class="open-form" data-form="kp_form21.php"><i class="fas fa-file-alt"></i> KP 21 Certification To Bar Action</button>
        <button class="open-form" data-form="kp_form22.php"><i class="fas fa-file-alt"></i> KP 22 Certification To Bar Counterclaim</button>
        <button class="open-form" data-form="kp_form10.php"><i class="fas fa-file-alt"></i> KP 10 Notice For Constitution Of Pangkat</button>
        <button class="open-form" data-form="kp_form18.php"><i class="fas fa-file-alt"></i> KP 18 Notice Of Hearing (Re: Failure To Appear)</button>
        <button class="open-form" data-form="kp_form19.php"><i class="fas fa-file-alt"></i> KP 19 Notice Of Hearing (Re: Failure To Appear)</button>
    </div>

    <div class="modal-container" id="modal-container">
        <div class="iframe-container">
            <iframe id="form-iframe" src="" sandbox="allow-same-origin allow-scripts allow-modals"></iframe>
        </div>
    </div>

    <script>
    const openFormButtons = document.querySelectorAll('.open-form');
    const modalContainer = document.getElementById('modal-container');
    const formIframe = document.getElementById('form-iframe');

    openFormButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const formSrc = 'forms/' + button.getAttribute('data-form');
            modalContainer.style.display = 'flex';
            formIframe.src = formSrc;

            // Add an event listener to close the modal when clicking outside
            modalContainer.addEventListener('click', (event) => {
                if (event.target === modalContainer) {
                    closeFormView();
                }
            });
        });
    });

    // Close the document view when pressing the "Esc" key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeFormView();
        }
    });

    function closeFormView() {
        modalContainer.style.display = 'none';
        formIframe.src = '';
    }
</script>


</div>            

                </div>
            </div>
        </div>

        <div class="rightcolumn">
            <div class="card">

                <h3>Shortcuts</h3><hr>
                <h2>Other case files</h2>   <br>     


                <div class="row">


    <br>


</form>


    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th style="width: 14%">Case No.</th>
            <th style="width: 18%">Title</th>
            <th style="width: 12%">Date Made</th>
            <th style="width: 15%">Case Status</th>
            <th style="width: 14%">Actions</th>
        </tr>
    </thead>
        
        <tbody>
    <?php
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['CNum'] . "</td>";
        echo "<td>" . $row['ForTitle'] . "</td>";
echo "<td>" . date('Y-m-d', strtotime($row['Mdate'])) . "</td>";
        echo "<td>" . $row['CMethod'] . "</td>";
        echo "<td>";
        echo '<a href="manage_case.php?id=' . $row['id'] . '" class="btn btn-sm btn-warning"><i class="fa fa-folder-open"></i></a> ';
        echo "</td>";
        echo "</tr>";
    }
    ?>
</tbody>

    </table>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');

            searchInput.addEventListener('input', function() {
                const searchText = searchInput.value;

                // Use AJAX to fetch matching rows from the server
                if (searchText.length > 2) { // To avoid sending requests for very short input
                    fetch(`search_complaints.php?search=${searchText}`)
                        .then(response => response.json())
                        .then(data => {
                            displayResults(data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });

            function displayResults(data) {
                // Clear the previous results
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(row => {
                        // Display matching rows
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.CNum}</td>
                            <td>${row.ForTitle}</td>
                            <td>${row.MDate}</td>
                            <td>
                                <a href='manage_case.php?id=${row.id}'>Manage</a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            }
        });
    </script>
                    

                </div>
            </div>
        </div>

   



            </div>
        </div>
    </div>




<script>

const card = document.querySelector('.card');

function adjustCardHeight() {
    const isFullscreen = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement;

    if (isFullscreen) {
        card.style.height = '100vh'; // Set height to 100% of the viewport height in fullscreen
    } else {
        card.style.height = '75vh'; // Set the initial height when exiting fullscreen
    }
}

document.addEventListener('fullscreenchange', adjustCardHeight);
document.addEventListener('webkitfullscreenchange', adjustCardHeight);
document.addEventListener('mozfullscreenchange', adjustCardHeight);
document.addEventListener('MSFullscreenChange', adjustCardHeight);

</script>

 








</body>
</html>