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
    } else if ($mode == "simpan") {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $status = $_POST['status'];
        $aktif = $_POST['aktif'];
        $cons = $_POST['cons'];


        try {
            $dbCon->execute("BEGIN");

            if ($id == 0 || $id == '') {
                $rsCek = $dbCon->execute("SELECT * FROM dpfdplnew.distributors d WHERE d.nama='$nama' AND d.aktif='true'");
                $jumlahCek = $dbCon->getNumRows($rsCek);

                if ($jumlahCek == 0) {
                    $querisimpan = "INSERT INTO dpfdplnew.distributors(nama, status, aktif, cons) VALUES ('$nama','$status', '$aktif', '$cons')";
                    $rsPosSimpan = $dbCon->execute($querisimpan);
                    if (!$rsPosSimpan) {
                        echo "gagal";
                    } else {
                        echo "sukses";
                    }
                } else {
                    echo "gagal";
                }
            } else {
                $rsCek = $dbCon->execute("SELECT * FROM dpfdplnew.distributors d WHERE d.nama='$nama' AND d.aktif='true' AND id != '$id'");
                $jumlahCek = $dbCon->getNumRows($rsCek);
                if ($jumlahCek == 0) {
                    $rsUpdatenmMerk = $dbCon->execute("UPDATE dpfdplnew.distributors SET nama='$nama', status='$status', aktif = '$aktif', cons = '$cons' WHERE id='$id'");
                    if (!$rsUpdatenmMerk) {
                        echo "gagal";
                    } else {
                        echo "sukses";
                    }
                } else {
                    echo "gagal";
                }
            }
            $dbCon->execute("COMMIT");
        } catch (Exception $e) {
            var_dump($e->getTrace());
            $dbCon->execute("ROLLBACK");
        }
    }
}
