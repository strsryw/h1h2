<?php
include ("../functions/function.php");
include ("../functions/Spreadsheet/Excel/Writer.php");
//include ("../functions/Spreadsheet/Excel/excel_reader2.php");
$data 		= $_POST['buffer'];
//var_export($data);exit();


$periodeBulan	= $_POST['bulan'];		
$periodeTahun	= $_POST['tahun'];		
$filterUploadKe	= $_POST['filterUploadKe'];		
$filterStatusUpload	= $_POST['filterStatusUpload'];		
//var_dump($filterUploadKe);exit();
//$bulangaji0	= namaBulan($bulangaji);
// $statusUpload	= $_POST['statusUpload'];
// $cabang	= $_POST['cabang'];
// if($statusUpload==""){
// 	$status="";
// }elseif($statusUpload=="0"){
// 	$status="Cabang Belum Upload";
// 	$tglUpload="";
// }else{
// 	$status="Cabang Sudah Upload";
// 	$tglUpload=dateindo($result[tglUpload]);
// }
// $finger		=$_POST['finger'];
// if($finger!="0"){
// 	if($finger=="1"){
// 		$nama= "-fingerprint";
// 		$judul= "KARYAWAN FINGERPRINT";
// 	}elseif($finger=="2"){
// 		$nama= "-non-fingerprint";
// 		$judul= "KARYAWAN NON FINGERPRINT";
// 	}
// }else{
// 	$judul= "";
// }
// $judul= "Cabang ".$status;
//	Start Excel
	$xls = new Spreadsheet_Excel_Writer();
	//$xls = new Spreadsheet_Excel_Reader();

	$xls->send("report-upload-refreshkaryawan-$periodeBulan-$periodeTahun.xls");

	$fTt = $xls->addFormat();
	$fTt->setBold();
	
	$fTt->setVAlign('vcenter');
	$fTt->setHAlign('left');
//var_dump($fTt->setBold());exit();
//	Format Header
	$fHd= $xls->addFormat();
	$fHd->setBorder(1);
	$fHd->setBold();
	$fHd->setVAlign('vcenter');
	$fHd->setHAlign('center');
	$fHd->setTextWrap(1);
	$fHd->setSize(9);
	//var_dump($fHd->setBold());exit();
//	Format List Left
	$fLL= $xls->addFormat();
	$fLL->setBorder(1);
	$fLL->setVAlign('top');
	$fLL->setHAlign('left');
	$fLL->setTextWrap(1);
	$fLL->setSize(8);
//	Format List Right
	$fLR= $xls->addFormat();
	$fLR->setBorder(1);
	$fLR->setVAlign('top');
	$fLR->setHAlign('right');
	$fLR->setNumFormat(3);
	$fLR->setSize(8);
//	$fLR->setLocked();
//	Format List Center
	$fLC= $xls->addFormat();
	$fLC->setBorder(1);
	$fLC->setVAlign('top');
	$fLC->setHAlign('center');
	$fLC->setSize(8);
//	Format Total
	$fT= $xls->addFormat();
	$fT->setBorder(1);
	$fT->setVAlign('vcenter');
	$fT->setHAlign('right');
	$fT->setNumFormat(3);
	$fT->setSize(8);
//	Format Keterangan
	$fK= $xls->addFormat();
	$fK->setVAlign('vcenter');
	$fK->setHAlign('left');
	$fK->setSize(8);
//	Format Footer
	$fFt= $xls->addFormat();
	$fFt->setVAlign('vcenter');
	$fFt->setHAlign('right');
	$fFt->setSize(8);
	
	$sheet = $xls->addWorksheet('refreshkaryawan');
	$sheet->setPaper(5); // legal
	$sheet->setLandscape();
	//$sheet->setPortrait();
	$sheet->setMarginLeft(0.5);
	$sheet->setMarginRight(2);
	$sheet->setMarginTop(0.5);
	$sheet->setMarginBottom(0.5);
	$sheet->centerHorizontally(1);
	$sheet->fitToPages(1,'');
