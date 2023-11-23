<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
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

<!DOCTYPE html>
<html>
<head>
    <title>Barangay Complaints</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
</head>
<hr><br>
<body>

<div class="columns-container">
    <div class="left-column">
        <div class="card">
    <h4><b>Barangay Complaints</b></h4>

    <br>

<form method="GET" action="" class="searchInput">
    <input type="text" name="search" id="search" placeholder="Search by Case No., Title, Complainants, or Respondents" class="searchInput">
    <input type="button" value="Search" onclick="location.href='user_complaints.php';" class="refresh-button">
    <input type="button" value="+ Add complaint" onclick="location.href='add_complaint.php';" class="complaint-button">

</form>


    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th style="width: 10%">Case No.</th>
            <th style="width: 20%">Title</th>
            <th style="width: 15%">Complainants</th>
            <th style="width: 15%">Respondents</th>
            <th style="width: 10%">Date Made</th>
            <th style="width: 10%">Case Status</th>
            <th style="width: 20%">Actions</th>
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

        </div>
        </div>

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
                                <a href='manage_case.php?id=${row.id}'>Manage</a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            }
        });
    </script>
</body>
</html>
