$(document).ajaxStart(function(){
    $("#loading").fadeIn();
}).ajaxStop(function(){
    $("#loading").fadeOut();
});

$(document).ready(function() {
	// $('#openCheck').onclick(function(e){
    //        e.preventDevault();
    //        alert('test')
    //    })
    //onLoadHandler()
    //$("#divBtnUpdate").hide()
    // $("#closeCheck").click(function(e){
    //     e.preventDefault();
    //     $("#gridReportRefresh").show();
    //     $("#gridhide").hide();       
    // })

    // $("#openCheck").click(function(e){
    //     e.preventDefault();
    //     $("#gridReportRefresh").hide();
    //     $("#gridhide").show();
    //     //$(this).hide()
    // })
    onLoadHandler();
})

function onLoadHandler(){
    prosesAmbilData();
    // setUploadke();
    // alert('tes');
}
function setUploadke(){
    var tahun=document.getElementById("tahun").value;
    var bulan=document.getElementById("bulan").value;
    var url="h2.php";
    var dataUploadke=document.getElementById("filterUploadKe").value;
    // alert(dataUploadke);
    $.ajax({
        url: url,
        type: "POST",
        dataType:"text",
        data:({tahun:tahun,bulan:bulan,mode:'getUploadke'}),
        // async:false,
        success: function(result){
            // console.log(result)
            dataUploadke.innerHTML='';
             if(result==''){
                 dataUploadke.innerHTML='<option value="All" selected="selected">Semua</option>';
             }else{
                 dataUploadke.innerHTML=result;
             }
        }
    }); 
    return dataUploadke
}
function dataReady(){
	//loadGridArray(gridReportRefresh,"reportrefreshkaryawan",document.h1form.buffer);
    loadGridArray(gridhide,"reportrefreshkaryawan",document.h1form.buffer);
	serial=gridhide.getRowCount();
    // $("#gridReportRefresh").show();
    // $("#gridhide").hide();
}

function ambilData(id) {
    var link = $('#baseurl').val();
    var base_url = link + 'divisi/getData';

    $.ajax({
        type: 'POST',
        data: 'id=' + id,
        url: base_url,
        dataType: 'json',
        success: function (hasil) {
            $('#iddivisi').val(hasil[0].id_divisi);
            $('#divisi').val(hasil[0].nama_divisi);

        }
    });
}

// function getData(hal) {
// 	curHal=hal;
// 	prosesAmbilData('all',hal);
// }

// function checksemua(){
  
// }
// function selectAll() {
//     alert('test')
//     var a=new Array; for(var i=0;i<gridhide.getRowCount();i++){}  return a;
// }
function cekAll(){
    document.h1form.bufferset.value='';
    var dataTampung='';
    for(n=0;n<gridhide.getRowCount();n++){
        //console.log(gridhide.getCellSelected(2,2));return
        // var c = gridhide.getCellValue(2,n);
        // var d = gridhide.getCellValue(3,n);
        // var e = gridhide.getCellValue(29,n);
        //c.setAttriburte("readonly","true");
        // if(c=='Gagal' && d=='Tanggal Masuk Berbeda' && e==''){
            gridhide.setCellValue(true,0,n);
            dataTampung +=gridhide.getCellValue(1,n)+',';
        // }
    }
    document.h1form.bufferset.value=dataTampung

}
function unCekAll(){
   
    for(n=0;n<gridhide.getRowCount();n++){
    gridhide.setCellValue(false,0,n);
    }
    document.h1form.bufferset.value=''
}
function updateInsert(){
    var idSet=document.h1form.bufferset.value
    var bulangaji=document.getElementById("bulan").value
    var tahungaji=document.getElementById("tahun").value
    //console.log(tahungaji);return
   // alert(idSet)
   if(idSet==''){
    alert('Belum ada data yang dipilih... ');
    return
   }
    var  url = 'h2.php';
     $.ajax({
        url: url,
        type: "POST",
        dataType:"text",
        data:({idSet:idSet,bulangaji:bulangaji,tahungaji:tahungaji,mode:'setUpdate'}),
        async:true,
        success: function(result){
            console.log(result);return
            alert(result);
            prosesAmbilData('srch')
        }
    }); 

}

