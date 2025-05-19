
<?php include("../functions/koneksi.php");
include("../functions/function.php");


if (!empty($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
} else {
}

$txt = '';
$txt_1 = '';
$txt_2 = '';

if (!empty($mode)) {
    if ($mode == 'retrieveData') {
        $query = "SELECT idNegara id, namaNegara nama, kodeNegara kode, STATUS FROM internationalbusiness.`countries` WHERE STATUS = 'aktif'";

        $hasil = $dbCon->execute($query);
        while ($result = $dbCon->getArray($hasil)) {
            $txt = $txt . "groupUser|" . $result['id'] . "|" . $result['nama'] . "|" . $result['kode'] . "|^";
        }
        // === tabel kedua ===

        $query = "SELECT p.`idProvinsi` idProvinsi, c.`idNegara` idNegara, p.`idProvinsi` idProvinsi, p.`namaProvinsi` nama  FROM internationalbusiness.`provinces` p INNER JOIN internationalbusiness.`countries` c ON p.`idNegara` = c.`idNegara` WHERE p.`status` = 'aktif'";
        $hasil = $dbCon->execute($query);
        while ($result = $dbCon->getArray($hasil)) {
            $txt_1 = $txt_1 . "menu|" . $result['idProvinsi'] . "|" . $result['idNegara'] . "|" . $result['idProvinsi'] . "|" . $result['nama'] . "|^";
        }
        // === tabel ketiga ---

        $query = "SELECT c.`idKota` idKota, p.`idProvinsi` idProvinsi, c.`idKota` idKota, c.`namaKota` nama FROM internationalbusiness.`cities` c INNER JOIN internationalbusiness.`provinces` p ON c.`idProvinsi` = p.`idProvinsi`";
        $hasil = $dbCon->execute($query);
        while ($result = $dbCon->getArray($hasil)) {
            $txt_2 = $txt_2 . "jenis|" . $result['idKota'] . "|" . $result['idProvinsi'] . "|" . $result['idKota'] . "|" . $result['nama'] . "|^";
        }

        echo $txt . "!" . $txt_1 . "!" . $txt_2;
    }

    if ($mode == 'saveData') {

        $data = $_POST['buffer'];
        try {
            $dbCon->execute("BEGIN");
            //loop save

            while (!strrpos($data, "^") === false) {

                $iValue = substr($data, 0, strpos($data, "^"));
                if (substr(strrev($iValue), 0, 3) <> "|||") {
                    $iValue = $iValue . "|";
                } else {
                    $iValue = $iValue;
                }
                $data = substr($data, strpos($data, "^") + 1, strlen($data));
                $tablename = trim(getColumnValue($iValue, 1));

                if (trim($tablename) == "groupUser") {
                    $i = 0;
                    while (!strrpos($iValue, "|") === false) {
                        $lenIValue = (int) strlen($iValue);
                        //if ($lenIValue>0){
                        $cValue = substr($iValue, 0, strpos($iValue, "|"));
                        //}
                        //elseif ($lenIValue<=0) {$cValue=" ";}
                        $iValue = substr($iValue, strpos($iValue, "|") + 1, strlen($iValue));

                        if ($i == 1) {
                            $idNegara = $cValue;
                        }
                        if ($i == 2) {
                            $namaNegara = $cValue;
                        }
                        if ($i == 3) {
                            $kode = $cValue;
                        }
                        $i++;
                    }
                    // simpan addnew
                    if (substr($idNegara, 0, 1) == "N") {
                        $query = "INSERT INTO internationalbusiness.`countries` (namaNegara, kodeNegara, STATUS) VALUES ('$namaNegara','$kode','aktif')";
                        $execute = $dbCon->execute($query);
                    }
                    // simpan update
                    else if (substr($idNegara, 0, 1) == "-") {
                    } else {
                    } // end simpan update

                }
            } //end loop save
            echo "Data berhasil disimpan";
            $dbCon->execute("COMMIT");
        } catch (Exception $e) {
            echo var_dump($e->getTrace());
            $dbCon->execute("ROLLBACK");
        }
    }
}
