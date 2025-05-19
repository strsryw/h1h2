<html>

<head>
	<title>.: Daftar Asset :.</title>
	<script type="text/javascript" src="../../base/aw.js"></script>
	<script type="text/javascript" src="../../base/functions.js"></script>
	<script type="text/javascript" src="../../base/formatNumber.js"></script>
	<script type="text/javascript" src="../../functions/jQuery/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="h1.js"></script>
	<script type='text/javascript'>
		var obj_caller = parent.opener;
	</script>
	<link href="../../base/aw.css" rel="stylesheet">
	<link href="../../functions/style.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.aw-column-0 {
			width: 30px;
			text-align: left
		}

		.aw-column-2 {
			width: 150px;
			text-align: left
		}
	</style>
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
			font: 12px sans-serif;
		}
	</style>
	<div id="loading" style="display:none">Loading...</div>
</head>

<body bgcolor="#CCCCCC" onLoad="onLoadHandler()">

	<form action="cariArea" name="h1form" method="post">
		<table width="800" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><textarea name="buffer" rows="10" cols="50" class="textBuff"></textarea>
					<textarea name="bufferHelper" rows="10" cols="50" class="textBuff"></textarea>
				</td>


			</tr>
			<tr>
				<td>
					<div id="linkHal" style="height:18px; font-weight:bold; display:none"></div>
					<label id="maxHal"></label>
					<label id="ditemukan" style="font-family:Tahoma"></label>
					<div id="loadingImage" style="height:18px; font-weight:bold; display:none"></div>
					<script type='text/javascript'>
						var daftarMenu = new AW.UI.Grid;
						daftarMenu.setId("daftarMenu");
						daftarMenu.setSize(980, 320);
						daftarMenu.setHeaderHeight(30);
						//daftarMenu.getHeadersTemplate().setClass("text", "wrap");
						var headerText = ["", "id", "Nama", "edit"];
						daftarMenu.setHeaderText(headerText);
						var kolId = getColumnIndex(headerText, "id");
						var kolNama = getColumnIndex(headerText, "Nama");

						daftarMenu.setColumnIndices([0, kolNama]);


						daftarMenu.setColumnResizable(false);
						var check = new AW.Templates.Checkbox;
						daftarMenu.setCellTemplate(check, 0);
						daftarMenu.setSelectionMode("single-row");
						daftarMenu.setColumnCount(daftarMenu.getColumnIndices().length);
						daftarMenu.setCellEditable(false);
						daftarMenu.setVirtualMode(false);
						daftarMenu.setSelectorVisible(true);
						daftarMenu.setSelectorWidth(25);

						daftarMenu.setSelectorText(function(i) {
							return this.getRowPosition(i) + 1
						});
						daftarMenu.refresh();
						daftarMenu.setHeaderTooltip(function(col) {
							return daftarMenu.getHeaderText(col);
						});
						daftarMenu.setCellTooltip(function(col, row) {
							return daftarMenu.getCellText(col, row);

						});
						daftarMenu.onRowDoubleClicked = function(event, index) {};
						daftarMenu.onCellClicked = function(event, col, row) {
							if (col != 0) {
								curVal = daftarMenu.getCellValue(0, row);
								daftarMenu.setCellData(!curVal, 0, row);
								daftarMenu.setCellText('', 0, row);
							}
						};

						document.write(daftarMenu);
					</script>
				</td>
			</tr>
			<tr>
				<td align=""><br>
					<input type="button" name="cekA" value="Check All" onclick="cekAll()" class="tomStd" style="display:''">
					<input type="button" name="cekU" value="Clear All" onClick="unCekAll()" class="tomStd" style="display:''">
					<input type="button" name="addO" value="Add" onclick="addToText()" class="tomStd" style="display:''">
				</td>
			</tr>
		</table>
	</form>
	<script type="text/javascript">
		$(function() {
			$('#loading').ajaxStart(function() {
				$(this).fadeIn();
			}).ajaxStop(function() {
				$(this).fadeOut();
			});
		});

		function cekAll() {
			for (n = 0; n < daftarMenu.getRowCount(); n++) {
				daftarMenu.setCellValue(true, 0, n);
			}
		}

		function unCekAll() {
			for (n = 0; n < daftarMenu.getRowCount(); n++) {
				daftarMenu.setCellValue(false, 0, n);
			}
		}

		function addToText() {
			p = daftarMenu.getRowCount();
			i = 0;
			for (n = 0; n < p; n++) {
				if (daftarMenu.getCellValue(0, n) == true) {

					q = obj_caller.grid.getRowCount();
					for (m = 0; m < q; m++) {
						txtHasilCari = obj_caller.grid.getCellValue(obj_caller.recCol1, m);
						txtA = daftarMenu.getCellData(kolId, n).toUpperCase();
						txtB = txtHasilCari.toUpperCase();

						if (txtB.indexOf(txtA) >= 0) {
							alert("Data yang anda pilih sudah pernah dimasukkan");
							return;
						}
					}

					obj_caller.addData();

					obj_caller.grid.setCellData(daftarMenu.getCellData(kolId, n), obj_caller.recCol1,
						obj_caller.grid.getCurrentRow());
					obj_caller.grid.onCellEditEnded(daftarMenu.getCellData(kolId, n), obj_caller.recCol1,
						obj_caller.grid.getCurrentRow());

					obj_caller.grid.setCellData(daftarMenu.getCellData(kolJenis, n), obj_caller.recCol2,
						obj_caller.grid.getCurrentRow());
					obj_caller.grid.onCellEditEnded(daftarMenu.getCellData(kolJenis, n), obj_caller.recCol2,
						obj_caller.grid.getCurrentRow());

					obj_caller.grid.setCellData(daftarMenu.getCellData(kolNoRegist, n), obj_caller.recCol3,
						obj_caller.grid.getCurrentRow());
					obj_caller.grid.onCellEditEnded(daftarMenu.getCellData(kolNoRegist, n), obj_caller.recCol3,
						obj_caller.grid.getCurrentRow());

					obj_caller.grid.setCellData(daftarMenu.getCellData(kolTglBeli, n), obj_caller.recCol4,
						obj_caller.grid.getCurrentRow());
					obj_caller.grid.onCellEditEnded(daftarMenu.getCellData(kolTglBeli, n), obj_caller.recCol4,
						obj_caller.grid.getCurrentRow());

					obj_caller.grid.setCellData(daftarMenu.getCellData(kolHarga, n), obj_caller.recCol5,
						obj_caller.grid.getCurrentRow());
					obj_caller.grid.onCellEditEnded(daftarMenu.getCellData(kolHarga, n), obj_caller.recCol5,
						obj_caller.grid.getCurrentRow());

					obj_caller.grid.setCellData(daftarMenu.getCellData(kolDetil, n), obj_caller.recCol6,
						obj_caller.grid.getCurrentRow());
					obj_caller.grid.onCellEditEnded(daftarMenu.getCellData(kolDetil, n), obj_caller.recCol6,
						obj_caller.grid.getCurrentRow());

					obj_caller.grid.setCellData(daftarMenu.getCellData(kolIdPemakai, n), obj_caller.recCol7,
						obj_caller.grid.getCurrentRow());
					obj_caller.grid.onCellEditEnded(daftarMenu.getCellData(kolIdPemakai, n), obj_caller.recCol7,
						obj_caller.grid.getCurrentRow());

					obj_caller.grid.setCellData(daftarMenu.getCellData(kolNama, n), obj_caller.recCol8,
						obj_caller.grid.getCurrentRow());
					obj_caller.grid.onCellEditEnded(daftarMenu.getCellData(kolNama, n), obj_caller.recCol8,
						obj_caller.grid.getCurrentRow());
					i++;
				} else {}
			}
			if (i == 0) {
				alert('Tidak ada daftarAsset terpilih');
				return;
			}

			parent.window.close();


		}
	</script>

</body>

</html>