// function prosesAmbilData(){
// 	var bulan=document.getElementById('bulan').value;
// 	var tahun=document.getElementById('tahun').value;
// 	var filterUploadKe=document.getElementById('filterUploadKe').value;
//     var filterStatusUpload=document.getElementById('filterStatusUpload').value;
   
// 	getData(1);
// }

function setKeterangan(){
    var status=document.getElementById('filterStatusUpload').value
    if(status=='Sukses'){
         var selectKet = document.getElementById('filterKeterangan');
         selectKet.innerHTML="";
         selectKet.innerHTML+="<option value='All' selected='selected'>Tampil Semua</option><option value='Forced'>Forced Entry</option>"
        $("#tdKet").show();
      //document.getElementById("tdKet").style.display = "block";
    }else if(status=='Gagal'){
        var selectKet = document.getElementById('filterKeterangan');
        selectKet.innerHTML="";
        selectKet.innerHTML+="<option value='Tanggal Lahir Berbeda' selected='selected'>Tanggal Lahir Berbeda</option><option value='Tanggal Masuk Berbeda'>Tanggal Masuk Berbeda (SEMUA DATA)</option><option value='TMBNULL'>Tanggal Masuk Berbeda (FORCED ENTRY)</option>";
        $("#tdKet").show();
    }else{
        var selectKet = document.getElementById('filterKeterangan');
        selectKet.innerHTML="";
        selectKet.innerHTML="<option value='All' selected='selected'>Tampil Semua</option>";
        document.getElementById("filterKeterangan").selectedIndex = "0";
        $("#tdKet").hide();
    }

}
function prosesAmbilData(tipe,hal){
    curHal=hal;
    var bulan=document.getElementById('bulan').value;
	var tahun=document.getElementById('tahun').value;
	var filterUploadKe=document.getElementById('filterUploadKe').value;
    // alert(filterUploadKe);
    var filterStatusUpload=document.getElementById('filterStatusUpload').value;
    var filterKeterangan=document.getElementById('filterKeterangan').value;
    
    if(bulan==''){
    	alert('pilih periode bulan upload');
    	return
    }
    if(tahun==''){
    	alert('Pilih periode tahun upload');
    	return
    }
    if(filterUploadKe==''){
    	alert('pilih periode upload ke');
    	return
    }
    if(filterStatusUpload==''){
    	alert('pilih status upload');
    	return
    }
    // if(filterStatusUpload=='Gagal'){
    //         $("#divBtnUpdate").show()
    // }else{
    //         $("#divBtnUpdate").hide()
    // }
    //alert(bundleId)
    var  url = 'h2.php';
    $.ajax({
        url: url,
        type: "POST",
        dataType:"text",
        data:({bulan:bulan,tahun:tahun,filterUploadKe:filterUploadKe,filterStatusUpload:filterStatusUpload,filterKeterangan:filterKeterangan,mode:'getData'}),
        async:true,
        success: function(result){
            console.log(result);
            result=result.split("!");
			document.h1form.buffer.value=result[0];
			if(result[0]==0 || result[0]==""){
				// openDialog("Peringatan", "Data tidak ditemukan", 320, 150, "alert", "dialog");
                $("#divBtnUpdate").hide();
			}

    		dataReady();
            unCekAll()
            // result=result.split("^");
            // //alert(result);
            // $('#example').children('tbody:first').html(result[0]);

	
            // if(result[1].trim().length!=0){
            //     document.getElementById('linkHal').style.display='';
            //     document.getElementById('linkHal').innerHTML=result[1];
            //   }else{
            //     document.getElementById('linkHal').style.display='none';
            //   }
            //console.log(result)
        }
    });	
}

function cetakLap(format){
	if (document.h1form.buffer.value.length==0){
		openDialog("Peringatan", "Ambil Data terlebih dahulu", 320, 150, "alert", "dialog");return;
	}
	else{
		if(format=="excel"){
			document.h1form.action='reportExcel.php';
		}
		else{
            alert('file reportHTML blm ada');return;
			// document.h1form.action='reportHTML.php';
		}
		document.h1form.target='_blank';
	}
	document.h1form.submit();
}