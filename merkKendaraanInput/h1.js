var serial=0;
var curHal=1;
$(document).ready(function () {
	onLoadHandler();
});
function onLoadHandler() {
	getData(1);
	Batal();
}
function getData(hal){
	curHal=hal;
	var NmMerkCari=document.getElementById('txtNmMerkCari').value;
	var url = 'h2.php';
	$.ajax({
		url: url,
		type: "POST",
		data: ({NmMerkCari:NmMerkCari,hal:hal,mode:'getData'}),
		dataType: "text",
		success: function(result){
			
			result=result.split("!");
			//console.log(result[1])
			$('#tblDetil').children('thead:first').html(result[0]);
			$('#tblDetil').children('tbody:first').html(result[1]);
			if(result[2].trim().length!=0){
			document.getElementById('linkHal').style.display='';
			document.getElementById('linkHal').innerHTML=result[2];}
			else{document.getElementById('linkHal').style.display='none';}
		}
	})
}
function addLink(){
	document.forms[0].style.display='block';
	document.forms[0].reset();
	$("#simpanBtn").val('Add Simpan');
	$("#batalBtn").show();
}
function  editLink(idData){
	//alert(idData)
	var id = document.getElementById("txtIdMerk"+idData).innerHTML;
	var nmMerk=document.getElementById("txtNmMerk"+idData).innerHTML;
	var kdMerk=document.getElementById("txtKodeMerk"+idData).innerHTML;
	document.getElementById("txtIdMerk").value=id;
	document.getElementById("txtNmMerk").value=nmMerk;
	document.getElementById("txtKdMerk").value=kdMerk;
	$("#simpanBtn").val('Edit Simpan');
	document.forms[0].style.display='block';
	$("#batalBtn").show();
}
function Batal(){
	$("#simpanBtn").val('Add');
	document.forms[0].reset();
	document.forms[0].style.display='none';
	$("#batalBtn").hide();
}

function delLink(idData){
	var url='h2.php';
	$.ajax({
		url:url,
		type:"POST",
		data:({idMerk:idData,mode:"delData"}),
		success:function(result){
			if(result=='Success'){
				onLoadHandler();
			}else{
				alert('Data Gagal dihapus')
				onLoadHandler();
			}
		}
	})
}

function cekSimpan(){
	if (document.forms[0].txtNmMerk.value==""){
		alert ("Nama Merk masih kosong");
		return 0;
	}
	saveData();
}
function saveData(){
	var url="h2.php";
	var txtIdMerk=document.getElementById("txtIdMerk").value;
	var txtNmMerk=document.getElementById("txtNmMerk").value;
	var txtKdMerk=document.getElementById("txtKdMerk").value;
	$.ajax({
		url:url,
		type:"POST",
		data:({idMerk:txtIdMerk,nmMerk:txtNmMerk,txtKdMerk:txtKdMerk,mode:"saveData"}),
		dataType:"text",
		success:function(result){
			//console.log(result);
			alert(result);
			document.forms[0].reset();
			getData(1);
			Batal();
		}
	})
}

