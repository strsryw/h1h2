<?php
include("../asset/function.php");
include("../functions/koneksi.php");


$mode = $_POST['mode'];

if (!empty($mode)) {
    if ($mode == 'getData') {
        $filterNamaDistributor = $_POST['filterNamaDistributor'];
        $filterAktif = $_POST['filterAktif'];

        $txtData = "";
        $query = "SELECT * FROM dpfdplnew.distributors d WHERE d.nama LIKE '%$filterNamaDistributor%' AND d.aktif = '$filterAktif'";
        $hsl = $dbCon->execute($query);
        $n = 1;
        while ($result = $dbCon->getArray($hsl)) {
            $txtData .= "<tr>
                            <td>" . $n . "</td>
                            <td id='txtNama" . $result['id'] . "'>" . $result['nama'] . "</td>
                            <td id='txtStatus" . $result['id'] . "'>" . $result['status'] . "</td>
                            <td id='txtAktif" . $result['id'] . "'>" . $result['aktif'] . "</td>
                            <td id='txtCons" . $result['id'] . "'>" . $result['cons'] . "</td>
                            <td><button onclick='edit(" . $result['id'] . ")'>Edit</button><button onclick='hapus(" . $result['id'] . ")'>Hapus</button></td>";
            $n++;
        }

        echo $txtData;
    }
}
