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
      // getData(1);
  });
  
  function getData(hal, distSearch, cabSearch, distkotaSearch, tglfakturSearch, nofakturSearch, outletSearch, alamatSearch, produkSearch, qtySearch, hnaSearch, gsvSearch, disc_pSearch, vdisc_pSearch, valuenetSearch, batchSearch, dpfdplSearch, divisiSearch, subdivSearch, mode){
      if(mode == 'klik'){
        let inputs = document.querySelectorAll('#tblGetData input');
      // Periksa apakah ada elemen input
        if (inputs.length === 0) {
          
        }else{
          for (let i = 1; i <= 18; i++) {
            searchValues['search' + i] = '';
          }
        }
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
      setDataTable(hal);
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
  
  function setDataTable(hal){
    
    let json = bufferToJSon(headers, document.getElementById('buffer').value);
  
    if ($.fn.DataTable.isDataTable("#tblGetData")) {
      $("#tblGetData").DataTable().destroy();
    }
    $("#tblGetData").empty();
    if (hal == 1) {
        start = 0;
    } else {
        start = (hal - 1) * 10;
    }
    table = $('#tblGetData').DataTable({
        initComplete: function(settings){
            if (settings.aoData.length === 0) {
                $('#tblGetData tbody').html('<tr><td colspan="19" style="text-align: center;"><div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Data Kosong</strong></div></td></tr>');
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
                    '<input type="text" id="search' + index +
                    '" style="width:100%" class="form-control input-sm search" placeholder="' +
                    $(header).text() +
                    '" value="' + (searchValues['search' + index] || '') + '" />';
                }
                $(`<th>${input}</th>`).appendTo(newRow);
              }
            });
        },
        info:false,
        searching: false, 
        scrollX:true,
        ordering: false,
        paging:false,
        data:json,
        columns: columnConfig,
        destroy: true
    });
    search();
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
        // let dist= document.getElementById('search1').value; 
        // let cab= document.getElementById('search2').value;  
        // let distkota= document.getElementById('search3').value;  
        // let tglfaktur= document.getElementById('search4').value;  
        // let nofaktur= document.getElementById('search5').value;  
        // let outlet= document.getElementById('search6').value;  
        // let alamat= document.getElementById('search7').value;  
        // let produk= document.getElementById('search8').value;  
        // let qty= document.getElementById('search9').value;  
        // let hna= document.getElementById('search10').value;  
        // let gsv= document.getElementById('search11').value;  
        // let disc_p= document.getElementById('search12').value;  
        // let vdisc_p= document.getElementById('search13').value;  
        // let valuenet= document.getElementById('search14').value;  
        // let batch= document.getElementById('search15').value;  
        // let dpfdpl= document.getElementById('search16').value;  
        // let divisi= document.getElementById('search17').value;  
        // let subdiv= document.getElementById('search18').value; 
  
        searchValues = {
          search1: document.getElementById('search1').value,
          search2: document.getElementById('search2').value,
          search3: document.getElementById('search3').value,
          search4: document.getElementById('search4').value,
          search5: document.getElementById('search5').value,
          search6: document.getElementById('search6').value,
          search7: document.getElementById('search7').value,
          search8: document.getElementById('search8').value,
          search9: document.getElementById('search9').value,
          search10: document.getElementById('search10').value,
          search11: document.getElementById('search11').value,
          search12: document.getElementById('search12').value,
          search13: document.getElementById('search13').value,
          search14: document.getElementById('search14').value,
          search15: document.getElementById('search15').value,
          search16: document.getElementById('search16').value,
          search17: document.getElementById('search17').value,
          search18: document.getElementById('search18').value,
        };
        getData(1, 
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
          searchValues.search18, 'keypress');
  
  
        // $("#search1").val(dist);
        // $("#search2").val(cab);
        // $("#search3").val(distkota);
        // $("#search4").val(tglfaktur);
        // $("#search5").val(nofaktur);
        // $("#search6").val(outlet);
        // $("#search7").val(alamat);
        // $("#search8").val(produk);
        // $("#search9").val(qty);
        // $("#search10").val(hna);
        // $("#search11").val(gsv);
        // $("#search12").val(disc_p);
        // $("#search13").val(vdisc_p);
        // $("#search14").val(valuenet);
        // $("#search15").val(batch);
        // $("#search16").val(dpfdpl);
        // $("#search17").val(divisi);
        // $("#search18").val(subdiv);
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