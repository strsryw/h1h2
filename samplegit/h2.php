<?php
include("../asset/function.php");
include("../functions/koneksi.php");


$mode = $_POST['mode'];

if (!empty($mode)) {
    if ($mode == 'getData') {
        $filterNamaDistributor = $_POST['filterNamaDistributor'];
        $filterStatus = $_POST['filterStatus'];

        $txtData = "";
        $query = "SELECT * FROM dpfdplnew.distributors d WHERE d.nama LIKE '%$filterNamaDistributor%' AND d.aktif = '$filterStatus'";
        $hsl = $dbCon->execute($query);
        $n = 1;
        while ($result = $dbCon->getArray($hsl)) {
            $txtData .= "<tr>
                            <td>" . $n . "</td>
                            <td id='txtNama" . $result['id'] . "'>" . $result['nama'] . "</td>
                            <td><button onclick='edit(" . $result['id'] . ")'>Edit</button><button onclick='hapus(" . $result['id'] . ")'>Hapus</button></td>
                          ";
            $n++;
        }

        echo $txtData;
    }
}
