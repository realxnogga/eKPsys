<?php
include_once("connection.php");
$con = connection();

include 'user-navigation.php';
include 'functions.php';

$countSql = "SELECT COUNT(*) as total FROM kp_form7";
$countResult = $con->query($countSql);
$countRow = $countResult->fetch_assoc();
$totalRows = $countRow['total'];

$sql = "SELECT * FROM kp_form7  ORDER BY id DESC";
$brgy = $con->query($sql) or die($con->error);
$row = $brgy->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
 
    <title>User Dashboard</title>

    <?php include 'functions.php';?>

</head>
<body>

    <?php include 'user-navigation.php';?>
<hr>
<br><br>

<h2><b>User Dashboard</b></h2>



        <div class="columns-container">
    <div class="left-column">
        <div class="card">
        <h4><b>Home</b></h4>

        </div>

        
        
  
    </div>
</div>
<script>
function liveSearch() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector(".table");
    tr = table.querySelectorAll("tbody tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        var rowMatchesSearch = false;

        for (var j = 0; j < td.length; j++) {
            cell = td[j];
            if (cell) {
                txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    rowMatchesSearch = true;
                    break;
                }
            }
        }

        tr[i].style.display = rowMatchesSearch ? "" : "none";
    }
}
</script>
</body>
</html>
