<?php
include("../functions/koneksi.php");
// include("../functions/session.php");
include("../functions/function.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Check Karyawan Aktif</title>
<link type="text/css" href="../base/aw.css" rel="stylesheet" />
<link type="text/css" href="../functions/style.css" rel="stylesheet" />
<link type="text/css" href="../functions/jquery/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
<style type="text/css">
#gridReportAbsensi .aw-header-0 .aw-column-0, #gridReportAbsensi .aw-header-0 .aw-column-1,#gridReportAbsensi .aw-header-0 .aw-column-2,#gridReportAbsensi .aw-header-0 .aw-column-3{ text-align:center}
.aw-column-0 {width:150px; text-align:left}
.aw-column-1 {width:300px; text-align:left}
.aw-column-2 {width:130px; text-align:center}
.aw-column-3 {width:130px; text-align:center}
.aw-column-4 {width:130px; text-align:center}
.aw-column-5 {width:130px; text-align:center}
.aw-column-6 {width:130px; text-align:center}
table tr td { height:25px; }
</style>
<script type="text/javascript">parent.document.title=document.title;</script>
<script type="text/javascript" src="../base/aw.js"></script>
<script type="text/javascript" src="../base/functions.js"></script>
<!-- <script type="text/javascript" src="../functions/jQuery/js/jquery-ui-1.8.2.custom.min.js"></script>  -->
<script type="text/javascript" src="../functions/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="../functions/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="h1.js"></script>
</head>
<div id="loading" style="display:none">Loading...</div>
<body class="body">
<!-- <?php include('../header.php'); ?> -->
<h3>Laporan Check Karyawan Aktif</h3>
<form name="h1form" action="" method="post">
	<table width="" border="0" cellpadding="0"  cellspacing="0" id="masterreportabsensi">
		<tr><td width="110"><label>Periode</label></td>
			<td colspan="3">: <?php inp_bulan('bulangaji'); ?><?php inp_tahun('tahungaji'); ?></td>
		</tr>
		<tr><td><label>Nama Karyawan</label></td>
			<td>: <input name="namakry" /></td>
		</tr>
		<tr><td><label>Kode NIK</label></td>
			<td>: <input name="kodenik" /></td>
		</tr>
		<tr><td><label>Status</label></td>
			  <td>:
          	<select name="status" id="status">
              <option value="all" selected="selected">Tampilkan Semua</option>
              <option value="null">Tidak Ada di Transaksi</option>
            </select>
        </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;<input type="button" value="Cari Data" name="Ambil" onClick="cariData('srch')" /></td>
		</tr>
	</table>
	<!--<div id="linkHal" style="height:18px; font-weight:bold; display:block;"></div>
	<label id="maxHal" style="display:none"></label>-->
	<script type='text/javascript'>
		var gridReportAbsensi = new AW.UI.Grid;
		gridReportAbsensi.setId("gridReportAbsensi");
		gridReportAbsensi.setSize(1125, 400);
		gridReportAbsensi.setHeaderHeight(25);
		gridReportAbsensi.setHeaderText(["NIK", 
		"Nama Karyawan", "Dalam Kota", "Alpha", "Cuti", "Ijin", "Sakit"]);
		gridReportAbsensi.setColumnIndices([0,1,2,3,4,5,6]);
		gridReportAbsensi.setColumnCount(gridReportAbsensi.getColumnIndices().length);
		gridReportAbsensi.setColumnResizable(false);
		gridReportAbsensi.setCellEditable(false);
		gridReportAbsensi.defineRowProperty("background", function(row){
		var a = this.getCellValue(7, row);
		var b = this.getCellValue(8, row);
		return a == 1 || b == 1 ? "#FA8072" : "#fff";
		});

		gridReportAbsensi.getRowTemplate().setStyle("background", function(){
			return this.getRowProperty("background");
		});
		
		document.write(gridReportAbsensi);
	</script>
	<br />
	<input type="button" value="Cetak Laporan" name="Cetak" onClick="cetakLap()" />
	<input type="button" value="Cetak Excel" name="CetakX" onClick="cetakLap('excel')" />
	<textarea name="buffer" cols="50" rows="10" class="textBuff"></textarea>
	<textarea name="bufferhelper" cols="50" rows="10" class="textBuff"></textarea>
</form>
</body>
</html>