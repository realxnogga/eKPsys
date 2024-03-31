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
    <title>KP Form 4 English</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- here angle the link for responsive paper -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="formstyles.css">
</head>
<style>
    .profile-img {
        width: 3cm;
    }

    /* Hide the number input arrows for WebKit browsers like Chrome, Safari */
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

    /* Regular screen styles for text inputs */
    input[type="text"], input[type="number"] {
        border: none;
        border-bottom: 1px solid black;
        font-family: 'Times New Roman', Times, serif;
        font-size: 18px;
        text-align: left;
        outline: none;
        width: auto; /* Adjust width as necessary */
    }

    h3, h5 {
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
            height: auto;
        }

        .paper[layout="landscape"] {
            width: 29.7cm;
            height: auto;
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

    /* Consolidated Print styles */
    @media print {
        body, html, .container, .paper {
            background: white;
            margin: 0;
            padding: 0;
            box-shadow: none;
            width: auto;
        }
        
        .paper {
            padding-left: 2.54cm; /* 1 inch */
            padding-right: 2.54cm; /* 1 inch */
        }

        input[type="text"], input[type="number"], select {
            border: none !important;
            border-bottom: 1px solid black !important;
            color: black !important;
            background-color: white !important;
            display: inline-block !important;
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        
        input[type="text"]:after, input[type="number"]:after {
            content: "";
            display: block;
            margin-top: -1px;
            border-bottom: 1px solid black;
        }

        /* Hide elements that should not be printed */
        .btn, .top-right-buttons {
            display: none !important;
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
               
                </div>      <h5> <b style="font-family: 'Times New Roman', Times, serif;">KP Form No. 4</b></h5>

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
<br>LIST OF APPOINTED LUPON MEMBERS</h3>
<form method="POST">
                <div style="text-align: left;">
                <br><br><p style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">Listed hereunder are the duly appointed members of the <i>Lupong
            Tagapamayapa</i> in this Barangay who shall serve as such upon taking their oath of office and until a new Lupon is
            constituted on the third year following their appointment.
                </p>
                                    <div style="display: flex; ">
    <div style="flex: 1; margin-left: 70px; ">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <?php $nameKey = "name$i"; ?>
            <p style="margin: 0; font-family: 'Times New Roman', Times, serif; font-size: 18px;"><?php echo $i; ?>. <input type="text" name="appointed_lupon_<?php echo $i; ?>" value="<?php echo $linkedNames[$nameKey] ?? ''; ?>" style="width: 250px; margin-bottom: 5px; font-family: 'Times New Roman', Times, serif; font-size: 18px;"></p>
        <?php endfor; ?>
    </div>

        <div style="flex: 1;">
        <?php for ($i = 11; $i <= 20; $i++): ?>
            <?php $nameKey = "name$i"; ?>
            <p style="margin: 0; font-family: 'Times New Roman', Times, serif; font-size: 18px;"><?php echo $i; ?>. <input type="text" name="appointed_lupon_<?php echo $i; ?>" value="<?php echo $linkedNames[$nameKey] ?? ''; ?>" style="width: 250px; margin-bottom: 5px;"></p>
        <?php endfor; ?>
    </div>
</div>

        </div><br><br>
                </div>


                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

    
    <body>
    <p class="important-warning-text" style="text-align: center; font-family: 'Times New Roman', Times, serif; font-size: 18px; margin-left: 450px; margin-right: auto;">
    <input type="text" id="positionInput" name="pngbrgy" style="font-family: 'Times New Roman', Times, serif; border: none; border-bottom: 1px solid black; outline: none; text-align: center; font-size: 18px;" size="25" value="<?= strtoupper($linkedNames['punong_barangay'] ?? 'Punong Barangay') ?>">
    <p style="margin-top: 10px; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-left: 420px;">Punong Barangay
</p>

<script>
    // Function to select the text when clicked
    const positionInput = document.getElementById('positionInput');
    positionInput.addEventListener('click', function() {
        this.select();
    });
</script>

    <p style="text-align: justify; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-right: 610px;">ATTESTED:</p>
    <p class="important-warning-text" style="text-align: center; font-family: 'Times New Roman', Times, serif; font-size: 18px; margin-right: 470px; margin-left: auto;">
    <input type="text" id="pngbrgy" name="pngbrgy" style="font-family: 'Times New Roman', Times, serif; border: none; border-bottom: 1px solid black; outline: none;" size="25">
    <p style="margin-top: 10px; font-size: 18px; font-family: 'Times New Roman', Times, serif; margin-right: 450px;">Barangay/Lupon Secretary
    </p><br>
    <input type="submit" name="saveForm" value="Save" class="btn btn-primary print-button common-button" style="position: fixed; right: 20px; top: 130px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                </form>
        <div>
                    <p class="important-warning-text" style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">
                    IMPORTANT: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    This notice is required to be posted in three (3) conspicuous places in the
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    barangay for at least three (3)
                    weeks.
                    </p>
                    <p class="important-warning-text" style="text-indent: 2em; text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 18px;">
                    WARNING: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Tearing or defacing this notice shall be subject to punishment according
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    to law.
                    </p>
                    </div>
                    </div> 
</form>
<?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                
            </div>
        </div>
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
            filename: 'kp_form4_' + barangayCaseNumber + '.pdf', // Dynamic filename
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