//	$sheet->setColumn(baris, kolom, lebar)

	$sheet->setColumn(0,0,12);	
	$sheet->setColumn(0,1,25);
	$sheet->setColumn(0,2,15);	
	$sheet->setColumn(0,3,25);
	$sheet->setColumn(0,4,15);
	$sheet->setColumn(0,5,15);
	$sheet->setColumn(0,6,15);	
	$sheet->setColumn(0,7,15);
	$sheet->setColumn(0,8,15);	
	$sheet->setColumn(0,9,15);
	$sheet->setColumn(0,10,15);	
	$sheet->setColumn(0,11,15);
	$sheet->setColumn(0,12,15);	
	$sheet->setColumn(0,13,25);	
	$sheet->setColumn(0,14,7);	
	$sheet->setColumn(0,15,17);
	$sheet->setColumn(0,16,17);
	$sheet->setColumn(0,17,17);	
	$sheet->setColumn(0,18,17);
	$sheet->setColumn(0,19,17);	
	$sheet->setColumn(0,20,7);	
	$sheet->setColumn(0,21,7);	
	$sheet->setColumn(0,22,7);
	$sheet->setColumn(0,23,7);
	$sheet->setColumn(0,23,7);
	$sheet->setColumn(0,24,7);
	$sheet->setColumn(0,25,7);
	$sheet->setColumn(0,26,7);
	$sheet->setColumn(0,27,7);
	
	

//	$sheet->write(baris, kolom, text, format)
//	$sheet->mergeCells(awalBaris,awalKolom,akhirBaris,akhirKolom);
	$baris=0;
	$lastCol=26;
	$sheet->write($baris, 0, "LAPORAN UPLOAD REFRESH KARYAWAN", $fTt);
	//$sheet->mergeCells($baris,0,0,$lastCol);
	
	// if($finger!="0"){
	// 	$baris=1;
	// 	$sheet->write($baris, 0, $judul, $fTt);
	// 	$sheet->mergeCells($baris,0,$baris,$lastCol);
	// }else{
	// 	$baris=0;
	// }
	//if($kodedivisi!=""){
