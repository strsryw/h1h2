<?php
function inp_mgu($year, $month, $week, $dbCon)
{

?>
	<style type="text/css">
		div {
			font-size: 11px;
		}

		#loading {
			position: absolute;
			top: 0;
			left: 0;
			color: white;
			background-color: red;
			padding: 5px 10px;
			font: 12px Arial;
		}
	</style>
	<div id="loading" style="display:none">Loading...</div>
<?php
	$tanggal = dateToDouble(date("d-m-Y"));

	$rsMinggu = $dbCon->execute("select * from lkh_periode where tglAwal<='$tanggal' and tglAkhir>='$tanggal'");
	$dataMinggu = $dbCon->getArray($rsMinggu);
	echo "Mgu <select name=\"" . $week . "\" id=\"" . $week . "\" class='roundIt'>\n";
	for ($m = 1; $m < 6; $m++) {
		if ($dataMinggu[minggu] == $m) {
			echo "<option value=$m selected='selected' style='background:#afa'>$m</option>";
		} else {
			echo "<option value=$m>$m</option>";
		}
	}
	echo "</select>\n";
	echo " Bln <select name=\"" . $month . "\" id=\"" . $month . "\" class='roundIt'>";
	for ($t = 1; $t <= 12; $t++) {
		if ($t == intval($dataMinggu[bln])) {
			echo "<option value=$t selected='selected' style='background:#afa'>" . monthName($t) . "</option>\n";
		} else {
			echo "<option value=$t>" . monthName($t) . "</option>\n";
		}
	}
	echo " </select> ";
	echo "Thn <select name=\"" . $year . "\" id=\"" . $year . "\" class='roundIt'>\n";
	for ($t = date("Y") - 5; $t <= date("Y") + 10; $t++) {
		if ($t == $dataMinggu[thn]) {
			echo "<option value=$t selected='selected' style='background:#afa'>$t</option>\n";
		} else {
			echo "<option value=$t>$t</option>\n";
		}
	}
	echo "</select>\n<br>";
	echo "<label id=tgl style='font-size:11px; font-weight:bold'></label>";
	echo "<script>
