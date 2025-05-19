<?php include("../functions/koneksi.php");
include("../functions/function.php");


// utk get value select 
$page = $_GET['page'];
$resultCount = 10;
$end = ($page - 1) * $resultCount;
$start = $end + $resultCount;

$query = "SELECT  m.kodenik kodenik,  m.namakry namakry FROM absensi.master_karyawan m
INNER JOIN absensi.karyawan_aktif k ON k.namakry=m.namakry AND k.tgllahir=m.tgllahir WHERE m.`namakry` LIKE '%" . $_GET['term'] . "%' AND k.blngaji='10' AND k.thngaji=2023 GROUP BY m.namakry,m.tgllahir ORDER BY m.namakry LIMIT {$end}, {$start}";

$hsl = $dbCon->execute($query);
$jum = $dbCon->getNumRows($hsl);
$data = [];
if ($jum == 0 || $jum == NULL) {
    $empty[] = ['id' => '', 'col' => '', 'total_count' => ''];
    echo json_encode($empty);
} else {
    while ($result = $dbCon->getArray($hsl)) {
        $data[] = ['id' => $result['kodenik'], 'col' => $result['namakry'], 'total_count' => $jum];
    }
    echo json_encode($data);
}
