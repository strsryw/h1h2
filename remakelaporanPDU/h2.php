<?php
include("../asset/function.php");
include("../functions/koneksi.php");

$mode = $_POST['mode'];
$dist = $_POST['dist'];
$cabang = $_POST['cabang'];
$bulanperiode = $_POST['bulanperiode'];
$tahunperiode = $_POST['tahunperiode'];
$hm = $_POST['hal'];
$distSearch = $_POST['distSearch'];
$cabSearch = $_POST['cabSearch'];
$distkotaSearch = $_POST['distkotaSearch'];
$tglfakturSearch = $_POST['tglfakturSearch'];
$nofakturSearch = $_POST['nofakturSearch'];
$outletSearch = $_POST['outletSearch'];
$alamatSearch = $_POST['alamatSearch'];
$produkSearch = $_POST['produkSearch'];
$qtySearch = $_POST['qtySearch'];
$hnaSearch = $_POST['hnaSearch'];
$gsvSearch = $_POST['gsvSearch'];
$disc_pSearch = $_POST['disc_pSearch'];
$vdisc_pSearch = $_POST['vdisc_pSearch'];
$valuenetSearch = $_POST['valuenetSearch'];
$batchSearch = $_POST['batchSearch'];
$dpfdplSearch = $_POST['dpfdplSearch'];
$divisiSearch = $_POST['divisiSearch'];
$subdivSearch = $_POST['subdivSearch'];

