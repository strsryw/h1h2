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
            <td>Aktif</td>
            <td>:</td>
            <td><select id="filterAktif" style="width: 100%;">
                    <option value="true" selected>ACTIVE</option>
                    <option value="false">NON ACTIVE</option>
                </select></td>
        </tr>
        <tr>
            <td colspan="3"><button style="width: 100%;" onclick="getData(1)">CARI</button></td>

        </tr>
    </table>

    <br>

    <table>
        <tr>
            <td>Distributor</td>
            <td>:</td>
            <td><input type="text" id="inputNama"></td>
        </tr>
        <tr>
            <td>Aktif</td>
            <td>:</td>
            <td><select id="selectAktif" style="width: 100%;">
                    <option value="true">ACTIVE</option>
                    <option value="false">NON ACTIVE</option>
                </select></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td><select id="selectStatus" style="width: 100%;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select></td>
        </tr>
        <tr>
            <td>Cons</td>
            <td>:</td>
            <td><input type="text" id="inputCons"></td>
        </tr>
        <tr>
            <td colspan="3"><button style="width: 100%;" onclick="simpan()">SUBMIT</button></td>

        </tr>
    </table>

    <br>

    <table border="1" id="tblGetData">
        <thead>
            <tr>
                <td>No</td>
                <td>Distributor</td>
                <td>Status</td>
                <td>Aktif</td>
                <td>Cons</td>
                <td>Action</td>

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