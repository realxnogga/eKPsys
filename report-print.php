<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}
include 'count_lupon.php';

include 'report_handler.php';


?>

<!DOCTYPE html>
<html>
<head>

<!-- Include jQuery, html2pdf.js, and xlsx libraries -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

    <script>
    function generatePDF() {
    var element = document.querySelector('table');
    var additionalContent = `
        <br><br>
        <p>***Total Number of Lupons excluding Lupon Chairman and Lupon Secretary</p>
        <p>***Please attach Form 06-A "LIST OF CASES"</p>
        <br><br>
    `;

    // Create a new window with the combined content
    var newWindow = window.open('', '_blank');
    newWindow.document.write('<html><head><title>PDF</title></head><body>' + element.outerHTML + additionalContent + '</body></html>');
    newWindow.document.close();

    // Use html2pdf library to generate PDF
    html2pdf(newWindow.document.body, {
        margin: 10,
        filename: 'table_' + getFormattedDate() + '.pdf',
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
    });

    // Close the new window
    newWindow.close();
}

    // Function to download table as Excel
    function downloadExcel() {
        var element = document.querySelector('table');
        
        // Use xlsx library to generate Excel file
        var wb = XLSX.utils.table_to_book(element);
        var wbout = XLSX.write(wb, { bookType: 'xlsx', bookSST: true, type: 'binary' });

        // Convert string to ArrayBuffer
        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
            return buf;
        }

        // Create Blob and trigger download
        var blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
        saveAs(blob, 'table_' + getFormattedDate() + '.xlsx');
    }

    // Function to adjust table styles for PDF generation
    function adjustTableStyles(table) {
        // Store original styles
        table.setAttribute('data-original-style', table.getAttribute('style') || '');

        // Set new styles for PDF generation
        table.style.fontSize = '10px'; // Adjust font size
        table.style.width = '100%'; // Adjust table width
        // Add more style adjustments as needed
    }

    // Function to restore original table styles
    function restoreTableStyles(table) {
        // Restore original styles
        var originalStyle = table.getAttribute('data-original-style');
        table.setAttribute('style', originalStyle);
    }

    // Function to get the current date and time in a formatted string
    function getFormattedDate() {
        var now = new Date();
        var year = now.getFullYear();
        var month = ('0' + (now.getMonth() + 1)).slice(-2);
        var day = ('0' + now.getDate()).slice(-2);

        return year + month + day + '_';
    }
</script>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px; /* Adjust font size for printing */

    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 5px;
        text-align: center;
    }

    .header {
        text-align: left;
    }

    .sub-header {
    }

    /* ... Your existing styles ... */

    @media print {
            .header, .sub-header {
                font-size: 8px; /* Adjust font size for printing */
            }
        }
</style>
</head>
<body>
<b>
<table>
    <!-- Header Section -->
    <tr>
        <td colspan="60" class="sub-header">CY LUPONG TAGAPAMAYAPA INCENTIVES AWARDS (LTIA)<BR>LTIA FORM 07-PERFORMANCE HIGHLIGHTS</td>
    </tr>
    <tr>
        <td colspan="60" class="sub-header">CATEGORY: BARANGAY</td>
    </tr>
    <tr>
        <td colspan="25" class="header">FINALIST LUPONG TAGAPAMAYAPA : <?php echo strtoupper($_SESSION['brgy_name']); ?></td>
        <td  colspan="38" class="header">POPULATION : <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_population; // Display the selected month's value
        } else {echo $population;} ?></td>
    </tr>
    <tr>
        <td colspan="25" class="header">PUNONG BARANGAY : <?php echo $_SESSION['punong_brgy']; ?></td>
        <td colspan="38" class="header">LAND AREA : <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_landarea; // Display the selected month's value
        } else {echo $landarea;} ?></td>
    </tr>
    <tr>
        <td colspan="25" class="header">CITY/MUNICIPALITY : <?php echo strtoupper($_SESSION['munic_name']); ?></td>
        <td colspan="38" class="header">TOTAL NO. OF CASES : <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_totalc; // Display the selected month's value
        } else {echo $natureSum;} ?></td>
    </tr>
    <tr>
        <td colspan="25" class="header">MAYOR : <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_mayor; // Display the selected month's value
        } else {echo $mayor;} ?></td>
        <td colspan="38" class="header">NUMBER OF LUPONS : <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_numlup; // Display the selected month's value
        } else {echo $numlup;} ?></td>
    </tr>
    <tr>
        <td colspan="25"class="header">PROVINCE : LAGUNA</td>
        <td colspan="38"class="header">MALE : <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_male; // Display the selected month's value
        } else {echo $male;} ?></td>
    </tr>
    <tr>
        <td colspan="25"class="header">REGION : <?php  if ($selected_month && $selected_month !== date('F Y')) {
            echo $s_region; // Display the selected month's value
        } else {echo $region;} ?></td>
        <td colspan="38"class="header">FEMALE : <?php  if ($selected_month && $selected_month !== date('F Y')) {
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
        <td rowspan="2" colspan="6">NATURE OF CASES <br> (1)</td>
        <td colspan="38">ACTION TAKEN</td>
        <td rowspan="3" colspan="4">OUTSIDE THE <br> JURISDICTION <br> OF THE <br> BARANGAY <br> (4)</td>
        <td rowspan="3" colspan="4">TOTAL <br> (cases <br> filed) <br> (5)</td>
        <td rowspan="3" colspan="4">BUDGET <br> ALLO- <br>CATED <br> (6)</td>

    </tr>
    <tr>
        <td colspan="19">SETTLED <br> (2)</td>
        <td colspan="18">NOT SETTLED <br> (3)</td>
    
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
<br><br>
    <p>***Total Number of Lupons excluding Lupon Chairman and Lupon Secretary</p>
    <p>***Please attached Form 06-A "LIST OF CASES"</p>
    <br><br>
    <button onclick="generatePDF()">Generate PDF</button>
    <button onclick="downloadExcel()">Download Excel</button>

</body>
</html>