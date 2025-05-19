<html>

<head>
	<title>Cari jenis</title>
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
		#jenis .aw-column-0 {
			width: 35px;
			text-align: left
		}

		#jenis .aw-column-1 {
			width: 35px;
			text-align: left
		}

		#jenis .aw-column-2 {
			width: 350px;
			text-align: left
		}

		#jenis .aw-column-4 {
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
	//$rsGroupkategori=$dbCon->execute("select * from jenisasset");
	?>
	<form id="frmcari" name="frmCari" method="post" action="cariKategoriAsset.php?aksi=cari">
		<input type="text" id="cariJenis" name="cariJenis">
		<input type="submit" name="submit" value="Cari">
	</form>
	<form d="frmInput" name="frmInput" action="/cariMenu">
		<select name="groupMenu" class="roundIt" onChange="changeMenu(this.value)" style="display:none">
		</select>
		<input type='hidden' name='lastId'>
		<textArea name="buffer" rows="15" cols="200" style="display:none">
<?php
if (!empty($_REQUEST['aksi'])) {
	if ($_REQUEST['aksi'] == "cari") {
		$jenis = $_REQUEST['cariJenis'];

		$kueri = "select id,nama nama,kode from newasset.typedetail where nama like '%$jenis%' order by nama";
	} else {
		$kueri = "select id,nama nama,kode from newasset.typedetail order by nama";
	}
} else {
	$kueri = "select id,nama nama,kode from newasset.typedetail order by nama";
}



$hasil = $dbCon->execute($kueri);
$jum = $dbCon->getNumRows($hasil);
$txt = '';
//function getChildren($parent,$dbCon){
//			$children = $dbCon->execute("select a.*,b.parentId groupId from (select * from listMenu) a 
//										 inner JOIN listMenu b on a.parentId=b.id where a.parentId= $parent order by id");
//			return $children;
//		}


while ($data = $dbCon->getArray($hasil)) {



	$txt = $txt . "jenis||" . $data['id'] . "|" . $data['nama'] . "||" . $data['kode'] . "|^";
}


