<?php include("../functions/koneksi.php");
include("../functions/function.php");

$mode = $_POST['mode'];

if (!empty($mode)) {
    if ($mode == 'getDtOnload') {
        $txtData = '';
        $txtData .= "<option value=''>-- Pilih Jabatan --</option>";
        $dbCon->execute("BEGIN");
        $query = "SELECT * FROM absensi.`master_jabatan` j";
        $hsl = $dbCon->execute($query);
        while ($result = $dbCon->getArray($hsl)) {
            $id = $result['id'];
            $jabatan = $result['jabatan'];

            $txtData .= "<option value='$id'>" . $jabatan . "</option>";
        }

        echo $txtData;
    }
}
