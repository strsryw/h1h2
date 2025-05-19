<?php
include("../functions/koneksi.php");
// include("../functions/session.php");
include("../functions/function.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Aktivitas Karyawan </title>
    <!-- echo $this->Html->script('select2.js'); -->
    <!-- echo $this->Html->css('select2.css'); -->
    <link type="text/css" href="../base/aw.css" rel="stylesheet" />
    <link type="text/css" href="../functions/style.css" rel="stylesheet" />
    <link type="text/css" href="../functions/select2.css" rel="stylesheet" />
    <link type="text/css" href="../functions/style.css" rel="stylesheet" />
    <link type="text/css" href="../functions/jquery/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
    <link href="../functions/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        /* #gridReportAktivitasKaryawan .aw-header-0 .aw-column-0,
        #gridReportAktivitasKaryawan .aw-header-0 .aw-column-1,
        #gridReportAktivitasKaryawan .aw-header-0 .aw-column-2,
        #gridReportAktivitasKaryawan .aw-header-0 .aw-column-3 {
            text-align: center
        } */

        .select2-selection__rendered {
            line-height: 20px !important;
            width: 130px;
        }

        .select2-container .select2-selection--single {
            height: 20px !important;
        }

        .select2-selection__arrow {
            height: 20px !important;
        }

        /* nik  */
        .aw-column-0 {
            width: 100px;
            text-align: left
        }

        /* nama  */
        .aw-column-1 {
            width: 250px;
            text-align: left
        }

        /* kode divisi  */
        .aw-column-2 {
            width: 180px;
            text-align: center
        }

        /* tanggal  */
        .aw-column-3 {
            width: 120px;
            text-align: right
        }

        /* hari  */
        .aw-column-4 {
            width: 120px;
            text-align: right
        }

        /* checkin  */
        .aw-column-5 {
            width: 120px;
            text-align: center
        }

        /* checkout  */
        .aw-column-6 {
            width: 120px;
            text-align: center
        }

        /* kriteria  */
        .aw-column-7 {
            width: 200px;
            text-align: center
        }

        /* jenis  */
        .aw-column-8 {
            width: 200px;
            text-align: left
        }

        /* status  */
        .aw-column-9 {
            width: 110px;
            text-align: left
        }

        /* keterangan  */



        table tr td {
            height: 25px;
        }
    </style>
    <script type="text/javascript">
        parent.document.title = document.title;
    </script>
    <script type="text/javascript" src="../base/aw.js"></script>
    <script type="text/javascript" src="../base/functions.js"></script>
    <!-- <script type="text/javascript" src="../functions/jQuery/js/jquery-ui-1.8.2.custom.min.js"></script>  -->
    <script type="text/javascript" src="../functions/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="../functions/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../functions/jquery/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript" src="h1.js"></script>
    <script type="text/javascript" src="../functions/select2.js"></script>
</head>
<div id="loading" style="display:none">Loading...</div>

<body class="body">
    <!-- <?php include('../header.php'); ?> -->
    <h3>Laporan Aktivitas Karyawan </h3>
    <form name="h1form" action="" method="post">
        <table width="" border="0" cellpadding="0" cellspacing="0" id="masterreportaktivitaskaryawan">
            <tr>
                <td width="110"><label>Periode</label></td>

                <td>:</td>
                <td> <?php inp_bulan('bulangaji'); ?></td>
                <td><?php inp_tahun('tahungaji'); ?></td>
            </tr>
            <tr>
                <td><label>Nama Karyawan</label></td>
                <td>: </td>
                <td colspan="2"><select name="namakry" id="namakry" class="select2"></select></td>
                <td></td>
            </tr>
            <tr hidden>
                <td><label>Kode NIK</label></td>
                <td>: </td>
                <td><input name="kodenik" /></td>
            </tr>
            <tr hidden>
                <td><label>Kode Divisi</label></td>
                <td>: </td>
                <td><input name="kodedivisi" /></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;&nbsp;</td>
                <td colspan="2"><input type="button" value="Cari Data" name="Ambil" onClick="cariData('srch')" /></td>
                <td></td>
            </tr>
        </table>
        <!--<div id="linkHal" style="height:18px; font-weight:bold; display:block;"></div>
	<label id="maxHal" style="display:none"></label>-->
        <script type='text/javascript'>
            var gridReportAktivitasKaryawan = new AW.UI.Grid;
            gridReportAktivitasKaryawan.setId("gridReportAktivitasKaryawan");
            gridReportAktivitasKaryawan.setSize(1600, 700);
            gridReportAktivitasKaryawan.setHeaderHeight(25);
            gridReportAktivitasKaryawan.setHeaderText(["NIK",
                "Nama Karyawan", "Kode Divisi", "Tanggal", "Hari", "Check In", "Check Out", "Penyimpangan", "Keterangan", "Status"
            ]);
            gridReportAktivitasKaryawan.setColumnIndices([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
            gridReportAktivitasKaryawan.setColumnCount(gridReportAktivitasKaryawan.getColumnIndices().length);
            gridReportAktivitasKaryawan.setColumnResizable(false);
            gridReportAktivitasKaryawan.setCellEditable(true);
            gridReportAktivitasKaryawan.setSelectionMode("single-row");
            gridReportAktivitasKaryawan.setSelectorVisible(true);
            gridReportAktivitasKaryawan.setSelectorWidth(50);
            gridReportAktivitasKaryawan.setSelectorText(function(i) {
                return this.getRowPosition(i) + 1
            });
            document.write(gridReportAktivitasKaryawan);
        </script>
        <br />
        <input type="button" value="Cetak Laporan" name="Cetak" onClick="cetakLap()" />
        <input type="button" value="Cetak Excel" name="CetakX" onClick="cetakLap('excel')" />
        <textarea name="buffer" cols="50" rows="10" class="textBuff" style="display: inline-block;"></textarea>
        <textarea name="bufferhelper" cols="50" rows="10" class="textBuff"></textarea>
    </form>

    <div class="modal fade" id="modalPenyimpangan" role="dialog" aria-labelledby="modalPenyimpangan" style="outline: 0;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;">
                    <table class="table">
                        <tr>
                            <td>NIK</td>
                            <th id="txtNIKp"></th>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <th id="txtNamap"></th>
                        </tr>
                    </table>
                    <table id="tablePopPenyimpangan" class="table table-bordered">
                        <thead>
                            <tr class="active">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Kriteria</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <tr>
                                <td colspan="10" style="text-align:center; background-color:#fff !important;">
                                    <div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Empty Data</strong></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTotal" role="dialog" aria-labelledby="modalTotal" style="outline: 0;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 6px;min-height: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" style="overflow-x:auto; padding-top:0;padding-bottom:0;">
                    <table class="table">
                        <tr>
                            <td>NIK</td>
                            <th id="txtNIKt"></th>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <th id="txtNamat"></th>
                        </tr>
                    </table>
                    <table id="tablePopTotal" class="table table-bordered">
                        <thead>
                            <tr class="active">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Absen Masuk</th>
                                <th>Absen Keluar</th>
                                <th>Source</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="10" style="text-align:center; background-color:#fff !important;">
                                    <div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Empty Data</strong></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>