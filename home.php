<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <script>
    // Function to update and display the visit count
    function updateVisitCount() {
      try {
        // Check if local storage is supported
        if (typeof(Storage) !== "undefined") {
          // Check if the 'visitCount' key exists in local storage
          if (localStorage.getItem('visitCount')) {
            // If it exists, increment the count
            let visitCount = parseInt(localStorage.getItem('visitCount')) + 1;
            localStorage.setItem('visitCount', visitCount);
          } else {
            // If it doesn't exist, set the count to 1
            localStorage.setItem('visitCount', 1);
          }

          // Display the visit count on the page
          document.getElementById('visitCount').innerHTML = "Total Website Visits: " + localStorage.getItem('visitCount');
        } else {
          console.error("Local storage is not supported.");
        }
      } catch (error) {
        console.error("An error occurred: " + error.message);
      }
    }

  
    window.onload = updateVisitCount;
  </script>
  <style>
    body {
        background-image: url('img/homebg.png');
        background-size: cover;
    }
    .card {
      box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
    }
    .translucent-background {
        background-color: rgba(0, 0, 0, 0.4); 
        padding: 10px;
        border-radius: 10px;
        color: white;
        margin: 20px;
    }

    
  </style>
  
</head>

<body>
  
  <div class="body-wrapper">
    <header class="app-header">
      <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav mx-auto d-flex justify-content-center">
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="showTab('home')">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="showTab('downloads')">Downloads</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="showTab('login')">Login</a>
          </li>
        </ul>
      </nav>
    </header>

    <!-- Tab content -->
    <div id="homeTab" style="display: block;">
    <br>
    <div class="body-wrapper">
    <div class="container-fluid">
       
          <div class="col-lg-100">
    <div class="row">
        <div class="col-lg-12">
                <div class="card-body visit p-0 text-center">
                    <div id="visitCount" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);"></div><br>
                    <div id="clock" style="color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5); font-size: 30px;"></div>

                    <script>
    function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        var meridiem = (hours >= 12) ? 'PM' : 'AM';

        // Convert hours to 12-hour format
        hours = (hours % 12) || 12;

        hours = (hours < 10) ? '0' + hours : hours;
        minutes = (minutes < 10) ? '0' + minutes : minutes;
        seconds = (seconds < 10) ? '0' + seconds : seconds;

        var timeString = hours + ':' + minutes + ':' + seconds + ' ' + meridiem;
        var dayOfWeek = getDayOfWeek(now.getDay());
        var fullDate = getFullDate(now);

        document.getElementById('clock').innerHTML = timeString + '<br>' + dayOfWeek + ', ' + fullDate;
    }

    function getDayOfWeek(dayIndex) {
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return days[dayIndex];
    }

    function getFullDate(date) {
        var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var day = date.getDate();
        var month = monthNames[date.getMonth()];
        var year = date.getFullYear();

        return day + ' ' + month + ' ' + year;
    }

    // Update the clock every second
    setInterval(updateClock, 1000);

    // Initial call to display the clock immediately
    updateClock();
</script>


                    <div class="row align-items-center justify-content-center">
                        <!-- Your centered content goes here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
        
          <br>

    <div class="card-body card-develop text-center">
        <div class="d-flex align-items-center">
        <h5 class="card-title fw-semibold mb-4 mx-auto text-white fs-20" style="font-size: 25px; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5);">The Developers</h5>

        </div> 
    

   
        <div class="row">
          <div class="col-sm-2 col-xl-2">
            <div class="card overflow-hidden rounded-2">
              <div class="position-relative">
              <img src="img/phil.png" class="card-img-top rounded-0" alt="..." data-toggle="modal" data-target="#imageModal">
                <a href="javascript:void(0)"></a>                      </div>
              <div class="card-body pt-3 p-4">
                <h6 class="fw-semibold fs-4">Phil Bojo Repotente</h6>
              </div>
            </div>
          </div>
          <!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Image inside the modal -->
        <img src="img/phil-1.png" class="img-fluid" alt="...">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Link Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
          <div class="col-sm-2 col-xl-2">
            <div class="card overflow-hidden rounded-2">
              <div class="position-relative">
                <a href="javascript:void(0)"><img src="img/angel.png" class="card-img-top rounded-0" alt="..." data-toggle="modal" data-target="#imageModal4"></a>
                <a href="javascript:void(0)"></a>                      </div>
              <div class="card-body pt-3 p-4">
                <h6 class="fw-semibold fs-4">Angel May L. De Guzman</h6>
              </div>
            </div>
          </div>
          <!-- Modal -->
