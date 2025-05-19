var serial;
var serial_1;
function onLoadHandler() {
	 getData(1); 
	}
function getData(hal){
	curHal=hal;
	cariData(hal);
}
function cariData(hal){

	gridGroupUser.setSelectorText(function(i){
		if(hal>=1){
			jmlHal=hal-1;
				}
			else{jmlHal=0;}
				return this.getRowPosition(i)+1+(30*(jmlHal))
				}); 
	var url = 'h2.php';
	//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({hal:hal,mode:'retrieveData'}),
      dataType: "text",
      success: function(returnedVal){
		returnedVal=returnedVal.split("!");
		document.h1form.buffer.value=returnedVal[0];
		document.h1form.buffer_1.value=returnedVal[1];
		document.h1form.buffer_2.value=returnedVal[2].trim();
		dataReady();
      }
   	}
	);	
}
function dataReady(){
buffer=document.h1form.buffer;
buffer_1=document.h1form.buffer_1;	
buffer_2=document.h1form.buffer_2;
loadGridArray(gridGroupUser,"groupUser",document.h1form.buffer);
serial=gridGroupUser.getRowCount();
idGroupUser= gridGroupUser.getCellData(0,gridGroupUser.getCurrentRow());
idGroupMenu= gridMenu.getCellData(0,gridMenu.getCurrentRow());
idGroupJenis = gridJenis.getCellData(0,gridJenis.getCurrentRow());
filterGridArray(gridMenu,"groupUser",1,idGroupUser,document.forms[0].buffer);
filterGridArray(gridMenu,"menu",1,idGroupMenu,document.forms[0].buffer_1);
filterGridArray(gridJenis,"jenis",1,idGroupJenis,document.forms[0].buffer_2);
}

function saveData(){
	var buffer=document.h1form.buffer.value;
	var url = 'h2.php';	
	$.ajax({
      url: url,
      type: "POST",
      data: ({bufferh2:buffer,mode:'saveData'}),
      dataType: "text",
      success: function(returnedVal){
	  alert(returnedVal.trim().replace(/[\n\r]/g,''));
	  document.forms[0].bufferHelper.value=returnedVal.trim().replace(/[\n\r]/g,'');
	  getData(1);	

      }
   	});
}
function saveData_1(){

	var buffer_1=document.h1form.buffer_1.value;
	var url = 'h2.php';	
	$.ajax({
      url: url,
      type: "POST",
      data: ({bufferh2_1:buffer_1,mode_1:'saveData'}),
      dataType: "text",
      success: function(returnedVal){
		alert(returnedVal.trim().replace(/[\n\r]/g,''));
	  document.forms[0].bufferHelper.value=returnedVal.trim().replace(/[\n\r]/g,'');
	  getData(1);	

      }
   	});
}
function saveData_2(){

	var buffer_2=document.h1form.buffer_2.value;
	var url = 'h2.php';	
	$.ajax({
      url: url,
      type: "POST",
      data: ({bufferh2_2:buffer_2,mode_2:'saveData'}),
      dataType: "text",
      success: function(returnedVal){
		alert(returnedVal.trim().replace(/[\n\r]/g,''));
	  document.forms[0].bufferHelper.value=returnedVal.trim().replace(/[\n\r]/g,'');
	  getData(1);	

      }
   	});
}
function addData(){
	if ((gridMenu.getSelectedRows().length)>0 ) return;
	lastId=document.forms[0].lastId.value;
	if (lastId.length==0){
		document.forms[0].lastId.value='0';
	}else{
		lastId=parseInt(lastId)+1;
		document.forms[0].lastId.value=lastId;
	}
	lastId=document.forms[0].lastId.value;
	gridGroupUser.addRow(serial++);
	r=gridGroupUser.getCurrentRow();
	gridGroupUser.setCellData("N"+lastId,0,r);
	gridGroupUser.setCellData("",1,r);
	gridGroupUser.setCellData("",2,r);
	newRow="groupUser|N"+lastId+"|||^";
	document.forms[0].buffer.value=document.forms[0].buffer.value+newRow;
	
}
function delData(){
	if ((gridGroupUser.getSelectedRows().length)<1 ) return;
	idGroupUser = gridGroupUser.getCellValue(0, gridGroupUser.getCurrentRow());
	// idGroupUser=gridGroupUser.getCellData(0,gridGroupUser.getCurrentRow());
	gridGroupUser.deleteRow(gridGroupUser.getCurrentRow());
	//2 kemungkinan : id termporer -> hapus dari buffer
	//                id permanen -> tambahkan tanda - di id tsb yg ada di buffer
	deleteDataOnBuffer("groupUser",idGroupUser,document.forms[0].buffer);
	
}
 
