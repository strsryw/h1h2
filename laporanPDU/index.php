<?php include("../asset/function.php"); ?>
<style>
  /* Page Numbers */
  .linkHal {
    /*font: 83%/1.4 sans-serif;
    padding: 1em;
    margin: 1em 0;
    clear: left;
    font-size: 85%;*/
    padding: 0.2em;
    margin: 0.4em 0;
  }

  .linkHal a,
  .linkHal span {
    color: #003366;
    display: block;
    float: left;
    padding: 0.2em 0.5em;
    margin-right: 0.1em;
    border: 1px solid #fff;
    background: #fff;
  }

  .linkHal span.current {
    border: 1px solid #2E6AB1;
    font-weight: bold;
    background: #2E6AB1;
    color: #fff;
  }

  .linkHal a {
    border: 1px solid #9AAFE5;
    text-decoration: none;
    cursor: pointer;
  }

  .linkHal a:hover {
    border-color: #2E6AB1;
  }

  .linkHal a.nextprev {
    font-weight: bold;
  }

  .linkHal span.nextprev {
    color: #666;
  }

  .linkHal span.nextprev {
    border: 1px solid #ddd;
    color: #999;
  }

  .linkHal .nextprev-next {
    float: right;
  }

  table td {
    font-size: 11px;
  }

  #detailpk {
    margin: 0% 2% 2% 2%;
    width: 95%;
    height: 100%;
    position: absolute;
    position: fixed;
    z-index: 1002;
    display: none;
    background: white;
  }

  #detailsppk {
    margin: 0% 2% 2% 2%;
    width: 95%;
    height: 100%;
    position: absolute;
    position: fixed;
    z-index: 1002;
    display: none;
    background: white;
  }

  #atas {
    font-size: 15pt;
    padding: 20px;
    height: 80%;
  }

  #bawah {
    background: #fff;
  }

  #tombol-tutup {
    background: #e74c3c;
  }

  #tombol-tutup,
  #tombol {
    height: 30px;
    width: 100px;
    color: #fff;
    border: 0px;
    margin-top: 5%;
  }

  #tombol-tutup2 {
    background: #e74c3c;
  }

  #tombol-tutup2,
  #tombol2 {
    height: 30px;
    width: 100px;
    color: #fff;
    border: 0px;
    margin-top: 5%;
  }

  #bg {
    opacity: .80;
    position: absolute;
    display: none;
    position: fixed;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: #000;
    z-index: 1001;
    opacity: 0.8;
  }

  #bg2 {
    opacity: .80;
    position: absolute;
    display: none;
    position: fixed;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: #000;
    z-index: 1001;
    opacity: 0.8;
  }

  #tombol {
    background: #e74c3c;
  }


  #detailpk {
    display: none;
  }

  #detailsppk {
    display: none;
  }

  .bungkus-table {
    width: 100%;
    margin: auto;
  }

  tfoot input {
    width: 100%;
    padding: 3px;
    box-sizing: border-box;
  }

  #tahunperiode {
    width: 100px;
    height: 25px;
    border-radius: 5px;
  }

  #bulanperiode {
    width: 100px;
    height: 25px;
    border-radius: 5px;
  }
</style>
<style type="text/css">
  div {
    font-size: 11px;
  }

  #loading {
    position: absolute;
    top: 0;
    left: 0;
    color: white;
    background-color: red;
    padding: 5px 10px;
    font: 12px sans-serif;
  }
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>


  <link rel="stylesheet" href="../asset/css/3.4.0/bootstrap.min.css">
  <script src="../asset/js/3.4.1/jquery.min.js"></script>

  <!-- datatable  -->
  <link rel="stylesheet" href="../asset/css/dataTables.min.css">
  <script src="../asset/js/dataTables.min.js"></script>
  <!-- datatable  -->

  <!-- bootstrap datatable -->
  <link rel="stylesheet" href="../asset/css/dataTables.bootstrap.css">


  <script src="h1.js"></script>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Laporan PDU</title>

</head>
<div id="loading" style="display:none">Loading...</div>

