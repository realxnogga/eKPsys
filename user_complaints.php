<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;

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
<body>
    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <div class="row">

                    <h3>Barangay Cases</h3><br><br><hr>
                    <h2>Your files</h2>        

    <br>


</form>


    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th style="width: 10%">Case No.</th>
            <th style="width: 20%">Title</th>
            <th style="width: 15%">Complainants</th>
            <th style="width: 15%">Respondents</th>
            <th style="width: 12%">Date Made</th>
            <th style="width: 20%">Case Status</th>
            <th style="width: 15%">Actions</th>
        </tr>
    </thead>
        
        <tbody>
    <?php
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['CNum'] . "</td>";
        echo "<td>" . $row['ForTitle'] . "</td>";
        echo "<td>" . $row['CNames'] . "</td>";
        echo "<td>" . $row['RspndtNames'] . "</td>";
echo "<td>" . date('Y-m-d', strtotime($row['Mdate'])) . "</td>";
        echo "<td>" . $row['CMethod'] . "</td>";
        echo "<td>";
        echo '<a href="edit_complaint.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a> ';
        echo '<a href="archive_complaint.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger"><i class="fa fa-file-o"></i></a> ';
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
                            <td>${row.CNames}</td>
                            <td>${row.RspndtNames}</td>
                            <td>${row.MDate}</td>
                            <td>
                                <a href='edit_complaint.php?id=${row.id}'>Edit</a> |
                                <a href='archive_complaint.php?id=${row.id}'>Archive</a> |
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

        <div class="rightcolumn">
            <div class="card">

                <h3>Add a complaint</h3><hr>
                <h2>KP Form 7</h2>        

                    <?php echo $successMessage; // Display success message here ?>

    <form action="" method="post">
        <br>

        
        <div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
          <label class="form-control-label px-3">Case No.<span class="text-danger"> *</span></label>
          <!-- Set the Case Number input field value -->
          <input type="text" id="CNum" name="CNum" placeholder="MMYY - Case No." value="<?php echo $caseNum; ?>" onblur="validate(1)" >
      </div>
<div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Title<span class="text-danger"> *</span></label>
<input type="text" id="ForTitle" name="ForTitle" placeholder="Enter Name" onblur="validate(2)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Complainants:<span class="text-danger"> *</span></label>
        <input type="text" id="CNames" name="CNames" placeholder="Enter name of complainants" onblur="validate(3)" required>
    </div>
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Respondents:<span class="text-danger"> *</span></label>
        <input type="text" id="RspndtNames" name="RspndtNames" placeholder="Enter name of respondents" onblur="validate(4)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-12 flex-column d-flex">
        <label class="form-control-label px-3">Complaint<span class="text-danger"> *</span></label>
        <input type="text" id="CDesc" name="CDesc" placeholder="" onblur="validate(5)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
    <div class="form-group col-12 flex-column d-flex">
        <label class="form-control-label px-3">Petition<span class="text-danger"> *</span></label>
        <input type="text" id="Petition" name="Petition" placeholder="" onblur="validate(6)" required>
    </div>
</div>
<div class="row justify-content-between text-left">
 <div class="form-group col-sm-6 flex-column d-flex">
    <label class="form-control-label px-3">Made:<span class="text-danger"> *</span></label>
    <input type="datetime-local" id="Mdate" name="Mdate" onblur="validate(7)" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
</div>

    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Received:</label>
        <input type="date" id="RDate" name="RDate" onblur="validate(8)" >
    </div>
</div>

<div class="row justify-content-between text-left">
    <div class="form-group col-sm-6 flex-column d-flex">
        <label class="form-control-label px-3">Case Type:<span class="text-danger"> *</span></label>
        <select name="CType">
            <option value="Civil">Civil</option>
            <option value="Criminal">Criminal</option>
            <option value="Others">Others</option>
        </select>
    </div>
</div><br>
<div class="row justify-content-end">
    <div class="form-group col-sm-2">
        <input type="submit" name="submit" value="Submit">
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
        card.style.height = '50vh'; // Set height to 100% of the viewport height in fullscreen
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