function addData_1(){
	if ((gridGroupUser.getSelectedRows().length)<1 ){ alert("Silahkan Pilih Pabrikan"); return;}
	
	lastId=document.forms[0].lastId_1.value;
	if (lastId.length==0){
		document.forms[0].lastId_1.value='0';
	}else{
		lastId=parseInt(lastId)+1;
		document.forms[0].lastId_1.value=lastId;
	}
	lastId=document.forms[0].lastId_1.value;
	gridMenu.addRow(serial_1++);
	r=gridMenu.getCurrentRow();
	gridMenu.setCellData("N"+lastId,0,r);
	gridMenu.setCellData(idGroupUser,1,r);
	gridMenu.setCellData("",2,r);
	gridMenu.setCellData("",3,r);
	newRow="menu|N"+lastId+"|"+idGroupUser+"||||^";
	document.forms[0].buffer_1.value=document.forms[0].buffer_1.value+newRow;
	
	
}
function delData_1(){
	if ((gridMenu.getSelectedRows().length)<1 ) return;
	if (gridMenu.getCurrentRow()<0) return;
	idMenu=gridMenu.getCellData(0,gridMenu.getCurrentRow());
	gridMenu.deleteRow(gridMenu.getCurrentRow());
	//2 kemungkinan : id termporer -> hapus dari buffer
	//                id permanen -> tambahkan tanda - di id tsb yg ada di buffer
	deleteDataOnBuffer("menu",idMenu,document.forms[0].buffer_1);
}
function addData_2(){
	idmenu=gridMenu.getCellData(0,gridMenu.getCurrentRow());
	
	if ((gridMenu.getSelectedRows().length)<1 ){ alert("Silahkan Pilih Merk"); return;}

	lastId=document.forms[0].lastId_2.value;
	if (lastId.length==0){
		document.forms[0].lastId_2.value='0';
	}else{
		lastId=parseInt(lastId)+1;
		document.forms[0].lastId_2.value=lastId;
	}
	lastId=document.forms[0].lastId_2.value;
	gridJenis.addRow(serial_2++);
	r=gridJenis.getCurrentRow();
	gridJenis.setCellData("N"+lastId,0,r);
	gridJenis.setCellData(idGroupMenu,1,r);
	gridJenis.setCellData("",2,r);
	gridJenis.setCellData("",3,r);
	newRow="jenis|N"+lastId+"|"+idmenu+"||||^";
	document.forms[0].buffer_2.value=document.forms[0].buffer_2.value+newRow;
	//gridFindjenis(gridJenis,3,2,4)
	
}
function delData_2(){
	if ((gridJenis.getSelectedRows().length)<1 ) return;
	if (gridJenis.getCurrentRow()<0) return;
	idJenis=gridJenis.getCellData(0,gridJenis.getCurrentRow());
	gridJenis.deleteRow(gridJenis.getCurrentRow());
	//2 kemungkinan : id termporer -> hapus dari buffer
	//                id permanen -> tambahkan tanda - di id tsb yg ada di buffer
	deleteDataOnBuffer("jenis",idJenis,document.forms[0].buffer_2);
}



function addKategori() {
	
	var sURL = "../merkKendaraanInput/index.php";
	//obj_calwindow=window.close();
	var obj_calwindow = window.open(
		sURL,'kategori','resizable=0,scrollbars=1,toolbar=0,directories=0,status=1,menubar=0,width=800,height=500,left=600,top=100'
	);
	obj_calwindow.opener = self;
	obj_calwindow.focus();
}
function addJenis() {
	
	var sURL = "../typeKendaraanInput/index.php";
	
	var obj_calwindow = window.open(
		sURL,'type','resizable=0,scrollbars=1,toolbar=0,directories=0,status=1,menubar=0,width=800,height=500,left=800,top=100'
	);
	obj_calwindow.opener = self;
	obj_calwindow.focus();
}