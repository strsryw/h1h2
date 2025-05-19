let columnConfig = [
  { 
    "title": "NO", 
    'data':'no', 
    'width': "1%",
    },
  { 
    "title": "DIST", 
    'data':'dist',
    'width': "5%",
  },
  { 
    "title": "CABANG", 
    'data':'cab',
    'width': "5%",
  },
  { 
    "title": "DISTKOTA", 
    'data':'distkota',
    'width': "3%",
  },
  { 
    "title": "TANGGAL", 
    'data':'tglfaktur',
    'width': "5%",
  },
  { 
    "title": "NO_FAKTUR", 
    'data':'nofaktur',
    'width': "5%",
  },
  { 
    "title": "OUTLET", 
    'data':'outlet',
    'width': "10%",
  },
  { 
    "title": "ALAMAT", 
    'data':'alamat', 
    'width': "15%",
    render: function (data, type, row, meta) {
      return batasiString(data, 25);
    },
    createdCell: function (td, cellData, rowData, row, col) {
      $(td).attr("title", cellData);
      $(td).css("cursor", "pointer");
    },
  },
  { 
    "title": "PRODUK", 
    'data':'produk',
    'width': "10%",
  },
  { 
    "title": "QTY", 
    'data':'qty', 
    'width': "2%",
  },
  { 
    "title": "HNA", 
    'data':'hna', 
    'width': "5%",
  },
  { 
    "title": "GSV", 
    'data':'gsv', 
    'width': "5%",
  },
  { 
    "title": "DISC_P", 
    'data':'disc_p', 
    'width': "4%",
  },
  { 
    "title": "VDISC_P", 
    'data':'vdisc_p', 
    'width': "5%",
  },
  { 
    "title": "VALUENET", 
    'data':'valuenet', 
    'width': "6%",
  },
  { 
    "title": "BATCH", 
    'data':'batch', 
    'width': "6%",
  },
  { 
    "title": "DPFDPL", 
    'data':'nodpfdpl', 
    'width': "6%",
  },
  { 
    "title": "DIVISI", 
    'data':'divisi', 
    'width': "1%",
  },
  { 
    "title": "SUBDIV", 
    'data':'subdiv', 
    'width': "1%",
  },
];

let headers = ['no','dist','cab' ,'distkota' ,'tglfaktur' ,'nofaktur' ,'outlet' ,'alamat' ,'produk' ,'qty' ,'hna' ,'gsv' ,'disc_p' ,'vdisc_p' ,'valuenet' ,'batch' ,'nodpfdpl' ,'divisi' ,'subdiv'];

let searchValues = {};

$(document).ready(function () {
  setDataTable();
  search(); 
});

function getData(hal, distSearch, cabSearch, distkotaSearch, tglfakturSearch, nofakturSearch, outletSearch, alamatSearch, produkSearch, qtySearch, hnaSearch, gsvSearch, disc_pSearch, vdisc_pSearch, valuenetSearch, batchSearch, dpfdplSearch, divisiSearch, subdivSearch, mode){
  if(mode == 'klik'){
      for(let i = 1; i<= 18; i++){
        document.getElementById('search'+i).value = '';
      }
  }else{

  }
    var bulanperiode = document.forms[0].bulanperiode.value;
    var tahunperiode = document.forms[0].tahunperiode.value;
    var dist = document.getElementById("dist").value;
    var cabang = document.getElementById("cabang").value;

    if(tglfakturSearch == ''){
    }else{
      tglfakturSearch = convertDateToYMD(tglfakturSearch);
    } 
    if(dist == ''){
      alert('Harap pilih dist terlebih dahulu');
      return
    }

    $.ajax({
        url:'h2.php',
        type:'post',
        async:false,
        data:{
            bulanperiode, tahunperiode, dist, cabang, mode:'retrieveData',
            hal, distSearch, cabSearch, distkotaSearch, tglfakturSearch, nofakturSearch, outletSearch, alamatSearch, produkSearch, qtySearch, hnaSearch, gsvSearch, disc_pSearch, vdisc_pSearch, valuenetSearch, batchSearch, dpfdplSearch, divisiSearch, subdivSearch
        },
        dataType:'text',
        success:function(response){
          // console.log(response);
          response = response.split("!");
          document.getElementById('buffer').value = response[0];
          document.getElementById('txtExcel').value = response[2];
          if(response[1].trim().length!=0){
              document.getElementById('linkHal').style.display='';
              document.getElementById('linkHal').innerHTML=response[1];
          }else{
              document.getElementById('linkHal').style.display='block';
              document.getElementById('linkHal').innerHTML ='...';
          }
        }
    });

    table.clear(); // clear lalu add row
    if(document.getElementById('buffer').value == '' || document.getElementById('buffer').value == '[]'){ //ketika buffer kosong
      $('#tblGetData tbody').html('<tr><td colspan="19" style="text-align: center;"><div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Data Kosong</strong></div></td></tr>');
    }else{
      table.rows.add(JSON.parse(document.getElementById('buffer').value));
      table.draw();
  }
}

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

