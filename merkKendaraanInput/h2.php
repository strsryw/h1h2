<?php
session_start();
// include "../database.php";
// include "../fungsi.php";
include "../functions/koneksi.php";
include "../functions/function.php";
//cek session

// $session_namauser = $_SESSION["newasset_session_nama"];
// $session_userid = $_SESSION["newasset_session_id"];
// $session_groupId = $_SESSION["newasset_session_groupId"];
// $session_area = $_SESSION["newasset_session_area"];
// $session_perusahaan = $_SESSION['newasset_session_perusahaan'];
// $session_perusahaan = str_replace(",", "','", $session_perusahaan);
// if ($session_namauser == "") {
// 	header("location:../index.php");
// }
$mode = $_POST['mode'];

if (!empty($mode)) {
	if ($mode == "getData") {
		$hm	= $_POST['hal'];
		$NmMerkCari = $_POST["NmMerkCari"];
		$limit = 10;
		$txtHead = "";
		$txtData = "";
		if (empty($hm) || $hm == 1) {
			$start = 0;
		} else {
			$start = ($hm - 1) * $limit;
		}

		$reportMerk = "SELECT id,nama,kode FROM newasset.`merk` WHERE nama LIKE '%$NmMerkCari%' ORDER BY nama";
		$queryMerk = $dbCon->execute($reportMerk);

		$jumRecord = $queryMerk->num_rows;
		$sum = ceil($jumRecord / $limit);

		/* -----------------------------Navigasi Record ala google style ----------------------------- */
		$linkHal = pageNavs($hm, $sum, $limit);
		/* -----------------------------End Navigasi Record ala google style ----------------------------- */
		$rsTampil = $dbCon->execute($reportMerk . " limit $start, $limit");

		if ($jumRecord == 0 || $jumRecord == Null) {
			$txtHead = "<tr class='small'>
			<th align=\"center\">No</th>
			<th align=\"center\">Nama Merk</th>
			<th width='10%' align=\"center\">Kode</th>
			<th width='20%' align=\"center\">Action</th>
			</tr>";
			$txtData .= "
			<tr>
				<td colspan=4 align=\"center\">Tidak Ada Data</td>
			</tr>";
		} else {
			$n = $start + 1;
			foreach ($rsTampil as $dataMerk) {
				$txtHead = "<tr class='small'>
					<th width='10%' align=\"center\">No</th>
					<th width='60%' align=\"center\">Nama Merk</th>
					<th width='10%' align=\"center\">Kode</th>
					<th width='20%' align=\"center\">Action</th>
					</tr>";
				$txtData .= "
					<tr>
						<td id='txtIdMerk" . $dataMerk['id'] . "'align=\"center\"  style='display:none';>" . $dataMerk['id'] . "</td>
						<td align=\"center\">$n</td>
						<td id='txtNmMerk" . $dataMerk['id'] . "' align=\"left\">" . $dataMerk['nama'] . "</td>
						<td id='txtKodeMerk" . $dataMerk['id'] . "' align=\"center\">" . $dataMerk['kode'] . "</td>
						<td align=\"center\"><a href='javascript:void(0)' onClick='editLink(\"" . $dataMerk['id'] . "\")'>Edit</a> | <a href='javascript:void(0)' onClick='delLink(\"" . $dataMerk['id'] . "\")'>Delete</a></td>
					</tr>";
				$n++;
			}
		}
		echo $txtHead . "!" . $txtData . "!" . $linkHal;
	}
	if ($mode == "saveData") {
		try {
			$dbCon->execute("BEGIN");
			$idMerk = $_POST['idMerk'];
			$nmMerk = $_POST['nmMerk'];
			$kdMerk = $_POST['txtKdMerk'];

			if ($idMerk == 0 || $idMerk == '') {
				$rsCek = $dbCon->execute("select id from newasset.`merk` where nama='$nmMerk' and kode='" . $kdMerk . "'");
				$jumlahCek = $dbCon->getNumRows($rsCek);

				if ($jumlahCek <= 0) {
					$querisimpan = "INSERT INTO newasset.`merk`(nama,kode) VALUES ('$nmMerk','" . $kdMerk . "')";
					$rsPosSimpan = $dbCon->execute($querisimpan);
					if (!$rsPosSimpan) {
						echo "Data Gagal Di Input!!!";
					} else {
						echo "Input Data Berhasil!!!";
					}
				} else {
					echo "Data Gagal Di Input!!!  Merk $nmMerk sudah ada!!!";
				}
			} else {
				$rsCek = $dbCon->execute("select id from newasset.merk where nama='$nmMerk' and kode='" . $kdMerk . "'");
				$jumlahCek = $dbCon->getNumRows($rsCek);
				if ($jumlahCek <= 0) {
					$rsUpdatenmMerk = $dbCon->execute("UPDATE newasset.merk set nama='$nmMerk', kode='" . $kdMerk . "' WHERE id='$idMerk'");
					if (!$rsUpdatenmMerk) {
						echo "Data Gagal Di Update!!!";
					} else {
						echo "Update Data Berhasil!!!";
					}
				} else {
					echo "Data Gagal Di Update!!!  Merk $nmMerk masih ada !!!";
				}
			}
			$dbCon->execute("COMMIT");
		} catch (Exception $e) {
			var_dump($e->getTrace());
			$dbCon->execute("ROLLBACK");
		}
	}
	if ($mode == 'delData') {
		try {
			$dbCon->execute("BEGIN");
			$idMerk = $_POST['idMerk'];
			$hasil = $dbCon->execute("DELETE FROM newasset.merk WHERE id =$idMerk");
			if ($hasil) {
				echo "Success";
			} else {
				echo "Error";
			}
			$dbCon->execute("COMMIT");
		} catch (Exception $e) {
			var_dump($e->getTrace());
			$dbCon->execute("ROLLBACK");
		}
	}
}
