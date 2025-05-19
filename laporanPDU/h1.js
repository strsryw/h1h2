$(document).ready(function () {
  //-------------- return getdataonload
  var onloadCabang = getDtOnload();
  document.getElementById("cabang").innerHTML = onloadCabang;
});

//-------------- onchange getcabang
function getCabang() {
  var dist = document.getElementById("dist").value;
  $.ajax({
    url: "h2.php",
    type: "post",
    data: { dist, mode: "getCabang" },
    dataType: "text",
    success: function (result) {
      // console.log(result);
      document.getElementById("cabang").innerHTML = result;
    },
  });
}

//-------------- getcabang ketika onload
function getDtOnload() {
  var dist = document.getElementById("dist").value;
  var url = "h2.php";
  var dataCallback;
  $.ajax({
    url: url,
    type: "POST",
    dataType: "text",
    data: { dist, mode: "getDtOnload" },
    async: false,
    success: function (result) {
      // console.log(result);return
      dataCallback = result;
    },
  });
  return dataCallback;
}

//-------------- fungsi getdata
function getData(hal) {
  $(document)
    .ajaxStart(function () {
      $("#loading").fadeIn();
    })
    .ajaxStop(function () {
      $("#loading").fadeOut();
    });
  //-------------- array th untuk alternatif ketika search kolom individual placeholdernya kosong
  var tampungPlaceholder = [
    "NO",
    "DIST",
    "CABANG",
    "DIST KOTA",
    "TANGGAL",
    "NO_FAKTUR",
    "OUTLET",
    "ALAMAT",
    "PRODUK",
    "QTY",
    "HNA",
    "GSV",
    "DISC_P",
    "VDISC_P",
    "VALUENET",
    "BATCH",
    "NO DPFDPL",
    "DIVISI",
    "SUBDIV",
  ];
  //get name dari input searching kolom
  var dataTableTh = document.getElementsByName("dataTableTh");

  //-------------- hapus datatable sblmnya untuk menghindari inisiasi dobel
  if ($.fn.DataTable.isDataTable("#tblGetData")) {
    $("#tblGetData").DataTable().destroy();
  }

  var url = "h2.php";
  var bulanperiode = document.forms[0].bulanperiode.value;
  var tahunperiode = document.forms[0].tahunperiode.value;
  var dist = document.getElementById("dist").value;
  var cabang = document.getElementById("cabang").value;

  if (dist == "") {
    alert("Pilih dist terlebih dahulu");
    $("#tblGetData").children("tbody:first").html(`<tr>
    <td style='text-align:center;font-weight:bold;' colspan=19>Data Kosong</td>
  </tr>`);
    return;
  }

  $.ajax({
    url: url,
    type: "post",
    data: {
      bulanperiode,
      tahunperiode,
      dist,
      cabang,
      hal,
      mode: "retrieveData",
    },
    dataType: "text",
    success: function (result) {
      // console.log(result);
      // return;
      result = result.split("!");
      var data = result[0];
      var dataExcel = result[1];
      $("#tblGetData").children("tbody:first").html(data);
      //-------------- ketika getdata kosong maka
      if (dataExcel == "Data Kosong") {
        //-------------- mengosongkan txtExcel menghindari error cetak
        document.getElementById("txtExcel").value = "";
        //-------------- untuk disable input searching kolom ketika data kosong
        for (let i = 0; i < dataTableTh.length; i++) {
          dataTableTh[i].disabled = true;
          dataTableTh[i].value = ""; //reset input value
        }
        //-------------- untuk ubah isi tbody
        $("#tblGetData").children("tbody:first").html(`<tr>
        <td style='text-align:center;font-weight:bold;' colspan=19>Data Kosong</td>
      </tr>`);
        return;
        //menghindari error load datatable
      }
      document.getElementById("txtExcel").value = dataExcel;
      //-------------- membuat agar tfoot berada di atas
      document.getElementById("tfoot").style.display = "table-header-group";
      var i = 0;
      //-------------- fungsi search column individual
      new DataTable("#tblGetData", {
        initComplete: function () {
          this.api()
            .columns()
            .every(function () {
              let column = this;
              let title = column.header().textContent;
              //-------------- Create input element
              let input = document.createElement("input");
              input.setAttribute("name", "dataTableTh");
              //-------------- penambahan placeholder untuk awal load datatable
              input.placeholder = title;
              //-------------- ketika placeholde kosong maka isi manual loop dari array
              if (input.placeholder == "") {
                input.placeholder = tampungPlaceholder[i];
              }
              column.header().replaceChildren(input);
              //-------------- Event listener for user input
              input.addEventListener("keyup", () => {
                if (column.search() !== this.value) {
                  column.search(input.value).draw();
                }
              });
              i++;
            });
        },
        //ketika data kosong maka
        language: {
          zeroRecords: "Data Kosong",
          responsive: true, // Mengaktifkan responsif
        },
      });
    },
  });
}

//-------------- cetakexcel
function printdata() {
  //-------------- data buffer txtExcel berasal dari getData
  var bufferExcel = document.getElementById("txtExcel").value;
  //-------------- ketika belum get data
  if (bufferExcel == "") {
    alert("Tidak ada data untuk dicetak excel");
    return;
  }
  document.getElementById("formExcel").submit();
}
