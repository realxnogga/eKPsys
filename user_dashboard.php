<?php
session_start();
include 'connection.php';
include 'user-navigation.php';
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}
include 'count_lupon.php';

include 'report_handler.php';


$months_query = $conn->prepare("SELECT DISTINCT DATE_FORMAT(report_date, '%M %Y') AS month_year FROM reports WHERE user_id = :user_id");
$months_query->execute(['user_id' => $user_id]);
$months = $months_query->fetchAll(PDO::FETCH_ASSOC);

// Set a default value for selected_month if not set
$selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : date('F Y');

// Check if a month is selected
if (isset($_POST['selected_month'])) {
    $selected_month = $_POST['selected_month'];

    // Retrieve report data for the selected month
    $report_query = $conn->prepare("SELECT * FROM reports WHERE user_id = :user_id AND DATE_FORMAT(report_date, '%M %Y') = :selected_month");
    $report_query->execute(['user_id' => $user_id, 'selected_month' => $selected_month]);
    $report_data = $report_query->fetch(PDO::FETCH_ASSOC);

    // Populate variables with selected month's data
    // Modify these lines to match your database column names
    $s_mayor = $report_data['mayor'] ?? '';
    $s_region = $report_data['region'] ?? '';
    $s_budget = $report_data['budget'] ?? '';
    $s_population = $report_data['population'] ?? '';
    $s_landarea = $report_data['landarea'] ?? '';
    $s_male = $report_data['male'] ?? '';
    $s_female = $report_data['female'] ?? '';
    $s_totalc = $report_data['totalcase'] ?? '';
    $s_numlup = $report_data['numlupon'] ?? '';
    $s_criminal = $report_data['criminal'] ?? '';
    $s_civil = $report_data['civil'] ?? '';
    $s_others = $report_data['others'] ?? '';
    $s_totalNature = $report_data['totalNature'] ?? '';
    $s_mediation = $report_data['media'] ?? '';
    $s_conciliation = $report_data['concil'] ?? '';
    $s_arbit = $report_data['arbit'] ?? '';
    $s_totalSet = $report_data['totalSet'] ?? '';
    $s_pending = $report_data['pending'] ?? '';
    $s_dismissed = $report_data['dismissed'] ?? '';
    $s_repudiated = $report_data['repudiated'] ?? '';
    $s_dropped = $report_data['dropped'] ?? '';
    $s_totalUnset = $report_data['totalUnset'] ?? '';
    $s_outside = $report_data['outsideBrgy'] ?? '';
    $s_certified = $report_data['certcourt'] ?? '';


} else {
    // If no month is selected, display the current month's data (or default behavior)
    // Fetch and display the most recent report data
    // Modify this query according to your needs
    $default_report_query = $conn->prepare("SELECT * FROM reports WHERE user_id = :user_id ORDER BY report_date DESC LIMIT 1");
    $default_report_query->execute(['user_id' => $user_id]);
    $default_report_data = $default_report_query->fetch(PDO::FETCH_ASSOC);

    // Populate variables with default data (current month's data or most recent)
    // Modify these lines to match your database column names
    $s_mayor = $default_report_data['mayor']  ?? '';
    $s_region = $default_report_data['region']  ?? '';
    $s_budget = $default_report_data['budget']  ?? '';
    $s_population = $default_report_data['population'] ?? '';
    $s_landarea = $default_report_data['landarea'] ?? '';
    $s_male = $default_report_data['male'] ?? '';
    $s_female = $default_report_data['female'] ?? '';
    $s_totalc = $default_report_data['totalcase'] ?? '';
    $s_numlup = $default_report_data['numlupon'] ?? '';
    $s_criminal = $default_report_data['criminal'] ?? '';
    $s_civil = $default_report_data['civil'] ?? '';
    $s_others = $default_report_data['others'] ?? '';
    $s_totalNature = $default_report_data['totalNature'] ?? '';
    $s_mediation = $default_report_data['media'] ?? '';
    $s_conciliation = $default_report_data['concil'] ?? '';
    $s_arbit = $default_report_data['arbit'] ?? '';
    $s_totalSet = $default_report_data['totalSet'] ?? '';
    $s_pending = $default_report_data['pending'] ?? '';
    $s_dismissed = $default_report_data['dismissed'] ?? '';
    $s_repudiated = $default_report_data['repudiated'] ?? '';
    $s_dropped = $default_report_data['dropped'] ?? '';
    $s_totalUnset = $default_report_data['totalUnset'] ?? '';
    $s_outside = $default_report_data['outsideBrgy'] ?? '';
    $s_certified = $default_report_data['certcourt'] ?? '';

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style copy.css">
    <style>
* {
  box-sizing: border-box;
}

body {
    font-family: 'Roboto';
  color: black;

}



/* Float four columns side by side */
.column {
  float: left;
  width: 25%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}


/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn {   
  float: left;
  width: 75%;
}

/* Right column */
.rightcolumn {
  float: left;
  width: 25%;
  padding-left: 60px;
}

/* Add a card effect for articles */
.card {
   background-color: white;
   padding: 20px;
   margin-top: 20px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 800px) {
  .leftcolumn, .rightcolumn {   
    width: 100%;
    padding: 0;
  }
}



#clock {
            font-size: 2em;
            margin-bottom: 20px;
        }
        
        #date {
            font-size: 1.2em;
        }
