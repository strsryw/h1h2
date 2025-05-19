<?php
// session_start();
// $session_namauser=$_SESSION["newasset_session_nama"];
// $session_userid = $_SESSION["newasset_session_id"];
// $session_groupId = $_SESSION["newasset_session_groupId"];
// $session_area = $_SESSION["newasset_session_area"];
// $session_perusahaan=$_SESSION['newasset_session_perusahaan'];
// if($session_namauser=="")
// {
// 	header("location:../index.php");
// } 
?>

<html>

<head>
	<title>.:: Groups Asset ::.</title>
	<script src="../base/aw.js"></script>
	<script src="../base/functions.js"></script>
	<script language="javascript" src="h1.js"></script>
	<script src="../functions/jQuery/js/jquery-1.9.0.js"></script>
	<script src="../functions/jQuery/js/jquery-1.4.2.js"></script>
	<script language="javascript" src="menuFinder.js"></script>
	<link href="../base/aw.css" rel="stylesheet">
	</link>
	<link href="../functions/style.css" rel="stylesheet">
	</link>
	<style>
		#gridGroupUser .aw-column-0 {
			width: 150px;
			text-align: left
		}

		#gridGroupUser .aw-column-1 {
			width: 230px;
			text-align: left
		}


		#gridMenu .aw-column-0 {
			width: 150px;
			text-align: left
		}

		#gridMenu .aw-column-3 {
			width: 230px;
			text-align: left
		}

		#gridJenis .aw-column-0 {
			width: 150px;
			text-align: left
		}

		#gridJenis .aw-column-3 {
			width: 230px;
			text-align: left
		}

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

