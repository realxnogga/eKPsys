<?php
session_start();
include 'connection.php';
include 'index-navigation.php';
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}


include 'report_handler.php';

$searchInput = isset($_GET['search']) ? $_GET['search'] : '';

$userID = $_SESSION['user_id'];

$query = "SELECT * FROM complaints WHERE UserID = '$userID' AND IsArchived = 0";

if (!empty($searchInput)) {

    $query .= " AND (CNum LIKE '%$searchInput%' OR ForTitle LIKE '%$searchInput%' OR CNames LIKE '%$searchInput%' OR RspndtNames LIKE '%$searchInput%')";
}

    $query .= " ORDER BY MDate DESC";

$result = $conn->query($query);

include 'add_handler.php';

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

include 'count_lupon.php';
  
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



  
  <style>
   .scrollable-card-body {
    
            max-height: 400px; /* Set the maximum height for the card body */
            overflow-y: auto; /* Enable vertical scrolling */
            scrollbar-width: thin; /* Specify a thin scrollbar */
            scrollbar-color: transparent transparent; /* Set scrollbar color to transparent */
        }

        /* For Webkit browsers like Chrome and Safari */
        .scrollable-card-body::-webkit-scrollbar {
            width: 8px; /* Set the width of the scrollbar */
        }

        .scrollable-card-body::-webkit-scrollbar-thumb {
            background-color: transparent; /* Set scrollbar thumb color to transparent */
        }






        table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px; /* Adjust font size for printing */
        background-color: white;  

    }

    table, th, td {
        border: 0.1px solid black;
    }

    th, td {
        text-align: center;
    }

    .header {
        text-align: left;
    }

    .sub-header {
    }


    .custom-card {
      padding: 30px;
    }





</style>

</head>

<body style="background-color: #eeeef6">
  <!--  Body Wrapper -->
 
      <div class="container-fluid">
        <!--  Row 1 -->




        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <div class="mb-4">
                  <h5 class="card-title fw-semibold">Account Information</h5>
                </div><b><hr>
                <label for="region">Punong Barangay:</label>
                            <input type="text" class="form-control" id="region" name="region" readonly
                                   value="<?php echo $_SESSION['punong_brgy']; ?>">

<label for="region">Region:</label>
                            <input type="text" class="form-control" id="region" name="region" readonly
                                   value="<?php if ($selected_month && $selected_month !== date('F Y')) {
                                       echo $s_region; // Display the selected month's value
                                   } else {
                                       echo $region;
                                   } ?>">

<label for="region">City/Municipality:</label>
                            <input type="text" class="form-control" id="region" name="region" readonly
                                   value="<?php echo strtoupper($_SESSION['munic_name']); ?>">



                                

<label for="totalc">Total No. of Cases:</label>
                        <input type="number" class="form-control" id="totalc" name="totalc" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalc; // Display the selected month's value
        } else {echo $natureSum;} ?>">
              </div></b>
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
            <div class="card-body p-4 scrollable-card-body"> <!-- Add the scrollable class here -->
                <h5 class="card-title fw-semibold mb-4">Recent Complaints</h5>
               <hr><br>
                <form method="GET" action="" class="searchInput">
  
</form>

     
<table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th style="width: 10%">No.</th>
            <th style="width: 10%">Title</th>
            <th style="width: 10%">Date</th>
            <th style="width: 10%">Progress</th>
        </tr>
    </thead>
        
<tbody>
    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= $row['CNum'] ?></td>
            <td><?= $row['ForTitle'] ?></td>
            <td><?= date('Y-m-d', strtotime($row['Mdate'])) ?></td>

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
                            <td>${row.MDate}</td>
                        
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



        <div class="card custom-card">
              <div class="card-body">
                
  </div>
 
 <b>   
    <table>
 

