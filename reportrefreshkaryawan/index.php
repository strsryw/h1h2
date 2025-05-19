<?php
include("../functions/koneksi.php");
//include("../functions/session.php");
include("../functions/function.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Laporan upload refresh karyawan
  </title>
  <link type="text/css" href="../base/aw.css" rel="stylesheet" />
  <link type="text/css" href="../functions/style.css" rel="stylesheet" />
  <!-- setting server -->
  <!-- <link type="text/css" href="../functions/jQuery/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" />  -->
  <!-- setting localhost -->
  <link type="text/css" href="../functions/jQuery/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
  <link href="../functions/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

  <style type="text/css">
    #gridReportRefresh {
      width: 770px;
      height: 310px
    }

    .aw-header-0 .aw-column-0,
    .aw-header-0 .aw-column-1,
    .aw-header-0 .aw-column-2,
    .aw-header-0 .aw-column-21,
    .aw-header-0 .aw-column-25 {
      text-align: center
    }

    #gridhide {
      width: 1200px;
      height: 500px
    }

    .aw-header-0 .aw-column-0,
    .aw-header-0 .aw-column-1,
    .aw-header-0 .aw-column-2,
    .aw-header-0 .aw-column-21,
    .aw-header-0 .aw-column-25 {
      text-align: center
    }

    .aw-column-0 {
      width: 30px;
      text-align: center
    }

    .aw-column-1 {
      width: 100px;
      text-align: center
    }

    .aw-column-2 {
      width: 100px;
      text-align: center
    }

    .aw-column-3 {
      width: 200px;
      text-align: center
    }

    .aw-column-4 {
      width: 100px;
      text-align: center
    }

    .aw-column-5 {
      width: 200px;
      text-align: left
    }

    .aw-column-6 {
      width: 100px;
      text-align: center
    }

    .aw-column-7 {
      width: 100px;
      text-align: center
    }

    .aw-column-8 {
      width: 100px;
      text-align: center
    }

    .aw-column-9 {
      width: 100px;
      text-align: center
    }

    .aw-column-10 {
      width: 100px;
      text-align: center
    }

    .aw-column-11 {
      width: 100px;
      text-align: center
    }

    .aw-column-12 {
      width: 100px;
      text-align: center
    }

    .aw-column-13 {
      width: 100px;
      text-align: center
    }

    .aw-column-14 {
      width: 100px;
      text-align: center
    }

    .aw-column-15 {
      width: 100px;
      text-align: center
    }

    .aw-column-16 {
      width: 100px;
      text-align: center
    }

    .aw-column-17 {
      width: 100px;
      text-align: center
    }

    .aw-column-18 {
      width: 100px;
      text-align: center
    }

    .aw-column-19 {
      width: 100px;
      text-align: center
    }

    .aw-column-20 {
      width: 100px;
      text-align: center
    }

    .aw-column-21 {
      width: 100px;
      text-align: center
    }

    .aw-column-22 {
      width: 100px;
      text-align: center
    }

    .aw-column-23 {
      width: 100px;
      text-align: center
    }

    .aw-column-24 {
      width: 100px;
      text-align: center
    }

    .aw-column-25 {
      width: 100px;
      text-align: center
    }

    .aw-column-26 {
      width: 100px;
      text-align: center
    }

    .aw-column-27 {
      width: 100px;
      text-align: center
    }

    .aw-column-28 {
      width: 100px;
      text-align: center
    }

    /*.aw-column-4, .aw-column-6, .aw-column-7, .aw-column-8,
.aw-column-9, .aw-column-10,.aw-column-11,.aw-column-12,
.aw-column-14,.aw-column-15,.aw-column-16,.aw-column-17,
.aw-column-18,.aw-column-19,.aw-column-20,.aw-column-21,
.aw-column-22,.aw-column-23,.aw-column-24 {width: 100px; text-align:right}
.aw-column-5, .aw-column-13{width: 60px; text-align:left}
.aw-column-25 {width:150px; text-align:left}
.aw-column-26 {width:60px; text-align:left}*/
    table tr td {
      height: 25px;
    }
  </style>
  <script type="text/javascript">
    parent.document.title = document.title;
  </script>
  <script type="text/javascript" src="../base/aw.js"></script>
  <script type="text/javascript" src="../base/functions.js"></script>
  <!-- setting server -->
  <!--  <script type="text/javascript" src="../functions/jquery/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../functions/jquery/js/jquery-ui-1.8.2.custom.min.js"></script>  -->
  <!-- setting localhost -->

  <!-- <script type="text/javascript" src="../functions/jQuery/js/jquery-1.4.2.min.js"></script> -->
  <script type="text/javascript" src="../functions/jQuery/js/jquery-ui-1.8.2.custom.min.js"></script>
  <script type="text/javascript" src="../functions/jQuery/js/jquery.min.js"></script>
  <script type="text/javascript" src="../functions/bootstrap/js/bootstrap.min.js"></script>


  <script type="text/javascript" src="h1.js"></script>
