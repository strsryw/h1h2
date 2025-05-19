<?php
include("../functions/koneksi.php");
// include("../functions/session.php");
include("../functions/function.php");
$mode		= $_POST['mode'];
$hm			= $_POST['hal'];
$id			= $_POST['id'];
$gcNik		= $_POST['gcNik'];
$namakry	= $_POST['namakry'];
$kodenik	= $_POST['kodenik'];
$bulangaji	= $_POST['bulangaji'];
$tahungaji	= $_POST['tahungaji'];
$status		= $_POST['status'];
if (!empty($mode)) {
	if ($mode == "retrieveData") {
		$dbCon->execute("BEGIN");
		$limit = 100;
		if (empty($hm) || $hm == 1) {
			$start = 0;
		} else {
			$start = ($hm - 1) * $limit;
		}

		$filterStatus = '';
		if ($status == 'null') {
			$filterStatus = "HAVING dalam_kota IS NULL";
		}

		if (!empty($namakry)) {
			$qryNama = " AND namakry LIKE '%$namakry%' ";
		} else {
			$qryNama = " ";
		}
		if (!empty($kodenik)) {
			$qryNIK = " AND nik LIKE '%$kodenik%' ";
		} else {
			$qryNIK = " ";
		}

		$qry = "SELECT nik, namakry, SUM(dalam_kota) dalam_kota, SUM(alpha) alpha,SUM(cuti) cuti, SUM(ijin) ijin, 
		SUM(sakit_dgn_surat1+sakit_dgn_surat2+sakit_tnp_surat1+sakit_tnp_surat2) jmlSakit, SUM(alpha)>10 a, SUM(alpha)>SUM(dalam_kota) b FROM karyawan_aktif r
		LEFT JOIN (SELECT * FROM absensi.transaksi WHERE bln_gaji = '$bulangaji' AND thn_gaji = '$tahungaji') t ON t.nikkaryawan = r.nik
		WHERE blngaji = '$bulangaji' AND thngaji = '$tahungaji'
		$qryNama
		$qryNIK
		GROUP BY namakry,tgllahir
		$filterStatus; 
		";
		echo $qry;
		exit();

		$hsl = $dbCon->execute($qry);
		$jum = $dbCon->getNumRows($hsl);

		while ($result = $dbCon->getArray($hsl)) {
			$txt = $txt . "reportabsensi|" . $result['nik'] . "|" . $result['namakry'] . "|" . $result['dalam_kota'] . "|" .
				$result['alpha'] . "|" . $result['cuti'] . "|" . $result['ijin'] . "|" . $result['jmlSakit'] . "|" . $result['a'] . "|" . $result['b'] . "||^";
		}
		// echo $result;
		echo $txt . "!" . $jum;
	}
} else {
}
