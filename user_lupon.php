<?php
session_start();
include 'connection.php';
include 'index-navigation.php';
include 'functions.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

include 'lupon_handler.php';
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'english'; // Set default language to English
}
?>


<!doctype html>
<html lang="en">

<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupon</title>
    <link rel="shortcut icon" type="image/png" href=".assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <style>
        .active {
        background-color: #ffcc00;
        color: #fff;
    }
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); /* Dark overlay background */
}

/* CSS for the iframe container */
.kp-form-iframe {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 1000px; /* Adjust the width as needed */
    height: 800px; /* Adjust the height as needed */
    background-color: white;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}
.form-control {
        width: 220px; /* Adjust the width as needed */
    }



    .card {
      box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
      border-radius: 15px;

      }
</style>
</head>

<body style="background-color: #E8E8E7">


<div class="container-fluid">
<a href="user_dashboard.php" class="btn btn-dark m-1">Back to Dashboard</a>
<br><br>

<div class="card overflow-hidden">
                  <div class="card-body p-4">
                    
                  <div class="d-flex align-items-center">
    <img src="img/cluster.png" alt="Logo" style="max-width: 120px; max-height: 120px; margin-right: 10px;" class="align-middle">
    <div>
    <h5 class="card-title mb-2 fw-semibold">Department of the Interior and Local Government</h5>

    </div></div>    
<br>
                  <h5 class="card-title mb-9 fw-semibold"><?php echo ucfirst($_SESSION['language']); ?> Forms</h5>

                    
                    

<!-- Language Selection Buttons -->
<button type="button" onclick="setLanguage('english')" class="btn <?php echo ($_SESSION['language'] === 'english') ? 'btn-dark' : 'btn-light'; ?> m-1">English</button>
<button type="button" onclick="setLanguage('tagalog')" class="btn <?php echo ($_SESSION['language'] === 'tagalog') ? 'btn-dark' : 'btn-light'; ?> m-1">Tagalog</button>

<script>
// Function to set language via AJAX
function setLanguage(language) {
    // Send AJAX request to update language session variable
    $.ajax({
        url: 'update_language.php',
        method: 'POST',
        data: { language: language },
        success: function(response) {
            // Reload the page to reflect language changes
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(error);
        }
    });
}
</script>
<br>


<div class="form-buttons">
    <?php
    $formButtons = [
        'KP 1' => 'kp_form1.php',
        'KP 2' => 'kp_form2.php',
        'KP 3' => 'kp_form3.php',
        'KP 4' => 'kp_form4.php',
        'KP 5' => 'kp_form5.php',
        'KP 6' => 'kp_form6.php',
    ];

    foreach ($formButtons as $buttonText => $formFileName) {
        $formUsed = array_search($buttonText, array_keys($formButtons)) + 7;

        $formID = null; // Initialize $formID
        $formIdentifier = null; // Initialize $formIdentifier

        // Construct file path based on language
        $languageFolder = ($_SESSION['language'] === 'english') ? 'forms/' : 'formsT/';
        $formPath = $languageFolder . $formFileName;

        // Display form buttons with data-form attribute
        echo '<a href="' . $formPath . '?formID=' . $formID . '" class="open-form"><button class="open-form btn btn-light m-1" data-form="' . $formFileName . '"><i class="fas fa-file-alt"></i> ' . $buttonText . $formIdentifier . ' </button></a>';
    }
    ?>
</div>
</div> </div>
        <!--  Row 1 -->
        <div class="row">
        <div class="col-md-13 mb-3">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">        
                    


                     <h5 class="card-title mb-9 fw-semibold">Lupon</h5>
<b>
                     <form method="post">
                     <div class="row">
        <div class="col-md-3 mb-3">
            <?php
    for ($i = 1; $i <= 5; $i++) {
        $iFormatted = str_pad($i, 2, '0', STR_PAD_LEFT); // Add leading 0
        $nameKey = "name$i";
        $nameValue = $linkedNames[$nameKey] ?? '';
        echo "<div>$iFormatted. <input type='text' name='linked_name[]' class='form-control' value='$nameValue' placeholder='Name $iFormatted'></div>";
    }
    ?>
        </div>
        <div class="col-md-3 mb-3">
            <?php
    for ($i = 6; $i <= 10; $i++) {
        $iFormatted = str_pad($i, 2, '0', STR_PAD_LEFT); // Add leading 0
        $nameKey = "name$i";
        $nameValue = $linkedNames[$nameKey] ?? '';
        echo "<div>$iFormatted. <input type='text' name='linked_name[]' class='form-control' value='$nameValue' placeholder='Name $iFormatted'></div>";
    }
    ?>
        </div>
        <div class="col-md-3 mb-3">
            <?php
    for ($i = 11; $i <= 15; $i++) {
        $iFormatted = str_pad($i, 2, '0', STR_PAD_LEFT); // Add leading 0
        $nameKey = "name$i";
        $nameValue = $linkedNames[$nameKey] ?? '';
        echo "<div>$iFormatted. <input type='text' name='linked_name[]' class='form-control' value='$nameValue' placeholder='Name $iFormatted'></div>";
    }
    ?>
        </div>
        <div class="col-md-3 mb-3">
            <?php
    for ($i = 16; $i <= 20; $i++) {
        $iFormatted = str_pad($i, 2, '0', STR_PAD_LEFT); // Add leading 0
        $nameKey = "name$i";
        $nameValue = $linkedNames[$nameKey] ?? '';
        echo "<div>$iFormatted. <input type='text' name='linked_name[]' class='form-control' value='$nameValue' placeholder='Name $iFormatted'></div>";
    }
    ?>
        </div>
</div>

<label for="criminal">Punong Barangay:</label>
<input type="text" name="punong_barangay" class='form-control' value="<?= strtoupper($linkedNames['punong_barangay'] ?? '') ?>">

<label for="criminal">Lupon Chairman:</label>
<input type="text" name="lupon_chairman" class='form-control' value="<?= strtoupper($linkedNames['lupon_chairman'] ?? '') ?>">
<br>
<button type="submit" class="btn btn-success m-1" id="save-button" name="save">Appoint</button>
<button type="submit"  class="btn btn-warning m-1" id="save-button" name="appoint">Notice</button>
<button type="button"  class="btn btn-light m-1" id="clear-button" name="clear">Clear All</button>
<a href="upload_file_lupon.php" class="btn btn-sm btn-primary" title="Upload" data-placement="top"><i class="fas fa-upload"></i> </a>
                  </form>


       
    </div></div>
       


</body>
</html>
