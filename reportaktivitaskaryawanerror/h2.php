<?php include("../functions/koneksi.php");
include("../functions/function.php");


//data post
$bulangaji = $_POST['bulangaji'];
$tahungaji = $_POST['tahungaji'];
$kodenik = $_POST['kodenik'];
$namakry = $_POST['namakry'];
$kodedivisi = $_POST['kodedivisi'];
$hm = $_POST['hal'];
$mode = $_POST['mode'];


// $namakry = '2230183'; //hardcode




if (!empty($mode)) {
    if ($mode == 'retrieveData') {
        $dbCon->execute("BEGIN");

        $txt = "";
        $limit = 100;
        if (empty($hm) || $hm == 1) {
            $start = 0;
        } else {
            $start = ($hm - 1) * $limit;
        }

        // $bulangaji = 10; // hardcode
        // $tahungaji = 2023; // hardcode

        //query untuk menentukan tglawal dan akhir berdasarkan bulangaji dan tahungaji hk
        $cariHK = "SELECT h.tanggalAwal tglAwal, h.tanggalAkhir tglAkhir, h.hk hk FROM absensi.harikerja h WHERE h.bln = '$bulangaji' AND h.thn = '$tahungaji' AND h.kodenik = ''";
        $hslHK = $dbCon->execute($cariHK);
        while ($result = $dbCon->getArray($hslHK)) {
            $tglAwal  = $result['tglAwal'];
            $tglAkhir = $result['tglAkhir'];
            $jumHk = $result['hk'];
        }


        // var_dump($tglAwal);
        // var_dump($tglAkhir);
        // var_dump($jumHk);
        // exit();
        // $jumHk = 25; // hardcode;

        $tglAwalExplode = explode('-', $tglAwal);
        $tglAwalPecah = $tglAwalExplode[0] . '-' . $tglAwalExplode[1] . '-'; // untuk menyesuaikan query Y-m-

        $tglAkhirExplode = explode('-', $tglAkhir);
        $tglAkhirPecah = $tglAkhirExplode[0] . '-' . $tglAkhirExplode[1] . '-'; // untuk menyesuaikan query Y-m-


        //get nik karyawan 
        //        $getNIKAbsen = "SELECT k.*, nikGabung, nikBaru FROM absensi.master_karyawan k 
        //        LEFT JOIN (SELECT kodenik,namakry,tgllahir,SUBSTRING(GROUP_CONCAT(DISTINCT CONCAT(\"'\",kodedivisi,\"'\") ORDER BY namakry,tgllahir,tglKeluar DESC),2,LOCATE(\"'\",GROUP_CONCAT(DISTINCT CONCAT(\"'\",kodedivisi,\"'\") ORDER BY namakry,tgllahir,tglKeluar DESC),5)-2) kodedivisi,GROUP_CONCAT(DISTINCT CONCAT(\"'\",kodenik,\"'\")) nikGabung,SUBSTRING(GROUP_CONCAT(DISTINCT CONCAT(\"'\",kodenik,\"'\") ORDER BY namakry,tgllahir,tglKeluar DESC),2,LOCATE(\"'\",GROUP_CONCAT(DISTINCT CONCAT(\"'\",kodenik,\"'\") ORDER BY namakry,tgllahir,tglKeluar DESC),5)-2) nikBaru FROM absensi.master_karyawan GROUP BY namakry,tgllahir) kk ON kk.namakry=k.namakry AND kk.tgllahir=k.tgllahir
        //        WHERE  k.kodenik='" . $namakry . "'";
        // $query = "SELECT  m.kodenik kodenik,  m.namakry namakry FROM absensi.master_karyawan m
        // INNER JOIN absensi.karyawan_aktif k ON k.namakry=m.namakry AND k.tgllahir=m.tgllahir WHERE m.`namakry` LIKE '%" . $_POST['term'] . "%' AND k.blngaji='$bulangaji' AND k.thngaji=$tahungaji GROUP BY m.namakry,m.tgllahir ORDER BY m.namakry LIMIT {$end}, {$start}";
        // $hsl2 = $dbCon->execute($query);
        // if ($dbCon->getNumRows($hsl2) <= 0) {
        //     if ($bulangaji == 1) {
        //         $bulangaji = 12;
        //         $tahungaji = $tahungaji - 1;
        //     } else {
        //         $bulangaji = $bulangaji - 1;
        //     }
        // }
        $getNIKAbsen = "SELECT kk.* FROM (SELECT k.* FROM (SELECT * FROM absensi.`master_karyawan` WHERE kodenik LIKE '%" . $namakry . "%') m INNER JOIN  (SELECT * FROM absensi.`karyawan_aktif` WHERE thngaji='" . $tahungaji . "' AND blngaji='" . $bulangaji . "') k ON k.namakry=m.`namakry` AND k.tgllahir=m.`tgllahir` GROUP BY namakry,tgllahir) ka
        LEFT JOIN (SELECT kodenik,namakry,tgllahir,GROUP_CONCAT(DISTINCT CONCAT(\"'\",kodenik,\"'\")) nikGabung,SUBSTRING(GROUP_CONCAT(DISTINCT CONCAT(\"'\",kodenik,\"'\") ORDER BY namakry,tgllahir,tglKeluar DESC),2,LOCATE(\"'\",GROUP_CONCAT(DISTINCT CONCAT(\"'\",kodenik,\"'\") ORDER BY namakry,tgllahir,tglKeluar DESC),5)-2) nikBaru FROM absensi.master_karyawan GROUP BY namakry,tgllahir) kk ON kk.namakry=ka.namakry AND kk.tgllahir=ka.tgllahir ";

        $txt = "";
        $hslAll = $dbCon->execute($getNIKAbsen);
        $jumAll = $dbCon->getNumRows($hslAll);

        //var_dump($hsl); exit();
        while ($resultNIK = $dbCon->getArray($hslAll)) {
            $namaKaryawan = $resultNIK['namakry'];
            $nikKaryawan = $resultNIK['kodenik'];
            $nikGabung = $resultNIK['nikGabung'];
            $nikBaru = $resultNIK['nikBaru'];
            $kodeDivisiKaryawan = $resultNIK['kodedivisi'];

            //query get data 
            $query = "SELECT '$nikBaru' kodenik ,'$namaKaryawan' namakry, '$kodeDivisiKaryawan' kodedivisi, DATE AS tanggal, hari, checkIn, checkOut, jenis, kriteriacuti, penyimpanganall, keterangan, `status`,statusProses FROM (SELECT FROM_UNIXTIME(UNIX_TIMESTAMP(CONCAT('$tglAwalPecah',n)),'%Y-%m-%d') AS DATE, DAYNAME(FROM_UNIXTIME(UNIX_TIMESTAMP(CONCAT('$tglAwalPecah',n)),'%Y-%m-%d')) hari FROM (
				SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS n
						FROM  (SELECT 0 UNION ALL SELECT 1) AS b0,
							  (SELECT 0 UNION ALL SELECT 1) AS b1,
							  (SELECT 0 UNION ALL SELECT 1) AS b2,
							  (SELECT 0 UNION ALL SELECT 1) AS b3,
							  (SELECT 0 UNION ALL SELECT 1) AS b4 ) t
				WHERE n >= $jumHk AND n <= DAY(LAST_DAY('$tglAwal'))
				UNION SELECT FROM_UNIXTIME(UNIX_TIMESTAMP(CONCAT('$tglAkhirPecah',m)),'%Y-%m-%d') AS DATE, DAYNAME(FROM_UNIXTIME(UNIX_TIMESTAMP(CONCAT('$tglAkhirPecah',m)),'%Y-%m-%d')) hari FROM (
				SELECT (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 AS m
						FROM  (SELECT 0 UNION ALL SELECT 1) AS b0,
							  (SELECT 0 UNION ALL SELECT 1) AS b1,
							  (SELECT 0 UNION ALL SELECT 1) AS b2,
							  (SELECT 0 UNION ALL SELECT 1) AS b3,
							  (SELECT 0 UNION ALL SELECT 1) AS b4 ) t
				WHERE m > 0 AND m <= DAY('$tglAkhir')) ld
				LEFT JOIN (SELECT tanggal,nik,MIN(waktu) checkIn, IF(COUNT(nik)>1,MAX(waktu),\"-\") checkOut FROM absensi.attendanceonline WHERE nik in (" . $nikGabung . ") GROUP BY tanggal) att ON ld.DATE=att.tanggal
				LEFT JOIN (SELECT DATE_FORMAT(detil.tanggal, '%Y-%m-%d') AS tanggal ,detil.nik,detil.jenis,detil.kriteriacuti,detil.keterangan, detil.penyimpanganall,detil.status,po.statusProses FROM (SELECT *,GROUP_CONCAT(penyimpangan) penyimpanganall  FROM absensi.`detailpengajuanpenyimpangan` WHERE nik IN (" . $nikGabung . ") AND tanggal>='" . $tglAwal . "' AND tanggal<='" . $tglAkhir . "' and status not like '%ditolakatasan%' GROUP BY tanggal) detil
				LEFT JOIN (SELECT * FROM absensi.`penyimpanganonline` WHERE nik IN (" . $nikGabung . ") AND tanggal>='" . $tglAwal . "' AND tanggal<='" . $tglAkhir . "') po ON po.tanggal=detil.tanggal AND po.nik=detil.nik) p ON ld.DATE=p.tanggal GROUP BY date 
				ORDER BY DATE";
            //array translate day sql mjd bahasa indonesia
            $dayToHari = array(
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu',
                'Sunday'    => 'Minggu',
            );

            $hsl = $dbCon->execute($query);
            $jum = $dbCon->getNumRows($hsl);

            while ($result = $dbCon->getArray($hsl)) {

                $result['checkIn'] = $result['checkIn'] ?? '-';
                $result['checkOut'] = $result['checkOut'] ?? '-';
                $result['keterangan'] = $result['keterangan'] ?? '-';

                //kondisi untuk jenis || kriteria kosong
                $result['jenis'] = $result['jenis'] ?? '';
                $result['kriteriacuti'] = $result['kriteriacuti'] ?? '';

                $penyimpangan = $result['penyimpanganall'];
                $penyimpangan = ($penyimpangan == ' - ') ? '-' : $penyimpangan;

                //hari dalam bindo
                $result['hari'] = $dayToHari[$result['hari']] ?? $result['hari'];
                //getstatuspenyimpangan
                if ($result['status'] == "finish" && $result['statusProses'] == "false") {
                    $statusTampil = "di Antrian HRD";
                } elseif ($result['status'] == "finish" && $result['statusProses'] == "true") {
                    $statusTampil = "di Setujui HRD";
                } else {
                    $statusTampil = $result['status'];
                }

                $txt .= "gridReportAktivitasKaryawan|" . $result['kodenik'] . "|"
                    . $result['namakry'] . "|" . $result['kodedivisi'] . "|" . $result['tanggal'] . "|" . $result['hari'] . "|" . $result['checkIn'] . "|" . $result['checkOut'] . "|" . $penyimpangan . "|" . $result['keterangan'] . "|" . $statusTampil . "||^";
            }
        }
        echo $txt . "~!~" . $jumAll;
    }
    //ketika mode kosong
} else {
    // utk get value select lazy loads
    $page = $_POST['page'];
    $resultCount = 10;
    $end = ($page - 1) * $resultCount;
    $start = $end + $resultCount;
    if (!empty($bulangaji) && !empty($tahungaji)) {
        // ketka bulan gaji dan tahun gaji ada... yaitu ketika onchange
        $query = "SELECT  m.kodenik kodenik,  m.namakry namakry FROM absensi.master_karyawan m
        INNER JOIN absensi.karyawan_aktif k ON k.namakry=m.namakry AND k.tgllahir=m.tgllahir WHERE m.`namakry` LIKE '%" . $_POST['term'] . "%' AND k.blngaji='$bulangaji' AND k.thngaji=$tahungaji GROUP BY m.namakry,m.tgllahir ORDER BY m.namakry LIMIT {$end}, {$start}";
        $hsl2 = $dbCon->execute($query);
        if (($dbCon->getNumRows($hsl2)) <= 0) {
            if ($bulangaji == 1) {
                $bulangaji = 12;
                $tahungaji = $tahungaji - 1;
            } else {
                $bulangaji = $bulangaji - 1;
            }
            $query = "SELECT  m.kodenik kodenik,  m.namakry namakry FROM absensi.master_karyawan m
        INNER JOIN absensi.karyawan_aktif k ON k.namakry=m.namakry AND k.tgllahir=m.tgllahir WHERE m.`namakry` LIKE '%" . $_POST['term'] . "%' AND k.blngaji='$bulangaji' AND k.thngaji=$tahungaji GROUP BY m.namakry,m.tgllahir ORDER BY m.namakry LIMIT {$end}, {$start}";
        }
    } else {
        // ketika tidak ada maka mengikuti tabel harikerja .. yaitu ketika onload
        $hariKerja = "SELECT * FROM absensi.harikerja h WHERE tanggalawal<='" . date('Y-m-d') . "' AND tanggalakhir>='" . date('Y-m-d') . "' AND kodenik=''";
        $cariHK = $dbCon->execute($hariKerja);

        while ($resultHK = $dbCon->getArray($cariHK)) {
            $bulangaji = $resultHK['bln'];
            $tahungaji = $resultHK['thn'];
        }

        // $bulangaji = 11;
        if ($bulangaji == 1) {
            $bulangaji = 12;
            $tahungaji = $tahungaji - 1;
        } else {
            $bulangaji = $bulangaji - 1;
        }

        // $tahungaji  = 2023; //hardcode
        // $bulangaji = 10; //hardcode
        // $tahungaji = 2023; //hardcode

        $query = "SELECT  m.kodenik kodenik,  m.namakry namakry FROM absensi.master_karyawan m
        INNER JOIN absensi.karyawan_aktif k ON k.namakry=m.namakry AND k.tgllahir=m.tgllahir WHERE m.`namakry` LIKE '%" . $_POST['term'] . "%' AND k.blngaji='$bulangaji' AND k.thngaji='$tahungaji' GROUP BY m.namakry,m.tgllahir ORDER BY m.namakry LIMIT {$end}, {$start}";
    }



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
}
