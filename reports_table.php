<!DOCTYPE html>
<html>

<head>
    <title>Reports</title>

    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Center the table */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .custom-table {
            margin: auto;
            text-align: center;
            border-collapse: collapse;
            width: 100%;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid black;
            padding: 5px;
        }

        /* Hide non-table content when printing */
        @media print {
            body > *:not(table) {
                display: none !important;
            }
        }
    </style>
</head>
<body>
     
    <div class="table-responsive">
<table class="table custom-table">
    <tbody>
    <tr>
    <td colspan="19">
    <p><b> CATEGORY: BARANGAY</b></p>
    </td>

    <tr>
    <td colspan="15">
    <p><b>FINALIST LUPONG TAGAPAMAYAPA : </b></p>
    </td>
    <td colspan="4">
    <p><b>POPULATION : </b></p>
    </td>
    </tr>
    <tr>
    <td colspan="15">
    <p><b>PUNONG BARANGAY:</b></p>
    </td>
    <td colspan="4">
    <p><b>LAND AREA :</b></p>
    </td>
    </tr>
    <tr>
    <td colspan="15">
    <p><b>CITY/MUNICIPALITY :</b></p>
    </td>
    <td colspan="4">
    <p><b>TOTAL NO. OF CASES:</b></p>
    </td>
    </tr>
    <tr>
    <td colspan="15">
    <p><b>MAYOR: </b></p>
    </td>
    <td colspan="4">
    <p><b>NUMBER OF LUPONS:</b></p>
    </td>
    </tr>
    <tr>
    <td colspan="15">
    <p><b>PROVINCE: </b></p>
    </td>
    <td colspan="4">
    <p><b>MALE :</b></p>
    </td>
    </tr>
    <tr>
    <td colspan="15">
    <p><b>REGION: </b></p>
    </td>
    <td colspan="4">
    <p><b> FEMALE :</b></p>
    </td>
    </tr>

    <tr>
    <td colspan="17">
    <p><b><em>General Instruction: </em></b><em>Please read the Technical Notes at the back before accomplishing this form. Supply only the number.</em></p>
    </td>
    <td></td>
    <td></td>
    </tr>
   
    <tr>
    <td colspan="4">
    <p><b>NATURE OF CASES </b></p>
    </td>
    <td colspan="12">
    <p><b>ACTION TAKEN</b></p>
    </td>
    <td></td>
    <td rowspan="4">
    <p><b>TOTAL<br /> (cases filed)</b></p>
    </td>
    <td rowspan="4">
    <p><b>BUDGET ALLO-CATED<br /> (6)</b></p>
    </td>
    </tr>
    <tr>
    <td colspan="4">
    <p><b>(1)</b></p>
    </td>
    <td colspan="6" rowspan="2">
    <p><b>SETTLED </b></p>
    <p><b>(2)</b></p>
    </td>
    <td colspan="6" rowspan="2">
    <p><b>NOT SETTLED </b></p>
    <p><b>(3)</b></p>
    </td>
    <td rowspan="3">
    <p><b>OUTSIDE THE JURISDICTION OF THE BARANGAY<br /> (5)</b></p>
    </td>
    </tr>
    <tr>
    <td colspan="4"></td>
    </tr>
    <tr>
    <td>
    <p><b>CRIMI-NAL<br /> (1a)</b></p>
    </td>
    <td>
    <p><b>CIVIL<br /> (1b)</b></p>
    </td>
    <td>
    <p><b>OTHERS<br /> (1c)</b></p>
    </td>
    <td>
    <p><b>TOTAL </b></p>
    <p><b>(1D) </b></p>
    </td>
    <td colspan="2">
    <p><b>MEDIA-TION<br /> (2a)</b></p>
    </td>
    <td colspan="2">
    <p><b>CONCI-LIATION<br /> (2b)</b></p>
    </td>
    <td>
    <p><b>ARBIT-RATION<br /> (2c)</b></p>
    </td>
    <td>
    <p><b>TOTAL<br /> (2D)</b></p>
    </td>
    <td>
    <p><b>PEN-DING<br /> (3a)</b></p>
    </td>
    <td>
    <p><b>DIS-MISSED<br /> (3b)</b></p>
    </td>
    <td>
    <p><b>REPU-DIATED<br /> (3c)</b></p>
    </td>
    <td>
    <p><b>CERTIFIED TO FILE ACTION IN COURT<br /> (3d)</b></p>
    </td>
    <td>
    <p><b>DROP-PED/ WITH--DRAWN<br /> (3e)</b></p>
    </td>
    <td>
    <p><b>TOTAL<br /> (3F)</b></p>
    </td>
    </tr>
    <tr >
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="2"></td>
    <td colspan="2"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
    </tbody>
    </table>
</div>
    <button onclick="printTable()">Print Table</button>
    <script>
        function printTable() {
            // Hide non-table content before printing
            const nonTableContent = document.querySelectorAll(':not(table)');
            nonTableContent.forEach(element => {
                element.classList.add('no-print');
            });

            // Initiate browser's print dialog
            window.print();

            // Restore non-table content after printing
            nonTableContent.forEach(element => {
                element.classList.remove('no-print');
            });
        }
    </script>
</body>
</html>