// var_dump($_POST);
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
    } else if ($mode == 'retrieveData') {
        if (!empty($dist)) {
            if ($dist == 'jivssm') {
                $queryDist = " AND dist = 'jiv'";
            } else {
                $queryDist = " AND dist = '$dist'";
            }
        }
        if (!empty($cabang)) {
            if (!empty($cabSearch)) {
                $queryDistKota = " AND distkota LIKE '%$distkotaSearch%'";
            } else {
                $queryDistKota = " AND distkota = '$cabang'";
            }
        } else {
            $queryDistKota = " AND distkota LIKE '%$distkotaSearch%'";
        }

        $txtData = '';
        $txtExcel = "NO|DIST|CABANG|DIST KOTA|TANGGAL|NO_FAKTUR|OUTLET|ALAMAT|PRODUK|QTY|HNA|GSV|DISC_P|VDISC_P|VALUENET|BATCH|NO DPFDPL|DIVISI|SUBDIV^";

        //halaman 
        $limit = 10;
        if (empty($hm) || $hm == 1) {
            $start = 0;
        } else {
            $start = ($hm - 1) * $limit;
        }
        $n = $start + 1;


        // $query = "SELECT sd.`bln` bln , sd.`thn` thn, sd.`dist` dist, sd.`cab` cab, sd.`distkota` distkota, sd.`tglfaktur` tglfaktur, sd.`nofaktur` nofaktur, sd.`outlet` outlet, sd.`alamat` alamat, sd.`produk` produk, sd.`qty` qty, sd.`hna` hna, sd.`gsv` gsv, sd.`disc_p` disc_p, sd.`vdisc_p` vdisc_p, sd.`valuenet` valuenet, sd.`batch` batch, sd.`nodpfdpl` dpfdpl, sd.`divisi` divisi, sd.`subdiv` subdiv FROM sales_distri.`" . $dist . "_mentah` sd WHERE bln = $bulanperiode AND thn = $tahunperiode $queryDist $queryDistKota";

        $query = "SELECT * FROM (SELECT
        sd.`bln` bln,
        sd.`thn` thn,
        sd.`dist` dist,
        sd.`cab` cab,
        sd.`distkota` distkota,
        sd.`tglfaktur` tglfaktur,
        sd.`nofaktur` nofaktur,
        sd.`outlet` outlet,
        sd.`alamat` alamat,
        sd.`produk` produk,
        sd.`qty` qty,
        sd.`hna` hna,
        sd.`gsv` gsv,
        sd.`disc_p` disc_p,
        sd.`vdisc_p` vdisc_p,
        sd.`valuenet` valuenet,
        sd.`batch` batch,
        sd.`nodpfdpl` nodpfdpl,
        sd.`divisi` divisi,
        sd.`subdiv` subdiv
    FROM
        sales_distri.`" . $dist . "_mentah` sd
    WHERE
        bln = '$bulanperiode'
        AND thn = '$tahunperiode'
        AND dist = '$dist'
        AND distkota LIKE '%$cabang%') a WHERE a.dist LIKE '%$distSearch%' AND a.cab LIKE '%$cabSearch%' AND a.distkota LIKE '%$distkotaSearch%' AND a.tglfaktur LIKE '%$tglfakturSearch%' AND a.nofaktur LIKE '%$nofakturSearch%' AND a.outlet LIKE '%$outletSearch%' AND a.alamat LIKE '%$alamatSearch%' AND a.produk LIKE '%$produkSearch%' AND a.qty LIKE '%$qtySearch%' AND a.hna LIKE '%$hnaSearch%' AND a.gsv LIKE '%$gsvSearch%' AND a.disc_p LIKE '%$disc_pSearch%' AND a.vdisc_p LIKE '%$vdisc_pSearch%' AND a.valuenet LIKE '%$valuenetSearch%' AND a.batch LIKE '%$batchSearch%' AND a.nodpfdpl LIKE '%$dpfdplSearch%' AND a.divisi LIKE '%$divisiSearch%' AND a.subdiv LIKE '%$subdivSearch%'";
        // var_dump($query);
        $hsl = $dbCon->execute($query);
        $jumRecord = $dbCon->getNumRows($hsl);
        $sum = ceil($jumRecord / $limit);

        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal = pageNavSearch($hm, $sum, $limit, $distSearch, $cabSearch, $distkotaSearch, $tglfakturSearch, $nofakturSearch, $outletSearch, $alamatSearch, $produkSearch, $qtySearch, $hnaSearch, $gsvSearch, $disc_pSearch, $vdisc_pSearch, $valuenetSearch, $batchSearch, $dpfdplSearch, $divisiSearch, $subdivSearch);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */

        //-------------- hasil query berdasarkan paging
        $rsTampil = $dbCon->execute($query . " LIMIT $start, $limit");
        $n = $start + 1;
        $no = 1;


        $test = [];
        if ($jumRecord == 0 || $jumRecord == NULL) {
            $txtData = '';
            $txtExcel = 'data kosong';
        } else {
            foreach ($rsTampil as $row) {
                $test[] = [
                    'no' => $n,
                    'dist' => $row['dist'],
                    'cab' => $row['cab'],
                    'distkota' => $row['distkota'],
                    'tglfaktur' => dateindo($row['tglfaktur']),
                    'nofaktur' => $row['nofaktur'],
                    'outlet' => $row['outlet'],
                    'alamat' => $row['alamat'],
                    'produk' => $row['produk'],
                    'qty' => number_format($row['qty'], 0, ",", "."),
                    'hna' => number_format($row['hna'], 0, ",", "."),
                    'gsv' => number_format($row['gsv'], 0, ",", "."),
                    'disc_p' => $row['disc_p'],
                    'vdisc_p' => number_format($row['vdisc_p'], 0, ",", "."),
                    'valuenet' => number_format($row['valuenet'], 0, ",", "."),
                    'batch' => $row['batch'],
                    'nodpfdpl' => $row['nodpfdpl'],
                    'divisi' => $row['divisi'],
                    'subdiv' => $row['subdiv']
                ];

                $txtData .= "laporanpdu|" . $n . "|" . $row['dist'] . "|" . $row['cab'] . "|" . $row['distkota'] . "|" . dateindo($row['tglfaktur']) . "|" . $row['nofaktur'] . "|" . $row['outlet'] . "|" . $row['alamat'] . "|" . $row['produk'] . "|" . number_format($row['qty'], 0, ",", ".") . "|" . number_format($row['hna'], 0, ",", ".") . "|" . number_format($row['gsv'], 0, ",", ".") . "|" . $row['disc_p'] . "|" . number_format($row['vdisc_p'], 0, ",", ".") . "|" . number_format($row['valuenet'], 0, ",", ".") . "|" . $row['batch'] . "|" . $row['nodpfdpl'] . "|" . $row['divisi'] . "|" . $row['subdiv'] . "|^";
                $n++;
            }

            foreach ($hsl as $data) {
                $txtExcel .= $no . "|" . $data['dist'] . "|" . $data['cab'] . "|" . $data['distkota'] . "|" . dateindo($data['tglfaktur']) . "|" . $data['nofaktur'] . "|" . $data['outlet'] . "|" . $data['alamat'] . "|" . $data['produk'] . "|" . number_format($data['qty'], 0, ",", ".") . "|" . number_format($data['qty'], 0, ",", ".") . "|" . number_format($data['qty'], 0, ",", ".") . "|" . $data['disc_p'] . "|" . number_format($data['qty'], 0, ",", ".") . "|" . number_format($data['qty'], 0, ",", ".") . "|" . $data['batch'] . "|" . $data['dpfdpl'] . "|" . $data['divisi'] . "|" . $data['subdiv'] . "^";
                $no++;
            }
        }
        echo json_encode($test) . "!" . $linkHal . "!" . $txtExcel;

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


