<?php
include("../functions/koneksi.php");
include("../functions/function.php");
//include("../functions/Spreadsheet/Excel/reader.php");
include("../functions/Spreadsheet/Excel/excel_reader2.php");

//	$session_namauser=$_SESSION["newasset_session_nama"];
//	$session_userid = $_SESSION["newasset_session_id"];
//	$session_groupId = $_SESSION["newasset_session_groupId"];
//	$session_area = $_SESSION["newasset_session_area"];
//	$session_perusahaan=$_SESSION['newasset_session_perusahaan'];;
//	if($session_namauser=="")
//	{
//		header("location:../index.php");
//	}
$mode = $_POST["mode"];


if (!empty($mode)) {
	//$hm=$_POST['hal'];

	$limit = 100;
	if ($mode == "getUploadke") {
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];

		$query = "SELECT uploadKe FROM refreshkaryawanhistory WHERE bulan='$bulan' AND tahun='$tahun' GROUP BY uploadKe";

		$uploadKe = $dbCon->execute($query);

		while ($jumlahUpload = $dbCon->getArray($uploadKe)) {
			$txtUpload .= "<option value='" . $jumlahUpload['uploadKe'] . "'>" . monthRome($jumlahUpload['uploadKe']) . "</option>";
		}
		echo $txtUpload;
	}
	if ($mode == "getData") {
		try {
			$dbCon->execute("BEGIN");

			$bulan = $_POST['bulan'];
			$tahun = $_POST['tahun'];
			$filterUploadKe = $_POST['filterUploadKe'];
			$filterStatusUpload = $_POST['filterStatusUpload'];
			$filterKeterangan = $_POST['filterKeterangan'];

			$fungsi = "getData";
			if ($filterUploadKe == 'All') {
				$filterUploadKeQuery = '';
				$filterSubUploadKe = '';
			} else {
				$filterUploadKeQuery = " AND r.uploadKe='$filterUploadKe'";
				$filterSubUploadKe = " AND uploadKe='$filterUploadKe'";
			}
			if ($filterStatusUpload == 'All') {
				$filterStatusUploadQuery = '';
			} else {
				$filterStatusUploadQuery = " AND r.`status`='$filterStatusUpload'";
			}
			if ($filterKeterangan == 'All') {
				$filterKetUploadQuery = '';
			} elseif ($filterKeterangan == 'TMBNULL') {
				$filterKetUploadQuery = ' AND m.kodenik IS NULL ';
			} else {
				$filterKetUploadQuery = " AND r.`ketStatus` like '%$filterKeterangan%'";
			}

			$query = "SELECT  r.*, m.`kodenik` as mnik, COUNT(r.id) as countid 
					FROM refreshkaryawanhistory r 
					LEFT JOIN master_karyawan m
					ON m.`kodenik`=r.kodeNik  
					WHERE r.`bulan` = '3'
					AND r.`tahun`='2023' 
					$filterUploadKeQuery 
					$filterStatusUploadQuery 
					$filterKetUploadQuery
					AND r.id NOT IN (SELECT idSet FROM refreshkaryawanhistory 
									WHERE `bulan` = '3'
									AND `tahun`='2023' $filterSubUploadKe 
									AND idSet IS  NOT NULL ORDER BY idSet)  
									GROUP BY r.id";

			// var_dump($query);
			// exit();
			$exeQuery = $dbCon->execute($query);
			$getRows = $dbCon->getNumRows($exeQuery);

			$txt = "";
			if ($getRows == 0) {
				$keterangan = "";
			} else {
				$txtdata = [];
				while ($getDataObject = $dbCon->getArray($exeQuery)) {
					$txt = $txt . "reportrefreshkaryawan||" . $getDataObject['id'] . "|" . $getDataObject['status'] . "|" . $getDataObject['ketStatus'] . "|" . $getDataObject['kodeNik'] . "|" . $getDataObject['namaKry'] . "|" . $getDataObject['kodeDivisi'] . "|" . $getDataObject['kodeDept'] . "|" . $getDataObject['kodeArea'] . "|" . $getDataObject['kodeBagian'] . "|" . $getDataObject['kodeSubArea'] . "|" . $getDataObject['kodeRegion'] . "|" . $getDataObject['kodeLokasi'] . "|" . $getDataObject['jabatan'] . "|" . $getDataObject['statusKry'] . "|" . $getDataObject['ketStatusKry'] . "|" . $getDataObject['kodeMakan'] . "|" . dateindo($getDataObject['tglLahir']) . "|" . dateindo($getDataObject['tglCoba']) . "|" . dateindo($getDataObject['tglMasuk']) . "|" . dateindo($getDataObject['tglKeluar']) . "|" . dateindo($getDataObject['tglMasukJst']) . "|" . $getDataObject['plafonCuti'] . "|" . $getDataObject['jCutiAwal'] . "|" . $getDataObject['jCutiBulan'] . "|" . $getDataObject['qtyCutiSdbl'] . "|" . $getDataObject['bulan'] . "|" . $getDataObject['tahun'] . "|" . $getDataObject['uploadKe'] . "|" . $getDataObject['mnik'] . "|" . $getDataObject['countid'] . "|^";
				}
			}
			echo $txt . "!" . $getRows . "!" . $query;
		} catch (Exception $e) {
			var_dump($e->getTrace());
			$dbCon->execute("ROLLBACK");
		}
	}
	if ($mode == 'setUpdate') {
		try {
			$dbCon->execute("BEGIN");

			date_default_timezone_set("Asia/Jakarta");
			$tahungaji = $_POST["tahungaji"];
			$bulangaji = $_POST["bulangaji"];

			// echo $bulangaji . '+' . $tahungaji;
			// exit();

			if (substr($bulangaji, 1, 1) == "") $bulangaji = "0" . $bulangaji;
			$inID = substr($_POST['idSet'], 0, strlen($_POST['idSet']) - 1);
			$inID2 = rtrim($_POST['idSet'], ',');
			// echo $inID;
			// exit();
			$txtHK = "SELECT * FROM harikerja WHERE thn='2023' AND bln='3'";

			$queHK = $dbCon->execute($txtHK);
			$resHK = $dbCon->getArray($queHK);

			$tanggalAwal  = $resHK['tanggalAwal'];
			$tanggalAkhir = $resHK['tanggalAkhir'];
			$resHK = $dbCon->getArray($queHK);

			// echo $tanggalAwal . '|' . $tanggalAkhir;
			// exit();
			$query = "SELECT * FROM refreshkaryawanhistory r WHERE r.id IN ($inID)";
			// var_dump($query);
			// exit();
			$exeQuery = $dbCon->execute($query);
			$getRows = $dbCon->getNumRows($exeQuery);

			//var_dump($exeQuery);exit();
			// for($i=o;$i<=$getRows;$i++){

			// }
			foreach ($exeQuery as $dataHistory) {
				//var_dump($dataHistory['id']);exit();
				$idHistory 	= $dataHistory['id'];
				$kodenik	= $dataHistory['kodeNik'];
				$namakry	= $dataHistory['namaKry'];
				$kodedivisi	= $dataHistory['kodeDivisi'];
				$kodedept	= $dataHistory['kodeDept'];
				$kodearea	= $dataHistory['kodeArea'];
				$kodebagian	= $dataHistory['kodeBagian'];
				$jabatan	= $dataHistory['jabatan'];
				$tgllahir	= $dataHistory['tglLahir'];
				$tglmasuk	= $dataHistory['tglMasuk'];
				$tglkeluar	= $dataHistory['tglKeluar'];
				$plafoncuti	= $dataHistory['plafonCuti'];
				$keterangan	= "";

				//variable tambahan
				$kodeSubArea	= $dataHistory['kodeSubArea'];
				$kodeRegion		= $dataHistory['kodeRegion'];
				$kodeLokasi		= $dataHistory['kodeLokasi'];
				$statusKry		= $dataHistory['statusKry'];
				$ketStatusKry	= $dataHistory['ketStatusKry'];
				$kodeMakan		= $dataHistory['kodeMakan'];
				$tglCoba		= $dataHistory['tglCoba'];
				$tglMasukJst	= $dataHistory['tglMasukJst'];
				$jCutiAwal		= $dataHistory['jCutiAwal'];
				$jCutiBulan		= $dataHistory['jCutiBulan'];
				$qtyCutiSdbl	= $dataHistory['qtyCutiSdbl'];
				$uploadKe 		= $dataHistory['uploadKe'];

				//$variable=[$kodeSubArea,$kodeRegion,$kodeLokasi,$statusKry,$ketStatusKry,$kodeMakan,$tglCoba,$tglMasukJst,$jCutiAwal,$jCutiBulan,$qtyCutiSdbl];
				//var_dump($variable);exit();
				//var_dump(array($idHistory,$kodenik,$namakry,$kodedivisi);exit();

				if ($plafoncuti == "" or $plafoncuti < 1) {
					$plafoncuti = 0;
				}
				if (strlen($tgllahir) == "") {
					$tgllahirnew = "0000-00-00";
				} else {
					$tgllahirnew = $tgllahir;
				}
				if (strlen($tglmasuk) == "") {
					$tglmasuknew = "0000-00-00";
				} else {
					$tglmasuknew = $tglmasuk;
				}
				if (strlen($tglkeluar) == "") {
					$tglkeluarnew = "2030-12-31";
				} else {
					$tglkeluarnew = $tglkeluar;
				}
				//$debug=$tgllahirnew."|".$tglmasuknew."|".$tglkeluarnew;

				//var_dump($$debug);exit();
				$blnefektif	 = (floatval(substr($tglmasuknew, 0, 4)) * 12) + floatval(substr($tglmasuknew, 3, 2));

				//var_dump($blnefektif);exit();
				//tambahan rizki
				if (strlen($tglCoba) == "") {
					$tglCobaNew = "0000-00-00";
				} else {
					$tglCobaNew = dateluar($tglCoba, "-");
				}
				if (strlen($tglMasukJst) == "") {
					$tglMasukJstNew = "0000-00-00";
				} else {
					$tglMasukJstNew = dateluar($tglMasukJst, "-");
				}

				// $nikcek=''
				// if($tglkeluarnew < $tanggalAwal){
				// 	$nikcek.=$kodenik;
				// 	continue;
				// }

				$lastIdKry	= maxId("master_karyawan", "id", $dbCon);
				//var_dump($lastIdKry);exit();
				$txtInsDo 	= "INSERT INTO master_karyawan(id, kodenik, namakry,kodebagian,kodedept,jabatan,tglmasuk, cabangbank, rekbank, plafoncuti,tglkeluar,blnefektif,saldo_lalu,kodedivisi,kodearea,tgllahir)
							VALUES ('$lastIdKry','$kodenik','" . replacequote($namakry) . "', '$kodebagian', '$kodedept','" .  replacequote($jabatan) . "','$tglmasuknew','', '','$plafoncuti','$tglkeluarnew','$blnefektif','0','$kodedivisi','$kodearea', '$tgllahirnew')";

				// var_dump($txtInsDo);
				// exit();
				$hslIns 	= $dbCon->execute($txtInsDo);
				//keterangan
				$status 	= 'Sukses';
				$ketStatus	= 'Forced Entry / Tanggal Masuk Berbeda';



				//$updateHystory="UPDATE refreshkaryawanhistory SET `status`='$status',ketStatus='$ketStatus' WHERE id='$idHistory'";
				//var_dump($updateHystory);exit();
				//$hslUpdateHistory =$dbCon->execute($updateHystory);
				//$dbCon->execute("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 

				$insertHystory = "INSERT into refreshkaryawanhistory (kodenik,namakry,kodeDivisi,kodeDept,kodeArea,kodeBagian,kodeSubArea,kodeRegion,kodeLokasi,jabatan,statusKry,ketStatusKry,kodeMakan,tglLahir,tglCoba,tglMasuk,tglKeluar,tglMasukJst,plafonCuti,jCutiAwal,jCutiBulan,qtyCutiSdbl,dateUpload,bulan,tahun,`status`,ketStatus,uploadKe,idSet)VALUES('$kodenik','" . replacequote($namakry) . "','$kodedivisi','$kodedept','$kodearea','$kodebagian','$kodeSubArea','$kodeRegion','$kodeLokasi','" . replacequote($jabatan) . "','$statusKry','$ketStatusKry','$kodeMakan','$tgllahirnew','0000-00-00','$tglmasuknew','$tglkeluarnew','0000-00-00','$plafoncuti','$jCutiAwal','$jCutiBulan','$qtyCutiSdbl','" . date("Y-m-d H:i:s") . "','$bulangaji','$tahungaji','$status','$ketStatus','$uploadKe','$idHistory')";
				// var_dump($insertHystory);
				// exit();
				$hslInsertHistory = $dbCon->execute($insertHystory);

				$bulangajiA = $bulangaji;

				if (substr($bulangaji, 0, 1) == 0) {
					$bulangajiA = substr($bulangaji, 1, 1);
				}

				$hangus = "";
				if ($bulangajiA == '7') {
					//echo "jalan <br>";

					//get cutimasal tahun
					if (substr($kodenik, 0, 2) == "PA" || substr($kodenik, 0, 2) == "PB") {
						$kodeNikCari = substr($kodenik, 0, 2);
					} else {
						$kodeNikCari = '';
					}
					$resultCutiMasal = $dbCon->getArray($dbCon->execute("SELECT * FROM cutimasalpertahun WHERE thn='$tahungaji'  AND kodeNIK='$kodeNikCari'"));
					if ($resultCutiMasal['cutiMasal'] != "") {
						$cutiMasal = $resultCutiMasal['cutiMasal'];
					}

					//get nik gabung
					$getNikGabung = "SELECT namakry, GROUP_CONCAT(DISTINCT CONCAT(\"'\",kodenik,\"'\")) nikgabung FROM master_karyawan WHERE namakry='$namakry' AND tgllahir='$tgllahirnew'";
					//echo $getNikGabung;
					$qNikGabung = $dbCon->execute($getNikGabung);
					while ($dNikGabung = $dbCon->getArray($qNikGabung)) {
						$nikGabung = $dNikGabung['nikgabung'];
					}

					$bulanIni = ($tahungaji * 12) + $bulangajiA;
					$bulanLalu = $bulanIni - 1;

					$getSaldoCuti = "SELECT * FROM `status` WHERE nikkaryawan IN (" . $nikGabung . ") and bln_efektif = '" . $bulanLalu . "'ORDER BY id,bln_efektif ASC";
					//echo $getSaldoCuti;
					$qCuti = $dbCon->execute($getSaldoCuti);
					while ($dCuti = $dbCon->getArray($qCuti)) {
						$saldo_cuti = $dCuti['saldo_cuti'];
					}
					$cutiHangus = $saldo_cuti - (12 - $cutiMasal);

					if ($cutiHangus > 0) {
						$hangus = "Saldo Cuti Hangus " . $cutiHangus;
					} else {
						$hangus = "";
					}
				}
				if ($hangus != "") {
					$ketHangus = $hangus;
				} else {
					$ketHangus = "";
				}
				$keterangan = $keterangan . " " . $ketHangus;



				$txtCek2 = "SELECT * FROM karyawan_aktif WHERE nik='$kodenik' AND thngaji='$tahungaji' AND blngaji='$bulangaji' ";
				//echo $txtCek2;exit();
				$hslCek2 = $dbCon->execute($txtCek2);
				$jumCek2 = $dbCon->getNumRows($hslCek2);
				//var_dump($hslCek2) ;exit();
				if ($jumCek2 > 0) {
					$txtUpd2 = " UPDATE karyawan_aktif SET nik='$kodenik',namakry='" . replacequote($namakry) . "',tgllahir='$tgllahirnew',keterangan='$keterangan' WHERE nik='$kodenik' and thngaji='$tahungaji' and blngaji='$bulangajiA' ";
					//$hslUpd2=$dbCon->execute($txtUpd2);
					//echo 'if 1';exit();
				} else {
					//echo $tglkeluarnew .'|'.$tanggalAwal;exit();
					// if($tglkeluarnew > $tanggalAwal){ // insert ke karyawan_aktif jika tglkeluar > tglawal

					// 	//echo 'if if 2';	exit();
					// }
					$lastIdAktif = maxId("karyawan_aktif", "id", $dbCon);
					//$txtIns2.=" ('$lastIdAktif', '$kodenik', '$tahungaji', '$bulangajiA', '', '". replacequote($namakry)."', '$tgllahirnew'),";
					$txtInsDo2 = "INSERT INTO karyawan_aktif 	(id, nik, thngaji, blngaji, keterangan, namakry, tgllahir) VALUES ('$lastIdAktif', '$kodenik', '$tahungaji', '$bulangajiA', '$keterangan','" . replacequote($namakry) . "','$tgllahirnew')";
					$hslIns2 = $dbCon->execute($txtInsDo2);
				}
				//echo 'if tidak masuk';exit();
				// $lastIdAktif=maxIdGenerator2("karyawan_aktif", "id", $dbCon);
				// //$txtIns2.=" ('$lastIdAktif', '$kodenik', '$tahungaji', '$bulangajiA', '', '". replacequote($namakry)."', '$tgllahirnew'),";
				// $txtInsDo2="INSERT INTO karyawan_aktif 	(id, nik, thngaji, blngaji, keterangan, namakry, tgllahir) VALUES ('$lastIdAktif', '$kodenik', '$tahungaji', '$bulangajiA', '$keterangan','".replacequote($namakry)."','$tgllahirnew')";
				// $hslIns2=$dbCon->execute($txtInsDo2);	
				//end copy
				# code...
			}
			//var_dump($getRows);exit();

			$dbCon->execute("COMMIT");
			echo "Data Karyawan Berhasil Direfresh!";
		} catch (Exception $e) {
			var_dump($e->getTrace());
			$dbCon->execute("ROLLBACK");
		}
	}
}