$(function() {
	$('#loading').ajaxStart(function(){
		$('[name=\"cetak\"]').attr(\"disabled\", true);
		$('[name=\"cetakXls\"]').attr(\"disabled\", true);
		$(this).fadeIn();
	}).ajaxStop(function(){
		$('[name=\"cetak\"]').removeAttr(\"disabled\");
		$('[name=\"cetakXls\"]').removeAttr(\"disabled\");
		$(this).fadeOut();
	});

		$('#" . $year . "').change(function(){getTanggal();});
		$('#" . $month . "').change(function(){getTanggal();});
		$('#" . $week . "').change(function(){getTanggal();});
		$('#" . $week . "').ready(function(){getTanggal();});
		
});
function getTanggal() {
		var thn= document.getElementById('" . $year . "').value;
		var bln= document.getElementById('" . $month . "').value;
		var mgu=document.getElementById('" . $week . "').value;
		var url = '../functions/getTgl.php';
		$('#tgl').load(url,{th:thn,bl:bln,mg:mgu});
		return false;
	}
</script>";
}
?>
<?php
function inp_mingguDPPU()
{
	echo " <select name='mingguDPPU' id='mingguDPPU' class=roundIt>
    <option value='I'>I</option>
    <option value='I S1'>I S1</option>
    <option value='I S2'>I S2</option>
    <option value='I S3'>I S3</option>
    <option value='II'>II</option>
    <option value='II S1'>II S1</option>
    <option value='II S2'>II S2</option>
    <option value='II S3'>II S3</option>
    <option value='III'>III</option>
    <option value='III S1'>III S1</option>
    <option value='III S2'>III S2</option>
    <option value='III S3'>III S3</option>
    <option value='IV'>IV</option>
    <option value='IV S1'>IV S1</option>
    <option value='IV S2'>IV S2</option>
    <option value='IV S3'>IV S3</option>
    <option value='V'>V</option>
    <option value='V S1'>V S1</option>
    <option value='V S2'>V S2</option>
	<option value='PD' style='display:none'>PD</option>
    </select>";
}
// kantorCabang
function inp_kantorCabang($dbCon)
{
	$queKacab = $dbCon->execute("select * from kantorCabang order by nama");
	echo "<select name='kantorCabang' style='width:200px' class=roundIt>";
	while ($hasilKantorCabang = $dbCon->getArray($queKacab)) {
		echo "<option value=$hasilKantorCabang[id]>" . strtoupper($hasilKantorCabang[nama]) . "</option>";
	}
	echo "</select>";
}
function inp_sis($proOpr, $dbCon)
{
	$queSis = $dbCon->execute("select * from lkh_sis where promosiOperasional='$proOpr' order by sisDPPU");
	echo "<select name='sis' id='sis' style='width:200px' class='roundIt'>";
	while ($hasilSis = $dbCon->getArray($queSis)) {
		echo "<option value=$hasilSis[sisDPPU]>" . strtoupper($hasilSis[sisDPPU]) . "</option>";
	}
	echo "</select>";
}
function getColumnValue($row, $kolomIndex)
{
	$srow = $row . "|";
	$nilai = "";
	for ($i = 0; $i < $kolomIndex; $i++) {
		$nilai = substr($srow, 0, strpos($srow, "|"));
		$srow = substr($srow, strpos($srow, "|") + 1, strlen($srow));
	};
	return $nilai;
}
function getMingguPenerimaan($minggu)
{
	switch ($minggu) {
		case 1:
			$mingguTerima = 'I';
			break;
		case 2:
			$mingguTerima = 'II';
			break;
		case 3:
			$mingguTerima = 'III';
			break;
		case 4:
			$mingguTerima = 'IV';
			break;
		case 5:
			$mingguTerima = 'V';
			break;
	}
	return $mingguTerima;
}
// ambil nama bulan berdasarkan angka bulan
function monthName($nomorbulan)
{

	$nama_bulan = array(0 => "", 1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	$hasilbulan = $nama_bulan[$nomorbulan];
	return $hasilbulan;
}
function monthRome($nomorbulan)
{
	$rome_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
	$hasilbulan = $rome_bulan[$nomorbulan];
	return $hasilbulan;
}
function monthAlpha($nomorbulan)
{
	$rome_bulan = array(1 => "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L");
	$hasilbulan = $rome_bulan[$nomorbulan];
	return $hasilbulan;
}
// ambil tanggal akhir tiap bulan berdasarkan angka bulan
function lastDate($i, $j)
{
	if ($i == 1 || $i == 3 || $i == 5  || $i == 7 || $i == 8 || $i == 10 || $i == 12) {
		$k = 31;
	} elseif ($i == 4 || $i == 6  || $i == 9 || $i == 11) {
		$k = 30;
	} elseif ($i == 2) {
		if ($j % 4 == 0) {
			$k = 29;
		} else {
			$k = 28;
		}
	}
	return $k;
}

// for generate html
function copyFolder($source, $target)
{
	if (is_dir($source)) {
		@mkdir($target);
		$d = dir($source);
		while (FALSE !== ($entry = $d->read())) {
			if ($entry == '.' || $entry == '..') {
				continue;
			}
			$Entry = $source . '/' . $entry;
			if (is_dir($Entry)) {
				full_copy($Entry, $target . '/' . $entry);
				continue;
			}
			copy($Entry, $target . '/' . $entry);
		}

		$d->close();
	} else {
		copy($source, $target);
	}
}

function deleteFolder($namaFolder)
{
	if (is_dir($namaFolder)) {
		$handleFolder = opendir($namaFolder);
	}
	if (!$handleFolder) {
		return false;
	}
	while ($file = readdir($handleFolder)) {
		if ($file != "." && $file != "..") {
			if (!is_dir($namaFolder . "/" . $file))
				unlink($namaFolder . "/" . $file);
			else
				deleteFolder($namaFolder . '/' . $file);
		}
	}
	closedir($handleFolder);
	rmdir($namaFolder);
	return true;
}


function inp_tahun($year)
{
	echo "<select name=\"" . $year . "\" id=\"" . $year . "\" class='roundIt'>\n";
	for ($t = date("Y") - 5; $t <= date("Y") + 10; $t++) {
		if ($t == date("Y")) {
			echo "<option value=$t selected='selected'>$t</option>\n";
		} else {
			echo "<option value=$t>$t</option>\n";
		}
	}
	echo "		</select>\n";
}
function inp_bulan($month)
{
	echo "<select name=\"" . $month . "\" id=\"" . $month . "\" class='roundIt'>";
	for ($t = 1; $t <= 12; $t++) {
		if ($t == date("n")) {
			echo "<option value=$t selected='selected'>" . monthName($t) . "</option>\n";
		} else {
			echo "<option value=$t>" . monthName($t) . "</option>\n";
		}
	}
	echo "</select> ";
}
// input periode
function inp_per($month, $year)
{
	echo "Bln <select name=\"" . $month . "\" id=\"" . $month . "\" class='roundIt'>";
	for ($t = 1; $t <= 12; $t++) {
		if ($t == date("n")) {
			echo "<option value=$t selected='selected'>" . monthName($t) . "</option>\n";
		} else {
			echo "<option value=$t>" . monthName($t) . "</option>\n";
		}
	}
	echo "</select> ";

	echo "Thn <select name=\"" . $year . "\" id=\"" . $year . "\" class='roundIt'>\n";
	for ($t = date("Y") - 5; $t <= date("Y") + 10; $t++) {
		if ($t == date("Y")) {
			echo "<option value=$t selected='selected'>$t</option>\n";
		} else {
			echo "<option value=$t>$t</option>\n";
		}
	}
	echo "		</select>\n";
}

// input popup periode
function pop_per($nama_popup)
{
	echo "<input type=\"text\" name=\"" . $nama_popup . "\" id=\"" . $nama_popup . "\" readonly=\"readonly\"
        class=\"textRO2\" onclick=\"NewCal('" . $nama_popup . "','ddmmyyyy',false,24)\">";
}

// input jenis lap
function frm_lap($angka)
{
	echo "<select name=\"format\" style=\"width:94px;\">";
	if ($angka == 'tiga') {
		echo "<option value=\"simple\">Simple</option>";
	}
	echo "<option value=\"detail\">Detail</option>
			<option value=\"excel\">Excel</option>
		</select>";
}




// nama uni lap
function uni($name)
{
	if ($name != "") {
		echo str_replace("/", "/<br />", $name);
	} else {
		echo "---";
	}
}

function disout($name)
{
	if ($name != "") {
		echo str_replace("/", "<br />", $name);
	} else {
		echo "---";
	}
}

function num($name)
{
	echo number_format($name, 0, ',', '.');
}


// value lap
function val($val)
{
	if ($val != "") {
		echo $val;
	} else {
		echo "---";
	}
}

// vs lap
function vsx($vsxa, $vsxb)
{
	if ($vsxa == $vsxb) {
		$vs = "Y";
	} else {
		$vs = "N";
	}
	return $vs;
}

// format tanggal indonesia
function dateindo($date)
{
	$newdate = substr($date, 8, 2) . "-" . substr($date, 5, 2) . "-" . substr($date, 0, 4);
	return $newdate;
}
function dateluar($date)
{
	$newdate = substr($date, 6, 4) . "-" . substr($date, 3, 2) . "-" . substr($date, 0, 2);
	return $newdate;
}
//date dalam DD-MM-YYYY
function dateToDouble($date)
{
	$tanggal = substr($date, 0, 2);
	$bulan = substr($date, 3, 2);
	$tahun = substr($date, 6, 4);

	date_default_timezone_set("Asia/Jakarta");
	$dateDouble = mktime(1, 00, 00, intval($bulan), intval($tanggal), intval($tahun));
	return number_format($dateDouble * 1000, 0, "", "");
}
function dateToDoubleFull($date)
{
	$tanggal = substr($date, 0, 2);
	$bulan = substr($date, 3, 2);
	$tahun = substr($date, 6, 4);
	date_default_timezone_set("Asia/Jakarta");
	$h = date("H");
	$m = date("i");
	$s = date("s");
	$dateDouble = mktime($h, $m, $s, intval($bulan), intval($tanggal), intval($tahun));
	return number_format($dateDouble * 1000, 0, "", "");
}
function dateToDoubleAwal($date)
{
	$tanggal = substr($date, 0, 2);
	$bulan = substr($date, 3, 2);
	$tahun = substr($date, 6, 4);
	date_default_timezone_set("Asia/Jakarta");
	$dateDouble = mktime(0, 00, 00, $bulan, $tanggal, $tahun);
	return number_format($dateDouble * 1000, 0, "", "");
}
function dateToDoubleAkhir($date)
{
	$tanggal = substr($date, 0, 2);
	$bulan = substr($date, 3, 2);
	$tahun = substr($date, 6, 4);
	date_default_timezone_set("Asia/Jakarta");
	$dateDouble = mktime(23, 59, 59, $bulan, $tanggal, $tahun);
	return number_format($dateDouble * 1000, 0, "", "");
}
function doubleToDate($dateDouble)
{
	//hasil dalam DD-MM-YYYY
	date_default_timezone_set("Asia/Jakarta");
	return $date = date("d-m-Y", $dateDouble / 1000);
}
function maxId($tabel, $field, $dbCon)
{
	$res = $dbCon->getRow($dbCon->execute("select max($field) from $tabel"));
	if (strlen($res[0]) == 0) {
		$maxId = 1;
	} else {
		$maxId = ($res[0]) + 1;
	}
	return $maxId;
}
function maxIdGenerator($tabel, $field, $pref, $dbCon)
{
	try {
		//update dulu id di tabel idGenerator(increment 1)
		if ($tabel == 'lkh_kas_temp') {
			$pref = $pref . 'X';
		}
		$kueri = $dbCon->execute("SELECT CONCAT('$pref',MAX(CAST(SUBSTRING(id,LENGTH('$pref')+1,LENGTH(id)) AS UNSIGNED))+1) maxId FROM $tabel WHERE SUBSTRING(id,1,length('$pref'))='$pref'");
		$res = $dbCon->getArray($kueri);
		$jml = $dbCon->getNumRows($kueri);
		if ($jml == 0) {
			//$dbCon->execute("insert into lkh_idGenerator values('".$tabel.$pref."','1')");
			$maxId = $pref . "1";
		} else {
			if (is_null($res['maxId']) == true) {
				$maxId = $pref . "1";
			} else {
				$maxId = $res['maxId'];
			}
		}
		return $maxId;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
}
function maxIdGeneratorBackup($tabel, $field, $pref, $dbCon)
{
	try {
		//update dulu id di tabel idGenerator(increment 1)
		$dbCon->execute("update lkh_idGenerator set lastId=lastId+1 where beanName='" . $tabel . $pref . "'");
		$kueri = $dbCon->execute("select lastId as maxId from lkh_idGenerator where beanName='" . $tabel . $pref . "'");
		$res = $dbCon->getRow($kueri);
		$jml = $dbCon->getNumRows($kueri);
		if ($jml == 0) {
			$dbCon->execute("insert into lkh_idGenerator values('" . $tabel . $pref . "','1')");
			$maxId = $pref . "1";
		} else {
			$maxId = $pref . $res[0];
		}
		return $maxId;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
}

function maxNoTransGenerator($tabel, $field, $pref, $kodeArco, $thn, $bln, $dbCon)
{

	try {
		//update dulu notrans(increment 1)
		//$dbCon->execute("update lkh_notaGenerator set lastId=lastId+1 where tableName='$tabel' and prefix='".$pref."' 
		//					and kodeArco='$kodeArco' and tahun='$thn' and bulan='$bln'");
		$prefId = $pref . $kodeArco . substr($thn, 2, 2) . $bln;
		//$kueri=$dbCon->execute("select lastId as maxId from lkh_notaGenerator where tableName='$tabel' and 
		//					prefix='".$pref."' and kodeArco='$kodeArco' 
		//					and tahun='$thn' and bulan='$bln'");
		$kueri = $dbCon->execute("select max($field) from $tabel where substring($field,1," . strlen($prefId) . ")='$prefId'");
		$res = $dbCon->getRow($kueri);
		$jml = $dbCon->getNumRows($kueri);
		if ($jml == 0) {
			//$dbCon->execute("insert into lkh_notaGenerator values('$tabel','".$pref."','$kodeArco','$thn','$bln','1')");
			$maxId = $prefId . "0001";
		} else {
			$maxId = $res[0];
			$maxId = substr($maxId, strlen($prefId) + 1, strlen($maxId));
			$maxId = $maxId + 10001;
			$maxId = substr($maxId, 1, 5);
			$maxId = $prefId . $maxId;
		}
		return $maxId;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
}
function maxNoBuktiGenerator($tabel, $kodeArco, $promosiOperasional, $thn, $bln, $tr, $dbCon)
{
	/* $kueri=$dbCon->execute("select lastId as maxId from lkh_notaGenerator where tableName='$tabel' and 
							prefix='".$pref."' and kodeArco='$kodeArco' 
							and tahun='$thn' and bulan='$bln'");*/
	try {
		if ($promosiOperasional == "PRO") {
			$proOprBukti = "P";
		} elseif ($promosiOperasional == "OPR") {
			$proOprBukti = "O";
		}
		$nomorBukti = $kodeArco . "" . substr($thn, 2, 2) . "" . monthCode($bln) . "" . $proOprBukti;
		$quePeriode = $dbCon->execute("SELECT MIN(tglAwal) a,MAX(tglAkhir) b FROM lkh_periode WHERE thn='$thn' AND bln=$bln");
		$rsPeriode = $dbCon->getArray($quePeriode);

		$rsJmlBukti = $dbCon->execute("SELECT SUM(IF(tr='M' or tr='RK',1,0)) AS M,SUM(IF(tr='K' or tr='RM',1,0)) AS K FROM ( 
									(SELECT tanggal, namaTransaksi, departemenId, departemen, SUM(masuk) masuk, SUM(keluar) keluar, 
									tr, jenisDana,keterangan FROM lkh_kas WHERE kodeArco='$kodeArco'
									AND  tanggal>='$rsPeriode[a]' and tanggal < '$rsPeriode[b]' AND 
									(jenisDana!='DER') AND promosiOperasional='$promosiOperasional' AND cashTransfer<>'T' AND 
									keterangan NOT LIKE '%Penggantian DTP%' GROUP BY tanggal,tr,jenisDana,IF(tr='K' or tr='RM',departemenId,'') 
									ORDER BY id) 
									UNION 
									(SELECT tanggalRealisasi, namaTransaksi, departemenId, departemen, 0 masuk, 
									SUM(keluar-masuk) keluar, tr, jenisDana,keterangan FROM lkh_kas WHERE kodeArco='$kodeArco'
									AND (jenisDana='DER' AND statusRealisasi!='0') 
									and tanggalRealisasi>='$rsPeriode[a]' AND tanggalRealisasi < '$rsPeriode[b]' AND 
									IF(tr='RK',tanggal=tanggalRealisasi,tanggal=tanggal) AND promosiOperasional='$promosiOperasional' AND 
									cashTransfer<>'T' AND keterangan NOT LIKE '%Penggantian DTP%' 
									GROUP BY tanggalRealisasi,jenisDana,departemenId HAVING keluar<>'0' ORDER BY id) ) a 
									order by tanggal,field(tr,'SA','M','RK','K','RM'),IF(tr='M',FIELD(jenisDana,'','Mutasi Arco'),jenisDana ) , departemenId");
		$dataJmlBukti = $dbCon->getArray($rsJmlBukti);
		if ($tr == "M") {
			$maxId = $dataJmlBukti['M'] + 1;
		} else {
			$maxId = $dataJmlBukti['K'] + 1;
		}
		$no = substr(10000 + $maxId, 1, 4);
		$noBukti = $tr . $nomorBukti . "" . $no;
		return $noBukti;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
}
function getKode($prefix, $kdArco, $dbCon)
{
	$tahun = date('y');
	$bulan = monthAlpha(intval(date('m')));
	$kodeMasuk = $prefix . $kdArco . $tahun . $bulan . "NDPPU";

	$panjang = strlen($kodeMasuk);

	$hasil = $dbCon->execute("select max(dppuId_reffId) as maxId from lkh_kas where 
					substring(dppuId_reffId,1,$panjang)='$kodeMasuk'");
	if ($data = $dbCon->getArray($hasil)) {
		$kode = substr($data['maxId'], $panjang, strlen($data['maxId']));
		$kode = $kode + 10001;
		$kode = $kodeMasuk . substr($kode, 1, strlen($kode));
	}
	return $kode;
}
function monthNameShort($nomorbulan)
{
	$nama_bulan_short = array(1 => "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
	$hasilbulan = $nama_bulan_short[$nomorbulan];
	return $hasilbulan;
}
function num_bulat($name)
{
	echo number_format($name, 2, ',', '.');
}
function nf($s)
{
	$hnf = number_format(floatval($s), 0, ".", ",");
	if ($s == 0 || $s == "") return "-";
	else return $hnf;
}
function outDPPU($name)
{
	if ($name != "") {
		$outD = substr($name, 0, strpos($name, "/"));
	} else {
		echo "---";
	}
	return $outD;
}

function getSisaSaldoAwal($trUserId, $trUserGroupId, $kodeArco, $arcoId, $kantorCabangId, $proOpr, $dbCon)
{

	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo
		from lkh_kas where kantorCabangId in ($kantorCabangId) 
		and kodeArco='$kodeArco' and arcoId in ($arcoId) and tr='SA' 
		and sis<>'DTP' and saldo>0 and promosiOperasional='$proOpr'");
	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	$sisaSaldo = $hasilSisaSaldoKas['sisaSaldo'];

	return $sisaSaldo;
}

function getSisaSaldo($trUserId, $trUserGroupId, $kodeArco, $kantorCabangId, $proOpr, $dbCon)
{
	if ($trUserGroupId == 2) {
		$queSisaSaldoKas = $dbCon->execute("SELECT SUM(masuk-keluar) AS sisaSaldo FROM 
		((SELECT * FROM lkh_kas_temp
		WHERE kantorCabangId IN ($kantorCabangId) 
		AND kodeArco='$kodeArco' AND IF(jenisDana='BALIKAN KHUSUS' AND tr NOT IN ('SA','M'),trUserId IN ($trUserId),trUserId=truserid)
		AND (tr<>'SA' OR tr<>'KSA') AND promosiOperasional='$proOpr' AND arcoId IN ($trUserId)) UNION
		(SELECT * FROM lkh_kas
		WHERE kantorCabangId IN ($kantorCabangId) 
		AND kodeArco='$kodeArco' AND IF(jenisDana='BALIKAN KHUSUS' AND tr NOT IN ('SA','M'),trUserId IN ($trUserId),trUserId=truserid)
		AND (tr<>'SA' OR tr<>'KSA') AND promosiOperasional='$proOpr' AND arcoId IN ($trUserId))) a");
		$queSisaSaldoInternal = $dbCon->execute("select sum(keluar-masuk) as sisaSaldo
		from lkh_kasarco
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' and arcoId in ($trUserId) and promosiOperasional='$proOpr'");
		$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
		$hasilSisaSaldoInternal = $dbCon->getArray($queSisaSaldoInternal);
		$sisaSaldo = $hasilSisaSaldoKas['sisaSaldo'] - $hasilSisaSaldoInternal['sisaSaldo'];
	} else {
		$queSisaSaldoInternal = $dbCon->execute("select sum(masuk-keluar) as sisaSaldo
		from lkh_kaskasir where kantorCabangId='$kantorCabangId' and kodeArco='$kodeArco'
		and kasirId='$trUserId' and (tr<>'SA' or tr<>'KSA')  and promosiOperasional='$proOpr'");
		$quePengeluaranKas = $dbCon->execute("select sum(keluar-masuk) as pengeluaranKas
		from lkh_kas_temp
		where kantorCabangId='$kantorCabangId' and kodeArco='$kodeArco' 
		and IF(tr='M' AND jenisDana='BALIKAN KHUSUS',trUserId=trUserId,trUserId IN ($trUserId)) and promosiOperasional='$proOpr'");
		$hasilSisaSaldoInternal = $dbCon->getArray($queSisaSaldoInternal);
		$hasilPengeluaranKas = $dbCon->getArray($quePengeluaranKas);
		$sisaSaldo = $hasilSisaSaldoInternal['sisaSaldo'] - $hasilPengeluaranKas['pengeluaranKas'];
	}
	return $sisaSaldo;
}
function getSisaSaldoArco($trUserId, $trUserGroupId, $kodeArco, $kantorCabangId, $proOpr, $dbCon)
{
	if ($trUserGroupId == 2) {
		$queSisaSaldoKas = $dbCon->execute("SELECT SUM(masuk-keluar) AS sisaSaldo FROM
				(
				(SELECT * FROM lkh_kas
				WHERE kantorCabangId IN ($kantorCabangId)
				AND kodeArco='$kodeArco' AND IF(jenisDana='BALIKAN KHUSUS' AND tr NOT IN ('SA','M'),trUserId IN ($trUserId),trUserId=truserid)
				AND (tr<>'SA' OR tr<>'KSA') AND promosiOperasional='$proOpr' AND arcoId IN ($trUserId))) a");
		$queSisaSaldoInternal = $dbCon->execute("select sum(keluar-masuk) as sisaSaldo
				from lkh_kasarco
				where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' and arcoId in ($trUserId) and promosiOperasional='$proOpr'");
		$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
		$hasilSisaSaldoInternal = $dbCon->getArray($queSisaSaldoInternal);
		$sisaSaldo = $hasilSisaSaldoKas['sisaSaldo'] - $hasilSisaSaldoInternal['sisaSaldo'];
	} else {
		$queSisaSaldoInternal = $dbCon->execute("select sum(masuk-keluar) as sisaSaldo
				from lkh_kaskasir where kantorCabangId='$kantorCabangId' and kodeArco='$kodeArco'
				and kasirId='$trUserId' and (tr<>'SA' or tr<>'KSA')  and promosiOperasional='$proOpr'");
		$quePengeluaranKas = $dbCon->execute("select sum(keluar-masuk) as pengeluaranKas
				from lkh_kas
				where kantorCabangId='$kantorCabangId' and kodeArco='$kodeArco'
				and IF(tr='M' AND jenisDana='BALIKAN KHUSUS',trUserId=trUserId,trUserId IN ($trUserId)) and promosiOperasional='$proOpr'");
		$hasilSisaSaldoInternal = $dbCon->getArray($queSisaSaldoInternal);
		$hasilPengeluaranKas = $dbCon->getArray($quePengeluaranKas);
		$sisaSaldo = $hasilSisaSaldoInternal['sisaSaldo'] - $hasilPengeluaranKas['pengeluaranKas'];
	}
	return $sisaSaldo;
}
function getSisaSaldoTampungan($trUserId, $trUserGroupId, $kodeArco, $kantorCabangId, $proOpr, $dbCon)
{
	if ($trUserGroupId == 2) {
		$queSisaSaldoKas = $dbCon->execute("SELECT SUM(masuk-keluar) AS sisaSaldo FROM
				(
				(SELECT * FROM lkh_kas_temp
				WHERE kantorCabangId IN ($kantorCabangId)
				AND kodeArco='$kodeArco' AND IF(jenisDana='BALIKAN KHUSUS' AND tr NOT IN ('SA','M'),trUserId IN ($trUserId),trUserId=truserid)
				AND (tr<>'SA' OR tr<>'KSA') AND promosiOperasional='$proOpr' AND arcoId IN ($trUserId))) a");
		$queSisaSaldoInternal = $dbCon->execute("select sum(keluar-masuk) as sisaSaldo
				from lkh_kasarco
				where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' and arcoId in ($trUserId) and promosiOperasional='$proOpr'");
		$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
		$hasilSisaSaldoInternal = $dbCon->getArray($queSisaSaldoInternal);
		$sisaSaldo = $hasilSisaSaldoKas['sisaSaldo'] - $hasilSisaSaldoInternal['sisaSaldo'];
	} else {
		$queSisaSaldoInternal = $dbCon->execute("select sum(masuk-keluar) as sisaSaldo
				from lkh_kaskasir where kantorCabangId='$kantorCabangId' and kodeArco='$kodeArco'
				and kasirId='$trUserId' and (tr<>'SA' or tr<>'KSA')  and promosiOperasional='$proOpr'");
		$quePengeluaranKas = $dbCon->execute("select sum(keluar-masuk) as pengeluaranKas
				from lkh_kas
				where kantorCabangId='$kantorCabangId' and kodeArco='$kodeArco'
				and IF(tr='M' AND jenisDana='BALIKAN KHUSUS',trUserId=trUserId,trUserId IN ($trUserId)) and promosiOperasional='$proOpr'");
		$hasilSisaSaldoInternal = $dbCon->getArray($queSisaSaldoInternal);
		$hasilPengeluaranKas = $dbCon->getArray($quePengeluaranKas);
		$sisaSaldo = $hasilSisaSaldoInternal['sisaSaldo'] - $hasilPengeluaranKas['pengeluaranKas'];
	}
	return $sisaSaldo;
}
function getSisaBG($kodeArco, $arcoId, $kantorCabangId, $proOpr, $dbCon)
{
	$tglSekarang = dateToDouble(date("d-m-Y"));
	$queBG = $dbCon->execute("select IF(ISNULL(SUM(keluar)),0,SUM(keluar)) bonGantung
							from lkh_kas
							where arcoId in ($arcoId)
							and kantorCabangId in ($kantorCabangId)
							and tanggal <= '$tglSekarang'
							and jenisDana='DER'
							and (statusRealisasi='0' or (statusRealisasi='1' and tanggalRealisasi>'$tglSekarang'))
							and promosiOperasional='$proOpr'");
	$dataBG = $dbCon->getArray($queBG);
	return $dataBG['bonGantung'];
}
function getSisaSaldoPCO($trUserId, $trUserGroupId, $kodeArco, $arcoId, $kantorCabangId, $proOpr, $dbCon)
{

	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo
		from (select * from lkh_kas_temp
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' 
		and arcoId in ($arcoId) and (tr<>'SA' or tr<>'KSA') and promosiOperasional='$proOpr' and sis='PCO' UNION select * from lkh_kas
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' 
		and arcoId in ($arcoId) and (tr<>'SA' or tr<>'KSA') and promosiOperasional='$proOpr' and sis='PCO') a");

	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	return $hasilSisaSaldoKas[sisaSaldo];
}
function getSisaSaldoPCOTampungan($trUserId, $trUserGroupId, $kodeArco, $arcoId, $kantorCabangId, $proOpr, $dbCon)
{

	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo
			from (select * from lkh_kas_temp
			where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco'
			and arcoId in ($arcoId) and (tr<>'SA' or tr<>'KSA') and promosiOperasional='$proOpr' and sis='PCO') a");

	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	return $hasilSisaSaldoKas[sisaSaldo];
}
function getSisaSaldoPCOPerDept($trUserId, $trUserGroupId, $kodeArco, $arcoId, $kantorCabangId, $departemenId, $proOpr, $dbCon)
{
	return "select sum(saldo) as sisaSaldo
		from lkh_kas
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' 
		and arcoId in ($arcoId) and (tr<>'SA' or tr<>'KSA') and departemenId in ($departemenId) and promosiOperasional='$proOpr' and sis='PCO'";
	exit();
	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo
		from lkh_kas
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' 
		and arcoId in ($arcoId) and (tr<>'SA' or tr<>'KSA') and departemenId in ($departemenId) and promosiOperasional='$proOpr' and sis='PCO'");

	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	return $hasilSisaSaldoKas[sisaSaldo];
}
function getSisaSaldoDTP($trUserId, $trUserGroupId, $kodeArco, $arcoId, $kantorCabangId, $proOpr, $dbCon)
{
	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo
		from (select * from lkh_kas_temp
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' 
		and arcoId in ($arcoId) and promosiOperasional='$proOpr' and sis='DTP' UNION
select * from lkh_kas
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' 
		and arcoId in ($arcoId) and promosiOperasional='$proOpr' and sis='DTP') DTP");
	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	return $hasilSisaSaldoKas[sisaSaldo];
}
function getSisaSaldoDTPTampungan($trUserId, $trUserGroupId, $kodeArco, $arcoId, $kantorCabangId, $proOpr, $dbCon)
{
	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo
			from (select * from lkh_kas_temp
			where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco'
			and arcoId in ($arcoId) and promosiOperasional='$proOpr' and sis='DTP' ) DTP");
	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	return $hasilSisaSaldoKas[sisaSaldo];
}
function getSisaSaldoTP($trUserId, $trUserGroupId, $kodeArco, $kantorCabangId, $proOpr, $dbCon)
{

	$queSisaSaldoKas = $dbCon->execute("select sum(masuk-keluar) as sisaSaldo
											from lkh_kastp where kodeArco='$kodeArco' and  promosiOperasional='$proOpr'");
	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	$sisaSaldo = $hasilSisaSaldoKas['sisaSaldo'];
	return $sisaSaldo;
}
function getSisaSaldoDiKasir($trUserId, $trUserGroupId, $kodeArco, $kantorCabangId, $proOpr, $dbCon)
{
	$queSisaSaldoInternal = $dbCon->execute("select sum(masuk-keluar) as sisaSaldo
											   from lkh_kaskasir
											   where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco'
											   and arcoId in ($trUserId) and promosiOperasional='$proOpr'");
	$quePengeluaranKas = $dbCon->execute("select sum(keluar-masuk) as pengeluaranKas
											from lkh_kas where kantorCabangId in ($kantorCabangId)
											and kodeArco='$kodeArco' and trUserId not in ($trUserId) and 
											trUserGroupId='3' and promosiOperasional='$proOpr'");
	$hasilSisaSaldoInternal = $dbCon->getArray($queSisaSaldoInternal);
	$hasilPengeluaranKas = $dbCon->getArray($quePengeluaranKas);
	$sisaSaldo = $hasilSisaSaldoInternal['sisaSaldo'] - $hasilPengeluaranKas['pengeluaranKas'];
}

function getSisaSaldoAwalRPD($trUserId, $trUserGroupId, $kodeArco, $kantorCabangId, $dbCon)
{

	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo
		from lkh_kasrpd
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' and trUserId in ($trUserId) and tr='SA' and saldo>0 ");
	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	$sisaSaldo = $hasilSisaSaldoKas['sisaSaldo'];

	return $sisaSaldo;
}
function getSisaSaldoRPD($trUserId, $trUserGroupId, $kodeArco, $kantorCabangId, $dbCon)
{
	$tanggal = dateToDouble(date("d-m-Y"));
	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo
		from lkh_kasrpd
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' 
		and trUserId in ($trUserId) and tr='M' and saldo>0 and tanggal<='$tanggal'");
	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	$sisaSaldo = $hasilSisaSaldoKas['sisaSaldo'];

	return $sisaSaldo;
}

function getSisaSaldoAwalPettyCash($trUserId, $trUserGroupId, $kodeArco, $kantorCabangId, $dbCon)
{

	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo from lkh_kaspettycash
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' and trUserId in ($trUserId) and tr='SA' and saldo>0");
	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	$sisaSaldo = $hasilSisaSaldoKas['sisaSaldo'];

	return $sisaSaldo;
}
function getSisaSaldoPettyCash($trUserId, $trUserGroupId, $kodeArco, $kantorCabangId, $dbCon)
{
	$tanggal = dateToDouble(date("d-m-Y"));
	$queSisaSaldoKas = $dbCon->execute("select sum(saldo) as sisaSaldo
		from lkh_kaspettycash
		where kantorCabangId in ($kantorCabangId) and kodeArco='$kodeArco' 
		and trUserId in ($trUserId) and tr='M' and saldo>0 and tanggal<='$tanggal'");
	$hasilSisaSaldoKas = $dbCon->getArray($queSisaSaldoKas);
	$sisaSaldo = $hasilSisaSaldoKas['sisaSaldo'];

	return $sisaSaldo;
}
/*function getSisaSaldo($trUserId,$trUserGroupId,$arcoId,$kantorCabangId){
	if ($trUserGroupId==2){
		$queSisaSaldoKas=$dbCon->execute("select sum(masuk-keluar) as sisaSaldo from 
		lkh_kas where trUserId=$trUserId and kantorCabangId=$kantorCabangId");
		$queSisaSaldoInternal=$dbCon->execute("select sum(keluar-masuk) as sisaSaldo from 
		lkh_kasarco	 where arcoId=$trUserId and kantorCabangId=$kantorCabangId");
		$hasilSisaSaldoKas=$dbCon->getArray($queSisaSaldoKas);
		$hasilSisaSaldoInternal=$dbCon->getArray($queSisaSaldoInternal);
		$sisaSaldo=$hasilSisaSaldoKas['sisaSaldo']-$hasilSisaSaldoInternal['sisaSaldo'];
	}
	else{
		$queSisaSaldoInternal=$dbCon->execute("select sum(masuk-keluar) as sisaSaldo from 
		lkh_kaskasir where arcoId=$arcoId and kasirId=$trUserId and kantorCabangId=$kantorCabangId");
		$quePengeluaranKas=$dbCon->execute("select sum(keluar-masuk) as pengeluaranKas from 
		lkh_kas where arcoId=$arcoId and trUserId=$trUserId and kantorCabangId=$kantorCabangId");
		$hasilSisaSaldoInternal=$dbCon->getArray($queSisaSaldoInternal);
		$hasilPengeluaranKas=$dbCon->getArray($quePengeluaranKas);
		$sisaSaldo=$hasilSisaSaldoInternal['sisaSaldo']-$hasilPengeluaranKas['pengeluaranKas'];
	}
	return $sisaSaldo;
}
*/

function monthCode($nomorbulan)
{
	$nama_bulan = array(1 => "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L");
	$hasilbulan = $nama_bulan[$nomorbulan];
	return $hasilbulan;
}
function num_dua($name)
{
	$num_dua = number_format($name, 2, ',', '.');
	return $num_dua;
}
function selisihHari($date1, $date2)
{
	//date2 harus yg lebih besar	
	$datetime1 = explode("-", $date1);
	$datetime2 = explode("-", $date2);
	return GregorianToJD($datetime2[1], $datetime2[2], $datetime2[0]) - GregorianToJD($datetime1[1], $datetime1[2], $datetime1[0]);
}
function  selisihJam($date1, $date2)
{
	$hourdiff  = round((strtotime($date1) - strtotime($date2)) / 3600, 1);
}
function showWarning($kodeArco, $kantorCabangId, $trUserGroupId, $trUserId, $dbCon)
{
	$tanggalSekarang = date("Y-m-d");
	if ($trUserGroupId == 3) {
		$kodeArco = "";
	}
	$query1 = $dbCon->execute("SELECT jenisDana,promosiOperasional,COUNT(*) jumlah FROM lkh_kas WHERE kodeArco LIKE '%$kodeArco%' AND tr='K'
							AND trUserId IN  ($trUserId) AND statusRealisasi=0 
							AND 
							DATEDIFF(SYSDATE(),DATE_FORMAT(DATE('1970-01-01 23:59:59'+ INTERVAL tanggal/1000 SECOND),'%Y-%m-%d')) >14
							and jenisDana in ('WER','DER','TRANSFER')
							GROUP BY jenisDana,promosiOperasional");
	while ($data1 = $dbCon->getArray($query1)) {
		echo "Ada " . $data1[jumlah] . " transaksi " . $data1[jenisDana] . " " . $data1[promosiOperasional] . " yang tanggalnya lebih dari 2 minggu<br><br>";
	}
}
function showWarning2($kodeArco, $kantorCabangId, $trUserGroupId, $trUserId, $dbCon)
{
	/*
$tanggalSekarang=dateToDouble(date("d-m-Y"));
$resPeriode=$dbCon->execute("select * from lkh_periode
		where tglAwal<='".$tanggalSekarang."' and tglAkhir>='".$tanggalSekarang."'");
$periodeAktif=$dbCon->getArray($resPeriode);
if($periodeAktif[tglAkhir]==$tanggalSekarang){
	$query1=$dbCon->execute("select * from lkh_saldobukubank where thnLKH='$periodeAktif[thn]' and blnLKH='$periodeAktif[bln]' and 						     			   							 mingguLKH='$periodeAktif[minggu]' and kodeArco='$kodeArco' and kantorCabangId in ($kantorCabangId)");
	$jumlahDataSaldo=$dbCon->getNumRows($query1);
	if($jumlahDataSaldo==0){	
			echo "<font style='text-decoration:blink; font-weight:bold'> PERHATIAN</font><br />Anda belum memasukkan nilai saldo buku bank terakhir minggu $periodeAktif[minggu] ".monthName(intval($periodeAktif[bln]))." $periodeAktif[thn]</div>";
	}

	}*/
}
function showWarning3()
{
	echo "<div id='alertReal_2' style='position:absolute;right:38;bottom:32; 
								 z-index: 22; 
								 width:380px; 
								 height:auto; 
								 color: white; 
								 display:none;
								 background-color:#333; 
								 padding: 5px 10px;
								 opacity:0.9;filter:alpha(opacity=90);
								 -moz-box-shadow: 0px 0px 16px #000;
								 -webkit-box-shadow: 0px 0px 16px #000;
								 box-shadow: 0px 0px 16px #000;'>
<img id='close_message' title='close' onclick='$(\"#alertReal_2\").slideToggle(1000)' style='float:right;cursor:pointer'  src='../images/12-em-cross.png' />
<font style='text-decoration:blink; font-weight:bold;color:red'>INFO LKH</font><br />
<b>New Update : Mutasi Dana Lain Penerima</b><br />
1. Berdoa dahulu sebelum mengerjakan LKH<br />
2. Pastikan anda memilih menu yang benar<br>
3. Selalu perhatikan inputan 'Tanggal'<br>
4. Sebelum melakukan transaksi/mutasi, Harap cek dulu history LKH<br>
5. PROSES SERAH TERIMA DAN MUTASI ANTAR ARCO HANYA BISA DILAKUKAN 1x, TIDAK BISA DIULANG ATAU DIEDIT!<br>
</div>
<script>$(\"#alertReal_2\").slideToggle(1000)</script>
";
}
function cekJScript($pageWarning)
{
	echo "<noscript><meta http-equiv='REFRESH' content='0;url=" . $pageWarning . "'></noscript>";
}

function msgBox($pesan)
{
	echo "<script>alert('" . $pesan . "');</script>";
}
function jscript($script)
{
	echo "<script>" . $script . "</script>";
}
function pageNav($curHal, $maxHal, $jmlTampil)
{
	$linkHal = "";
	$halTengah = round($jmlTampil / 2);
	if ($maxHal > 0) {
		if ($curHal > 1) {
			$previous = $curHal - 1;
			$linkHal = $linkHal . "<a class='nextprev' onclick='getData(1)'> First</a> &nbsp";
			$linkHal = $linkHal . " <a class='nextprev' onclick='getData($previous)'> Prev</a> &nbsp";
		} elseif (empty($curHal) || $curHal == 1) {
			$linkHal = $linkHal . "<a class='nextprev'>First</a><a class='nextprev'> Prev </a> ";
		}
		$angka = "";
		for ($i = $curHal - ($halTengah - 1); $i < $curHal; $i++) {
			if ($i < 1)
				continue;
			$angka .= "<a class='num' onclick='getData($i)'>$i</a> ";
		}

		$angka .= "<span class='current'><b >$curHal</b> </span>";
		for ($i = $curHal + 1; $i < ($curHal + $halTengah); $i++) {
			if ($i > $maxHal)
				break;
			$angka .= "<a class='num' onclick='getData($i)'>$i</a> ";
		}

		$linkHal = $linkHal . $angka;

		if ($curHal < $maxHal) {
			$next = $curHal + 1;
			$linkHal = $linkHal . " <a class='nextprev'onclick='getData($next)'>Next </a>&nbsp;&nbsp;<a class='nextprev' onclick='getData($maxHal)'>Last</a> ";
		} else {
			$linkHal = $linkHal . " <a class='nextprev'>Next</a><a class='nextprev'>Last</a> ";
		}
	}
	return $linkHal;
}
function pageNav2($curHal, $maxHal, $jmlTampil, $indexFunct)
{
	$linkHal = "";
	$halTengah = round($jmlTampil / 2);
	if ($maxHal > 0) {
		if ($curHal > 1) {
			$previous = $curHal - 1;
			$linkHal = $linkHal . "<a class='nextprev' onclick='getData$indexFunct(1)'> First</a> &nbsp";
			$linkHal = $linkHal . " <a class='nextprev' onclick='getData$indexFunct($previous)'> Prev</a> &nbsp";
		} elseif (empty($curHal) || $curHal == 1) {
			$linkHal = $linkHal . "<a class='nextprev'>First</a><a class='nextprev'> Prev </a> ";
		}
		$angka = "";
		for ($i = $curHal - ($halTengah - 1); $i < $curHal; $i++) {
			if ($i < 1)
				continue;
			$angka .= "<a class='num' onclick='getData$indexFunct($i)'>$i</a> ";
		}

		$angka .= "<span class='current'><b >$curHal</b> </span>";
		for ($i = $curHal + 1; $i < ($curHal + $halTengah); $i++) {
			if ($i > $maxHal)
				break;
			$angka .= "<a class='num' onclick='getData$indexFunct($i)'>$i</a> ";
		}

		$linkHal = $linkHal . $angka;

		if ($curHal < $maxHal) {
			$next = $curHal + 1;
			$linkHal = $linkHal . " <a class='nextprev'onclick='getData$indexFunct($next)'>Next </a>&nbsp;&nbsp;<a class='nextprev' onclick='getData$indexFunct($maxHal)'>Last</a> ";
		} else {
			$linkHal = $linkHal . " <a class='nextprev'>Next</a><a class='nextprev'>Last</a> ";
		}
	}
	return $linkHal;
}
function addTrailingBlank($value, $length)
{
	$blankAdded = $length - strlen($value);

	for ($i = 0; $i < $blankAdded; $i++) {
		$value = $value . "_";
	}
	return $value;
}
function addHeadingBlank($value, $length)
{
	$blankAdded = $length - strlen($value);

	for ($i = 0; $i < $blankAdded; $i++) {
		$value = "_" . $value;
	}
	return $value;
}
function getRealIpAddr()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
function writeLog($dbCon, $trUserId)
{
	$ipClient = getRealIpAddr();
	$ipHostName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	//getRealIpAddr().php_uname('n').$_SERVER['REMOTE_ADDR'].GetHostByName($REMOTE_ADDR).gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$dbCon->execute("insert into lkh_log values('" . maxId('lkh_log', 'id', $dbCon) . "','" . date('Y-m-d h:n:s') . "','$trUserId','$ipClient','$ipHostName')");
}
function inpRek($trUserId, $dbCon)
{
	$queRek = "select a.id,a.userId,c.namauser,a.rekeningId,
				b.nama namaRekening,b.nomor,
				d.nama namaBank,a.jenisRekening
				from lkh_rekeninguser a 
				inner join lkh_rekening b on a.rekeningId=b.id 
				inner join lkh_users c on a.userId=c.id
				inner join bernofarmbank d on b.bankId=d.id where a.userId in ($trUserId)";
	$rsRek = $dbCon->execute($queRek);
	echo "<select name='rek' id='rek' style='width:490px' class='roundIt'>";
	while ($dataRek = $dbCon->getArray($rsRek)) {
		echo "<option value='$dataRek[rekeningId]'>" . addTrailingBlank(strtoupper($dataRek[namauser]), 25) . " | " . addTrailingBlank($dataRek[nomor], 15) . " | " . addTrailingBlank(strtoupper($dataRek[namaBank]), 25) . "</option>";
	}
	echo "</select>";
}
function inpRekTP($kantorCabangId, $dbCon)
{
	$queRek = "SELECT a.*,b.nama namaBank,b.alamat
				FROM lkh_rekeningtp a 				
				INNER JOIN bernofarmbank b ON a.bankId=b.id where a.kantorCabangId in ($kantorCabangId) order by a.nama";

	$rsRek = $dbCon->execute($queRek);
	echo "<select name='rekTP' id='rekTP' style='width:320px;font-family:courier' class='roundIt'>";
	echo "<option value=''>-Pilih Rek Tujuan-</option>";

	while ($dataRek = $dbCon->getArray($rsRek)) {
		echo "<option value='$dataRek[id]!$dataRek[nomor]!$dataRek[nama]!$dataRek[namaBank]' style='font-family:courier'>" . addTrailingBlank(strtoupper($dataRek[nama]), 12) . " | " . addTrailingBlank($dataRek[nomor], 15) . " | " . addTrailingBlank(strtoupper($dataRek[namaBank]), 25) . "</option>";
	}
	echo "</select>";
}
function inpRekPro($kantorCabangId, $dbCon)
{
	$queRek = "SELECT a.*,b.nama namaBank,b.alamat
				FROM lkh_rekeningpro a 				
				INNER JOIN bernofarmbank b ON a.bankId=b.id where a.kantorCabangId in ($kantorCabangId)";

	$rsRek = $dbCon->execute($queRek);
	echo "<select name='rekTP' id='rekTP' style='width:320px;font-family:courier' class='roundIt'>";
	while ($dataRek = $dbCon->getArray($rsRek)) {
		echo "<option value='$dataRek[id]!$dataRek[nomor]!$dataRek[nama]!$dataRek[namaBank]' style='font-family:courier'>" . addTrailingBlank(strtoupper($dataRek[nama]), 12) . " | " . addTrailingBlank($dataRek[nomor], 15) . " | " . addTrailingBlank(strtoupper($dataRek[namaBank]), 25) . "</option>";
	}
	echo "</select>";
}
function statusDana()
{
	$statusDana = array(
		"Diajukan", "Ditolak", "DisetujuiAsmen", "DisetujuiCoordAsmen", "DisetujuiAsdir",
		"BolehDikirim", "TelahDitransfer"
	);
	return $statusDana;
}
function mingguPengiriman()
{
	$mingguPengiriman = array(
		"I", "I S1", "I S2", "I S3", "II", "II S1",
		"II S2", "II S3", "III", "III S1", "III S2",
		"III S3", "IV", "IV S1", "IV S2", "IV S3", "V", "V S1", "V S2"
	);
	return $mingguPengiriman;
}
function getNextStatusDana($verificatorGroup, $dbCon)
{
	$nextStatus = "";
	$rsStatus = $dbCon->execute("select * from lkh_nextstatusdana where verificatorGroup='$verificatorGroup' and 
	jenisStatus='setuju'");
	while ($dataStatus = $dbCon->getArray($rsStatus)) {
		$nextStatus = $nextStatus . $dataStatus[nextStatus] . "|";
	}
	return $nextStatus;
}
function getStatusDanaTolakan($verificatorGroup, $statusDana, $dbCon)
{
	$nextStatus = "";
	$rsStatus = $dbCon->execute("select * from lkh_nextstatusdana where verificatorGroup='$verificatorGroup' and 
	jenisStatus='tolakan' and statusDana='$statusDana'");
	while ($dataStatus = $dbCon->getArray($rsStatus)) {
		$nextStatus = $nextStatus . $dataStatus[nextStatus] . "|";
	}
	return $nextStatus;
}
function getIsBolehDikirim($kategoriDana, $statusDana, $nilaiPengajuan, $dbCon)
{
	$return = false;
	$rsBolehDikirim = $dbCon->execute("select * from lkh_statusBolehDikirim where kategori='$kategoriDana' and statusDana='$statusDana'");
	$jml = $dbCon->getNumRows($rsBolehDikirim);
	if ($jml > 0) {

		while ($dataBolehDikirim = $dbCon->getArray($rsBolehDikirim)) {
			$limitBawah = $dataBolehDikirim[limitBawah];
			$limitAtas = $dataBolehDikirim[limitAtas];
			if ($limitBawah == 0 && $limitAtas == 0) {
				$return = true;
				break;
			} elseif ($limitBawah == 0 && $limitAtas != 0) {
				if ($nilaiPengajuan <= $limitAtas) {
					$return = true;
					break;
				}
			} elseif ($limitBawah != 0 && $limitAtas != 0) {
				if ($nilaiPengajuan >= $limitBawah && $nilaiPengajuan <= $limitAtas) {
					$return = true;
					break;
				}
			} elseif ($limitBawah != 0 && $limitAtas == 0) {
				if ($nilaiPengajuan >= $limitBawah) {
					$return = true;
					break;
				}
			}
		}
	}
	return $return;
}
function getJmlRPDBlmReal($kodeArco, $dbCon)
{
	$rs = $dbCon->execute("SELECT COUNT(DISTINCT noLS) jmlBlmReal 
						FROM lkh_kasrpd 
						WHERE kodeArco='$kodeArco' AND id NOT IN (
										SELECT kasMasukId 
										FROM lkh_kasrpd 
										WHERE kodeArco='$kodeArco' AND tr='K' AND statusRealisasi=1
						) AND tr='M'");
	$data = $dbCon->getArray($rs);
	return $data[jmlBlmReal];
}
function inp_post($nama, $dbCon)
{
	$rsPost = $dbCon->execute("select * from postwer");
	echo "<select name='$nama' id='$nama' class='roundIt'>";
	echo "<option value=''>-Pilih Post-</option>";
	while ($dataPost = $dbCon->getArray($rsPost)) {
		echo "<option value=$dataPost[id]>$dataPost[post]</option>";
	}
	echo "</select>";
}
function inp_departemen($nama, $dbCon)
{
	$rsDept = $dbCon->execute("select * from bernodb.bernofarmdepartemenmarketing");
	echo "<select name='$nama' id='$nama' class='roundIt'>";
	echo "<option value=''>-Pilih Departemen-</option>";
	while ($dataDept = $dbCon->getArray($rsDept)) {
		echo "<option value=$dataDept[id]>" . strtoupper($dataDept[nama]) . "</option>";
	}
	echo "</select>";
}
function replacemeta($strInp)
{
	$str = preg_replace('/[^a-zA-Z0-9]/', '', $strInp);
	return $str;
}
function replacequote($strInp)
{
	//$str=str_replace("'","''",$strInp);
	$str = addslashes($strInp);

	return $str;
}
function comparePeriode($thn1, $bln1, $minggu1, $thn2, $bln2, $minggu2, $kompare)
{
	if ($bln1 < 10) {
		$bln1 = "0" . $bln1;
	}
	if ($bln2 < 10) {
		$bln2 = "0" . $bln2;
	}
	if ($kompare == "G") {
		if ($thn1 . "-" . $bln1 . "-" . $minggu1 > $thn2 . "-" . $bln2 . "-" . $minggu2)
			return true;
	} elseif ($kompare == "L") {
		if ($thn1 . "-" . $bln1 . "-" . $minggu1 < $thn2 . "-" . $bln2 . "-" . $minggu2)
			return true;
	} elseif ($kompare == "GE") {
		if ($thn1 . "-" . $bln1 . "-" . $minggu1 >= $thn2 . "-" . $bln2 . "-" . $minggu2)
			return true;
	} elseif ($kompare == "LE") {
		if ($thn1 . "-" . $bln1 . "-" . $minggu1 <= $thn2 . "-" . $bln2 . "-" . $minggu2)
			return true;
	} elseif ($kompare == "E") {
		if ($thn1 . "-" . $bln1 . "-" . $minggu1 == $thn2 . "-" . $bln2 . "-" . $minggu2)
			return true;
	}
}
function ambil_data()
{
	echo "<input type=\"button\" name=\"ambilData\" onclick=\"getData()\" value=\"Ambil Data\" class=\"tom95\" />";
}
function Terbilang($x)
{
	$array = array(" ", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	if ($x < 12)
		return " " . $array[$x];
	else if ($x < 20)
		return Terbilang($x - 10) . "belas";
	else if ($x < 100)
		return Terbilang(intval($x / 10)) . " puluh" .  Terbilang($x % 10);
	else if ($x < 200)
		return " seratus" . Terbilang($x - 100);
	else if ($x < 1000)
		return Terbilang(intval($x / 100)) . " ratus" . Terbilang($x % 100);
	else if ($x < 2000)
		return " seribu" . Terbilang($x - 1000);
	else if ($x < 1000000)
		return Terbilang(intval($x / 1000)) . " ribu" . Terbilang($x % 1000);
	else if ($x < 1000000000)
		return Terbilang(intval($x / 1000000)) . " juta" . Terbilang($x % 1000000);
	else if ($x < 1000000000000)
		return Terbilang(intval($x / 1000000000)) . " milyar" . Terbilang($x % 1000000000);
}
function dateLocked($tglCek, $kodeArco, $dbCon)
{
	//CEK LOCK MINGGU PER KODE ARCO
	$rsCekMinggu = $dbCon->execute("SELECT * FROM lkh_lockedminggukantorcabang a LEFT  JOIN
	lkh_periode b ON a.thn=b.thn AND a.bln=CONVERT(b.bln, SIGNED INTEGER) AND a.minggu=b.minggu
	where b.tglAwal<=$tglCek and b.tglAkhir>=$tglCek and kodeArco like '%" . $kodeArco . "%'");
	$dataCekMinggu = $dbCon->getArray($rsCekMinggu);
	if ($dataCekMinggu[status] == 'locked') {
		return true;
	} else {
		return false;
	}
}
function dateTransferLocked($tglCek, $dbCon)
{
	//CEK LOCK MINGGU PER KODE ARCO
	$rsTanggalTransfer = $dbCon->execute("SELECT * FROM lkh_locktanggaltransfer 
	where tanggal=$tglCek");
	$dataCekTanggalTransfer = $dbCon->getArray($rsTanggalTransfer);
	if ($dataCekTanggalTransfer[status] == 'locked') {
		return true;
	} else {
		return false;
	}
}
function getPeriode($tanggal, $dbCon)
{
	$quePeriode = $dbCon->execute("select * from lkh_periode where tglAwal<='" . $tanggal . "' and tglAkhir>='" . $tanggal . "'");
	$hasilPeriode = $dbCon->getArray($quePeriode);
	$tglAwal = doubleToDate($hasilPeriode['tglAwal']);
	$tglAkhir = doubleToDate($hasilPeriode['tglAkhir']);
	$periode = $tglAwal . " s/d " . $tglAkhir;
	return "Periode : " . $periode . " (Minggu " . $hasilPeriode['minggu'] . " " . monthName(intval($hasilPeriode['bln'])) . " " . $hasilPeriode['thn'] . ")";
}
function getAtasan($pejId, $thn, $bln, $dbCon2)
{
	$rsAtasan = $dbCon2->execute("select a.* from pejabat_divisi_lama a inner join old_maker_cheker b on
								a.tahun=b.thn and a.bulan=b.bln and a.pejId=b.cheker and b.maker='$pejId'
								and b.thn='$thn' and b.bln='$bln'");
	$atasan;

	while ($dataAtasan = $dbCon2->getArray($rsAtasan)) {
		$atasan = $atasan . $dataAtasan[pejid] . "|" . $dataAtasan[nama_pejabat] . "|" . $dataAtasan[jabid];
	}
	return $atasan;
}
function H31203Z($x0b, $x0c = '')
{

	if ($x0c == '') {
		return $x0b;
	}

	if (strlen(trim($x0c)) < 5) {
		exit('...........');
	}

	$x0d = strlen($x0c);
	$x0d = ($x0d > 32) ? 32 : $x0d;

	$x0e = array();
	for ($x0f = 0; $x0f < $x0d; ++$x0f) {
		$x0e[$x0f] = ord($x0c{
		$x0f}) & 0x1F;
	}

	for ($x0f = 0, $x10 = 0; $x0f < strlen($x0b); ++$x0f) {
		$x11 = ord($x0b{
		$x0f});
		if ($x11 & 0xE0) {
			$x0b{
			$x0f} = chr($x11 ^ $x0e[$x10]);
		}

		$x10 = ($x10 + 1) % $x0d;
	}
	return $x0b;
}
function getHariTanggal($tanggal)
{
	$namaHari = date('l', strtotime($tanggal));
	return $namaHari;
}
/*function limitInput($tglDiperlukan){
	$allowed=true;
	$hariDiperlukan=date('l', strtotime($tglDiperlukan));
	if($hariDiperlukan=='Monday' || $hariDiperlukan=='Senin'){
		$waktuDiperlukan = strtotime($tglDiperlukan);
		$time_add      = $time_original + (3600*24); //add seconds of one day
		
		$new_date      = date("Y-m-d", $time_add);
	}
	
}*/
function printBox()
{
	echo ' <div id="myModal" class="modal fade" role="dialog">
   <div class="modal-dialog">
	<!-- konten modal-->
	<div class="modal-content">
		<!-- heading modal -->
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Bagian heading modal</h4>
		</div>
		<!-- body modal -->
		<div class="modal-body">
			<p>bagian body modal.</p>
		</div>
		<!-- footer modal -->
		<div class="modal-footer">
			<button type="button" id="btnok" class="btn btn-primary" data-dismisswithcallback="callBackOk">Confirm</button>
			<button type="button" id="tt" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
   </div>
</div>   
<div style="display:none" name="loadBox" id="load"><p></p></div>
<div style="display:none; z-index:1000;" name="dialogBox" id="dialog"><p></p></div>';
}
function num2alpha($n)
{
	for ($r = ""; $n >= 0; $n = intval($n / 26) - 1)
		$r = chr($n % 26 + 0x41) . $r;
	return $r;
}
?>