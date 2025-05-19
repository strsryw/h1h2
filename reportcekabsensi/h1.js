var serial=0;
var curHal=1;

$(document).ajaxStart(function(){
	$("#loading").fadeIn();
}).ajaxStop(function(){
	$("#loading").fadeOut();
});



function dataReady(){
	loadGridArray(gridReportAbsensi,"reportabsensi",document.h1form.buffer);
	serial=gridReportAbsensi.getRowCount();
}

function cariData(tipe,hal){
	// alert('test');return
	var url = 'h2.php';
	var bulangaji	= document.forms[0].bulangaji.value;
	var tahungaji 	= document.forms[0].tahungaji.value;
	var namakry		= document.forms[0].namakry.value;
	var kodenik		= document.forms[0].kodenik.value;
	var status = document.forms[0].status.value;
	// console.log(namakry);return;

	$.ajax({
		url: url,
		type: "POST",
		data: ({bulangaji:bulangaji, tahungaji:tahungaji, namakry:namakry, kodenik:kodenik, status:status, hal:hal,mode:'retrieveData'}),
		dataType: "text",
		success: function(returnedVal){
			console.log(returnedVal);return
			returnedVal=returnedVal.split("!");
			document.h1form.buffer.value=returnedVal[0];
			if(returnedVal[0]==0 || returnedVal[0]==""){
				alert("Peringatan, Data tidak ditemukan");
			}
			/*document.getElementById('linkHal').innerHTML=returnedVal[1];
			document.getElementById('maxHal').innerHTML=returnedVal[2];*/
			dataReady();
		}
	});
}

function cetakLap(format){
	if (document.h1form.buffer.value.length==0){
		alert("Peringatan, Ambil Data terlebih dahulu");return;
	}
	else{
		if(format=="excel"){
			document.h1form.action='reportExcel.php';
		}
		else{
			document.h1form.action='reportHTML.php';
		}
		document.h1form.target='_blank';
	}
	document.h1form.submit();
}

function ambilDataPenyimpangan(id, nama, gcNik) {
	var url = 'h2.php';
	var nama=nama;
	var gcNik = gcNik;
	var bulangaji	= document.forms[0].bulangaji.value;
	var tahungaji 	= document.forms[0].tahungaji.value;
	// console.log(gcNik);return;
	$.ajax({
		url:url,
		type:"POST",
		dataType:"Text",
		data:({id:id, gcNik:gcNik, bulangaji:bulangaji, tahungaji:tahungaji,
			mode:'ambilDataPenyimpangan'}),
		success:function(returnVal){
			// console.log(returnVal);return;
			returnVal=returnVal;
			if(returnVal[1]){
                $('#tablePopPenyimpangan').children('tbody:first').html(returnVal);
				$("#txtNamap").text(': '+nama);
				$("#txtNIKp").text(': '+id);
				$("#modalPenyimpangan").modal('show');
				
            }else{
                alert('Tidak ada');
            }
			
		}
	})
}

function ambilDataTotal(id,nama,gcNik) {
	var url = 'h2.php';
	var nama=nama;
	var gcNik = gcNik;
	var bulangaji	= document.forms[0].bulangaji.value;
	var tahungaji 	= document.forms[0].tahungaji.value;
	// console.log(gcNik);return;
	$.ajax({
		url:url,
		type:"POST",
		dataType:"Text",
		data:({id:id,gcNik:gcNik,bulangaji:bulangaji, tahungaji:tahungaji,
			mode:'ambilDataTotal'}),
		success:function(returnVal){
			// console.log(returnVal);return;
			returnVal=returnVal;
			if(returnVal[1]){
			$('#tablePopTotal').children('tbody:first').html(returnVal);
			$("#txtNamat").text(': '+nama);
			$("#txtNIKt").text(': '+id);
			$("#modalTotal").modal('show');
			}else{
				alert('Tidak ada');
			}
		}
	})
}
