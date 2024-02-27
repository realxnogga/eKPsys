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


      .card {
      box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
      border-radius: 15px;

      }

      .one-card {
      background-color: #5757a1;  
      color: white; 
      text-align: center;
      }

      .two-card {
      background-color: ;  
      color: white;  
      }

      .three-card {
      background-color: #E8EEFA ;
      background-color: white;
      background-size: cover;
      background-position: center;
      width: 100%;  
      }

      .four-card {
      background-color: #E9FAE8 ;  
      text-align: center;
      background-image: url('img/settled.png');
      background-size: cover;
      background-position: center;
      width: 100%;
      }

      .six-card {
      background-color: #FAE8E8 ;  
      text-align: center;
      background-image: url('img/unsettled.png');
      background-size: cover;
      background-position: center;
      width: 100%;
      }


      .five-card {
      background-color: white ;  
      text-align: center;

      }

      .five-card {
      background-image: url('img/fb.png');
      background-size: cover;
      background-position: center;
      width: 100%;
      padding-bottom: 56.25%; /* 9:16 aspect ratio (16 / 9 * 100%) */
    }

    .seven-card {
      background-image: url('img/official.png');
      background-size: cover;
      background-position: center;
      width: 100%;
      padding-bottom: 56.25%; /* 9:16 aspect ratio (16 / 9 * 100%) */
    }


    .eight-card {
      background-image: url('img/ig.png');
      background-size: cover;
      background-position: center;
      width: 100%;
      padding-bottom: 56.25%; /* 9:16 aspect ratio (16 / 9 * 100%) */
      
    }

    .twelve-card {
    width: 100%;
    padding-bottom: 56.25%; /* 9:16 aspect ratio (16 / 9 * 100%) */
    background-size: cover;
    background-position: center;
    animation: imageChange 10s infinite; /* Change image every 3 seconds */
  }
  /*
  @keyframes imageChange {
    0%, 100% {
      background-image: url('img/img1.png');
    }
    33.33% {
      background-image: url('img/img2.png');
    }
    66.66% {
      background-image: url('img/img1.png');
    }
  }

  */

      .image-container {
          display: flex;
          justify-content: space-between;
          margin-bottom: 10px; /* Adjust margin between rows */
      }

      .image-container a {
          display: block;
          overflow: hidden;
          position: relative;
          transition: transform 0.3s ease;
          margin-right: 10px; /* Adjust the margin between images */
          text-align: center;
          background-color: black;
          box-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.2);
          margin-bottom: 10px; /* Adjust the margin between images */
          border-radius: 15px;



          margin-left: 10px; /* Adjust the left margin */
      margin-right: 10px; /* Adjust the right margin */
    }
      

      .image-container img {
          width: 100%; /* Adjust the width as needed */
          height: auto; /* Maintain aspect ratio */
          transition: transform 0.3s ease;
          max-width: 100%;
      }

  

      .image-container:last-child a {
          flex: 0 1 calc(33.333% - 10px); /* Adjust the percentage based on your layout */
      }

      .image-container:last-child a:last-child {
          margin-right: 10px; /* Adjust the margin for the last image in the last row */
      }

      .image-container a:hover,
      .image-container img:hover {
          transform: scale(1.1);
      }


      #dayNightCard {
              position: relative;
              width: 100%;
              padding-top: 50%; /* 4:3 aspect ratio */
              background-size: cover;
              background-position: center;
              color: white; /* Set text color */
          }

          #dayNightCard .card-body {
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              text-align: center;
          }

          #clock {
              font-size: 2.5em;
          }

          #ampm {
              font-size: 1em;
              display: inline-block; /* Make AM/PM display inline */
              vertical-align: top; /* Align AM/PM with the top of the clock */
          }




          .wider-input {
      width: 250; /* Adjust the width as needed */
      border-radius: 15px;
      background-color: white;
  }

      




  </style>


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  


  </head>


  <body style="background-color: #E8E8E7">


  <div class="container-fluid">
      

          <div class="row">
      <div class="col-lg-8 align-items-strech">
          <div class="card three-card">
              <div class="card-body">
                  <h5 class="card-title fw-semibold" style="color: black; ">References | Downloads</h5>
                  <div class=" d-block align-items-center justify-content-between mb-9">
                      <div class="mb-3 mb-sm-0"></div>
                  </div>


  <b>
  <div class="image-container">
      <!-- Row 1 -->
      <a href="links/Related_Laws_Katarungang_Pambarangay_Handbook (1).pdf" download>
      <img src="img/1.png" alt="Image 1">
      <figcaption style="color: white;">Related Laws KP Handbook</figcaption>
  </a>

      <a href="links/OFFENSES WITHIN KP_Jurisdiction_for Admin.pptx.pdf" download>
          <img src="img/3.png" alt="Image 3">
          <figcaption style="color: white;">Offenses within KP Jurisdiction for Admin</figcaption>
      </a>

      <a href="links/LTIA-FORMS-6-7-1.docx.pdf" download>
          <img src="img/4.png" alt="Image 4">
          <figcaption style="color: white;">LTIA-FORMS-6-7-1</figcaption>
      </a>

      <a href="links/KP-for-Atty-Ver.ppt.pdf" download>
          <img src="img/6.png" alt="Image 3">
          <figcaption style="color: white;">Revised KP Law</figcaption>
      </a>
  </div>

  <div class="image-container">
      <!-- Row 2 -->
      <a href="links/template-conso-report-KP (1).xlsx - Sheet1.pdf" download>
          <img src="img/2.png" alt="Image 2">
          <figcaption style="color: white;">Consolidated KP Compliance Report</figcaption>
      </a>

    

      <a href="links/KATARUNGANG PAMBARANGAY.pptx.pdf" download>
          <img src="img/10.png" alt="Image 3">
          <figcaption style="color: white;">DILG Laguna Cluster-A SUB LGRC</figcaption>
      </a>

      <a href="links/KP-Flowchart-with-link-to-KP-Forms_atty-ver.pptx.pdf" download>
          <img src="img/7.png" alt="Image 4">
          <figcaption style="color: white;">KP Flowchart with Links</figcaption>
      </a>

      <a href="links/KP actual process_Jurusdictional aspect.pptx.pdf" download>
          <img src="img/8.png" alt="Image 2">
          <figcaption style="color: white;">KP Actual Process Jurisdictional Aspect</figcaption>
      </a>

    
  </div>

  <div class="image-container">
      <!-- Row 3 -->
    

      <a href="links/Katarungang-Pambarangay-2018-v2.pptx.pdf" download>
          <img src="img/9.png" alt="Image 1">
          <figcaption style="color: white;">KP 2018 V2</figcaption>
      </a>

      <a href="links/criminal-cases-under-the-jurisdiction-of-KP_atty-ver.pptx.pdf" download>
          <img src="img/11.png" alt="Image 4">
          <figcaption style="color: white;">Criminal Cases Under the Jurisdiction of KP</figcaption>
      </a>


      <a href="links/KP-IRR.pdf" download>
          <img src="img/5.png" alt="Image 1">
          <figcaption style="color: white;">KP Forms English</figcaption>
      </a>    

      
      
      <a href="links/543442409-KP-Forms-Tagalog-1.pdf" download>
          <img src="img/12.png" alt="Image 2">
          <figcaption style="color: white;">KP Forms Tagalog</figcaption>
      </a>

      
  </div>

    </b>
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
            <div class="col-lg-8">
              <!-- Settled Cases Card -->
              <div class="card four-card">
                <div class="card-body">
                  <div class="row align-items-start">
                    <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                      Settled Cases
                    </h5>
                    <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">
                      <?php
                      if ($selected_month && $selected_month !== date('F Y')) {
                        echo $s_totalSet; // Display the selected month's value
                      } else {
                        echo $totalSettledCount;
                      }
                      ?>
  </p>
          
          <div class="col-8">
                        
                        </div>
                      
                      </div>
                    </div>


                  </div>
                  <div class="card six-card overflow-hidden">
                    <div class="card-body p-4">
                    <div class="row alig n-items-start"> <h5 class="card-title mb-9 fw-semibold" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
                    Unsettled Cases</h5>
                    <p class="mb-9 fw-semibold" style="color: white; font-size: 40px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5">
      <?php
      if ($selected_month && $selected_month !== date('F Y')) {
          echo $s_totalUnset; // Display the selected month's value
      } else {
          echo $totalUnsetCount;
      }
      ?>
  </p>
  </div>
  </div>
  </div>
  <a href="https://www.dilg.gov.ph/" class="card seven-card overflow-hidden" style="text-decoration: none;" target="_blank">
    <div class="card-body p-4">
      <div class="row align-items-start">
      </div>
    </div>
  </a>

  <a href="https://www.facebook.com/dilglaguna.clustera.7" class="card five-card overflow-hidden" style="text-decoration: none;" target="_blank">
    <div class="card-body p-4">
      <div class="row align-items-start">
      </div>
    </div>
  </a>

  <a href="https://www.instagram.com/dilgr4a/" class="card eight-card overflow-hidden" style="text-decoration: none;" target="_blank">
    <div class="card-body p-4">
      <div class="row align-items-start">
      </div>
    </div>
  </a>




  </div>    
  </div>    
      </div>    

    
    





    

    




    

















            






                      


    </div>


    
                    </div>
                    

                    
                  </div>
                </div>
                
      <!--          <div class="row">
        <div class="col-lg-4 d-flex align-items-strech">
          <div class="card w-100 eleven-card">
              <div class="card-body">
          



            </div>
          </div>
      </div>    

      <div class="col-lg-7 d-flex align-items-stretch">
      <div class="card w-100 twelve-card">
          <div class="card-body">
    
          </div>

          
      </div>
  </div>
    -->


      
    </div>
              </div>
            </div>
          </div>
        
    

                      
        </div>
      </div>
    </div>


    

  </body>

  </html>