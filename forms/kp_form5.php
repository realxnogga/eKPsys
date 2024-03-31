<?php
session_start();
include 'connection.php';
$linkedNames = $_SESSION['linkedNames'] ?? [];
include '../form_logo.php';
$cNum = $_SESSION['cNum'] ?? '';

?>
<!DOCTYPE html>
<html>
<head>
    <title>KP Form 5 English</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- here angle the link for responsive paper -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
</head>
<style>
    /* Hide the number input arrows */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hide the number input arrows for Firefox */
    input[type=number] {
        -moz-appearance: textfield;
        border: none;
        width: 40px;
        text-align: center;

    }
    h5 {
        margin: 0;
        padding: 0;
    }
    h3 {
        margin: 0;
        padding: 0;
    }
    .centered-line {
        border-bottom: 1px ridge black;
        display: inline-block;
        min-width: 350px;
        text-align: center;
    }
        
.profile-img{
   width: 3cm;
}

.header {
   text-align: center;
   padding-inline: 4cm;
}
h5 {
       margin: 0;
       padding: 0;
   }
   body {
    background: rgb(204, 204, 204);
}

.container {
    margin: 0 auto;
}

.paper {
    background: white;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
}

/* Add Bootstrap responsive classes for different screen sizes */
@media (min-width: 992px) {
    .paper {
        width: 21cm;
        height: 29.7cm;
    }

    .paper[layout="landscape"] {
        width: 29.7cm;
        height: 21cm;
    }
}

@media (min-width: 1200px) {
    .paper[size="A3"] {
        width: 29.7cm;
        height: 42cm;
    }

    .paper[size="A3"][layout="landscape"] {
        width: 42cm;
        height: 29.7cm;
    }

    .paper[size="A5"] {
        width: 14.8cm;
        height: 21cm;
    }

    .paper[size="A5"][layout="landscape"] {
        width: 21cm;
        height: 14.8cm;
    }
}

@media print {
    body, .paper {
        background: white;
        margin: 0;
        box-shadow: 0;
    }
  /* Adjust print styles here */
  .input-field {
    /* Example: Ensure input fields do not expand beyond their containers */
    max-width: 100%;
  }
  input[name="saveForm"] {
            display: none;
        }
  
  input[type="text"] {
        border-bottom: 1px solid black !important;
    }
}
</style>
</head>
<body>
    <div class="container">
        <div class="paper">
                
 <div class="top-right-buttons">
    <button class="btn btn-primary print-button common-button" onclick="window.print()" style="position:fixed; right: 20px;">
        <i class="fas fa-print button-icon"></i> Print
    </button>
    <button class="btn btn-success download-button common-button" id="downloadButton" style="position:fixed; right: 20px; top: 75px; ">
        <i class="fas fa-file button-icon"></i> Download
    </button>

    <a href="../user_lupon.php">
        <button class="btn common-button" style="position:fixed; right: 20px; top: 177px;">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </a>
               
                </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 5</b></h5>

 <div style="display:inline-block;text-align: center;">
<img class="profile-img" src="<?php echo $lgulogo; ?>" alt="Lgu Logo" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
<img class="profile-img" src="<?php echo $citylogo; ?>" alt="City Logo" style="height: 80px; width: 80px;">
<div style="text-align: center; font-family: 'Times New Roman', Times, serif;">
<br>
<h5 class="header" style="font-size: 18px;">Republic of the Philippines</h5>
<h5 class="header" style="font-size: 18px;">Province of Laguna</h5>
<h5 class="header" style="text-align: center; font-size: 18px;">
<?php
$municipality = $_SESSION['municipality_name'];
$isCity = in_array($municipality, ['Biñan', 'Calamba', 'Cabuyao', 'San Pablo', 'San Pedro', 'Santa Rosa']);
$isMunicipality = !$isCity;

if ($isCity) {
    echo 'City of ' . $municipality;
} elseif ($isMunicipality) {
    echo 'Municipality of ' . $municipality;
} else {
    echo 'City/Municipality of ' . $municipality;
}
?>
</h5>
<h5 class="header" style="font-size: 18px;">Barangay <?php echo $_SESSION['barangay_name']; ?></h5>
<h5 class="header" style="font-size: 18px; margin-top: 5px;">OFFICE OF THE PUNONG BARANGAY</h5>
</div>
<br>
<br>
<?php
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $currentYear = date('Y');
            ?>


<div style="text-align: right;">
                <select id="monthInput" name="month" required style="text-align: center; width: 110px; height: 31px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;">
                    <?php
                    $currentMonth = date('F');
                    foreach ($months as $index => $month) {
                        $monthNumber = $index + 1;
                        $selected = ($month == $currentMonth) ? 'selected' : '';
                        echo '<option value="' . $monthNumber . '" ' . $selected . '>' . $month . '</option>';
                    }
                    ?>
                </select>
                <input type="text" id="day" placeholder= "day" name="day" required style=" height: 30px; text-align: center; width: 30px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;">
                <label for="day">,</label>
                <input type="text" id="year" name="year" required style=" height: 30px; text-align: center; width: 45px; border: none; border-bottom: 1px solid black; font-size: 18px; font-family: 'Times New Roman', Times, serif;" value="<?php echo $currentYear; ?>">


