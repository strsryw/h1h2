<?php
include ("../functions/function.php");
$data 		= $_POST['buffer'];
$bulangaji	= $_POST['bulangaji'];
$tahungaji	= $_POST['tahungaji'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Check Rekap Absensi</title>
<link type="text/css" href="../functions/style.css" rel="stylesheet" />
<style type="text/css">
#container{ width:710px; margin:0 auto}
.tabel,.tabel td {border:1px solid black;border-collapse:collapse}
.tabel thead td{ font-weight:700}
.tabel tbody td{ padding-top:6px; padding-bottom:6px;vertical-align:top;}
.padleft{ text-align:left; padding-left:2px;}
body { background-image:none !important;background-color:#FFF!important;}
</style>
</head>
<body>
<div id="container">
<table width="700" border="0" align="center" cellspacing="0" cellpadding="0">
	<tr><th valign="middle" style="padding:20px 0">LAPORAN CHECK REKAP ABSENSI<br />
		Periode: <?php echo namaBulan($bulangaji)." ".$tahungaji; ?></th>
	</tr>
</table>
<table width="700" border="0" align="center" cellspacing="0" cellpadding="0" class="tabel">
	<thead>
	<tr valign="middle" align="center">
		<td width="40" height="40" align="center">No</td>
		<td width="100" align="center">NIK</td>
		<td width="200" align="center">Nama Karyawan</td>
		<td width="90" align="center">Rekap Absen</td>
		<td width="90" align="center">Non Finger</td>
		<td width="90" align="center">Penyimpangan</td>
		
    </tr>
	</thead>
	<tfoot>
	<tr><td align="center">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
	</tfoot>
	<tbody>
<?php
	$no=1;
	while (!strrpos($data,"^")===false){
		$iValue= substr($data,0,strpos($data,"^"));
		if (substr(strrev($iValue),0,4)<>"|||"){
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
				if ($i==3) { $rekapabsen=$cValue; }
				if ($i==4) { $nonfinger=$cValue; }
				if ($i==5) { $penyimpangan=$cValue; }
				$i++;
			}
?>
	<tr align="center">
		<td><?php echo $no; ?></td>
		<td class="padleft"><?php echo $nik; ?></td>
		<td class="padleft"><?php echo $nama; ?></td>
		<td><?php echo $rekapabsen; ?></td>
		<td><?php echo $nonfinger; ?></td>
		<td><?php echo $penyimpangan; ?></td>
		
	</tr>
<?php
			$no++;
		}
	}
?>
	</tbody>
</table><br/>
<div style="clear:both"></div>
</div>
</body>
</html>