//		$divisi= "DIVISI: ".$kodedivisi;
//		$baris=$baris+1;
//		$sheet->write($baris, 0, $divisi, $fTt);
//		$sheet->mergeCells($baris,0,$baris,$lastCol);
//	}
//	if($kodedept!=""){
//		$departemen= "DEPARTEMEN: ".$kodedept;
//		$baris=$baris+1;
//		$sheet->write($baris, 0, $departemen, $fTt);
//		$sheet->mergeCells($baris,0,$baris,$lastCol);
//	}
//	if($kodearea!=""){
//		$area= "AREA: ".$kodearea;
//		$baris=$baris+1;
//		$sheet->write($baris, 0, $area, $fTt);
//		$sheet->mergeCells($baris,0,$baris,$lastCol);
//	}
//	if($kodebagian!=""){
//		$bagian= "BAGIAN: ".$kodebagian;
//		$baris=$baris+1;
//		$sheet->write($baris, 0, $bagian, $fTt);
//		$sheet->mergeCells($baris,0,$baris,$lastCol);
//	}
	// "Status","Ket. Status","nik","nama kry","kode div","kode dept","kode area","kode bagian","kode subarea","kode region","kode lokasi","jabatan","status kry","ket status kry","kode makan","tgl Lahir","tgl coba","tgl masuk","tgl keluar","tgl masuk jst","plafoncuti","j cuti awal","j cuti bulan","qty cuti sdbl","bulan","tahun","Upload Ke"
	$sheet->write($baris+1, 0, "Periode          : ".$periodeBulan." - ".$periodeTahun, $fK);
	// $sheet->mergeCells($baris+2,0,$baris+1,$lastCol);
	$sheet->write($baris+2, 0, "Upload Ke     : ".$filterUploadKe, $fK);
	// $sheet->mergeCells($baris+4,0,$baris+2,$lastCol);
	$sheet->write($baris+3, 0, "Status           : ".$filterStatusUpload, $fK);
	$baris=$baris+5;

	$sheet->write($baris, 0, "Status", $fHd);
	$sheet->write($baris, 1, "Ket. Status", $fHd);
	$sheet->write($baris, 2, "Kode Nik", $fHd);
	$sheet->write($baris, 3, "Nama Kry", $fHd);
	$sheet->write($baris, 4, "Kode Div", $fHd);
	$sheet->write($baris, 5, "Kode Dept.", $fHd);
	$sheet->write($baris, 6, "Kode Area", $fHd);
	$sheet->write($baris, 7, "Kode Bagian", $fHd);
	$sheet->write($baris, 8, "Kode Subarea", $fHd);
	$sheet->write($baris, 9, "Kode Region", $fHd);
	$sheet->write($baris, 10, "Kode Lokasi", $fHd);
	$sheet->write($baris, 11, "Jabatan", $fHd);
	$sheet->write($baris, 12, "Status Kry", $fHd);
	$sheet->write($baris, 13, "Ket Status Kry", $fHd);
	$sheet->write($baris, 14, "Kode Makan", $fHd);
	$sheet->write($baris, 15, "Tgl Lahir", $fHd);
	$sheet->write($baris, 16, "Tgl Coba", $fHd);
	$sheet->write($baris, 17, "Tgl Masuk", $fHd);
	$sheet->write($baris, 18, "Tgl Keluar", $fHd);
	$sheet->write($baris, 19, "Tgl Masuk Jst", $fHd);
	$sheet->write($baris, 20, "PlafonCuti", $fHd);
	$sheet->write($baris, 21, "J Cuti Awal", $fHd);
	$sheet->write($baris, 22, "J Cuti Bulan", $fHd);
	$sheet->write($baris, 23, "Qty Cuti Sdbl", $fHd);
	$sheet->write($baris, 24, "Bulan ", $fHd);
	$sheet->write($baris, 25, "Tahun", $fHd);
	$sheet->write($baris, 26, "Upload Ke", $fHd);

	
	

	$baris=$baris+1;
	$no=1;
	// for($n=0;$n<80;$n++){
	// 	for($k=0;$k<1;$k++){$sheet->write($baris, $k, "Data".$n.'-'.$k, $fHd);}
	
	// 	$baris++;
	// }
		
	while (!strrpos($data,"^")===false){
		$iValue= substr($data,0,strpos($data,"^"));
		if (substr(strrev($iValue),0,4)<>"|||"){
			$iValue=$iValue."|||";
		}
		else{$iValue=$iValue;}
		$data= substr($data, strpos($data,"^")+1,strlen($data));
		$tablename = trim(getColumnValue($iValue, 1));
		if(trim($tablename)=="reportrefreshkaryawan") {
			$i=0;

			while(!strrpos($iValue,"|")===false){
				$lenIValue=(int) strlen($iValue);
				$cValue=substr($iValue,0,strpos($iValue,"|"));
				//var_dump($cValue);
				$iValue=substr($iValue,strpos($iValue,"|")+1,strlen($iValue));
				// if ($i==1) { $status=$cValue; }
				// if ($i==2) { $ketStatus=$cValue; }
				// if ($i==3) { $kodeNik=$cValue; }
				// if ($i==4) { $namaKry=$cValue; }
				// if ($i==5) { $kodeDiv=$cValue; }
				// if ($i==6) { $kodeDept=$cValue; }
				// if ($i==7) { $kodeArea=$cValue;}
				// if ($i==8) { $kodeBagian=$cValue; }
				// if ($i==9) { $kodeSubarea=$cValue; }
				// if ($i==10){ $kodeRegion=$cValue; }
				// if ($i==11){ $kodeLokasi=$cValue; }
				// if ($i==12){ $jabatan=$cValue; }
				// if ($i==13){ $statusKry=$cValue; }
				// if ($i==14){ $ketStatusKry=$cValue; }
				// if ($i==15){ $kodeMakan=$cValue; }
				// if ($i==16){ $tglLahir=$cValue; }
				// if ($i==17){ $tglCoba=$cValue; }
				// if ($i==18){ $tglMasuk=$cValue; }
				// if ($i==19){ $tglKeluar=$cValue; }
				// if ($i==20){ $tglMasukJs=$cValue; }
				// if ($i==21){ $plafoncuti=$cValue; }
				// if ($i==22){ $jCutiAwal=$cValue; }
				// if ($i==23){ $jCutiBulan=$cValue; }
				// if ($i==24){ $qtyCutiSdbl=$cValue; }
				// if ($i==25){ $bulan=$cValue; }
				// if ($i==26){ $tahun=$cValue; }
				// if ($i==27){ $uploadKe=$cValue; }
				if ($i==3) { $status=$cValue; }
				if ($i==4) { $ketStatus=$cValue; }
				if ($i==5) { $kodeNik=$cValue; }
				if ($i==6) { $namaKry=$cValue; }
				if ($i==7) { $kodeDiv=$cValue; }
				if ($i==8) { $kodeDept=$cValue; }
				if ($i==9) { $kodeArea=$cValue;}
				if ($i==10) { $kodeBagian=$cValue; }
				if ($i==11) { $kodeSubarea=$cValue; }
				if ($i==12){ $kodeRegion=$cValue; }
				if ($i==13){ $kodeLokasi=$cValue; }
				if ($i==14){ $jabatan=$cValue; }
				if ($i==15){ $statusKry=$cValue; }
				if ($i==16){ $ketStatusKry=$cValue; }
				if ($i==17){ $kodeMakan=$cValue; }
				if ($i==18){ $tglLahir=$cValue; }
				if ($i==19){ $tglCoba=$cValue; }
				if ($i==20){ $tglMasuk=$cValue; }
				if ($i==21){ $tglKeluar=$cValue; }
				if ($i==22){ $tglMasukJs=$cValue; }
				if ($i==23){ $plafoncuti=$cValue; }
				if ($i==24){ $jCutiAwal=$cValue; }
				if ($i==25){ $jCutiBulan=$cValue; }
				if ($i==26){ $qtyCutiSdbl=$cValue; }
				if ($i==27){ $bulan=$cValue; }
				if ($i==28){ $tahun=$cValue; }
				if ($i==29){ $uploadKe=$cValue; }
				
				$i++;
			}
			//exit();
			// if($baris>=8 ){break;}
			$sheet->write($baris, 0, $status, $fLC);
			$sheet->write($baris, 1, $ketStatus, $fLC);
			$sheet->write($baris, 2, $kodeNik, $fLC);
			$sheet->write($baris, 3, $namaKry, $fLL);
			$sheet->write($baris, 4, $kodeDiv, $fLC);
			$sheet->write($baris, 5, $kodeDept, $fLC);
			$sheet->write($baris, 6, $kodeArea, $fLC);
			$sheet->write($baris, 7, $kodeBagian, $fLC);
			$sheet->write($baris, 8, $kodeSubarea, $fLC);
			$sheet->write($baris, 9, $kodeRegion, $fLC);
			$sheet->write($baris, 10, $kodeLokasi, $fLC);
			$sheet->write($baris, 11, $jabatan, $fLC);
			$sheet->write($baris, 12, $statusKry, $fLC);
			$sheet->write($baris, 13, $ketStatusKry, $fLC);
			$sheet->write($baris, 14, $kodeMakan, $fLC);
			$sheet->write($baris, 15, $tglLahir, $fLC);
			$sheet->write($baris, 16, $tglCoba, $fLC);
			$sheet->write($baris, 17, $tglMasuk, $fLC);
			$sheet->write($baris, 18, $tglKeluar, $fLC);
			$sheet->write($baris, 19, $tglMasukJs, $fLC);
			$sheet->write($baris, 20, $plafoncuti, $fLC);
			$sheet->write($baris, 21, $jCutiAwal, $fLC);
			$sheet->write($baris, 22, $jCutiBulan, $fLC);
			$sheet->write($baris, 23, $qtyCutiSdbl, $fLC);
			$sheet->write($baris, 24, $bulan, $fLC);
			$sheet->write($baris, 25, $tahun, $fLC);
			$sheet->write($baris, 26, $uploadKe, $fLC);
			//var_dump($angka);exit();
			
			//if ($baris==22){break;}
			//$sheet->write($baris, 4, , $fLC);
			/*$sheet->write($baris, 25, $saldo_cuti_tambahan, $fLC);*/
			//$sheet->write($baris, 5, $keterangan, $fLL);
			/*$sheet->write($baris, 27, $kelebihanhari, $fLC);*/
			
			$baris++;
			$no++;
		}
	}

	//$sheet->write($baris+6, $lastCol, "Dicetak Tanggal : ".date('d-M-Y'), $fFt);
	$xls->close();
	exit;
?>