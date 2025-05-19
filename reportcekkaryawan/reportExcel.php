<?php
include ("../functions/function.php");
include ("../functions/Spreadsheet/Excel/Writer.php");
$data 		= $_POST['buffer'];
$bulangaji	= $_POST['bulangaji'];
$tahungaji	= $_POST['tahungaji'];
//	Start Excel
	$xls = new Spreadsheet_Excel_Writer();
	$xls->send("Check-Karyawan-Aktif-".namaBulan($bulangaji)."-$tahungaji.xls");
	$fTt = $xls->addFormat();
	$fTt->setBold();
	$fTt->setVAlign('vcenter');
	$fTt->setHAlign('center');
//	Format Header
	$fHd= $xls->addFormat();
	$fHd->setBorder(1);
	$fHd->setBold();
	$fHd->setVAlign('vcenter');
	$fHd->setHAlign('center');
	$fHd->setTextWrap(1);
	$fHd->setSize(9);
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
//	Format Footer
	$fFt= $xls->addFormat();
	$fFt->setHAlign('right');
	$sheet = $xls->addWorksheet('Check_Karyawan_Aktif');
	$sheet->setPaper(5); // legal
	//$sheet->setLand6cape();
	$sheet->setPortrait();
	$sheet->setMarginLeft(0.5);
	$sheet->setMarginRight(0.5);
	$sheet->setMarginTop(0.5);
	$sheet->setMarginBottom(2);
	$sheet->centerHorizontally(1);
	$sheet->fitToPages(1,'');

//	$sheet->setColumn(baris, kolom, lebar)
	$sheet->setColumn(0,0,5);	$sheet->setColumn(0,1,10);			
	$sheet->setColumn(0,2,40);	$sheet->setColumn(0,3,15);			
	$sheet->setColumn(0,7,15);				
	
	$baris=0;
	$lastCol=7;
//	$sheet->write(baris, kolom, text, format)
	$sheet->write($baris, 0, "LAPORAN CHECK KARYAWAN AKTIF", $fTt);
	$sheet->write(1, 0, "Periode: ".namaBulan($bulangaji)." ".$tahungaji, $fTt);
//	$sheet->mergeCells(awalBaris,awalKolom,akhirBaris,akhirKolom);
	$sheet->mergeCells(0,0,0,7);
	$sheet->mergeCells(1,0,1,7);
	$sheet->mergeCells(2,0,2,7);

	$baris=3;
	$sheet->write($baris, 0, "No", $fHd);
	$sheet->write($baris, 1, "NIK", $fHd);
	$sheet->write($baris, 2, "Nama Karyawan", $fHd);
	$sheet->write($baris, 3, "Dalam Kota", $fHd);
	$sheet->write($baris, 4, "Alpha", $fHd);
	$sheet->write($baris, 5, "Cuti", $fHd);
	$sheet->write($baris, 6, "Ijin", $fHd);
	$sheet->write($baris, 7, "Sakit", $fHd);
	
	$baris=4;
	$no=1;
	while (!strrpos($data,"^")===false){
		$iValue= substr($data,0,strpos($data,"^"));
		if (substr(strrev($iValue),0,5)<>"|||"){
			$iValue=$iValue."|||";
		}
		else{$iValue=$iValue;}
		$data= substr($data, strpos($data,"^")+1,strlen($data));
		$tablename = trim(getColumnValue($iValue, 1));
		if(trim($tablename)=="reportabsensi") {
			$i=0;
			while(!strrpos($iValue,"|")===false){
				$lenIValue=(int) strlen($iValue);
				$cValue=substr($iValue,0,strpos($iValue,"|"));
				$iValue=substr($iValue,strpos($iValue,"|")+1,strlen($iValue));
				if ($i==1) { $nik=$cValue; }
				if ($i==2) { $nama=$cValue; }
				if ($i==3) { $dalamkota=$cValue; }
				if ($i==4) { $alpha=$cValue; }
				if ($i==5) { $cuti=$cValue; }
				if ($i==6) { $ijin=$cValue; }
				if ($i==7) { $sakit=$cValue; }
				
				$i++;
			}
			$sheet->write($baris, 0, $no, $fLC);
			$sheet->write($baris, 1, $nik, $fLL);
			$sheet->write($baris, 2, $nama, $fLL);
			$sheet->write($baris, 3, $dalamkota, $fLL);
			$sheet->write($baris, 4, $alpha, $fLL);
			$sheet->write($baris, 5, $cuti, $fLL);
			$sheet->write($baris, 6, $ijin, $fLL);
			$sheet->write($baris, 7, $sakit, $fLL);
			
			$baris++;
			$no++;
			
		}
	}
	
	$sheet->setRow($baris, 25);
	$sheet->write($baris, 0, "", $fLC);
	$sheet->write($baris, 1, "", $fT);
	$sheet->write($baris, 2, "", $fLC);
	$sheet->write($baris, 3, "", $fLC);
	$sheet->write($baris, 4, "", $fLC);
	$sheet->write($baris, 5, "", $fLC);
	$sheet->write($baris, 6, "", $fLC);
	$sheet->write($baris, 7, "", $fLC);
	
	$sheet->write($baris+2, $lastCol, "Dicetak Tanggal : ".date('d-M-Y') ,$fFt);
	$xls->close();
	exit;
?>