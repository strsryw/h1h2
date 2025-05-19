<?php
ini_set('memory_limit', '1024M');
include("../asset/PHPExcel/PHPExcel.php");

include("../asset/function.php");


error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

$excel = new PHPExcel();

$excel->setActiveSheetIndex(0);
$worksheet = $excel->getActiveSheet();

$namaFile = "Laporan Excel";



$excel->getProperties()->setCreator("EDP")
	->setLastModifiedBy("EDP")
	->setTitle($namaFile)
	->setSubject($namaFile)
	->setDescription($namaFile)
	->setKeywords($namaFile)
	->setCategory("Laporan Excel");

// merubah style border pada cell yang aktif (cell yang terisi)
$styleArray = array(
	'borders' =>
	array(
		'allborders' =>
		array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '00000000'),
		),
	),
);

// melakukan pengaturan pada header kolom
$fontHeader = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		'rotation'   => 0,
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,

	)
);
$fontHeaderC = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		'rotation'   => 0,
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,

	)
);

// mengatur font list right dengan border

$FLR = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		'rotation'   => 0,
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,

	)
);
// mengatur font list left
$FLL = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		'rotation'   => 0,
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
	)
);
// mengatur font list center dengan border
$FLC = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		'rotation'   => 0,
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
	)
);

$FLr = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		'rotation'   => 0,
	),
);





//Mengatur lebar cell pada document excel
/*$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);*/



// nama dari sheet yang aktif 
$worksheet->setTitle('Laporan Excel');
//$worksheet->mergeCells('A1:F1');
//$worksheet->mergeCells('A2:F2');



//setting Header
$baris = 1;
$txt = $_POST['txtExcel'];
// echo $txt;
// exit();
$jmlKolom = 0;
$columnDimension = array();
$pecah1 = explode("^", $txt);
$k = 0;
foreach ($pecah1 as $pch1) {
	$pecah = explode("|", $pch1);
	if ($jmlKolom == 0) {
		$jmlKolom = count($pecah);
	}

	/*if($k==0){echo "header<br>";}
	if($k==1){echo "isi<br>";}*/
	$n = 0;
	foreach ($pecah as $pch) {
		if (strlen($pch) > intval($columnDimension[$n])) {
			$columnDimension[$n] = strlen($pch);
		}
		$worksheet->SetCellValue(num2alpha($n) . $baris . '', $pch);

		$n = $n + 1;
	}
	$baris++;

	$k++;
	//if($baris==1000){break;}
}

for ($j = 0; $j < $jmlKolom; $j++) {
	$excel->getActiveSheet()->getColumnDimension(num2alpha($j))->setWidth($columnDimension[$j] * 2);
}

//	$worksheet->getStyle('A1:F10')->applyFromArray($FLL);



$worksheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$worksheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$worksheet->getPageMargins()->setTop(1);
$worksheet->getPageMargins()->setRight(0.5);
$worksheet->getPageMargins()->setLeft(0.5);
$worksheet->getPageMargins()->setBottom(0.5);
$worksheet->getPageSetup()->setHorizontalCentered(true);
$worksheet->getPageSetup()->setPrintArea('A1:' . num2alpha($n - 1) . $baris . '');
$worksheet->getPageSetup()->setFitToPage(true);

// simpan file excel dengan form;at .xls
$filename = trim($namaFile . ".xls");

ob_end_clean();
//	
//		header('Content-Type: application/vnd.ms-excel');
//		header('Content-Disposition: attachment;filename="'.$filename.'"');
//		header('Cache-Control: max-age=0');
//	
//		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
//		if (ob_get_length() > 0) { ob_end_clean(); } 
//		
//		
//		$objWriter->save('php://output');
//		
//				
//		exit;
// Redirect output to a client's web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
if (ob_get_length() > 0) {
	ob_end_clean();
}
$objWriter->save('php://output');
exit();
