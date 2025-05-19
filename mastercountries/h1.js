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
        // alert(returnedVal);
        returnedVal = returnedVal.split('!');
		document.h1form.buffer.value = returnedVal[0];
        document.h1form.buffer_1.value = returnedVal[1];
		document.forms[0].buffer_2.value = returnedVal[2];
		dataReady();
      }
   	}
	);	
}
function dataReady(){
// buffer=document.h1form.buffer;
// buffer_1=document.h1form.buffer_1;	
// buffer_2=document.h1form.buffer_2;
loadGridArray(gridGroupUser,"groupUser",document.h1form.buffer);
serial=gridGroupUser.getRowCount();
// loadGridArray(gridMenu,"menu",document.h1form.buffer_1);
// serial_1=gridMenu.getRowCount();
// idGroupUser= gridGroupUser.getCellData(0,gridGroupUser.getCurrentRow());
// idGroupMenu= gridMenu.getCellData(0,gridMenu.getCurrentRow());
// idGroupJenis = gridJenis.getCellData(0,gridJenis.getCurrentRow());
// filterGridArray(gridMenu,"groupUser",1,idGroupUser,document.forms[0].buffer);
// filterGridArray(gridMenu,"menu",1,idGroupMenu,document.forms[0].buffer_1);
// filterGridArray(gridJenis,"jenis",1,idGroupJenis,document.forms[0].buffer_2);
}

function addData(){
	if((gridMenu.getSelectedRows().length)> 0 ) return;

	lastId = document.forms[0].lastId.value;
	if(lastId == ''){
		document.forms[0].lastId.value = '0';
	}else {
		lastId = parseInt(lastId)+1;
		document.forms[0].lastId.value = lastId;
	}

	lastId = document.forms[0].lastId.value;
	gridGroupUser.addRow(serial++);
	r = gridGroupUser.getCurrentRow();
	gridGroupUser.setCellData("N"+lastId, 0, r);
	gridGroupUser.setCellData("",+lastId, 1, r);
	gridGroupUser.setCellData("",+lastId, 2, r);
	newRow = "groupUser|N"+lastId+"|||^";
	document.forms[0].buffer.value = document.forms[0].buffer.value+newRow;
}

function saveData(){
	var buffer = document.forms[0].buffer.value;
	var url = 'h2.php';
	$.ajax({
		url:url,
		type:'post',
		data:({buffer:buffer,
			mode:'saveData'}),
		dataType:'text',
		success:function(returnedVal){
			alert(returnedVal.trim().replace(/[\n\r]/g,''));
			document.forms[0].bufferHelper.value=returnedVal.trim().replace(/[\n\r]/g,'');
			getData(1);	
		}
	})
}