<div style="display: flex; align-items: center; justify-content: center;">
    <div style="text-align: center; display: flex; align-items: center;">
        <img src="img/calamba.png" alt="Logo 1" style="width: 90px; height: 90px; margin-right: 40px; vertical-align: middle;">
        <div class="sub-header">
            CY LUPONG TAGAPAMAYAPA INCENTIVES AWARDS (LTIA)<br>
            LTIA FORM 07-PERFORMANCE HIGHLIGHTS
        </div>
        <img src="img/cy.jpg" alt="Logo 2" style="width: 99x; height: 87px; margin-left: 40px; vertical-align: middle;">
    </div>
</div><br>

    <tr>
        <td colspan="60" class="sub-header">CATEGORY: BARANGAY</td>
    </tr>
    <tr>
        <td colspan="25" class="header">FINALIST LUPONG TAGAPAMAYAPA : <?php echo strtoupper($_SESSION['brgy_name']); ?></td>
        <td  colspan="38" class="header">POPULATION : <?php  if ($selected_month && $selected_month !== date('F Y')){
            echo $s_population; // Display the selected month's value
        } else {echo $population;} ?></td>
    </tr>
    <tr>
        <td colspan="25" class="header">PUNONG BARANGAY : <?php echo $_SESSION['punong_brgy']; ?></td>
        <td colspan="38" class="header">LAND AREA : <?php  if ($selected_month && $selected_month !== date('F Y')){
            echo $s_landarea; // Display the selected month's value
        } else {echo $landarea;} ?></td>
    </tr>
    <tr>
        <td colspan="25" class="header">CITY/MUNICIPALITY : <?php echo strtoupper($_SESSION['munic_name']); ?></td>
        <td colspan="38" class="header">TOTAL NO. OF CASES : <?php  if ($selected_month && $selected_month !== date('F Y')){
            echo $s_totalc; // Display the selected month's value
        } else {echo $natureSum;} ?></td>
    </tr>
    <tr>
        <td colspan="25" class="header">MAYOR : <?php  if ($selected_month && $selected_month !== date('F Y')){
            echo $s_mayor; // Display the selected month's value
        } else {echo $mayor;} ?></td>
        <td colspan="38" class="header">NUMBER OF LUPONS : <?php  if ($selected_month && $selected_month !== date('F Y')){
            echo $s_numlup; // Display the selected month's value
        } else {echo $numlup;} ?></td>
    </tr>
    <tr>
        <td colspan="25"class="header">PROVINCE : LAGUNA</td>
        <td colspan="38"class="header">MALE : <?php  if ($selected_month && $selected_month !== date('F Y')){
            echo $s_male; // Display the selected month's value
        } else {echo $male;} ?></td>
    </tr>
    <tr>
        <td colspan="25"class="header">REGION : <?php  if ($selected_month && $selected_month !== date('F Y')){
            echo $s_region; // Display the selected month's value
        } else {echo $region;} ?></td>
        <td colspan="38"class="header">FEMALE : <?php  if ($selected_month && $selected_month !== date('F Y')){
            echo $s_female; // Display the selected month's value
        } else {echo $female;} ?></td>
    </tr></b>
    <tr>
        <td colspan="60" class="sub-header">‎</td>
    </tr>
    <tr>
        <td colspan="60" class="sub-header"><i>General Instructions: Please read the Technical Notes at the back before accomplishing this form. Supply only the number.</i></td>
    </tr>
    <tr>
        <td colspan="60" class="sub-header">‎</td>
    </tr>

    <tr>
        <td rowspan="2" colspan="4">NATURE OF CASES <br> (1)</td>
        <td colspan="40">ACTION TAKEN</td>
        <td rowspan="3" colspan="4">OUTSIDE THE <br> JURISDICTION <br> OF THE <br> BARANGAY <br> (4)</td>
        <td rowspan="3" colspan="4">TOTAL <br> (cases <br> filed) <br> (5)</td>
        <td rowspan="3" colspan="4">BUDGET <br> ALLO- <br>CATED <br> (6)</td>

    </tr>
    <tr>
        <td colspan="16">SETTLED <br> (2)</td>
        <td colspan="24">NOT SETTLED <br> (3)</td>
    
    </tr>
    <tr>
        <td colspan="1">CRIMI- <br> NAL <br> (1a)</td>
        <td colspan="1"> CIVIL <br> (1b)</td>
        <td colspan="1" >OTHERS <br> (1c)</td>
        <td colspan="1">TOTAL <br> (1D)</td>
        <td colspan="4">MEDIA- <br> TION <br> (2a)</td>
        <td colspan="4">CONCI- <br> LIATION <br> (2b)</td>
        <td colspan="4">ARBIT- <br> RATION <br> (2c)</td>
        <td colspan="4">TOTAL (2D)</td>
        <td colspan="4">PEN- <br> DING <br> (3a)</td>
        <td colspan="4">DIS- <br> MISSED <br> (3b)</td>
        <td colspan="4">REPU- <br> DIATED <br> (3c)</td>
        <td colspan="4">CERTIFIED <br> TO FILE <br>  ACTION IN <br> COURT (3d) </td>
        <td colspan="4">DROP- <br> PED/ <br> WITH- <br> DRAWN <br> (3e) </td>
        <td colspan="4">TOTAL (3F)</td>

        
    </tr>
    

    <tr>
        <td colspan="1"> <br><?php echo $criminalCount; ?><br><br> </td>
        <td colspan="1"> <br><?php echo $civilCount; ?> <br><br> </td>
        <td colspan="1" ><br> <?php echo $othersCount; ?> <br><br></td>
        <td colspan="1"><br><?php echo $natureSum; ?><br><br> </td>
        <td colspan="4"> <br><?php echo $mediationCount; ?> <br><br></td>
        <td colspan="4"> <br><?php echo $conciliationCount; ?><br><br></td>
        <td colspan="4"><br> <?php echo $arbitrationCount; ?><br><br></td>
        <td colspan="4"> <br><?php echo $totalSettledCount; ?><br><br></td>
        <td colspan="4"> <br><?php echo $pendingCount; ?><br><br></td>
        <td colspan="4"> <br><?php echo $dismissedCount; ?><br><br></td>
        <td colspan="4"><br><?php echo $repudiatedCount; ?><br><br> </td>
        <td colspan="4"> <br><?php echo $certifiedCount; ?> <br><br></td>
        <td colspan="4"> <br><?php echo $droppedCount; ?> <br><br></td>
        <td colspan="4"><br> <?php echo $totalUnsetCount; ?><br><br></td>
        <td colspan="4"><br> <?php echo $pendingCount ?><br><br></td>
        <td colspan="4"> <br><?php echo $totalUnsetCount; ?><br><br></td>
        <td colspan="4"><br> <?php echo $budget; ?><br><br></td>

        
    </tr>
    </table>