function pageNavSearch(
    $curHal,
    $maxHal,
    $jmlTampil,
    $distSearch,
    $cabSearch,
    $distkotaSearch,
    $tglfakturSearch,
    $nofakturSearch,
    $outletSearch,
    $alamatSearch,
    $produkSearch,
    $qtySearch,
    $hnaSearch,
    $gsvSearch,
    $disc_pSearch,
    $vdisc_pSearch,
    $valuenetSearch,
    $batchSearch,
    $dpfdplSearch,
    $divisiSearch,
    $subdivSearch
) {
    $linkHal = "";
    $halTengah = round($jmlTampil / 2);
    if ($maxHal > 0) {
        if ($curHal > 1) {
            $previous = $curHal - 1;
            $linkHal .= "<a class='nextprev' onclick='getData(1, \"$distSearch\", \"$cabSearch\", \"$distkotaSearch\", \"$tglfakturSearch\", \"$nofakturSearch\", \"$outletSearch\", \"$alamatSearch\", \"$produkSearch\", \"$qtySearch\", \"$hnaSearch\", \"$gsvSearch\", \"$disc_pSearch\", \"$vdisc_pSearch\", \"$valuenetSearch\", \"$batchSearch\", \"$dpfdplSearch\", \"$divisiSearch\", \"$subdivSearch\")'> First</a> &nbsp";
            $linkHal .= " <a class='nextprev' onclick='getData($previous, \"$distSearch\", \"$cabSearch\", \"$distkotaSearch\", \"$tglfakturSearch\", \"$nofakturSearch\", \"$outletSearch\", \"$alamatSearch\", \"$produkSearch\", \"$qtySearch\", \"$hnaSearch\", \"$gsvSearch\", \"$disc_pSearch\", \"$vdisc_pSearch\", \"$valuenetSearch\", \"$batchSearch\", \"$dpfdplSearch\", \"$divisiSearch\", \"$subdivSearch\")'> Prev</a> &nbsp";
        } elseif (empty($curHal) || $curHal == 1) {
            $linkHal .= "<a class='nextprev'>First</a><a class='nextprev'> Prev </a> ";
        }
        $angka = "";
        for ($i = $curHal - ($halTengah - 1); $i < $curHal; $i++) {
            if ($i < 1)
                continue;
            $angka .= "<a class='num' onclick='getData($i, \"$distSearch\", \"$cabSearch\", \"$distkotaSearch\", \"$tglfakturSearch\", \"$nofakturSearch\", \"$outletSearch\", \"$alamatSearch\", \"$produkSearch\", \"$qtySearch\", \"$hnaSearch\", \"$gsvSearch\", \"$disc_pSearch\", \"$vdisc_pSearch\", \"$valuenetSearch\", \"$batchSearch\", \"$dpfdplSearch\", \"$divisiSearch\", \"$subdivSearch\")'>$i</a> ";
        }

        $angka .= "<span class='current'><b>$curHal</b> </span>";
        for ($i = $curHal + 1; $i < ($curHal + $halTengah); $i++) {
            if ($i > $maxHal)
                break;
            $angka .= "<a class='num' onclick='getData($i, \"$distSearch\", \"$cabSearch\", \"$distkotaSearch\", \"$tglfakturSearch\", \"$nofakturSearch\", \"$outletSearch\", \"$alamatSearch\", \"$produkSearch\", \"$qtySearch\", \"$hnaSearch\", \"$gsvSearch\", \"$disc_pSearch\", \"$vdisc_pSearch\", \"$valuenetSearch\", \"$batchSearch\", \"$dpfdplSearch\", \"$divisiSearch\", \"$subdivSearch\")'>$i</a> ";
        }

        $linkHal .= $angka;

        if ($curHal < $maxHal) {
            $next = $curHal + 1;
            $linkHal .= " <a class='nextprev' onclick='getData($next, \"$distSearch\", \"$cabSearch\", \"$distkotaSearch\", \"$tglfakturSearch\", \"$nofakturSearch\", \"$outletSearch\", \"$alamatSearch\", \"$produkSearch\", \"$qtySearch\", \"$hnaSearch\", \"$gsvSearch\", \"$disc_pSearch\", \"$vdisc_pSearch\", \"$valuenetSearch\", \"$batchSearch\", \"$dpfdplSearch\", \"$divisiSearch\", \"$subdivSearch\")'>Next </a>&nbsp;&nbsp;<a class='nextprev' onclick='getData($maxHal, \"$distSearch\", \"$cabSearch\", \"$distkotaSearch\", \"$tglfakturSearch\", \"$nofakturSearch\", \"$outletSearch\", \"$alamatSearch\", \"$produkSearch\", \"$qtySearch\", \"$hnaSearch\", \"$gsvSearch\", \"$disc_pSearch\", \"$vdisc_pSearch\", \"$valuenetSearch\", \"$batchSearch\", \"$dpfdplSearch\", \"$divisiSearch\", \"$subdivSearch\")'>Last</a> ";
        } else {
            $linkHal .= " <a class='nextprev'>Next</a><a class='nextprev'>Last</a> ";
        }
    }
    return $linkHal;
}