</style>
</head>
<br>

<body>

<div class="row">
  <div class="leftcolumn">
    <div class="card">

      
        <h4><b>Monthly Report (<?php echo isset($selected_month) ? $selected_month : date('F, Y'); ?>) Overview:</b></h4><br>
            <div class="row">
                <div class="col-md-6">
                    <canvas id="natureChart" width="100" height="70"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                        // Get data from PHP variables
                        var criminalCount = <?php echo json_encode($s_criminal); ?>;
                        var civilCount = <?php echo json_encode($s_civil); ?>;
                        var othersCount = <?php echo json_encode($s_others); ?>;
                        var landArea = <?php echo json_encode($s_landarea); ?>;
                        var population = <?php echo json_encode($s_population); ?>;

                        // Create a bar chart
                        var ctx = document.getElementById('natureChart').getContext('2d');
                        var natureChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                        labels: ['Criminal', 'Civil', 'Others', 'Land Area', 'Population'],
                        datasets: [{
                            label: 'Nature of Cases, Land Area, and Population',
                            data: [criminalCount, civilCount, othersCount, landArea, population],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
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

    </div>
    <div class="card">
      <h2>TITLE HEADING</h2>
    </div>
  </div>

  <div class="rightcolumn">
    <div class="card">



    <div id="clock"></div>
<div id="date"></div>

<script>
    function updateClock() {
        const now = new Date();

        const hours = now.getHours();
        const minutes = now.getMinutes();
        const period = hours >= 12 ? 'PM' : 'AM';

        const formattedHours = hours % 12 || 12; // Convert 24-hour format to 12-hour format

        const formattedTime = `${formatDigit(formattedHours)}:${formatDigit(minutes)} ${period}`;

        const clockElement = document.getElementById('clock');
        clockElement.textContent = formattedTime;

        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const formattedDate = now.toLocaleDateString(undefined, options);

        const dateElement = document.getElementById('date');
        dateElement.textContent = formattedDate;

        setTimeout(updateClock, 60000); // Update every minute
    }

    function formatDigit(digit) {
        return digit < 10 ? `0${digit}` : digit;
    }

    updateClock(); // Initial call to display the clock and date
</script>


</div>

    <div class="card">

    <div class="powr-social-feed" id="14f40e85_1701146073"></div><script src="https://www.powr.io/powr.js?platform=html"></script>



</div>
  
  </div>



</div>






        </div>
    </div>
</div>

    
</body>
</html>