<br><br><br><br>
    </div>    


        <div class="row">
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
              <h5 class="card-title fw-semibold">About</h5><hr>
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">      
                  <div class="mb-3 mb-sm-0">
                  </div>

                </div>

                <form method="POST">

<div class="form-group">
    <label for="mayor">Mayor:</label>
    <input type="text" class="form-control" id="mayor" name="mayor" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
echo $s_mayor;
} 
else if ($selected_year && $selected_year !== date('Y')){echo $mayor;}
else{
echo $mayor;            
} ?>">
</div>
<div class="form-group">
    <label for="region">Region:</label>
    <input type="text" class="form-control" id="region" name="region" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
echo $s_region;
} else if ($selected_year && $selected_year !== date('Y')){echo $region;}
else{
echo $region;            
} ?>">
</div>
<div class="form-group">
    <label for="budget">Budget Allocated:</label>
    <input type="text" class="form-control" id="budget" name="budget" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
echo $s_budget;
} else if ($selected_year && $selected_year !== date('Y')){echo $budget;}
else{
echo $budget;            
} ?>">
</div>

<div class="form-group">
    <label for="popul">Population:</label>
    <input type="text" class="form-control" id="popul" name="population" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
echo $s_population;
} else if ($selected_year && $selected_year !== date('Y')){echo $population;}
else{
echo $population;            
} ?>">
</div>
<div class="form-group">
    <label for="landarea">Land Area:</label>
    <input type="text" class="form-control" id="landarea" name="landarea" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