<body>

  <h3 style="text-align: center;"><b>Laporan PDU</b></h3>
  <hr>
  <form class="form"> <!-- form -->
    <div class="container">
      <table border="0" cellpadding="0" cellspacing="0" class="table table-responsive" id="tblPropertyPK">
        <!-- tr cari periode -->
        <tr>
          <td>Periode</td>
          <td>: <?php inp_bulan('bulanperiode'); ?> <?php inp_tahun('tahunperiode'); ?>
          </td>
        </tr>


        <tr>
          <td>Dist</td>
          <td> :
            <select name="dist" id="dist" style="width: 100px ; height: 25px ;  border-radius: 5px" onchange="getCabang()">
              <option value="">Pilih dist</option>
              <option value="aaa">AAA</option>
              <option value="cmn">CMN</option>
              <option value="dbm">DBM</option>
              <option value="jivssm">JIV</option>
              <option value="kls">KLS</option>
              <option value="ppg">PPG</option>
              <option value="sss">SSS</option>
              <option value="tab">TAB</option>
              <option value="tsj">TSJ</option>
              <option value="udc">UDC</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Cabang</td>
          <td> :
            <select name="cabang" id="cabang" style="width: 180px ; height: 25px ;  border-radius: 5px">
              <option value=""></option>
            </select>
          </td>
        </tr>
        <tr>
          <td><button type="button" onClick="getData(1)" id="cari" class="btn btn-sm btn-primary">CARI</button> &nbsp; <button type="button" onclick="printdata(1)" id="cetakExcel" id="cetakExcel" class="btn btn-sm btn-primary">CETAK EXCEL</button>
          </td>
          <td></td>
        </tr>
        <!-- end tr tipe,dist,cabang -->
      </table>
    </div>
  </form> <!-- end form -->
  <center>

    <div id="linkHal" style="height:18px; font-weight:bold; display:none;font-size:11px" class="linkHal"></div>

    <div class="table-responsive">
      <table id="tblGetData" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <td style='font-weight:bold;'>NO</td>
            <td style='font-weight:bold'>DIST</td>
            <td style='font-weight:bold'>CABANG</td>
            <td style='font-weight:bold'>DIST KOTA</td>
            <td style='font-weight:bold'>TANGGAL</td>
            <td style='font-weight:bold'>NO_FAKTUR</td>
            <td style='font-weight:bold'>OUTLET</td>
            <td style='font-weight:bold'>ALAMAT</td>
            <td style='font-weight:bold'>PRODUK</td>
            <td style='font-weight:bold'>QTY</td>
            <td style='font-weight:bold'>HNA</td>
            <td style='font-weight:bold'>GSV</td>
            <td style='font-weight:bold'>DISC_P</td>
            <td style='font-weight:bold'>VDISC_P</td>
            <td style='font-weight:bold'>VALUENET</td>
            <td style='font-weight:bold'>BATCH</td>
            <td style='font-weight:bold'>NO DPFDPL</td>
            <td style='font-weight:bold'>DIVISI</td>
            <td style='font-weight:bold'>SUBDIV</td>
          </tr>
        </thead>
        <!-- tfoot untuk input search kolom  -->
        <tfoot id="tfoot" style="display:none">
          <tr>
            <td style='font-weight:bold'>NO</td>
            <td style='font-weight:bold'>DIST</td>
            <td style='font-weight:bold'>CABANG</td>
            <td style='font-weight:bold'>DIST KOTA</td>
            <td style='font-weight:bold'>TANGGAL</td>
            <td style='font-weight:bold'>NO_FAKTUR</td>
            <td style='font-weight:bold'>OUTLET</td>
            <td style='font-weight:bold'>ALAMAT</td>
            <td style='font-weight:bold'>PRODUK</td>
            <td style='font-weight:bold'>QTY</td>
            <td style='font-weight:bold'>HNA</td>
            <td style='font-weight:bold'>GSV</td>
            <td style='font-weight:bold'>DISC_P</td>
            <td style='font-weight:bold'>VDISC_P</td>
            <td style='font-weight:bold'>VALUENET</td>
            <td style='font-weight:bold'>BATCH</td>
            <td style='font-weight:bold'>NO DPFDPL</td>
            <td style='font-weight:bold'>DIVISI</td>
            <td style='font-weight:bold'>SUBDIV</td>
          </tr>
        </tfoot>
        <tbody id="tampilcari">

          <tr>
            <td style='text-align:center' colspan=19>Pilih dist dan klik cari untuk menampilkan data</td>
          </tr>

        </tbody>
      </table><!-- end tabel -->
    </div>
  </center>

</body>
<script>
  function dialog(stat) {
    if (stat == "open") {
      document.getElementById("load").innerHTML = "<b> Loading.. Mohon tunggu sampai proses selesai..</b>";
      /*<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Silakan relax dan bikin </b><img width='18' height='18' src='../images/cupCoffee.png' align='absmiddle'/>*/
      $('#load').dialog({
        width: 360,
        height: 60,
        modal: true,
        title: "Please wait...",
        headerVisible: false
      });
      $('#load').dialog('widget').find(".ui-dialog-titlebar").hide();

    } else if (stat == "destroy") {
      $('#load').dialog("destroy");
    }
  }
  $(function() {
    $(document).ajaxStart(function() {
      document.getElementById('loading').style.display = '';
    }).ajaxStop(function() {
      document.getElementById('loading').style.display = 'none';
    });
  });
</script>

<form action="cetakexcel.php" method="post" id="formExcel" target="_blank">
  <textarea id="txtExcel" cols="150" rows="5" name="txtExcel" style="display:none;"></textarea>
</form>
<form action="cetakexcel.php" method="post" id="formExcel2" target="_blank">
  <textarea id="txtExcel2" cols="150" rows="5" name="txtExcel" style="display:none"></textarea>
</form>
<form action="cetakexcel.php" method="post" id="formExcel3" target="_blank">
  <textarea id="txtExcel3" cols="150" rows="5" name="txtExcel" style="display:none"></textarea>
</form>

</html>