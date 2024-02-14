<?php
session_start();
include 'connection.php';
include 'index-navigation.php';
include 'functions.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;

}
// Retrieve the search input from the form
$searchInput = isset($_GET['search']) ? $_GET['search'] : '';

// Retrieve user-specific complaints from the database
$userID = $_SESSION['user_id'];

// Initial query for all complaints sorted by Mdate in descending order
$query = "SELECT * FROM complaints WHERE UserID = '$userID' AND IsArchived = 0";

// Modify your SQL query to filter out archived complaints if a search is performed
if (!empty($searchInput)) {
    // Add conditions to filter based on the search input
    $query .= " AND (CNum LIKE '%$searchInput%' OR ForTitle LIKE '%$searchInput%' OR CNames LIKE '%$searchInput%' OR RspndtNames LIKE '%$searchInput%')";
}

    $query .= " ORDER BY MDate DESC";

$result = $conn->query($query);


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaints</title>
    <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />

</head>

<body style="background-color: #eeeef6">


<div class="container-fluid">
<a href="user_dashboard.php" class="btn btn-outline-dark m-1">Back to Dashboard</a>
<br><br>

        <!--  Row 1 -->
            <div class="card">
              <div class="card-body">
                    
                  <div class="d-flex align-items-center">
    <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
    <div>
        <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
    </div></div>    
    <br>   

                     <h5 class="card-title mb-9 fw-semibold">Barangay Complaints</h5><hr>
                   <b>  
<br>
                   <form method="GET" action="" class="searchInput">
    <div style="display: flex; align-items: center;">
        <input type="text" class="form-control" name="search" id="search" placeholder="Search by Case No., Title, Complainants, or Respondents" class="searchInput" style="flex: 1; margin-right: 5px;">
        <input type="button" class="btn btn-dark m-1" value="Search" onclick="location.href='user_complaints.php';" class="refresh-button">
        <input type="button" class="btn btn-success m-1" value="Add complaint" onclick="location.href='add_complaint.php';" class="complaint-button" style="margin-left: 0;">
    </div>
</form>

<br>
     
<table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th style="width: 10%">No.</th>
            <th style="width: 5%">Title</th>
            <th style="width: 2%">Complainants</th>
            <th style="width: 2%">Respondents</th>
            <th style="width: 5%">Date</th>
            <th style="width: 2%">Status</th>
            <th style="width: 5%">Progress</th>
            <th style="width: 10%">Actions</th>
        </tr>
    </thead>
        
<tbody>
    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= $row['CNum'] ?></td>
            <td><?= $row['ForTitle'] ?></td>
            <td><?= $row['CNames'] ?></td>
            <td><?= $row['RspndtNames'] ?></td>
            <td><?= date('Y-m-d', strtotime($row['Mdate'])) ?></td>
            <td><?= $row['CMethod'] ?></td>

            <?php
            $complaintId = $row['id'];
            $caseProgressQuery = "SELECT current_hearing FROM case_progress WHERE complaint_id = $complaintId";
            $caseProgressResult = $conn->query($caseProgressQuery);
            $caseProgressRow = $caseProgressResult->fetch(PDO::FETCH_ASSOC);
            ?>

            <td>
                <?php if ($caseProgressRow): ?>
                    <?php switch ($caseProgressRow['current_hearing']):
                        case '0': ?>
                            Not Set
                            <?php break; ?>
                        <?php case '1st': ?>
                            1st Hearing
                            <?php break; ?>
                        <?php case '2nd': ?>
                            2nd Hearing
                            <?php break; ?>
                        <?php case '3rd': ?>
                            3rd Hearing
                            <?php break; ?>
                        <?php default: ?>
                            Unknown
                    <?php endswitch; ?>
                <?php else: ?>
                    Not Set
                <?php endif; ?>
            </td>

            <td>
    <a href="edit_complaint.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary"  title="Edit" data-placement="top"><i class="fas fa-edit"></i></a>
    <a href="archive_complaint.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" title="Archive" data-placement="top"><i class="fas fa-archive"></i></a>
    <a href="manage_case.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning" title="Manage" data-placement="top"><i class="fas fa-folder"></i></a>


</td>

        </tr>
    <?php endwhile; ?>
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
            
            
   

  

      
    </div></div>
      

              </div>

              
            </div>
          </div></b>
                    
          </div>
        </div>
       
       
          
    </div>
  </div>

</body>

</html>
