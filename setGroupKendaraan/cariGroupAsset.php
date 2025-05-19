<html>

<head>
	<title>Cari Menu</title>
	<script src="../base/aw.js"></script>
	<script src="../base/functions.js"></script>
	<script language="JavaScript" src="../base/formatNumber.js"></script>
	<script language="JavaScript">
		//var re_id = new RegExp('id=(\d+)');
		//var num_id = (re_id.exec(String(window.location))? new Number(RegExp.$1) : 0);
		var obj_caller = opener;
		//(window.opener?window.opener.menus[num_id] : null);
	</script>
	<link href="../base/aw.css" rel="stylesheet">
	</link>
	<link href="../functions/style.css" rel="stylesheet">
	</link>
	<style>
		#menu .aw-column-0 {
			width: 35px;
			text-align: left
		}

		#menu .aw-column-1 {
			width: 35px;
			text-align: left
		}

		#menu .aw-column-2 {
			width: 370px;
			text-align: left
		}

		#menu .aw-column-3 {
			width: 50px;
			text-align: center
		}

		* {
			font-family: sans-serif;
		}

		.huruf {
			font-family: sans-serif;
		}

		.style1 {
			font-family: sans-serif;
			font-size: 12px;
		}
	</style>
</head>

<body background="">
	<?php
	include("../functions/koneksi.php");
	include("../functions/function.php");
	//include("h2.js");
	// $rsGroupMenu = $dbCon->execute("select nama, kode from newasset.merk order by nama");
	?>
	<!-- buffer bantuan  -->
	<form method="post" action="cariGroupAsset.php?aksi=cari">
		<input type="text" id="cariJenis" name="cariJenis">
		<input type="submit" name="submit" value="Cari"><br>
		<select name="groupMenu" class="roundIt" onChange="changeMenu(this.value)" style="display:inline-block">
		</select>
		<input type='hidden' name='lastId'>
		<textArea name="buffer" rows="15" cols="200" style="display:inline-block;">

<?php
if (!empty($_REQUEST['aksi'])) {
	$jenis = $_REQUEST['cariJenis'];
	if ($_REQUEST['aksi'] == "cari") {
		//id>=160 and
		$kueri = "SELECT id id,nama nama,kode kode FROM newasset.`merk` WHERE nama LIKE '%$jenis%' ORDER BY nama";
		// var_dump($kueri);
	} else {
		$kueri = "SELECT id id,nama nama,kode kode FROM newasset.`merk` WHERE nama LIKE '%$jenis%' ORDER BY nama";
	}
} else {
	// where id>=160
	$kueri = "SELECT id id,nama nama,kode kode FROM newasset.`merk` ORDER BY nama";
}


$hasil = $dbCon->execute($kueri);
$jum = $dbCon->getNumRows($hasil);

//function getChildren($parent,$dbCon){
//			$children = $dbCon->execute("select a.*,b.parentId groupId from (select * from listMenu) a 
//										 inner JOIN listMenu b on a.parentId=b.id where a.parentId= $parent order by id");
//			return $children;
//		}

$txt = '';
while ($data = $dbCon->getArray($hasil)) {
	$txt = $txt . "menu||" . $data['id'] . "|" . $data['nama'] . "||" . $data['kode'] . "|^";
}


echo $txt;



//$kueri="select * from merk where id>=160 order by nama";
//		$hasil=$dbCon->execute($kueri);
//		$jum=$dbCon->getNumRows($hasil);
//		$txt;
//		//function getChildren($parent,$dbCon){
////			$children = $dbCon->execute("select a.*,b.parentId groupId from (select * from listMenu) a 
////										 inner JOIN listMenu b on a.parentId=b.id where a.parentId= $parent order by id");
////			return $children;
////		}
//		function printTree($result,$dbCon){
//			global $txt;
//			while($data=$dbCon->getArray($result)){
//		
//			$namaMenu=$data[namaMenu];
//
//			$txt=$txt."menu||".$data[id]."|".$data[nama]."|".$data[kode]."|^";
//						}
//		}
//		
//		printTree($hasil,$dbCon);
//		echo $txt;