//comment function maxIdGenerator bila sudah ada di file function 
//function maxIdGenerator2($tabel,$field,$dbCon){
// try{
//  //update dulu id di tabel idcounter(increment 1)
//	  $dbCon->execute("update idcounter set lastid=lastid+1 where tableName='".$tabel."'");
//	  $kueri=$dbCon->execute("select lastid as maxId from idcounter where tableName='".$tabel."'");
//	  $res=$dbCon->getRow($kueri);
//	 // var_dump($res);exit();
//	  $jml=$dbCon->getNumRows($kueri);
//	  if($jml==0){
//	   $dbCon->execute("insert into idcounter values('".$tabel."','1')");
//	   $maxId="1";
//	   }
//	  else{
//	   $maxId=$res[0];
//	   }
//	  return $maxId;
//	 }
//	 catch(Exception $e){
//	  var_dump($e->getTrace());
//	 }
//}
//end comment maxIdGenerator


function pageNavMulti($curHal, $maxHal, $jmlTampil, $fungsi)
{
	$linkHal = '';
	$angka = '';
	$halTengah = round($jmlTampil / 2);
	if ($maxHal > 1) {
		if ($curHal > 1) {
			$previous = $curHal - 1;
			$linkHal = $linkHal . "<a class='nextprev' onclick='" . $fungsi . "(1)'> First</a> &nbsp";
			$linkHal = $linkHal . " <a class='nextprev' onclick='" . $fungsi . "($previous)'> Prev</a> &nbsp";
		} elseif (empty($curHal) || $curHal == 1) {
			$linkHal = $linkHal . "<a class='nextprev'>First</a><a class='nextprev'> Prev </a> ";
		}

		for ($i = $curHal - ($halTengah - 1); $i < $curHal; $i++) {
			if ($i < 1)
				continue;
			$angka .= "<a class='num' onclick='" . $fungsi . "($i)'>$i</a> ";
		}

		$angka .= "<span class='current'><b >$curHal</b> </span>";
		for ($i = $curHal + 1; $i < ($curHal + $halTengah); $i++) {
			if ($i > $maxHal)
				break;
			$angka .= "<a class='num' onclick='" . $fungsi . "($i)'>$i</a> ";
		}

		$linkHal = $linkHal . $angka;

		if ($curHal < $maxHal) {
			$next = $curHal + 1;
			$linkHal = $linkHal . " <a class='nextprev'onclick='" . $fungsi . "($next)'>Next </a>&nbsp;&nbsp;<a class='nextprev' onclick='" . $fungsi . "($maxHal)'>Last</a> ";
		} else {
			$linkHal = $linkHal . " <a class='nextprev'>Next</a><a class='nextprev'>Last</a> ";
		}
	}
	return $linkHal;
}
 
//aktifkan jika kirim server
// function monthRome($nomorbulan){
//  $rome_bulan = array(1=>"I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
//  $hasilbulan=$rome_bulan[$nomorbulan];
//  return $hasilbulan;
// }

//aktifkan monthRome
// function monthRome($nomorbulan){
// 	$rome_bulan = array(1=>"I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
// 	$hasilbulan=$rome_bulan[$nomorbulan];
// 	return $hasilbulan;
// }