function setDataTable(){
  
  if ($.fn.DataTable.isDataTable("#tblGetData")) {
    $("#tblGetData").DataTable().destroy();
  }
  $("#tblGetData").empty();

  table = $('#tblGetData').DataTable({
      initComplete: function(settings){
          if (settings.aoData.length === 0) {
              $('#tblGetData tbody').html('<tr><td colspan="19" style="text-align: center;"><div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Pilih dist dan klik cari untuk menampilkan data</strong></div></td></tr>');
          }
        var firstRow = $("table thead tr:first");
        var newRow = $('<tr id="searchIndividu">').insertAfter(firstRow);
        this.api()
          .columns()
          .every(function (index) {
            var column = this;
            var header = $(column.header());

            // Check if the column is visible
            if (column.visible()) {
              let input = "";
              if (header.text() !== "NO") {
                input =
                  '<input type="text" id="search' + index +'" class="form-control input-sm search" placeholder="' +
                  $(header).text() +
                  '" value="' + (searchValues['search' + index] || '') + '" />';
              }
              $(`<th>${input}</th>`).appendTo(newRow);
            }
          });
      },
      info:false,
      searching: false, 
      // scrollX:true,
      ordering: false,
      paging:false,
      columns: columnConfig,
      destroy: true
  });
  
  table.columns.adjust();
}

function bufferToJSon(header,buffer){
	var JSon=[];	
	data=buffer;
   while (data.indexOf("^")>=0){
     iValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);
     tablename = getColumnValue(iValue, 1).trim();
	 var jSingle={};
	 	x=0;
		 while(iValue.indexOf("|")>=0){
			  cValue=iValue.substring(0,iValue.indexOf("|"));
              iValue=iValue.substring(iValue.indexOf("|")+1);
				if (cValue.trim()!=tablename){
				jSingle[header[x]]=cValue;
				x++;
      }
    	}
			   JSon.push(jSingle);
   }
  return JSon;
}

function printdata() {

  var bufferExcel = document.getElementById("txtExcel").value;
 
  if (bufferExcel == "" || bufferExcel == 'data kosong') {
    alert("Tidak ada data untuk dicetak excel");
    return;
  }
  document.getElementById("formExcel").submit();
}

function batasiString(str, maxLength) {
  return (str.length <= maxLength) ? str : str.substring(0, maxLength) + "...";
}

function search() {
  $("#searchIndividu input").on("keypress", function (e) {
    if (e.keyCode === 13) {
      for (let i = 1; i <= 18; i++) {
        searchValues['search' + i] = document.getElementById('search' + i).value;
      }

      getData(
        1, 
        searchValues.search1, 
        searchValues.search2, 
        searchValues.search3, 
        searchValues.search4, 
        searchValues.search5, 
        searchValues.search6, 
        searchValues.search7, 
        searchValues.search8, 
        searchValues.search9, 
        searchValues.search10, 
        searchValues.search11, 
        searchValues.search12, 
        searchValues.search13, 
        searchValues.search14, 
        searchValues.search15, 
        searchValues.search16, 
        searchValues.search17, 
        searchValues.search18, 
        'keypress'
      );
    }
  });
}

function convertDateToYMD(dateStr) {
  // Memisahkan string tanggal berdasarkan karakter "-"
  const parts = dateStr.split('-');

  // Pastikan input memiliki 3 bagian
  if (parts.length !== 3) {
    alert('Tanggal wajib dd-mm-yyy');
    return;
  }

  const day = parts[0];
  const month = parts[1];
  const year = parts[2];

  // Mengembalikan string dalam format y-m-d
  return `${year}-${month}-${day}`;
}