<body onLoad="onLoadHandler()">
	<h3 class="style1" align="center">Setting Group, Kategori dan Jenis Asset</h3>
	<form name="h1form" action="" method="post">
		<table border="0" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td></td>
				<td></td>
				<td align="center"><input class="huruf" type="button" name="Submit3" value="Add Kategori" onClick="addKategori()"></td>
				<td></td>
				<td align="center"><input class="huruf" type="button" name="Submit4" value="Add Jenis" onClick="addJenis()"></td>
			</tr>
			<tr>
				<td width="125">
					<script>
						var gridMenu = new AW.UI.Grid;
						gridMenu.setId("gridMenu");
						var gridGroupUser = new AW.UI.Grid;
						gridGroupUser.setId("gridGroupUser");
						gridGroupUser.setSize(250, 350);
						gridGroupUser.setHeaderText(["id", "Group Asset"]);
						gridGroupUser.setColumnIndices([1]);
						//gridGroupUser.setSelectionMode("single-row");
						gridGroupUser.setColumnCount(1);
						gridGroupUser.setCellEditable(true);

						gridGroupUser.onCellEditEnded = function(text, col, row) {
							idGroupUser = gridGroupUser.getCellValue(0, row);
							updateDataOnBuffer("groupUser", idGroupUser, col, text, document.forms[0].buffer);
						};
						gridGroupUser.onCellClicked = function(event, column, row) {
							idGroupUser = gridGroupUser.getCellValue(0, row);
							filterGridArray(gridMenu, "menu", 1, idGroupUser, document.forms[0].buffer_1)
							serial_1 = gridMenu.getRowCount();
						};
						document.write(gridGroupUser);
					</script>
				</td>
				<td width="48">&nbsp;</td>
				<td width="125">
					<script>
						var gridJenis = new AW.UI.Grid;
						gridJenis.setId("gridJenis");
						gridMenu.setSize(250, 350);
						gridMenu.setHeaderText(["", "Group Id", "kategori Id", "Kategori"]);
						gridMenu.setColumnIndices([3]);
						//gridGroupUser.setSelectionMode("single-row");
						gridMenu.setColumnCount(gridMenu.getColumnIndices().length);
						gridMenu.setCellEditable(true);

						gridMenu.onCellEditEnded = function(text, col, row) {
							idmenu = gridMenu.getCellValue(0, row);
							kategori = gridMenu.getCellValue(3, row);

							updateDataOnBuffer("menu", idmenu, 2, text, document.forms[0].buffer_1);
							updateDataOnBuffer("menu", idmenu, 3, kategori, document.forms[0].buffer_1);
							//updateDataOnBuffer("menu",idmenu,4,kategori,document.forms[0].buffer_1);
						};
						gridMenu.setCellTooltip(function(col, row) {
							if (col == 3)
								return "DOUBLE CLICK UNTUK MENGUPDATE KATEGORI ASSET"
						});
						gridMenu.onCellDoubleClicked = function(event, column, row) {
							if (column == 3) {
								gridFindmenu(gridMenu, 3, 2);
								gridFindmenu.finder();


							}
						};
						gridMenu.onCellClicked = function(event, column, row) {
							idGroupMenu = gridMenu.getCellValue(2, row);
							filterGridArray(gridJenis, "jenis", 1, idGroupMenu, document.forms[0].buffer_2)
							serial_2 = gridJenis.getRowCount();
						};
						document.write(gridMenu);
					</script>
				</td>

				<td width="48">&nbsp;</td>
				<td width="125">
					<script>
						gridJenis.setSize(250, 350);
						gridJenis.setHeaderText(["", "kategoriId", "jenisId", "Jenis"]);
						gridJenis.setColumnIndices([3]);
						//gridGroupUser.setSelectionMode("single-row");
						gridJenis.setColumnCount(gridJenis.getColumnIndices().length);
						gridJenis.setCellEditable(true);

						gridJenis.onCellEditEnded = function(text, col, row) {
							idmenu = gridJenis.getCellValue(0, row);
							jenis = gridJenis.getCellValue(3, row);
							updateDataOnBuffer("jenis", idmenu, 2, text, document.forms[0].buffer_2);
							updateDataOnBuffer("jenis", idmenu, 3, jenis, document.forms[0].buffer_2);
						};
						gridJenis.setCellTooltip(function(col, row) {
							if (col == 3)
								return "DOUBLE CLICK UNTUK MENGUPDATE JENIS ASSET"
						});
						gridJenis.onCellDoubleClicked = function(event, column, row) {
							if (column == 3) {
								gridFindjenis(gridJenis, 3, 2);
								gridFindjenis.finder();
								//if((gridJenis.getSelectedRows().length)<1 ) return;
								//						r=gridJenis.getCurrentRow();
								//					
							}
						};
						document.write(gridJenis);
					</script>
				</td>

			</tr>
			<tr>
				<td>
					<input class="huruf" type="button" name="Add" value="Add" onClick="addData()" />
					<input class="huruf" type="button" name="Del" value="Del" onClick="delData()" />
					<input class="huruf" type="button" name="Submit" value="Save" onClick="saveData()" />
				</td>
				<td>&nbsp;</td>
				<td>
					<input class="huruf" type="button" name="Add2" value="Add" onClick="addData_1()" />
					<input class="huruf" type="button" name="Del2" value="Del" onClick="delData_1()" />
					<input class="huruf" type="button" name="Submit2" value="Save" onClick="saveData_1()" />
				</td>
				<td>&nbsp;</td>
				<td>
					<!--	    <input class="huruf" type="button" name="Add3" value="Add" onClick="addData_2()"/>-->

					<input class="huruf" type="button" name="Add3" value="Add" onClick="gridFindjenis(gridJenis,3,2)" />
					<input class="huruf" type="button" name="Del3" value="Del" onClick="delData_2()" />
					<input class="huruf" type="button" name="Submit3" value="Save" onClick="saveData_2()" />
				</td>
			</tr>
		</table>
		<br>
		<input type='hidden' name='lastId'>
		<input type='hidden' name='lastId_1'>
		<input type='hidden' name='lastId_2'>

		<textarea name="buffer" cols=50 rows=10 style="display:none"></textarea>
		<textarea name="buffer_1" cols=50 rows=10 style="display:none"></textarea>
		<textarea name="buffer_2" cols=50 rows=10 style="display:none"></textarea>
		<textarea name="bufferHelper" cols="50" rows="10" class="textBuff"></textarea>
		<script>
			$(function() {
				$(document).ajaxStart(function() {
					$("#loading").fadeIn();
				});
				$(document).ajaxStop(function() {
					$("#loading").fadeOut();
				});

			});
		</script>
	</form>
</body>

</html>