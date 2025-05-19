var serial = 0;
var curHal = 1;

$(document)
  .ready(function () {
    //ambil value tahungaji bulangaji utk onchange
    var tahunBulanGaji = document.querySelectorAll(
      // ambil attribute name dari bulan dan tahun
      "[name='tahungaji'], [name='bulangaji']"
    );

    // fungsi onchange untuk bulan dan tahun
    tahunBulanGaji.forEach(function (thnbln) {
      thnbln.addEventListener("change", function () {
        var bulangaji = document.forms[0].bulangaji.value;
        var tahungaji = document.forms[0].tahungaji.value;
        // lazyload ketika onchange
        $(".select2").select2({
          placeholder: "Search",
          minimumInputLength: 1,
          language: {
            inputTooShort: function () {
              return "Masukkan setidaknya 1 huruf";
            },
          },
          width: "100%",
          ajax: {
            type: "post",
            url: "h2.php",
            dataType: "json",
            delay: 250,
            cache: false,
            data: function (params) {
              return {
                term: params.term,
                page: params.page || 1,
                bulangaji,
                tahungaji,
              };
            },
            processResults: function (data, params) {
              // console.log(data);
              var page = params.page || 1;
              return {
                results: $.map(data, function (item) {
                  console.log(item.id, item.col);
                  return { id: item.id, text: item.col };
                }),
                pagination: {
                  more: page * 10 <= data[0].total_count,
                },
              };
            },
          },
        });
      });
    });

    // select2 lazyload ketika onload
    $(".select2").select2({
      placeholder: "Search",
      minimumInputLength: 1,
      // allowClear: true,
      language: {
        inputTooShort: function () {
          return "Masukkan setidaknya 1 huruf";
        },
      },
      width: "100%",
      ajax: {
        type: "post",
        url: "h2.php",
        dataType: "json",
        delay: 250,
        cache: false,
        data: function (params) {
          return {
            term: params.term,
            page: params.page || 1,
          };
        },
        processResults: function (data, params) {
          // console.log(data);
          var page = params.page || 1;
          return {
            results: $.map(data, function (item) {
              console.log(item.id, item.col);
              return { id: item.id, text: item.col };
            }),
            pagination: {
              more: page * 10 <= data[0].total_count,
            },
          };
        },
      },
    });
  })
  .ajaxStart(function () {
    $("#loading").fadeIn();
  })
  .ajaxStop(function () {
    $("#loading").fadeOut();
  });

//memasukkan data ke dari buffer ke table
function dataReady() {
  loadGridArray(
    gridReportAktivitasKaryawan,
    "gridReportAktivitasKaryawan",
    document.h1form.buffer
  );
  serial = gridReportAktivitasKaryawan.getRowCount();
}

//fungsi getdata
function cariData(tipe, hal) {
  var url = "h2.php";
  var bulangaji = document.forms[0].bulangaji.value;
  var tahungaji = document.forms[0].tahungaji.value;
  var namakry = document.forms[0].namakry.value;
  var kodenik = document.forms[0].kodenik.value;
  var kodedivisi = document.forms[0].kodedivisi.value;
//  if (namakry == "") {
//    alert("Pilih nama karyawan terlebih dahulu");
//    return;
//  }
  // console.log(namakry);
  $.ajax({
    url: url,
    type: "post",
    data: {
      bulangaji,
      tahungaji,
      kodenik,
      kodedivisi,
      namakry,
      hal,
      mode: "retrieveData",
    },
    dataType: "text",
    success: function (returnedVal) {
      // console.log(returnedVal);
      // return;
      returnedVal = returnedVal.split("~!~");
      document.h1form.buffer.value = returnedVal[0];
      if (returnedVal[1] == 0 || returnedVal[1] == "") {
        alert("Peringatan, Data tidak ditemukan");
      }
      dataReady();
    },
  });
}

//cetak laporan
function cetakLap(format) {
  if (document.h1form.buffer.value.length == 0) {
    alert("Peringatan, Ambil Data terlebih dahulu");
    return;
  } else {
    if (format == "excel") {
      document.h1form.action = "reportExcel.php";
    } else {
      document.h1form.action = "reportHTML.php";
    }
    document.h1form.target = "_blank";
  }
  document.h1form.submit();
}
