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
$query = "SELECT * FROM complaints WHERE UserID = '$userID' AND IsArchived = 0 AND FileID IS NOT NULL";

// Function to get the ordinal suffix
function getOrdinalSuffix($number) {
    if ($number % 100 >= 11 && $number % 100 <= 13) {
        return 'th';
    }
    switch ($number % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
    }
}


// shakii pa-add lang sa php mo, from here

// Retrieve the search input from the form
$searchInput = isset($_GET['search']) ? $_GET['search'] : '';

// Retrieve user-specific complaints from the database
$userID = $_SESSION['user_id'];

// Set default values for $page and $complaintsPerPage
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$complaintsPerPage = 10;

// Get the current page from the URL parameter
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $complaintsPerPage;

// Initial query for all complaints sorted by Mdate in descending order
$query = "SELECT * FROM complaints WHERE UserID = '$userID' AND IsArchived = 0";

// Modify your SQL query to filter out archived complaints if a search is performed
if (!empty($searchInput)) {
    // Add conditions to filter based on the search input
    $query .= " AND (CNum LIKE '%$searchInput%' OR ForTitle LIKE '%$searchInput%' OR CNames LIKE '%$searchInput%' OR RspndtNames LIKE '%$searchInput%')";
}

$query .= " ORDER BY MDate DESC";

// Modify your SQL query to include LIMIT and OFFSET
$query .= " LIMIT $complaintsPerPage OFFSET $offset";

$result = $conn->query($query);


$totalCountQuery = "SELECT COUNT(*) as total FROM complaints WHERE UserID = '$userID' AND IsArchived = 0";
if (!empty($searchInput)) {
    $totalCountQuery .= " AND (CNum LIKE '%$searchInput%' OR ForTitle LIKE '%$searchInput%' OR CNames LIKE '%$searchInput%' OR RspndtNames LIKE '%$searchInput%')";
}

