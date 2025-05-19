
<?php include("../functions/koneksi.php");
include("../functions/function.php");
//include("h2.js");
if (!empty($_REQUEST['mode'])) {
	$mode = $_REQUEST['mode'];
} else {
}

$txt = '';
$txt_1 = '';
$txt_2 = '';
if (!empty($mode)) {
	// mode : retrieveData
	if ($mode == "retrieveData") {
		$kueri = "SELECT * FROM newasset.`pabrikan` groupsasset ORDER BY nama";
		$hasil = $dbCon->execute($kueri);
		while ($result = $dbCon->getArray($hasil)) {
			$txt = $txt . "groupUser|" . $result['id'] . "|" . trim($result['nama'])  . "|" . $result['kode'] . "|^";
		}
		// RetreiveData Grid Kedua======================================================================================
		$kueri = "SELECT g.id groupsId, g.nama groups,k.id kategoriId, k.nama kategori,k.kode FROM newasset.pabrikan g
		INNER JOIN newasset.merk k ON k.`pabrikanid`=g.id ORDER BY k.nama, k.kode";
		$hasil = $dbCon->execute($kueri);
		while ($result = $dbCon->getArray($hasil)) {
			$txt_1 = $txt_1 . "menu|" . $result['kategoriId'] . "|" . $result['groupsId'] . "|" . $result['kategoriId'] . "|" . $result['kategori'] . "|" . $result['kode'] . "|^";
		}

		// RetrieveData Grid ke 3

		$kueri = "SELECT k.id kategoriId,k.nama kategori,j.id jenisId,j.nama jenis,j.kode FROM newasset.`typedetail` j
		INNER JOIN newasset.merk k ON k.id=j.`merkid` ORDER BY j.kode,j.nama ";
		$hasil = $dbCon->execute($kueri);
		while ($result = $dbCon->getArray($hasil)) {
			$txt_2 = $txt_2 . "jenis|" . $result['jenisId'] . "|" . $result['kategoriId'] . "|" . $result['jenisId'] . "|" . $result['jenis'] . "|" . $result['kode'] . "|^";
		}

		// ==============================================================================================================
		echo $txt . "!" . $txt_1 . "!" . $txt_2;
	}
	// end mode : retrieveData


	// mode : saveData
	if ($mode == "saveData") {

		$data = $_REQUEST['bufferh2'];
		try {
			$dbCon->execute("BEGIN");
			//loop save

			while (!strrpos($data, "^") === false) {

				$iValue = substr($data, 0, strpos($data, "^"));
				if (substr(strrev($iValue), 0, 3) <> "|||") {
					$iValue = $iValue . "|";
				} else {
					$iValue = $iValue;
				}
				$data = substr($data, strpos($data, "^") + 1, strlen($data));
				$tablename = trim(getColumnValue($iValue, 1));

				if (trim($tablename) == "groupUser") {
					$i = 0;
					while (!strrpos($iValue, "|") === false) {
						$lenIValue = (int) strlen($iValue);
						//if ($lenIValue>0){
						$cValue = substr($iValue, 0, strpos($iValue, "|"));
						//}
						//elseif ($lenIValue<=0) {$cValue=" ";}
						$iValue = substr($iValue, strpos($iValue, "|") + 1, strlen($iValue));

						if ($i == 1) {
							$groupsId = $cValue;
						}
						if ($i == 2) {
							$groups = $cValue;
						}
						if ($i == 3) {
							$kode = $cValue;
						}
						$i++;
					}
					// simpan addnew
					if (substr($groupsId, 0, 1) == "N") {
						$insert = "INSERT INTO newasset.`pabrikan` (nama, kode)
						VALUES ('$groups','$kode')";
						// var_dump($insert);
						// exit();
						$execute = $dbCon->execute($insert);
					} // end simpan addnew
					// simpan update
					else if (substr($groupsId, 0, 1) == "-") {
						$delete = "delete from newasset.pabrikan where id='" . substr($groupsId, 1, strlen($groupsId)) . "'";
						$delete_1 = "UPDATE merk SET pabrikanid='0' WHERE pabrikanid='" . substr($groupsId, 1, strlen($groupsId)) . "'";
						$execute = $dbCon->execute($delete);
						$execute1 = $dbCon->execute($delete_1);
						// echo $delete_1;
						if ($execute1) {
							echo "jalan!!";
						} else {
							// echo "gagal" . mysqli_error();
						}
					} else {
						$update = "UPDATE newasset.pabrikan SET nama=' $groups', kode = '$kode' WHERE id='" . $groupsId . "'";
						$execute = $dbCon->execute($update);
					} // end simpan update

				}
			} //end loop save
			echo "Data berhasil disimpan";
			$dbCon->execute("COMMIT");
		} catch (Exception $e) {
			echo var_dump($e->getTrace());
			$dbCon->execute("ROLLBACK");
		}
	}
	// end mode : saveData
} else {
}
?>
	
	 <?php
		if (!empty($_REQUEST['mode_1'])) {
			$mode_1 = $_REQUEST['mode_1'];
		} else {
		}
		if (!empty($mode_1)) {

			// mode : saveData
			if ($mode_1 == "saveData") {

				$data = $_REQUEST['bufferh2_1'];
				try {
					$dbCon->execute("BEGIN");
					//loop save
					while (!strrpos($data, "^") === false) {

						$iValue = substr($data, 0, strpos($data, "^"));
						if (substr(strrev($iValue), 0, 3) <> "|||") {
							$iValue = $iValue . "|";
						} else {
							$iValue = $iValue;
						}
						$data = substr($data, strpos($data, "^") + 1, strlen($data));
						$tablename = trim(getColumnValue($iValue, 1));

						if (trim($tablename) == "menu") {
							$i = 0;
							while (!strrpos($iValue, "|") === false) {

								$cValue = substr($iValue, 0, strpos($iValue, "|"));

								$iValue = substr($iValue, strpos($iValue, "|") + 1, strlen($iValue));

								if ($i == 1) {
									$newId = $cValue;
								}
								if ($i == 2) {
									$groupsId = $cValue;
								}
								if ($i == 3) {
									$kategoriId = $cValue;
								}
								if ($i == 4) {
									$kategori = $cValue;
								}

								$i++;
							}


							// simpan addnew
							if (substr($newId, 0, 1) == "N") {
								//$insert2="insert into kategoriasset values('".maxid('kategoriasset','id',$dbCon)."','$kategori','$groupsId')";
								$insert2 = "update newasset.merk set pabrikanid='$groupsId' where id='$kategoriId'";
								//echo $insert2;

								$execute = $dbCon->execute($insert2);
							} // end simpan addnew
							// simpan update
							elseif (substr($newId, 0, 1) == "-") {
								$delete = "update newasset.merk set pabrikanid='0' where id='$kategoriId'";
								//$delete_1="UPDATE jenisasset SET kategoriId='(NULL)' WHERE kategoriId='".substr($kategoriId,1,strlen($kategoriId))."'";
								$execute = $dbCon->execute($delete);
								//$execute1=$dbCon->execute($delete_1);

							} else {
								$update = "update newasset.merk set id='" . $kategoriId . "',nama='" . $kategori . "',pabrikanid='" . $groupsId . "' where id='" . $kategoriId . "'";
								$execute = $dbCon->execute($update);
							} // end simpan update

						}
					} //end loop save
					echo "Data berhasil disimpan";
					$dbCon->execute("COMMIT");
				} catch (Exception $e) {
					echo var_dump($e->getTrace());
					$dbCon->execute("ROLLBACK");
				}
			}
			// end mode : saveData
		} else {
		}
		?>


	 <?php
		if (!empty($_REQUEST['mode_2'])) {
			$mode_2 = $_REQUEST['mode_2'];
		} else {
		}

		if (!empty($mode_2)) {

			// mode : saveData
			if ($mode_2 == "saveData") {

				$data = $_REQUEST['bufferh2_2'];
				try {
					$dbCon->execute("BEGIN");
					//loop save
					while (!strrpos($data, "^") === false) {
						$iValue = substr($data, 0, strpos($data, "^"));
						if (substr(strrev($iValue), 0, 3) <> "|||") {
							$iValue = $iValue . "|";
						} else {
							$iValue = $iValue;
						}
						$data = substr($data, strpos($data, "^") + 1, strlen($data));
						$tablename = trim(getColumnValue($iValue, 1));
						if (trim($tablename) == "jenis") {
							$i = 0;
							while (!strrpos($iValue, "|") === false) {

								$cValue = substr($iValue, 0, strpos($iValue, "|"));

								$iValue = substr($iValue, strpos($iValue, "|") + 1, strlen($iValue));
								if ($i == 1) {
									$newId = $cValue;
								}
								if ($i == 2) {
									$kategoriId = $cValue;
								}
								if ($i == 3) {
									$jenisId = $cValue;
								}
								if ($i == 4) {
									$jenis = $cValue;
								}

								$i++;
							}
							// simpan addnew
							if (substr($newId, 0, 1) == "N") {
								// $insert2="insert into jenisasset values('".maxid('jenisasset','id',$dbCon)."','$jenis','0','$kategoriId')";
								$insert2 = "update newasset.typedetail set merkid='$kategoriId' where id='$jenisId'";
								$execute = $dbCon->execute($insert2);
							} // end simpan addnew
							// simpan update
							elseif (substr($newId, 0, 1) == "-") {
								//$delete="delete from jenisasset where id='".substr($jenisId,1,strlen($jenisId))."'";
								$delete = "update newasset.typedetail set merkid='0' where id='$jenisId'";
								$execute = $dbCon->execute($delete);
							} else {
								$update = "update newasset.typedetail set id='" . $jenisId . "',nama='" . $jenis . "',merkid='" . $kategoriId . "' where id='" . $jenisId . "'";
								$execute = $dbCon->execute($update);
							} // end simpan update
						}
					} //end loop save
					echo "Data berhasil disimpan";
					$dbCon->execute("COMMIT");
				} catch (Exception $e) {
					echo var_dump($e->getTrace());
					$dbCon->execute("ROLLBACK");
				}
			}
			// end mode : saveData
		} else {
		}
		?>