</head>
<div id="loading" style="display:none">Loading...</div>

<body>
  <?php //include('../header.php'); 
  ?>
  <h3>Laporan Upload Refresh Karyawan</h3>
  <div id="dialog" style="display:none"></div>
  <form name="h1form" id="h1form" action="" method="post">
    <table width="1200" cellspacing="0" cellpadding="0" border="0">
      <tr height="10px">
        <td width="120">Periode Upload</td>
        <td width="200">

          <!-- untuk server
                                 -->
          <select name="bulan" id="bulan" class="form-control" onChange="setUploadke()" ;>
            <option value="" selected="selected">Pilih Bulan</option>
            <?php
            for ($t = 1; $t <= 12; $t++) {
              if ($t == date("n")) {
                echo "<option value=$t selected>" . namaBulan($t) . "</option>\n";
              } else {
                echo "<option value=$t>" . namaBulan($t) . "</option>\n";
              }
            }
            ?>
          </select>
          <select name="tahun" id="tahun" class="form-control" onChange="setUploadke()">
            <option value="" selected="selected">Pilih Tahun</option>
            <?php
            for ($t = date("Y") - 5; $t <= date("Y") + 10; $t++) {
              if ($t == date("Y")) {
                echo "<option value=$t selected>$t</option>\n";
              } else {
                echo "<option value=$t>$t</option>\n";
              }
            }
            ?>
          </select>
        </td>
        <td rowspan="6" valign="top">
          <fieldset style='width:850px'>
            Keterangan Halaman:
            <ol>
              <li>Halaman ini merepresentasikan,dari hasil setiap file excel yang di upload dari halaman report refresh karyawan</li>
              <li>Seluruh record dari file yang di excel, akan ditampilkan di GRID di bawah ini beserta status eksekusi</li>
            </ol>
            Keterangan Filter:
            <ol>
              <li><strong>Periode Upload</strong> : Menunjukkan bulan dan tahun periode file diupload</li>
              <li><strong>Upload Ke</strong>: Menunjukkan data hasil file upload yang ke berapa, dari periode upload</li>
              <li><strong>Status</strong>: Terdapat 3 pilihan dalam status
                <ol>
                  <li><strong>Tampilkan semua</strong>: Akan menampilkan semua record data yang di upload, sesuai dengan <strong>periode dan upload ke</strong></li>
                  <li><strong>Sukses</strong>: Akan menampilkan record data dengan status Sukses</li>
                  <li><strong>Gagal</strong>: Akan menampilkan record data dengan status Gagal</li>
                </ol>
              </li>
              <li><strong>Keterangan</strong>: keterangan akan muncul berdasarkan pilihan status,dan hanya 2 yang menjadi parameter yaitu Sukses dan Gagal
                <ol>
                  <li>Sukses <strong>Tampil Semua</strong> : akan menampilkan semua record yang berhasil di proses</li>
                  <li>Sukses <strong>Forced Entry</strong> : hanya akan menampilkan record yang berhasil di proses dengan FORCED ENTRY</li>
                  <li>Gagal <strong>Tanggal Lahir Berbeda </strong> : menampilkam record yang gagal diproses karena tanggal lahir yang berbeda</li>
                  <li>Gagal <strong>Tanggal Masuk Berbeda (SEMUA DATA)</strong> : menampilkan semua record yang gagal diproses karena Tanggal Masuk Berbeda</li>
                  <li><em>Gagal <strong>Tanggal Masuk Berbeda (FORCED ENTRY)</strong> : menampilkan data yang gagal diproses, akan tetapi bisa diproses ulang atau dipaksakan masuk karena di identifikasi merupakan data yang baru</em></li>
                </ol>
              </li>
            </ol>
          </fieldset>
        </td>
      </tr>
      <tr height="10">
        <td>Upload ke</td>
        <td>
          <select name="filterUploadKe" id="filterUploadKe" class="form-control">
            <option value="All" selected="selected">Semua</option>
            <option value="1">I</option>
            <option value="2">II</option>
            <option value="3">III</option>
            <option value="4">IV</option>
            <option value="5">V</option>
            <option value="6">VI</option>

          </select>
        </td>
      </tr>
      <tr height="10">
        <td>Status</td>
        <td><select name="filterStatusUpload" id="filterStatusUpload" class="form-control" onchange="setKeterangan()">
            <option value="All" selected="selected">Tampilkan Semua</option>
            <option value="Sukses">Sukses</option>
            <option value="Gagal">Gagal</option>

          </select></td>
      </tr>
      <tr height="10" id='tdKet' style="display:none">
        <td>Keterangan</td>
        <td><select name="filterKeterangan" id="filterKeterangan" class="form-control">
            <option value="All" selected="selected">Tampil Semua</option>
            <option value="Forced">Forced Entry</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="button" value="Proses" name="Proses" onClick="prosesAmbilData('srch')" /></td>
      </tr>
      <tr height="200">
        <td></td>
        <td></td>
      </tr>
    </table>

    <!-- <span onLoad="onLoadHandler()" ></span> -->

    <script type='text/javascript'>
      var header = ["", "", "Status", "Ket. Status", "nik", "nama kry", "kode div", "kode dept", "kode area", "kode bagian", "kode subarea", "kode region", "kode lokasi", "jabatan", "status kry", "ket status kry", "kode makan", "tgl Lahir", "tgl coba", "tgl masuk", "tgl keluar", "tgl masuk jst", "plafoncuti", "j cuti awal", "j cuti bulan", "qty cuti sdbl", "bulan", "tahun", "Upload Ke"];
      //alert(cekOpen)
      // var gridReportRefresh = new AW.UI.Grid;
      //     gridReportRefresh.setId("gridReportRefresh");
      //     gridReportRefresh.setHeaderHeight(50);
      //     //gridReportRefresh.setCellTemplate(new AW.Templates.CheckBox, 0);
      //     gridReportRefresh.setHeaderText(header);
      //     gridReportRefresh.setColumnIndices([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27]);
      //     gridReportRefresh.setColumnCount(gridReportRefresh.getColumnIndices().length);
      //     gridReportRefresh.setColumnResizable(true);
      //     gridReportRefresh.setCellEditable(true);
      //     //var template = gridReportRefresh.getCellTemplate(); 
      //     //gridReportRefresh.setSelectionMode(false);        
      //     //console.log(gridReportRefresh.setSelectionMode(false))
      //     gridReportRefresh.setSelectionMode("single-row");
      //     //gridReportRefresh.setSelectionMode("multi-row-marker");
      //     gridReportRefresh.setSelectorVisible(true);
      //     gridReportRefresh.setSelectorWidth(42);
      //     gridReportRefresh.setSelectorText(function(i){return this.getRowPosition(i)+1}); 
      //     document.write(gridReportRefresh);

      var gridhide = new AW.UI.Grid;
      gridhide.setId("gridhide");
      gridhide.setHeaderHeight(50);
      var check = new AW.Templates.Checkbox;
      gridhide.setCellTemplate(check, 0);
      gridhide.setHeaderText(header);
      gridhide.setColumnIndices([0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29]);
      gridhide.setColumnCount(gridhide.getColumnIndices().length);
      gridhide.setColumnResizable(true);
      gridhide.setCellEditable(true);
      //var template = gridReportRefresh.getCellTemplate(); 
      //gridReportRefresh.setSelectionMode(false);        
      //console.log(gridReportRefresh.setSelectionMode(false))
      gridhide.setSelectionMode("single-row");

      //gridhide.setSelectionMode("multi-row-marker");
      gridhide.onRowClicked = function(event, row) {


        //alert('test')
        // $("#modalOutlet").modal('show');
        var c = gridhide.getCellValue(2, row);
        var d = gridhide.getCellValue(3, row);
        var e = gridhide.getCellValue(29, row);
        //alert(e)


        // if (c == 'Sukses') {
        //   return gridhide.setCellValue(false, 0, row);
        // }
        // if (d != 'Tanggal Masuk Berbeda') {
        //   return gridhide.setCellValue(false, 0, row);
        // }
        // if (e != '') {
        //   return gridhide.setCellValue(false, 0, row);
        // }

        // if (this.getCellValue(0, row) == true) {
        //   gridhide.setCellValue(false, 0, row);
        // } else {
        //   gridhide.setCellValue(true, 0, row);
        // }
        document.h1form.bufferset.value = '';
        var dataTampung = '';
        for (n = 0; n < gridhide.getRowCount(); n++) {
          if (this.getCellValue(0, n) == true) {
            dataTampung += gridhide.getCellValue(1, n) + ',';
          }
        }
        document.getElementById('bufferset').value = dataTampung;
        // document.forms[0].bufferset.value = dataTampung;
        // document.h1form.bufferset.value = dataTampung
        //gridhide.setCellValue(true,0,row);
        //console.log(this.getCellValue(0, row))
      };

      // gridhide.onSelectedRowsChanging = function(even){
      //   document.h1form.bufferset.value=''
      //   var dataTampung='';
      //   var c = gridhide.getCellValue(2,even);
      //      //console.log(c);return
      //     //alert(c)
      //       if(c=='Sukses'){
      //         return  gridhide.setCellValue(false,0,even);
      //       }
      //      if(this.getCellValue(0,even)==true){
      //         gridhide.setCellValue(false,0,even);
      //      }else{
      //       gridhide.setCellValue(true,0,even);
      //      }
      //   for(n=0;n<gridhide.getRowCount();n++){
      //     if(this.getCellValue(0,n)==true){
      //       dataTampung +=gridhide.getCellValue(1,n)+',';       
      //     }
      //   }
      //   document.h1form.bufferset.value=dataTampung;
      // }
      //   gridhide.onSelectedRowsChanged = function(arrayOfRowIndices){
      //     window.status = arrayOfRowIndices;
      //     console.log(arrayOfRowIndices)
      // }
      gridhide.setSelectorVisible(true);
      gridhide.setSelectorWidth(42);
      gridhide.setSelectorText(function(i) {
        return this.getRowPosition(i) + 1
      });
      document.write(gridhide);

      //document.getElementById('gridhide').style.display = "none";
    </script>
    <br />

    <div id='divBtnUpdate' style='display:none'>
      <button type='button' id='openCheck'>Buka Checkbox</button>
      <button type='button' id='closeCheck'>Tutup Checkbox</button>



    </div>
    <fieldset style='width:500px'>
      <legend>Jika ada data yang tidak masuk, cek kembali dan simpan perubahan</legend>
      <button type='button' id='checkAll' onClick='cekAll()'> Check Semua</button>
      <button type='button' id='uncheckAll' onClick='unCekAll()'> Uncheck Semua</button>
      <button type='button' id='updateIn' onClick='updateInsert()'> Simpan Forced Entry</button>


    </fieldset>
    <input type="button" value="Cetak Laporan" name="Cetak" onClick="cetakLap()" style="display:none" />
    <input type="button" value="Cetak Excel" name="CetakX" onClick="cetakLap('excel')" />
    <textarea name="buffer" cols="50" rows="10" class="textBuff" style="display:inline-block"></textarea>
    <textarea name="bufferhelper" cols="50" rows="10" class="textBuff" style="display:inline-block"></textarea>
    <textarea name="bufferset" id="bufferset" cols="50" rows="10" class="textBuff" style="display:inline-block"></textarea>
  </form>
  <div class="modal fade" id="modalOutlet" role="dialog" aria-labelledby="modalOutlet" style="outline: 0;">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 6px;min-height: unset;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true"><i class="fa fa-times-circle fa-2x" aria-hidden="true"> </i></span></button>
          <h4 class="modal-title" id="myModalLabel"></h4>
        </div>
        <div class="modal-body" style="height: 700px;max-height: 700px;">

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle " aria-hidden="true"> </i> Close</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>