$totalCountResult = $conn->query($totalCountQuery);
$totalCountRow = $totalCountResult->fetch(PDO::FETCH_ASSOC);
$totalCount = $totalCountRow['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaints</title>
    <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<style>
    .table {
        font-size: 13px;
        font-weight: bold;
    }
    .table thead th {
        text-align: center; 
    }
    .table tbody td {
        text-align: center; 
    }
    .card {
        box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
        border-radius: 15px;
    }
    .case-number {
        width: 120px; 
        font-family: 'Arial', sans-serif; 
    }
    .date-column {
        width: 120px; 
        font-family: 'Arial', sans-serif;
    }
    .complainants-column,
    .respondents-column {
        width: 150px; 
        font-family: 'Arial', sans-serif; 
    }
    .title-column {
        width: 200px;
        font-family: 'Arial', sans-serif;
    }
    .table-bordered th,
    .table-bordered td {
        border: 2px solid #dee2e6; 
    }
    .actions-column {
        font-family: 'Arial', sans-serif; 
        margin: 0; 
    }
    .status-column,
    .hearing-column {
        width: 100px; 
        font-family: 'Arial', sans-serif;
    }
    .btn {
        font-size: 13px;
        margin-right: 4px; 
    }
    .btn:last-child {
        margin-right: 0;
    }
    .btn-dark, .btn-success {
        height: 38px; 
    }
    .actions-column a.btn {
        margin-left: 27;
        padding: 0;
    }
    .actions-column a.btn {
        box-sizing: border-box;
    }
</style>
</head>

<body style="background-color: #E8E8E7">

<div class="container-fluid">
    <a href="user_dashboard.php" class="btn btn-dark m-1">Back to Dashboard</a>
    <br><br>

    <!--  Row 1 -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
                <div>
                    <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>
                </div>
            </div>    
            <br>   
            <h5 class="card-title mb-9 fw-semibold">Barangay Complaints</h5>
            <b>  
            

            <form method="GET" action="" class="searchInput">
    <div style="display: flex; align-items: center;">
        <input type="text" class="form-control" name="search" id="search" placeholder="Search by Case No., Title, Complainants, or Respondents" class="searchInput" style="flex: 1; margin-right: 5px;" onkeyup="liveSearch()">
        <input type="button" class="btn btn-success m-1" value="Add complaint" onclick="location.href='add_complaint.php';" class="complaint-button" style="margin-left: 0;">
    </div>
</form>


<script>
function liveSearch() {
    var searchInput = $('#search').val();

    $.ajax({
        type: 'GET',
        url: 'live_search.php', // Create a separate PHP file for handling live search
        data: { search: searchInput },
        success: function(data) {
            // Update the table content with the response from the server
            $('#complaints-table').html(data);

            // Reapply styles to dynamically loaded FontAwesome icons
            $('.actions-column .btn i').css({
                'font-family': 'Arial, sans-serif',
                'margin-right': '5px',
                // Add other styles as needed
            });
        }
    });
}
</script>



<table id="complaints-table" class="table">
                    <thead class="thead">
                        <tr>
                        <th class="case-number">No.</th>
                        <th class="title-column">Title</th>
                        <th class="complainants-column">Complainants</th>
                        <th class="respondents-column">Respondents</th>
                        <th class="date-column">Date</th>
                        <th class="status-column">Status</th>
                        <th class="hearing-column">Hearing</th>
                        <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                            <?php
                     // Determine if the case is settled based on its method
$isSettled = in_array($row['CMethod'], ['Mediation', 'Conciliation', 'Arbitration']);

// Determine if the case is unsettled based on its status
$isUnsettled = in_array($row['CMethod'], ['Pending', 'Repudiated', 'Dismissed', 'Certified to file action in court', 'Dropped/Withdrawn']);

// Calculate the elapsed days since the complaint was added
$dateAdded = strtotime($row['Mdate']);
$currentDate = strtotime(date('Y-m-d'));
$elapsedDays = ($currentDate - $dateAdded) / (60 * 60 * 24);

// Check if the complaint is settled, pending, or unsettled
if ($isSettled) {
    $backgroundColor = '#dcfadf'; // Light green for settled cases
} elseif ($elapsedDays >= 10 && $elapsedDays <= 13) {
    $backgroundColor = '#FFE181'; // Light yellow for cases between 10 and 13 days
} elseif ($elapsedDays >= 14 && $elapsedDays <= 30 && !$isSettled) {
    $backgroundColor = '#F88D96'; // Light red for cases between 14 and 30 days that are not settled
} else {
    // Default case for 1-9 days or cases over 30 days, no color
    $backgroundColor = '';
}


          ?>
                            <tr style="background-color: <?= $backgroundColor ?>">
                            <td class="case-number"><?= str_pad($row['CNum'], 11, '0', STR_PAD_LEFT) ?></td>
                            <td class="title-column" style="white-space: pre-line;"><?= $row['ForTitle'] ?></td>
                            <td class="complainants-column" style="white-space: nowrap;"><?= $row['CNames'] ?></td>
                            <td class="respondents-column" style="white-space: nowrap;"><?= $row['RspndtNames'] ?></td>
                            <td class="date-column"><?= date('Y-m-d', strtotime($row['Mdate'])) ?></td>
                            <td class="status-column" style="white-space: nowrap;"><?= $row['CMethod'] ?></td>
                            <?php
$complaintId = $row['id'];
$caseProgressQuery = "SELECT current_hearing FROM case_progress WHERE complaint_id = $complaintId";
$caseProgressResult = $conn->query($caseProgressQuery);
$caseProgressRow = $caseProgressResult->fetch(PDO::FETCH_ASSOC);

?>

<td class="hearing-column" style="white-space: nowrap;">
    <?php if ($caseProgressRow): ?>
        <?php $currentHearing = $caseProgressRow['current_hearing']; ?>
        <?php if ($currentHearing === '0'): ?>
            Not Set
        <?php else: ?>
            <?php $ordinalHearing = str_replace('th', getOrdinalSuffix((int)$currentHearing), $currentHearing); ?>
            <?= $ordinalHearing ?> Hearing
        <?php endif; ?>
    <?php else: ?>
        Not Set
    <?php endif; ?>
</td>
                                <td class="actions-column">
                                <a href="edit_complaint.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-secondary" title="Edit" data-placement="top" style="width: 70px; display: flex; align-items: center; justify-content: center; margin-bottom: 5px;">
        <i class="fas fa-edit" style="margin-right: 5px;"></i> Edit
    </a>
    <a href="archive_complaint.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" title="Archive" data-placement="top" style="width: 70px; display: flex; align-items: center; justify-content: center; margin-bottom: 5px;">
        <i class="fas fa-archive" style="margin-right: 5px;"></i> Archive
    </a>
    <a href="manage_case.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning" title="Manage" data-placement="top" style="width: 70px; display: flex; align-items: center; justify-content: center; margin-bottom: 5px;">
        <i class="fas fa-folder" style="margin-right: 5px;"></i> Manage
    </a>
    <a href="upload_file.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary" title="Upload" data-placement="top" style="width: 70px; display: flex; align-items: center; justify-content: center; margin-bottom: 5px;">
        <i class="fas fa-upload" style="margin-right: 5px;"></i> Upload
    </a>
</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>


               

            </b>
            <div class="pagination justify-content-end">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&search=<?= $searchInput ?>" class="btn btn-primary mr-1">
            <i class="fas fa-chevron-left"></i>
        </a>
    <?php else: ?>
        <button class="btn btn-primary mr-1" disabled>
            <i class="fas fa-chevron-left"></i>
        </button>
    <?php endif; ?>

    <?php
    //edited 
    $totalPages = ceil($totalCount / $complaintsPerPage);

    // Display up to 10 pages, show "..." for the rest
    $startPage = max(1, min($totalPages - 9, $page));

    for ($i = $startPage; $i <= min($startPage + 9, $totalPages); $i++):
    ?>
        <a href="?page=<?= $i ?>&search=<?= $searchInput ?>" class="btn <?= ($i == $page) ? 'btn-info' : 'btn-primary' ?> mr-1"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($result->rowCount() == $complaintsPerPage): ?>
        <a href="?page=<?= $page + 1 ?>&search=<?= $searchInput ?>" class="btn btn-primary mr-1">
            <i class="fas fa-chevron-right"></i>
        </a>
    <?php else: ?>
        <button class="btn btn-primary mr-1" disabled>
            <i class="fas fa-chevron-right"></i>
        </button>
    <?php endif; ?>
</div>
<br>
<!--inedit ko din itoo-->
<div class="col-md-21text-right">
        <p style="margin-left:970px;" >Page <?= $page ?> of <?= $totalPages ?></p>
    </div>
  
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
                                <a href='manage_case.php?id=${row.id}'>Manage</a> |
                                <a href='upload_file.php?id=${row.id}'>Upload</a> <!-- Add Upload link -->
                            </td>
                            <iframe id="uploadFrame" name="uploadFrame" width="100%" height="300" frameborder="0"></iframe>
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
</body>
</html>
