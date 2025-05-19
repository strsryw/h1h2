<?php
include("../asset/function.php");
include("../functions/koneksi.php");


$mode = $_POST['mode'];
$dist = $_POST['dist'];
$cabang = $_POST['cabang'];
$bulanperiode = $_POST['bulanperiode'];
$tahunperiode = $_POST['tahunperiode'];
$hm = $_POST['hal'];

if (!empty($mode)) {
  // mode untuk getcabang ketika onchange 
  if ($mode == 'getCabang') {
    $getCabang = " <option value=''>All</option>";
    $query = "SELECT DISTINCT distkota FROM sales_distri.`" . $dist . "_mentah`";
    $hsl = $dbCon->execute($query);
    while ($result = $dbCon->getArray($hsl)) {
      $getCabang .= "  <option value='" . $result['distkota'] . "'>" . $result['distkota'] . "</option>";
    }

    echo $getCabang;

    //get data 
  } else if ($mode == 'retrieveData') {
    if (!empty($dist)) {
      //pengecualian untuk tabel jivssm dengan colom dist jiv krn nama tabel dan kolom berbeda
      if ($dist == 'jivssm') {
        $queryDist = " AND dist = 'jiv'";
      } else {


        $queryDist = " AND dist = '$dist'";
      }
    }
    if (!empty($cabang)) {
      $queryCabang = " AND distkota = '$cabang'";
    }
    // th excel 
    $txtExcel = "NO|DIST|CABANG|DIST KOTA|TANGGAL|NO_FAKTUR|OUTLET|ALAMAT|PRODUK|QTY|HNA|GSV|DISC_P|VDISC_P|VALUENET|BATCH|NO DPFDPL|DIVISI|SUBDIV^";
    $txtData = '';

    //halaman 
    $limit = 10;
    if (empty($hm) || $hm == 1) {
      $start = 0;
    } else {
      $start = ($hm - 1) * $limit;
    }
    $n = $start + 1;


    $query = "SELECT sd.`bln` bln , sd.`thn` thn, sd.`dist` dist, sd.`cab` cab, sd.`distkota` distkota, sd.`tglfaktur` tglfaktur, sd.`nofaktur` nofaktur, sd.`outlet` outlet, sd.`alamat` alamat, sd.`produk` produk, sd.`qty` qty, sd.`hna` hna, sd.`gsv` gsv, sd.`disc_p` disc_p, sd.`vdisc_p` vdisc_p, sd.`valuenet` valuenet, sd.`batch` batch, sd.`nodpfdpl` dpfdpl, sd.`divisi` divisi, sd.`subdiv` subdiv FROM sales_distri.`" . $dist . "_mentah` sd WHERE bln = $bulanperiode AND thn = $tahunperiode $queryDist $queryCabang";

    // var_dump($query);
    // exit();
    $hsl = $dbCon->execute($query);
    $jumRecord = $dbCon->getNumRows($hsl);
    $sum = ceil($jumRecord / $limit);

    /* -----------------------------Navigasi Record ala google style ----------------------------- */
    $linkHal = pageNav($hm, $sum, $limit);
    /* -----------------------------End Navigasi Record ala google style ----------------------------- */

    //-------------- hasil query berdasarkan paging
    $rsTampil = $dbCon->execute($query . " LIMIT $start, $limit");

    $n = $start + 1;

    if ($jumRecord == 0 || $jumRecord == NULL) {
      $txtData = "
      <tr>
        <td style='text-align:center' colspan=19>Data Kosong</td>
      </tr>";
      //kirim respon untuk mengetahui bhwa data kosong
      $txtExcel = 'Data Kosong';
    } else {

      foreach ($hsl as $data) {
        $txtData .= "
        <tr>
        <td>" . $n . "</td>
        <td>" . $data['dist'] . "</td>
        <td>" . $data['cab'] . "</td>
        <td>" . $data['distkota'] . "</td>
        <td>" . dateindo($data['tglfaktur']) . "</td>
        <td>" . $data['nofaktur'] . "</td>
        <td>" . $data['outlet'] . "</td>
        <td style='cursor:context-menu;' title = '" . $data['alamat'] . "'>" . batasiString($data['alamat'], 25) . "</td>
        <td>" . $data['produk'] . "</td>
        <td>" . number_format($data['qty'], 0, ",", ".") . "</td>
        <td>" . number_format($data['hna'], 0, ",", ".") . "</td>
        <td>" . number_format($data['gsv'], 0, ",", ".") . "</td>
        <td>" . $data['disc_p'] . "</td>
        <td>" . number_format($data['vdisc_p'], 0, ",", ".") . "</td>
        <td>" . number_format($data['valuenet'], 0, ",", ".") . "</td>
        <td>" . $data['batch'] . "</td>
        <td>" . $data['dpfdpl'] . "</td>
        <td>" . $data['divisi'] . "</td>
        <td>" . $data['subdiv'] . "</td>
        </tr>";

        //value buffer
        $txtExcel .= $n . "|" . $data['dist'] . "|" . $data['cab'] . "|" . $data['distkota'] . "|" . dateindo($data['tglfaktur']) . "|" . $data['nofaktur'] . "|" . $data['outlet'] . "|" . $data['alamat'] . "|" . $data['produk'] . "|" . $data['qty'] . "|" . $data['hna'] . "|" . $data['gsv'] . "|" . $data['disc_p'] . "|" . $data['vdisc_p'] . "|" . $data['valuenet'] . "|" . $data['batch'] . "|" . $data['dpfdpl'] . "|" . $data['divisi'] . "|" . $data['subdiv'] . "^";
        $n++;
      }
      $n++;
    }
    echo $txtData . "!" . $txtExcel;

    // mode untuk getCabang ketika onload 
  } else if ($mode == 'getDtOnload') {
    $getCabang = " <option value=''>Pilih cabang</option>";
    $query = "SELECT DISTINCT distkota FROM sales_distri.`" . $dist . "_mentah`";
    $hsl = $dbCon->execute($query);
    while ($result = $dbCon->getArray($hsl)) {
      $getCabang .= "  <option value='" . $result['distkota'] . "'>" . $result['distkota'] . "</option>";
    }
    echo $getCabang;
  }
}

// fungsi untuk pembatasan karakter pada string 
function batasiString($str, $maxLength)
{
  return (strlen($str) <= $maxLength) ? $str : substr($str, 0, $maxLength) . "...";
}
