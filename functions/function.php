<?php
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

// ambil nama bulan berdasarkan angka bulan
function monthName($nomorbulan)
{
	$nama_bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	$hasilbulan = $nama_bulan[$nomorbulan];
	return $hasilbulan;
}
function namaBulan($nomorbulan)
{
	$nama_bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
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
	echo "<select name=\"" . $year . "\" class='roundIt'>\n";
	for ($t = date("Y") - 5; $t <= date("Y") + 7; $t++) {
		if ($t == date("Y")) {
			echo "<option value=$t selected='selected'>$t</option>\n";
		} else {
			echo "<option value=$t>$t</option>\n";
		}
	}
	echo "		</select>\n";
}
function inp_tahunMesin($year)
{
	echo "<select name=\"" . $year . "\" class='roundIt'>\n";
	for ($t = date("Y") - 20; $t <= date("Y") + 5; $t++) {
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
	echo "<select name=\"" . $month . "\" class='roundIt'>";
	for ($t = 1; $t <= 12; $t++) {
		if ($t == date("n")) {
			echo "<option value=$t selected='selected'>" . monthName($t) . "</option>\n";
		} else {
			echo "<option value=$t>" . monthName($t) . "</option>\n";
		}
	}
	echo "</select> ";
}

function inp_tahunkosong($year)
{
	echo "<select name=\"" . $year . "\" class='roundIt'>\n";
	echo "<option value='' selected='selected'>Tahun</option>\n";
	for ($t = date("Y") - 5; $t <= date("Y") + 7; $t++) {
		if ($t == date("Y")) {
			echo "<option value=$t>$t</option>\n";
		} else {
			echo "<option value=$t>$t</option>\n";
		}
	}
	echo "		</select>\n";
}
function inp_bulankosong($month)
{
	echo "<select name=\"" . $month . "\" class='roundIt'>";
	echo "<option value='' selected='selected'>Bulan</option>\n";
	for ($t = 1; $t <= 12; $t++) {
		if ($t == date("n")) {
			echo "<option value=$t>" . monthName($t) . "</option>\n";
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
	for ($t = date("Y") - 5; $t <= date("Y") + 3; $t++) {
		if ($t == date("Y")) {
			echo "<option value=$t selected='selected'>$t</option>\n";
		} else {
			echo "<option value=$t>$t</option>\n";
		}
	}
	echo "		</select>\n";
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
function dateToDouble($date)
{
	$tanggal = substr($date, 0, 2);
	$bulan = substr($date, 3, 2);
	$tahun = substr($date, 6, 4);
	$dateDouble = mktime(1, 00, 00, $bulan, $tanggal, $tahun);
	return number_format($dateDouble * 1000, 0, "", "");
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
function maxOrder($tabel, $field, $parent, $value, $dbCon)
{
	$res = $dbCon->getRow($dbCon->execute("select max($field) from $tabel where $parent='$value'"));
	if (strlen($res[0]) == 0) {
		$maxId = 1;
	} else {
		$maxId = ($res[0]) + 1;
	}
	return $maxId;
}

function maxIdGenerator($tabel, $field, $pref, $dbCon)
{
	$kueri = $dbCon->execute("select lastId as maxId from lkh_idGenerator where beanName='" . $tabel . $pref . "'");
	$res = $dbCon->getRow($kueri);
	$jml = $dbCon->getNumRows($kueri);
	if ($jml == 0) {
		$dbCon->execute("insert into lkh_idGenerator values('" . $tabel . $pref . "','1')");
		$maxId = $pref . "1";
	} else {
		$maxId = ($res[0]) + 1;

		$dbCon->execute("update lkh_idGenerator set lastId='$maxId' where beanName='" . $tabel . $pref . "'");
		$maxId = $pref . $maxId;
	}

	return $maxId;
}

function maxNoTransGenerator($tabel, $field, $pref, $kodeArco, $thn, $bln, $dbCon)
{
	/* $kueri=$dbCon->execute("select lastId as maxId from lkh_notaGenerator where tableName='$tabel' and 
							prefix='".$pref."' and kodeArco='$kodeArco' 
							and tahun='$thn' and bulan='$bln'");*/
	$prefId = $pref . $kodeArco . $thn . $bln;
	$kueri = $dbCon->execute("select max($field) from $tabel where substring($field,1," . strlen($prefId) . ")='$prefId'");

	$res = $dbCon->getRow($kueri);
	$jml = $dbCon->getNumRows($kueri);

	if ($jml == 0) {
		//$dbCon->execute("insert into lkh_notaGenerator values('$tabel','".$pref."','$kodeArco','$thn','$bln','1')");
		$maxId = $prefId . "00001";
	} else {
		$maxId = $res[0];
		//	$dbCon->execute("update lkh_notaGenerator set lastId=lastId+1 where tableName='$tabel' and prefix='".$pref."' 
		//				and kodeArco='$kodeArco' and tahun='$thn' and bulan='$bln'");
		$maxId = substr($maxId, strlen($prefId) + 1, strlen($maxId));
		$maxId = $maxId + 100001;
		$maxId = substr($maxId, 1, 5);
		$maxId = $prefId . $maxId;
	}

	return $maxId;
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
	$hnf = number_format($s, 0, ".", ",");
	if ($s == 0 || $s == "") return "-";
	else return $hnf;
}

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
function pageNavs($curHal, $maxHal, $jmlTampil)
{
	$linkHal = '';
	$angka = '';
	$halTengah = round($jmlTampil / 2);
	if ($maxHal > 0) {
		if ($curHal > 1) {
			$previous = $curHal - 1;
			$linkHal = $linkHal . "<a class='nextprev' onclick='getData(1)'> First</a> &nbsp";
			$linkHal = $linkHal . " <a class='nextprev' onclick='getData($previous)'> Prev</a> &nbsp";
		} elseif (empty($curHal) || $curHal == 1) {
			$linkHal = $linkHal . "<a class='nextprev'>First</a><a class='nextprev'> Prev </a> ";
		}
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


//update 29012016

function maxNoRegGenerator($tabel, $field, $pref, $cabang, $kodejenis, $dbCon)
{
	/* $kueri=$dbCon->execute("select lastId as maxId from lkh_notaGenerator where tableName='$tabel' and 
							prefix='".$pref."' and kodeArco='$kodeArco' 
							and tahun='$thn' and bulan='$bln'");*/
	$prefId = $pref . $cabang . $kodejenis;
	$lenPrefId = strlen($prefId);
	if ($lenPrefId == 7) {
		$resData = "select max($field) from $tabel where substring($field,1," . strlen($prefId) . ")='$prefId' AND LENGTH($field)='11'";
	} else {
		$resData = "select max($field) from $tabel where substring($field,1," . strlen($prefId) . ")='$prefId' and LENGTH($field)='12'";
	}

	$kueri = $dbCon->execute($resData);
	$res = $dbCon->getRow($kueri);
	$jml = $dbCon->getNumRows($kueri);
	if ($jml == 0) {
		//$dbCon->execute("insert into lkh_notaGenerator values('$tabel','".$pref."','$kodeArco','$thn','$bln','1')");
		$maxId = $prefId . "0001";
	} else {
		$maxId = $res[0];
		//	$dbCon->execute("update lkh_notaGenerator set lastId=lastId+1 where tableName='$tabel' and prefix='".$pref."' 
		//				and kodeArco='$kodeArco' and tahun='$thn' and bulan='$bln'");
		$maxId = substr($maxId, strlen($prefId) + 1, strlen($maxId));
		$maxId = $maxId + 10001;
		$maxId = substr($maxId, 1, 4);
		$maxId = $prefId . $maxId;
	}

	return $maxId;
}

function maxNoNotaGenerator($tabel, $field, $pref, $idUser, $thn, $bln, $colbulan, $coltahun, $dbCon)
{
	/* $kueri=$dbCon->execute("select lastId as maxId from lkh_notaGenerator where tableName='$tabel' and 
							prefix='".$pref."' and kodeArco='$kodeArco' 
							and tahun='$thn' and bulan='$bln'");*/
	$thnP = substr($thn, 2, 2);
	$blnP = "0" . $bln;
	if ($idUser == "") {
		$idUser = $idUser;
	} elseif (strlen($idUser) == 1) {
		$idUser = "0" . $idUser;
	} else {
	}
	$prefId = $idUser . "-" . $thnP . $blnP;
	$kueri = $dbCon->execute("select max($field) from $tabel where substring($field,1," . strlen($prefId) . ")='$prefId' and $colbulan='$bln' and $coltahun='$thn'");
	//echo "select max($field) from $tabel where substring($field,1,".strlen($prefId).")='$prefId' and $colbulan='$bln' and $coltahun='$thn'";

	$res = $dbCon->getRow($kueri);
	$jml = $dbCon->getNumRows($kueri);
	//echo $jml;
	if ($jml == 0) {
		//$dbCon->execute("insert into lkh_notaGenerator values('$tabel','".$pref."','$kodeArco','$thn','$bln','1')");
		$maxId = $prefId . "0001";
	} else {
		$maxId = $res[0];
		//	$dbCon->execute("update lkh_notaGenerator set lastId=lastId+1 where tableName='$tabel' and prefix='".$pref."' 
		//				and kodeArco='$kodeArco' and tahun='$thn' and bulan='$bln'");
		$maxId = substr($maxId, strlen($prefId) + 1, strlen($maxId));
		$maxId = $maxId + 10001;
		$maxId = substr($maxId, 1, 4);
		$maxId = $prefId . $maxId;
	}

	return $maxId;
}
function maxNoUsulanGenerator($tabel, $field, $pref, $idUser, $thn, $bln, $colbulan, $coltahun, $dbCon)
{
	/* $kueri=$dbCon->execute("select lastId as maxId from lkh_notaGenerator where tableName='$tabel' and 
							prefix='".$pref."' and kodeArco='$kodeArco' 
							and tahun='$thn' and bulan='$bln'");*/
	$thnP = substr($thn, 2, 2);
	$blnP = "0" . $bln;
	if ($idUser == "") {
		$idUser = $idUser;
	} elseif (strlen($idUser) == 1) {
		$idUser = "0" . $idUser;
	} else {
	}
	$prefId = $idUser . "-" . $thnP . $blnP;
	$kueri = $dbCon->execute("select max($field) from $tabel where substring($field,1," . strlen($prefId) . ")='$prefId' and $colbulan='$bln' and $coltahun='$thn'");
	//echo "select max($field) from $tabel where substring($field,1,".strlen($prefId).")='$prefId' and $colbulan='$bln' and $coltahun='$thn'";

	$res = $dbCon->getRow($kueri);
	$jml = $dbCon->getNumRows($kueri);
	//echo $jml;
	if ($jml == 0) {
		//$dbCon->execute("insert into lkh_notaGenerator values('$tabel','".$pref."','$kodeArco','$thn','$bln','1')");
		$maxId = $prefId . "0001";
	} else {
		$maxId = $res[0];
		//	$dbCon->execute("update lkh_notaGenerator set lastId=lastId+1 where tableName='$tabel' and prefix='".$pref."' 
		//				and kodeArco='$kodeArco' and tahun='$thn' and bulan='$bln'");
		$maxId = substr($maxId, strlen($prefId) + 1, strlen($maxId));
		$maxId = $maxId + 10001;
		$maxId = substr($maxId, 1, 4);
		$maxId = $prefId . $maxId;
	}

	return $maxId;
}
function cekHTMLTag($strInp)
{
	$pos = strpos($mystring, $findme);

	// Note our use of ===.  Simply == would not work as expected
	// because the position of 'a' was the 0th (first) character.
	if (
		strpos($strInp, "<script") === false && strpos($strInp, "<body") === false && strpos($strInp, "<html") === false && strpos($strInp, "<a") === false
		&& strpos($strInp, "<div") === false
	) {
		return $strInp;
	} else {
		echo "Hayo..jangan input macam-macam";
		exit();
	}
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
