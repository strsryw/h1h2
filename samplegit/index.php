<?php


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script type="text/javascript" src="../functions/jquery/js/jquery.min.js"></script>

    <script src="h1.js"></script>
    <title>Sampel Git</title>
</head>

<body>

    <table>
        <tr>
            <td>Distributor</td>
            <td>:</td>
            <td><input type="text" id="filterNamaDistributor"></td>
        </tr>
        <tr>
            <td colspan="3"><button style="width: 100%;" onclick="getData(1)">CARI</button></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <br>

    <table border="1" id="tblGetData">
        <thead>
            <tr>
                <td>No</td>
                <td>Distributor</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="99" style="text-align:center;vertical-align:middle">Data Kosong</td>
            </tr>
        </tbody>
    </table>

</body>

</html>