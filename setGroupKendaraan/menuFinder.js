function gridFindmenu(grid,descriptionRecorderColumn,descriptionRecorderColumn_1,descriptionRecorderColumn_2) {
	if((gridGroupUser.getSelectedRows().length)<1 ){ alert("Silahkan Pilih Pabrikan"); return;}
	this.finder = menu_finder();
	this.callerType="grid";
	this.grid = grid;
	
	//this.idRecorderColumn = idRecorderColumn;
	this.descriptionRecorderColumn = descriptionRecorderColumn;	
	this.descriptionRecorderColumn_1=descriptionRecorderColumn_1;
	this.descriptionRecorderColumn_2=descriptionRecorderColumn_2;
}
function menu_finder() {

	var obj_calwindow = window.open(
		'cariGroupAsset.php','Menu','resizable=0,scrollbars=0,toolbar=0,directories=0,status=1,menubar=0,width=500,height=320,left=800,top=150'
	);
	obj_calwindow.opener = self;
	obj_calwindow.focus();
}

function gridFindjenis(grid,descriptionRecorderColumn,descriptionRecorderColumn_1,descriptionRecorderColumn_2) {
	if((gridMenu.getSelectedRows().length)<1 ){ alert("Silahkan Pilih Merk Kendaraan"); return;}
	
	this.finder = jenis_finder();
	this.callerType="grid";
	this.grid = grid;
	
	//this.idRecorderColumn = idRecorderColumn;
	this.descriptionRecorderColumn = descriptionRecorderColumn;	
	this.descriptionRecorderColumn_1=descriptionRecorderColumn_1;
	this.descriptionRecorderColumn_2=descriptionRecorderColumn_2;
}
function jenis_finder() {

	var obj_calwindow = window.open(
		'cariKategoriAsset.php','jenis','resizable=0,scrollbars=0,toolbar=0,directories=0,status=1,menubar=0,width=500,height=400,left=1000,top=150'
	);
	obj_calwindow.opener = self;
	obj_calwindow.focus();
}