<div class="modal fade" id="imageModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Image inside the modal -->
        <img src="img/angel-1.png" class="img-fluid" alt="...">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
          <div class="col-sm-2 col-xl-2">
            <div class="card overflow-hidden rounded-2">
              <div class="position-relative">
                <a href="javascript:void(0)"><img src="img/zydrick.png" class="card-img-top rounded-0" alt="..." data-toggle="modal" data-target="#imageModal2"></a>
                <a href="javascript:void(0)"></a>                      </div>
              <div class="card-body pt-3 p-4">
                <h6 class="fw-semibold fs-4">Prince Zydrick R. Salazar</h6>
              </div>
            </div>
          </div>
           <!-- Modal -->
<div class="modal fade" id="imageModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Image inside the modal -->
        <img src="img/zydrick-1.png" class="img-fluid" alt="...">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
          <div class="col-sm-2 col-xl-2">
            <div class="card overflow-hidden rounded-2">
              <div class="position-relative">
                <a href="javascript:void(0)"><img src="img/grace.png" class="card-img-top rounded-0" alt="..." data-toggle="modal" data-target="#imageModal3"></a>
                <a href="javascript:void(0)"></a>                      </div>
              <div class="card-body pt-3 p-4">
                <h6 class="fw-semibold fs-4">Mary Grace M. Bautista</h6>
              </div>
            </div>
          </div>
          <!-- Modal -->
<div class="modal fade" id="imageModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Image inside the modal -->
        <img src="img/grace-1.png" class="img-fluid" alt="...">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
          <div class="col-sm-2 col-xl-2">
            <div class="card overflow-hidden rounded-2">
              <div class="position-relative">
                <a href="javascript:void(0)"><img src="img/carl.png" class="card-img-top rounded-0" alt="..." data-toggle="modal" data-target="#imageModal1"></a>
                <a href="javascript:void(0)"></a>                      </div>
              <div class="card-body pt-3 p-4">
                <h6 class="fw-semibold fs-4">Carl Janzell N. Oropesa</h6>
              </div>
            </div>
          </div>
          <!-- Modal -->
<div class="modal fade" id="imageModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Image inside the modal -->
        <img src="img/carl-1.png" class="img-fluid" alt="...">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
          <div class="col-sm-2 col-xl-2">
            <div class="card overflow-hidden rounded-2">
              <div class="position-relative">
                <a href="javascript:void(0)"><img src="img/kisha.png" class="card-img-top rounded-0" alt="..." data-toggle="modal" data-target="#imageModal6"></a>
                <a href="javascript:void(0)"></a>                      </div>
              <div class="card-body pt-3 p-4">
                <h6 class="fw-semibold fs-4">Kisha V. Abrenilla</h6>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
<div class="modal fade" id="imageModal6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Image inside the modal -->
        <img src="img/kisha-1.png" class="img-fluid" alt="...">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<br>
<div class="row">
    <!-- Left side with text -->
    <div class="col-lg-4 d-flex align-items-stretch">
    <p style="font-size: 16px; color: white; text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5); text-align: justify;">
        Introducing the E-Katarungan Pambarangay System project by DILG Cluster-A in collaboration with Laguna State Polytechnic University, Los Baños, Laguna. This initiative revolutionizes local governance, leveraging technology to enhance the efficiency and accessibility of the barangay justice system, fostering community empowerment and harmonious progress.

        <br><br>

        Leveraging the latest technologies, this cutting-edge system not only enhances project management efficiency but also promotes seamless communication and resource sharing among users. With a user-friendly interface and robust features, it empowers students and educators to effortlessly navigate the collaborative landscape, fostering an environment that nurtures innovation and facilitates knowledge exchange.
    </p>
</div>

<!-- Right side with card -->
<div class="col-lg-8 d-flex align-items-strech">
    <div class="card w-100 rounded-2" style="background-image: url('img/home1.png'); background-size: cover; background-position: center;">
            <div class="translucent-background" style="text-shadow: 0 0 0.2cm rgba(0, 0, 0, 0.5); font-size: 14px;">
                Benchmarking Activity, Barangay San Vicente, Biñan City, Laguna, March 11, 2024
        </div>
    </div>
</div>




    <div id="downloadsTab" style="display: none;">
    <div class="body-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-100 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Downloads</h5>
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
    </div>
    <div id="loginTab" style="display: none;">
  <div class="body-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-100 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Title</h5>
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


      

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function showTab(tabName) {
      // Hide all tabs
      document.getElementById('homeTab').style.display = 'none';
      document.getElementById('downloadsTab').style.display = 'none';
      document.getElementById('loginTab').style.display = 'none';

      // Show the selected tab
      document.getElementById(tabName + 'Tab').style.display = 'block';
    }
  </script>
</body>

</html>