echo $s_landarea;
} else if ($selected_year && $selected_year !== date('Y')){echo $landarea;}
else{
echo $landarea;            
} ?>" >
</div>

<div class="form-group">
    <label for="totalc">Total No. of Cases:</label>
    <input type="number" class="form-control" id="totalc" name="totalc" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
echo $s_totalc;
} else if ($selected_year && $selected_year !== date('Y')){echo $natureSum;}
else{
echo $natureSum;            
} ?>">
</div>

<div class="form-group">
    <label for="numlup">Number of Lupons:</label>
    <input type="number" class="form-control" id="numlup" name="numlup" readonly value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
echo $s_numlup;
} else if ($selected_year && $selected_year !== date('Y')){echo $numlup;}
else{
echo $numlup;            
} ?>">
</div>

<div class="form-group">
    <label for="male">Male:</label>
    <input type="number" class="form-control" id="male" name="male" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
echo $s_male;
} else if ($selected_year && $selected_year !== date('Y')){echo $male;}
else{
echo $male;            
} ?>">
</div>

<div class="form-group">
    <label for="female">Female:</label>
    <input type="number" class="form-control" id="female" name="female" value="<?php  if ($selected_month && $selected_month !== date('F Y')) {
echo $s_female;
} else if ($selected_year && $selected_year !== date('Y')){echo $female;}
else{
echo $female;            
} ?>">
</div><br>


</form>




</div>

<script>
    // Get the data for the chart from your PHP variables
    var months = <?php echo json_encode($months); ?>;
    var caseCounts = <?php echo json_encode($caseCounts); ?>;

    // Prepare the chart data
    var ctx = document.getElementById('casesChart').getContext('2d');
    var casesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Number of Cases',
                data: caseCounts,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>





            </div>
          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- Yearly Breakup -->
                <div class="card overflow-hidden">
                  
                  <div class="card-body p-4">
                  <div class="row alig n-items-start"> <h5 class="card-title mb-9 fw-semibold">Case Progress</h5>
                        <hr><br>
                <!--  <h5 class="card-title mb-9 fw-semibold">Title</h5><hr><br>-->
                    <div class="row align-items-center">
                  
                    <canvas id="myChart" width="400" height="200"></canvas>

<script>
    // Sample data (replace this with your actual data)
    var labels = ["Settled", "Unsettled"];
    var data = [<?php echo $totalSettledCount; ?>, <?php echo $totalUnsetCount; ?>];

    // Get the canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Create a chart
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Settled vs Unsettled Cases',
                data: data,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)',  // Settled color
                    'rgba(255, 99, 132, 0.7)',  // Unsettled color
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 5
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
                




                    

                    


  </div>

                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <!-- Monthly Earnings -->
                <div class="card">
                  <div class="card-body">
                    <div class="row alig n-items-start"> <h5 class="card-title mb-9 fw-semibold">Nature of Cases</h5>
                        <hr><br>
                      <div class="col-8">
                       
                      </div>
                      <canvas id="natureChart" width="200" height="200"></canvas>
                    <script>
    // ... existing code ...

    // Function to draw a pie chart for the nature of cases
    function drawNatureChart() {
        var ctx = document.getElementById('natureChart').getContext('2d');
        var natureChart = new Chart(ctx, {
            type: 'pie', // Change the chart type to 'pie'
            data: {
                labels: ['Criminal', 'Civil', 'Others'],
                datasets: [{
                    label: 'Nature of Cases',
                    data: [<?php echo $criminalCount; ?>, <?php echo $civilCount; ?>, <?php echo $othersCount; ?>],
                    backgroundColor: [
                        'rgba(187,40,55,255)',
                        'rgba(252,225,16,255)',
                        'rgba(87,87,161,255)',
                    ],
                   
                    borderWidth: 5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Call the function to draw the chart when the page loads
    window.onload = function () {
        drawNatureChart();
    };

    // ... existing code ...
</script>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
       
   

                     
      </div>
    </div>
  </div>

</body>

</html>