?></textArea>
		<br>
		<script>
			var serial;
			var menu = new AW.UI.Grid;
			var check = new AW.Templates.Checkbox;
			menu.setCellTemplate(check, 0);
			menu.setId("menu");
			menu.setSize(460, 250);
			menu.setHeaderText(["", "Id Kategori", "Merk", "id Pabrikan", "Kode"]);
			menu.setColumnIndices([0, 2, 4]);
			//menu.setSelectionMode("single-row");
			menu.setColumnCount(3);
			menu.setCellEditable(false);


			menu.onCellClicked = function(event, col, row) {
				if (col != 0) {
					curVal = menu.getCellValue(0, row);
					menu.setCellData(!curVal, 0, row);
					menu.setCellText('', 0, row);
				}


			};

			menu.onRowDoubleClicked = function(event, index) {
				if (findData(obj_caller.grid, obj_caller.descriptionRecorderColumn, menu.getCellData(2, index)) == 1) {
					alert('Data ini sudah pernah dimasukkan.');
					return;
				}
				//obj_caller.document.write("testing");
				obj_caller.addData_1();
				obj_caller.grid.setCellData(menu.getCellData(2, index), obj_caller.descriptionRecorderColumn, obj_caller.grid.getCurrentRow());
				obj_caller.grid.onCellEditEnded(menu.getCellData(2, index), obj_caller.descriptionRecorderColumn, obj_caller.grid.getCurrentRow());

				obj_caller.grid.setCellData(menu.getCellData(1, index), obj_caller.descriptionRecorderColumn_1, obj_caller.grid.getCurrentRow());
				obj_caller.grid.onCellEditEnded(menu.getCellData(1, index), obj_caller.descriptionRecorderColumn_1, obj_caller.grid.getCurrentRow());

				obj_caller.grid.setCellData(menu.getCellData(4, index), obj_caller.descriptionRecorderColumn_2, obj_caller.grid.getCurrentRow());
				obj_caller.grid.onCellEditEnded(menu.getCellData(4, index), obj_caller.descriptionRecorderColumn_2, obj_caller.grid.getCurrentRow());

				obj_caller.grid.refresh();
				window.close();
			};
			menu.refresh();


			loadGridArray(menu, "menu", document.forms[0].buffer);
			parentId = document.forms[0].groupMenu.value;
			filterGridArray(menu, "menu", 3, parentId, document.forms[0].buffer);
			setColor();
			document.write(menu);

			function changeMenu(parentId) {
				filterGridArray(menu, "menu", 3, parentId, document.forms[0].buffer)
				setColor();
			}

			function setColor() {

				for (l = 0; l < menu.getRowCount(); l++) {

					typeMenu = menu.getCellText(4, l);
					if (typeMenu == "groupMenu") {

						for (n = 1; n <= 8; n++) {
							menu.getCellTemplate(n, l).setStyle("background-color", "#333")
							menu.getCellTemplate(n, l).setStyle("color", "#fff");

						}
					} else if (typeMenu == "Menu") {

						for (n = 1; n <= 8; n++) {
							menu.getCellTemplate(n, l).setStyle("background-color", "#ddd")
							menu.getCellTemplate(n, l).setStyle("color", "#000");
						}
					} else if (typeMenu == "subMenu") {

						for (n = 1; n <= 8; n++) {
							menu.getCellTemplate(n, l).setStyle("background-color", "#fff")
							menu.getCellTemplate(n, l).setStyle("color", "#000");
						}
					}
				}
			}

			function addToText() {
				p = menu.getRowCount();
				i = 0;
				for (n = 0; n < p; n++) {
					if (menu.getCellValue(0, n) == true) {

						q = obj_caller.grid.getRowCount();
						for (m = 0; m < q; m++) {
							txtHasilCari = obj_caller.grid.getCellValue(obj_caller.descriptionRecorderColumn_1, m);
							txtA = menu.getCellData(1, n).toUpperCase();
							txtB = txtHasilCari.toUpperCase();

							if (txtB.indexOf(txtA) >= 0) {
								alert("Data yang anda pilih sudah pernah dimasukkan");
								return;
							}
						}

						obj_caller.addData_1();

						obj_caller.grid.setCellData(menu.getCellData(2, n), obj_caller.descriptionRecorderColumn,
							obj_caller.grid.getCurrentRow());
						obj_caller.grid.onCellEditEnded(menu.getCellData(2, n), obj_caller.descriptionRecorderColumn,
							obj_caller.grid.getCurrentRow());

						obj_caller.grid.setCellData(menu.getCellData(1, n), obj_caller.descriptionRecorderColumn_1,
							obj_caller.grid.getCurrentRow());
						obj_caller.grid.onCellEditEnded(menu.getCellData(1, n), obj_caller.descriptionRecorderColumn_1,
							obj_caller.grid.getCurrentRow());

						obj_caller.grid.setCellData(menu.getCellData(3, n), obj_caller.descriptionRecorderColumn_2,
							obj_caller.grid.getCurrentRow());
						obj_caller.grid.onCellEditEnded(menu.getCellData(3, n), obj_caller.descriptionRecorderColumn_2,
							obj_caller.grid.getCurrentRow());
						i++;
					} else {}
				}
				if (i == 0) {
					alert('Tidak ada Data terpilih');
					return;
				}

				parent.window.close();


			}

			function tambahData() {
				if ((menu.getSelectedRows().length) > 0) return;
				lastId = document.forms[0].lastId.value;
				if (lastId.length == 0) {
					document.forms[0].lastId.value = '0';
				} else {
					lastId = parseInt(lastId) + 1;
					document.forms[0].lastId.value = lastId;
				}
				lastId = document.forms[0].lastId.value;
				menu.addRow(serial++);
				r = menu.getCurrentRow();
				menu.setCellData("N" + lastId, 0, r);
				menu.setCellData("", 1, r);
				newRow = "menu|N" + lastId + "|||^";
				document.forms[0].buffer.value = document.forms[0].buffer.value + newRow;

			}

			function delData() {
				if ((menu.getSelectedRows().length) < 1) return;
				idGroupUser = menu.getCellData(0, menu.getCurrentRow());
				menu.deleteRow(menu.getCurrentRow());
				//2 kemungkinan : id termporer -> hapus dari buffer
				//                id permanen -> tambahkan tanda - di id tsb yg ada di buffer
				deleteDataOnBuffer("groupUser", idGroupUser, document.forms[0].buffer);

			}
		</script>
		<br>
		<table>
			<tr>
				<td align=""><br>
					<!-- <input class="huruf" type="button" name="Add" value="Add" onClick="tambahData()" />
					<input class="huruf" type="button" name="Del" value="Del" onClick="delData()" />
					<input class="huruf" type="button" name="Submit" value="Save" onClick="saveData()" /> -->
					<input type="button" name="addO" value="Simpan" onclick="addToText()" class="tomStd" style="display:''">
				</td>
			</tr>
		</table>
	</form>
</body>

</html>