echo $txt;
?></textArea>
		<br>
		<script>
			var serial;
			var jenis = new AW.UI.Grid;
			var check = new AW.Templates.Checkbox;
			jenis.setCellTemplate(check, 0);
			jenis.setId("jenis");
			jenis.setSize(460, 250);
			jenis.setHeaderText(["", "Id Jenis", "Type", "idmerk", "Kode"]);
			jenis.setColumnIndices([0, 2, 4]);
			//jenis.setSelectionMode("single-row");
			jenis.setColumnCount(3);
			jenis.setCellEditable(false);


			jenis.onCellClicked = function(event, col, row) {
				if (col != 0) {
					curVal = jenis.getCellValue(0, row);
					jenis.setCellData(!curVal, 0, row);
					jenis.setCellText('', 0, row);
				}


			};

			jenis.onRowDoubleClicked = function(event, index) {
				if (findData(obj_caller.grid, obj_caller.descriptionRecorderColumn, jenis.getCellData(2, index)) == 1) {
					alert('Data ini sudah pernah dimasukkan.');
					return;
				}
				obj_caller.addData_2();
				//obj_caller.document.write("testing");
				obj_caller.grid.setCellData(jenis.getCellData(2, index), obj_caller.descriptionRecorderColumn, obj_caller.grid.getCurrentRow());
				obj_caller.grid.onCellEditEnded(jenis.getCellData(2, index), obj_caller.descriptionRecorderColumn, obj_caller.grid.getCurrentRow());

				obj_caller.grid.setCellData(jenis.getCellData(1, index), obj_caller.descriptionRecorderColumn_1, obj_caller.grid.getCurrentRow());
				obj_caller.grid.onCellEditEnded(jenis.getCellData(1, index), obj_caller.descriptionRecorderColumn_1, obj_caller.grid.getCurrentRow());

				obj_caller.grid.setCellData(jenis.getCellData(4, index), obj_caller.descriptionRecorderColumn_2, obj_caller.grid.getCurrentRow());
				obj_caller.grid.onCellEditEnded(jenis.getCellData(4, index), obj_caller.descriptionRecorderColumn_2, obj_caller.grid.getCurrentRow());

				obj_caller.grid.refresh();
				window.close();
			};
			jenis.refresh();


			//loadGridArray(jenis,"jenis",document.forms[0].buffer)
			parentId = document.forms[1].groupMenu.value;
			filterGridArray(jenis, "jenis", 3, parentId, document.forms[1].buffer)
			setColor();
			document.write(jenis);

			function changeMenu(parentId) {
				filterGridArray(jenis, "jenis", 3, parentId, document.forms[1].buffer)
				setColor();
			}

			function setColor() {

				for (l = 0; l < jenis.getRowCount(); l++) {

					typeMenu = jenis.getCellText(4, l);
					if (typeMenu == "groupMenu") {

						for (n = 1; n <= 8; n++) {
							jenis.getCellTemplate(n, l).setStyle("background-color", "#333")
							jenis.getCellTemplate(n, l).setStyle("color", "#fff");

						}
					} else if (typeMenu == "jenis") {

						for (n = 1; n <= 8; n++) {
							jenis.getCellTemplate(n, l).setStyle("background-color", "#ddd")
							jenis.getCellTemplate(n, l).setStyle("color", "#000");
						}
					} else if (typeMenu == "subMenu") {

						for (n = 1; n <= 8; n++) {
							jenis.getCellTemplate(n, l).setStyle("background-color", "#fff")
							jenis.getCellTemplate(n, l).setStyle("color", "#000");
						}
					}
				}
			}

			function addToText() {
				p = jenis.getRowCount();
				i = 0;
				for (n = 0; n < p; n++) {
					if (jenis.getCellValue(0, n) == true) {

						q = obj_caller.grid.getRowCount();
						for (m = 0; m < q; m++) {
							txtHasilCari = obj_caller.grid.getCellValue(obj_caller.descriptionRecorderColumn_1, m);
							txtA = jenis.getCellData(1, n).toUpperCase();
							txtB = txtHasilCari.toUpperCase();


							txtKodeCari = obj_caller.grid.getCellValue(obj_caller.descriptionRecorderColumn_2, m);
							txtC = jenis.getCellData(4, n).toUpperCase();
							txtD = txtKodeCari.toUpperCase();

							if (txtB == txtA) {
								alert("Data yang anda pilih sudah pernah dimasukkan");
								jenis.getCellValue(0, n) = false
								return;
							}
							if (txtC == txtD) {
								alert("Data Kode untuk " + jenis.getCellData(2, n) + " sama\n Silahkan rubah terlebih dahulu");
								jenis.setCellValue('', 0, n)
								return;
							}


						}
						//alert(jenis.getCellData(2,n)+'***'+jenis.getCellData(1,n)+'***'+jenis.getCellData(4,n))
						obj_caller.addData_2();

						obj_caller.grid.setCellData(jenis.getCellData(2, n), obj_caller.descriptionRecorderColumn,
							obj_caller.grid.getCurrentRow());
						obj_caller.grid.onCellEditEnded(jenis.getCellData(2, n), obj_caller.descriptionRecorderColumn,
							obj_caller.grid.getCurrentRow());

						obj_caller.grid.setCellData(jenis.getCellData(1, n), obj_caller.descriptionRecorderColumn_1,
							obj_caller.grid.getCurrentRow());
						obj_caller.grid.onCellEditEnded(jenis.getCellData(1, n), obj_caller.descriptionRecorderColumn_1, obj_caller.grid.getCurrentRow());

						obj_caller.grid.setCellData(jenis.getCellData(4, n), obj_caller.descriptionRecorderColumn_2,
							obj_caller.grid.getCurrentRow());
						obj_caller.grid.onCellEditEnded(jenis.getCellData(4, n), obj_caller.descriptionRecorderColumn_2, obj_caller.grid.getCurrentRow());


						i++;
					} else {}
				}
				if (i == 0) {
					alert('Tidak ada type terpilih');
					return;
				}

				parent.window.close();
			}
		</script>
		<br>
		<table>
			<tr>
				<td align=""><br>
					<!-- <input class="huruf" type="button" name="Add" value="Add" onClick="tambahData()"/>
	  <input class="huruf" type="button" name="Del" value="Del" onClick="delData()"/>
      <input class="huruf" type="button" name="Submit" value="Save" onClick="saveData()"/>-->
					<input type="button" name="addO" value="Masukkan" onclick="addToText()" class="tomStd" style="display:''">
				</td>
			</tr>
		</table>
	</form>
</body>

</html>