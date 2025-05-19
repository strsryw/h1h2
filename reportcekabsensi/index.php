<?php
include("../functions/koneksi.php");
// include("../functions/session.php");
include("../functions/function.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Laporan Check Rekap Absensi </title>
	<link type="text/css" href="../base/aw.css" rel="stylesheet" />
	<link type="text/css" href="../functions/style.css" rel="stylesheet" />
	<link type="text/css" href="../functions/jquery/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
	<link href="../functions/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		#gridReportAbsensi .aw-header-0 .aw-column-0,
		#gridReportAbsensi .aw-header-0 .aw-column-1,
		#gridReportAbsensi .aw-header-0 .aw-column-2,
		#gridReportAbsensi .aw-header-0 .aw-column-3 {
			text-align: center
		}

		.aw-column-0 {
			width: 120px;
			text-align: left
		}

		.aw-column-1 {
			width: 300px;
			text-align: left
		}

		.aw-column-2 {
			width: 140px;
			text-align: center
		}

		.aw-column-3 {
			width: 140px;
			text-align: center
		}

		.aw-column-4 {
			width: 140px;
			text-align: center
		}

		.aw-column-5 {
			width: 160px;
			text-align: center
		}

		table tr td {
			height: 25px;
		}
	</style>
	<script type="text/javascript">
		parent.document.title = document.title;
	</script>
	<script type="text/javascript" src="../base/aw.js"></script>
	<script type="text/javascript" src="../base/functions.js"></script>
	<!-- <script type="text/javascript" src="../functions/jQuery/js/jquery-ui-1.8.2.custom.min.js"></script>  -->
	<script type="text/javascript" src="../functions/jquery/js/jquery.min.js"></script>
	<script type="text/javascript" src="../functions/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../functions/jquery/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" src="h1.js"></script>
</head>
<div id="loading" style="display:none">Loading...</div>

<body class="body">
	<!-- <?php include('../header.php'); ?> -->
	<h3>Laporan Check Rekap Absensi </h3>
	<form name="h1form" action="" method="post">
		<table width="" border="0" cellpadding="0" cellspacing="0" id="masterreportabsensi">
			<tr>
				<td width="110"><label>Periode</label></td>
				<td colspan="3">: <?php inp_bulan('bulangaji'); ?><?php inp_tahun('tahungaji'); ?></td>
			</tr>
			<tr>
				<td><label>Nama Karyawan</label></td>
				<td>: <input name="namakry" /></td>
			</tr>
			<tr>
				<td><label>Kode NIK</label></td>
				<td>: <input name="kodenik" /></td>
			</tr>
			<tr>
				<td>Status</td>
				<td>:
					<select name="status" id="status">
						<option value="all" selected="selected">Tampilkan Semua</option>
						<option value="lebih">Absen lebih dari HK</option>
						<option value="null">Tidak ada absen</option>
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
			gridReportAbsensi.setSize(910, 400);
			gridReportAbsensi.setHeaderHeight(25);
			gridReportAbsensi.setHeaderText(["NIK",
				"Nama Karyawan", "Rekap Absen", "Non Finger", "Penyimpangan"
			]);
			gridReportAbsensi.setColumnIndices([0, 1, 2, 3, 4]);
			gridReportAbsensi.setColumnCount(gridReportAbsensi.getColumnIndices().length);
			gridReportAbsensi.setColumnResizable(false);
			gridReportAbsensi.setCellEditable(true);
			gridReportAbsensi.setSelectionMode("single-row");
			gridReportAbsensi.setSelectorVisible(true);
			gridReportAbsensi.setSelectorWidth(50);
			gridReportAbsensi.setSelectorText(function(i) {
				return this.getRowPosition(i) + 1
			});
			gridReportAbsensi.onCellClicked = function(event, col, row) {
				var id = gridReportAbsensi.getCellValue(0, row);
				var nama = gridReportAbsensi.getCellValue(1, row);
				var gcNik = gridReportAbsensi.getCellValue(5, row);
				if (col == 4) {
					ambilDataPenyimpangan(id, nama, gcNik);
				}

				if (col == 2) {
					ambilDataTotal(id, nama, gcNik);
				}
			};

			document.write(gridReportAbsensi);
		</script>
		<br />
		<input type="button" value="Cetak Laporan" name="Cetak" onClick="cetakLap()" />
		<input type="button" value="Cetak Excel" name="CetakX" onClick="cetakLap('excel')" />
		<textarea name="buffer" cols="50" rows="10" class="textBuff"></textarea>
		<textarea name="bufferhelper" cols="50" rows="10" class="textBuff"></textarea>
	</form>

	<div class="modal fade" id="modalPenyimpangan" role="dialog" aria-labelledby="modalPenyimpangan" style="outline: 0;">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 6px;min-height: unset;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;">
					<table class="table">
						<tr>
							<td>NIK</td>
							<th id="txtNIKp"></th>
						</tr>
						<tr>
							<td>Name</td>
							<th id="txtNamap"></th>
						</tr>
					</table>
					<table id="tablePopPenyimpangan" class="table table-bordered">
						<thead>
							<tr class="active">
								<th>No</th>
								<th>Tanggal</th>
								<th>Jenis</th>
								<th>Kriteria</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody id="tbody">
							<tr>
								<td colspan="10" style="text-align:center; background-color:#fff !important;">
									<div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Empty Data</strong></div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalTotal" role="dialog" aria-labelledby="modalTotal" style="outline: 0;">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 6px;min-height: unset;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;">
					<table class="table">
						<tr>
							<td>NIK</td>
							<th id="txtNIKt"></th>
						</tr>
						<tr>
							<td>Name</td>
							<th id="txtNamat"></th>
						</tr>
					</table>
					<table id="tablePopTotal" class="table table-bordered">
						<thead>
							<tr class="active">
								<th>No</th>
								<th>Tanggal</th>
								<th>Absen Masuk</th>
								<th>Absen Keluar</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="10" style="text-align:center; background-color:#fff !important;">
									<div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Empty Data</strong></div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
				</div>
			</div>
		</div>
	</div>
</body>

</html>