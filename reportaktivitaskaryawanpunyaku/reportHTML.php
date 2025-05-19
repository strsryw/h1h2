<?php
include("../functions/function.php");
$data         = $_POST['buffer'];
$bulangaji    = $_POST['bulangaji'];
$tahungaji    = $_POST['tahungaji'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Check Karyawan Aktif</title>
    <link type="text/css" href="../functions/style.css" rel="stylesheet" />
    <style type="text/css">
        #container {
            width: 1600px;
            margin: 0 auto
        }

        .tabel,
        .tabel td {
            padding: 5px;
            border: 1px solid black;
            border-collapse: collapse
        }

        .tabel thead td {
            font-weight: 700
        }

        .tabel tbody td {
            padding-top: 6px;
            padding-bottom: 6px;
            vertical-align: top;
        }

        .padleft {
            text-align: left;
            padding-left: 2px;
        }

        body {
            background-image: none !important;
            background-color: #FFF !important;
        }
    </style>
</head>

<body>
    <div id="container">
        <table width="1500" border="0" align="center" cellspacing="0" cellpadding="0">
            <tr>
                <th valign="middle" style="padding:20px 0">LAPORAN AKTIVITAS KARYAWAN AKTIF<br />
                    Periode: <?php echo namaBulan($bulangaji) . " " . $tahungaji; ?></th>
            </tr>
        </table>
        <table width="1600" border="0" align="center" cellspacing="0" cellpadding="0" class="tabel">
            <thead>
                <tr valign="middle" align="center">
                    <td width="40" height="40" align="center">No</td>
                    <td width="150" align="center">NIK</td>
                    <td width="150" align="center">Nama Karyawan</td>
                    <td width="150" align="center">Kode Divisi</td>
                    <td width="150" align="center">Tanggal</td>
                    <td width="150" align="center">Hari</td>
                    <td width="150" align="center">Checkin</td>
                    <td width="150" align="center">Checkout</td>
                    <td width="200" align="center">Penyimpangan</td>
                    <td width="150" align="center">Keterangan</td>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $no = 1;
                while (!strrpos($data, "^") === false) {
                    $iValue = substr($data, 0, strpos($data, "^"));
                    if (substr(strrev($iValue), 0, 4) <> "|||") {
                        $iValue = $iValue . "|||";
                    } else {
                        $iValue = $iValue;
                    }
                    $data = substr($data, strpos($data, "^") + 1, strlen($data));
                    $tablename = trim(getColumnValue($iValue, 1));
                    if (trim($tablename) == "gridReportAktivitasKaryawan") {
                        $i = 0;
                        while (!strrpos($iValue, "|") === false) {
                            $lenIValue = (int) strlen($iValue);
                            $cValue = substr($iValue, 0, strpos($iValue, "|"));
                            $iValue = substr($iValue, strpos($iValue, "|") + 1, strlen($iValue));
                            if ($i == 1) {
                                $kodenik = $cValue;
                            }
                            if ($i == 2) {
                                $namakry = $cValue;
                            }
                            if ($i == 3) {
                                $kodedivisi = $cValue;
                            }
                            if ($i == 4) {
                                $tanggal = $cValue;
                            }
                            if ($i == 5) {
                                $hari = $cValue;
                            }
                            if ($i == 6) {
                                $checkin = $cValue;
                            }
                            if ($i == 7) {
                                $checkout = $cValue;
                            }
                            if ($i == 8) {
                                $penyimpangan = $cValue;
                            }
                            if ($i == 9) {
                                $keterangan = $cValue;
                            }

                            $i++;
                        }
                ?>
                        <tr align="center">
                            <td><?php echo $no; ?></td>
                            <td class="padleft"><?php echo $kodenik; ?></td>
                            <td class="padleft"><?php echo $namakry; ?></td>
                            <td align="left"><?php echo $kodedivisi; ?></td>
                            <td align="right"><?php echo $tanggal; ?></td>
                            <td align="right"><?php echo $hari; ?></td>
                            <td align="center"><?php echo $checkin; ?></td>
                            <td align="center"><?php echo $checkout; ?></td>
                            <td align="left"><?php echo $penyimpangan; ?></td>
                            <td align="left"><?php echo $keterangan; ?></td>

                        </tr>
                <?php
                        $no++;
                    }
                }
                ?>
            </tbody>
        </table><br />
        <div style="clear:both"></div>
    </div>
</body>

</html>