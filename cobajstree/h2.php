<?php
include "../functions/koneksi.php";
include "../functions/function.php";


$mode = $_POST['mode'];
$dbCon = new dbClass($server, $port, $user, $password, $database, 1);

if (!empty($mode)) {
    if ($mode == 'retrieveData') {
        $dbCon->execute("BEGIN");

        // echo getSubMenu(NULL);

        $sql = "SELECT * FROM dpfdplnew.listmenus WHERE parentId IS NULL";

        $querysql = $dbCon->execute($sql);
        $output = "<ul>\n";
        foreach ($querysql as $data) {
            $output .= "<li>\n" . $data['namaMenu'];
            $output .= getSubMenu($data['id'], $dbCon);
            $output .= "</li>";
        }

        echo $output;
    }
}

function getSubMenu($parentId, $dbCon)
{
    // // global $dbCon;


    if ($parentId == NULL) {
        $sql = "SELECT * FROM dpfdplnew.listmenus WHERE parentId IS NULL";

        $querysql = $dbCon->execute($sql);
        $output = "<ul>\n";
        foreach ($querysql as $data) {
            $output .= "<li>\n" . $data['namaMenu'];
            $output .= getSubMenu($data['id'], $dbCon);
            $output .= "</li>";
        }
    } else {
        $sql = "SELECT * FROM dpfdplnew.listmenus WHERE parentId = '" . $parentId . "'";
        $querysql = $dbCon->execute($sql);
        $output = "<ul>\n";
        foreach ($querysql as $data) {
            $output .= "<li>\n" . $data['namaMenu'];
            $output .= getSubMenu($data['id'], $dbCon);
            $output .= "</li>";
        }
    }
    $output .= "</ul>";
    return $output;
}
