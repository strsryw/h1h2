<?php include("../functions/koneksi.php");
include("../functions/function.php");

$dbCon = new dbClass($server, $port, $user, $password, $database, 1);
//data post
$mode = $_POST['mode'];



if (!empty($mode)) {
    if ($mode == 'retrieveData') {

        // tampil semua 
        $dbCon->execute("BEGIN");
        $sql = "SELECT * FROM dpfdplnew.listmenus WHERE parentId IS NULL";
        $querysql = $dbCon->execute($sql);
        echo displayMenu($querysql, $dbCon);
    }
}


//menampilkan menu utama
function displayMenu($querysql, $dbCon)
{
    $txtData = '';
    foreach ($querysql as $data) {

        $txtData .= '<li onclick="toggleElement(\'' . $data['id'] . '\')" style="cursor: pointer;">' . $data['namaMenu'] . '<span class="toggle-symbol">></span></li>';


        //query untuk getSubmenu
        $querySubMenu = $dbCon->execute("SELECT * FROM dpfdplnew.listmenus WHERE parentId = " . $data['id'] . "");
        $jum = $dbCon->getNumRows($querySubMenu);
        if ($jum > 0) {
            $txtData .= '<ul id="' . $data['id'] . '" style="display: none;">';
            $txtData .= displaySubMenu($querySubMenu, $data['id'], $dbCon);
            $txtData .= '</ul>';
        }
    }
    return $txtData;
}

// menampilkan menu di bawahnya 
function displaySubMenu($querySubMenu, $parentId, $dbCon)
{
    $txtData = '';
    $jum = $dbCon->getNumRows($querySubMenu);
    foreach ($querySubMenu as $data) {
        $queryAkhir = $dbCon->execute("SELECT * FROM dpfdplnew.listmenus WHERE parentId = " . $data['id'] . "");


        $txtData .= "<li id='" . $parentId . "' onclick=\"toggleElement('" . $data['id'] . $parentId . "')\">" . $data['namaMenu'] . "</li>";


        $jum = $dbCon->getNumRows($queryAkhir);
        if ($jum > 0) {
            $txtData .= '<ul id="' . $data['id'] . $parentId . '" style="display: none;">';
            $txtData .= displaySubMenu($queryAkhir, $data['id'], $dbCon);
            $txtData .= '</ul>';
        }
    }
    return $txtData;
}
