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
		if ($status == 'lebih') {
			$filterStatus = "HAVING COALESCE(rekapabsen,0)+COALESCE(nonfinger,0)>hk";
		} elseif ($status != 'all') {
			$filterStatus = "HAVING nonfinger IS NULL AND rekapabsen IS NULL";
		}

		if (!empty($namakry)) {
			$qryNama = " HAVING p.namakry LIKE '%$namakry%' ";
		} else {
			$qryNama = " ";
		}
		if (!empty($kodenik)) {
			$qryNIK = " HAVING gcNik LIKE '%$kodenik%' ";
		} else {
			$qryNIK = " ";
		}

		$qry = "SELECT kodenik,namakry,SUM(nf) nonfinger, SUM(f) rekapabsen,SUM(pe) penyimpangan, GROUP_CONCAT(QUOTE(kodenik)) gcNik, hk
		FROM (SELECT r.`kodenik`,r.namakry,r.tgllahir,n.dalamkota nf,a.dalamkota f,pe pe,h.hk hk FROM (SELECT * FROM master_karyawan WHERE  kodenik 
		IN (SELECT nik FROM karyawan_aktif WHERE (`blngaji`=($bulangaji - 1) OR `blngaji`=$bulangaji) AND `thngaji`=$tahungaji) GROUP BY kodenik) r
		INNER JOIN (SELECT * FROM harikerja WHERE thn=$tahungaji AND bln=$bulangaji) h ON 
		IF(r.kodenik LIKE '%PA%' OR r.kodenik LIKE '%PB%',h.kodenik=SUBSTR(r.kodenik,1,2),
		IF(r.kodenik NOT LIKE '%PA%' AND r.kodenik NOT LIKE '%PB%' AND r.kodedivisi LIKE '%adya artha%',h.kodenik='AA',h.kodenik='')
		)
		LEFT JOIN (SELECT nik, dalamkota FROM nonfinger WHERE `blngaji`=$bulangaji AND `thngaji`=$tahungaji) n ON r.`kodenik` = n.`nik`
		LEFT JOIN (SELECT nik, dalamkota FROM rekapabsen WHERE `blngaji`=$bulangaji AND `thngaji`=$tahungaji) a ON r.`kodenik` = a.`nik` 
		LEFT JOIN (SELECT nik, SUM(jumlah) pe FROM penyimpangan WHERE blngaji=$bulangaji AND thngaji=$tahungaji GROUP BY nik) k ON r.`kodenik` = k.`nik`
		) p
		GROUP BY namakry,tgllahir";
		var_dump($qry);
		exit();
		$hsl = $dbCon->execute($qry);
		$jum = $dbCon->getNumRows($hsl);

		while ($result = $dbCon->getArray($hsl)) {
			$txt = $txt . "reportabsensi|" . $result['kodenik'] . "|"
				. $result['namakry'] . "|" . $result['rekapabsen'] . "|" . $result['nonfinger'] . "|"
				. $result['penyimpangan'] . "|" . $result['gcNik'] . "||^";
		}
		echo $result;
		echo $txt . "!" . $jum;
	}

	if ($mode == "ambilDataPenyimpangan") {
		$limit = 100;
		if (empty($hm) || $hm == 1) {
			$start = 0;
		} else {
			$start = ($hm - 1) * $limit;
		}

		$qry = "SELECT * FROM penyimpangan p 
		WHERE p.thngaji = $tahungaji And p.blngaji = $bulangaji 
		AND p.nik IN ($gcNik)
		ORDER BY p.tanggal";

		// echo $qry;exit();

		$hsl = $dbCon->execute($qry);
		// $jum=$dbCon->getNumRows($hsl);

		while ($result = $dbCon->getArray($hsl)) {
			if (trim($result['kriteriacuti']) == "(null)") {
				$kriteriaTampil = "";
			} else {
				$kriteriaTampil = $result['kriteriacuti'];
			}
			$i++;
			$txt = $txt . "<tr>
			<td>" . $i . ".</td>
			<td>" . $result['tanggal'] . "</td>
			<td>" . $result['jenis'] . "</td>
			<td>" . $kriteriaTampil . "</td>
			<td>" . $result['keterangan'] . "</td>
		</tr>";
		}
		echo $txt;
	}

	if ($mode == "ambilDataTotal") {
		$limit = 100;
		if (empty($hm) || $hm == 1) {
			$start = 0;
		} else {
			$start = ($hm - 1) * $limit;
		}

		$qry = "SELECT * FROM totalabsen t 
		WHERE t.tahunGaji = $tahungaji And t.bulanGaji = $bulangaji 
		AND t.nik IN ($gcNik)
		GROUP BY t.tanggal
		ORDER BY t.tanggal";

		// echo $qry;exit();

		$hsl = $dbCon->execute($qry);
		// $jum=$dbCon->getNumRows($hsl);

		while ($result = $dbCon->getArray($hsl)) {
			$i++;
			$txt = $txt . "<tr>
			<td>" . $i . ".</td>
			<td>" . $result['tanggal'] . "</td>
			<td>" . $result['scanmasuk'] . "</td>
			<td>" . $result['scankeluar'] . "</td>
			<td>" . $result['source'] . "</td>
		</tr>";
		}
		echo $txt;
	}
} else {
}
