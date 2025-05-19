<?php
include("../asset/function.php");
include("../functions/koneksi.php");


$mode = $_POST['mode'];

if (!empty($mode)) {
    if ($mode == 'getData') {
        $filterNamaDistributor = $_POST['filterNamaDistributor'];

        $txtData = "";
        $query = "SELECT * FROM dpfdplnew.distributors d WHERE d.nama LIKE '%$filterNamaDistributor%'";
        $hsl = $dbCon->execute($query);
        $n = 1;
        while ($result = $dbCon->getArray($hsl)) {
            $txtData .= "<tr>
                            <td>" . $n . "</td>
                            <td>" . $result['nama'] . "</td>
                            <td>" . $result['status'] . "</td>
                            <td>" . $result['aktif'] . "</td>
                            <td>" . $result['cons'] . "</td>
            </tr>";
            $n++;
        }

        echo $txtData;
    }
}