<h3 style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; font-weight: bold;">
<br>OATH OF OFFICE</h3><br>

                <div style="text-align: left;">
                <p style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">Pursuant to Chapter 7, Title One, Book II, Local Government Code of 1991 (Republic Act No. 7160), I

 <input type="text" id="recipient" name="recipient" list="nameList" required style=" width: 20%; border: none; border-bottom: 1px solid black; margin-right: 0;"></p>
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
                   <p style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif;"> , being duly
                    qualified and having been duly appointed MEMBER of the <i>Lupong Tagapamayapa</i> of this Barangay, do hereby solemnly swear (or
                    affirm) that I will faithfully and conscientiously discharge to the best of my ability, my duties and functions as such member and as member of the <i>Pangkat ng Tagapagkasundo</i> in which I may be chosen to serve; that I will bear true faith and allegiance to the
                    Republic of the Philippines; that I will support and defend its Constitution and obey the laws, legal orders and decrees promulgated by
                    its duly constituted authorities; and that I voluntarily impose upon myself this obligation without any mental reservation or purpose of
                    evasion.
                </p>
                </div>

        <div style="position: relative;"><br>
        <p style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif; text-indent: 2em;">
        SO HELP ME GOD. (In case of affirmation the last sentence will be omitted.)</p>

    <br>

    <p class="important-warning-text" style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-left: 450px; margin-right: auto;">
    <input type="text" id="recipient" name="recipient" list="nameList" required style="font-size: 18px; width: 100%; border: none; border-bottom: 1px solid black; margin-right: 0;">
    <datalist id="nameList">
        <?php foreach ($linkedNames as $name): ?>
            <option value="<?php echo $name; ?>">
        <?php endforeach; ?>
    </datalist>
    <br><p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-top: 20px; margin-right: 120px;">Member
    </p><br><br><br>
    
    <form method="POST">
                    <p style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif; text-indent: 2em;">
                       SUBSCRIBED AND SWORN to (or AFFIRMED) before me this
                       <input type="number" name="made_day" placeholder="day" min="1" max="31" style="font-size: 18px; border: none; border-bottom: 1px solid black;" value="<?php echo $existingMadeDay; ?>">
        day of
        <select name="made_month" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; padding: 0; margin: 0; height: 30px; line-height: normal; box-sizing: border-box;" required>
    <?php foreach ($months as $m): ?>
        <?php if ($id > 0): ?>
            <option style="font-size: 18px;" value="<?php echo $existingMadeMonth; ?>" <?php echo ($m === $existingMadeMonth) ? 'selected' : ''; ?>><?php echo $existingMadeMonth; ?></option>
        <?php else: ?>
            <option style="font-size: 18px;" value="<?php echo $m; ?>" <?php echo ($m === $currentMonth) ? 'selected' : ''; ?>><?php echo $m; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>,
        <input type="number" name="made_year" size="1" placeholder="year" style="font-size: 18px; text-align: center; border: none; border-bottom: 1px solid black; left: 10px;" min="<?php echo date('Y') - 100; ?>" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>">.
        <div style="position: relative;">
        <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                </form>
    
    <canvas id="canvas1" width="190" height="80" style="float: right";></canvas>
    <script src="signature.js"></script>
    <p class="important-warning-text" style="text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-left: 440px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="border: none; border-bottom: 1px solid black;outline: none; text-align: center; font-size: 18px; font-family: 'Times New Roman', Times, serif;" size="25" value="<?= strtoupper($linkedNames['punong_barangay'] ?? 'Punong Barangay') ?>">
    <p style="font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-top: 20px; margin-right: 90px;">Punong Barangay
</p>
</form>
<script>
    var barangayCaseNumber = "<?php echo $cNum; ?>"; // Assume $cNum is your case number variable
    document.getElementById('downloadButton').addEventListener('click', function () {
        // Elements to hide during PDF generation
        var buttonsToHide = document.querySelectorAll('.top-right-buttons button');
        
        // Hide the specified buttons
        buttonsToHide.forEach(function (button) {
            button.style.display = 'none';
        });

// Ensure input borders are visible for PDF generation
var toInputs = document.querySelectorAll('input[name^="to"]');
toInputs.forEach(function(input) {
    input.style.borderBottom = '1px solid black';
});

        var pdfContent = document.querySelector('.paper');
        var downloadButton = document.getElementById('downloadButton');

        // Hide the download button
        downloadButton.style.display = 'none';

        // Modify the filename option to include the barangay case number
        html2pdf(pdfContent, {
            margin: [10, 10, 10, 10],
            filename: 'kp_form5_' + barangayCaseNumber + '.pdf', // Dynamic filename
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                scale: 2, // Adjust the scale as necessary
                width: pdfContent.clientWidth, // Set a fixed width based on the on-screen width of the content
                windowWidth: document.documentElement.offsetWidth // Set the window width to match the document width
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        }).then(function () {
            // Show the download button after PDF generation
            downloadButton.style.display = 'inline-block';

            // Show the other buttons after PDF generation
            buttonsToHide.forEach(function (button) {
                button.style.display = 'inline-block';
            });

            // Restore borders for all input types and select
            inputFields.forEach(function (field) {
                field.style.border = ''; // Use an empty string to revert to the default border
            });
        });
    });
</script>