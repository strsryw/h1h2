function loadGridArray(gridobj,tblName) {
	//alert("loading");
 	//style="display:none" 
   tableData = new Array();
    i=0;
   data = document.forms[0].buffer.value;
  
   while (data.indexOf("^")>=0){
     iValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);
     tablename = getColumnValue(iValue, 1).trim();
	 
     if(tablename==tblName) {
		 rowData=new Array();
		 firstColumn=true;
		 while(iValue.indexOf("|")>=0){
			  cValue=iValue.substring(0,iValue.indexOf("|"));
              iValue=iValue.substring(iValue.indexOf("|")+1);
       			
				if (!firstColumn){
      
		      		cellData=[cValue];
              		rowData=rowData.concat(cellData);
				}
			  firstColumn=false;
         }
       tableData[i++]=rowData;
		 
     }
   }
   gridobj.setCellText(tableData);
   gridobj.setCellData(tableData);
   gridobj.setRowCount(tableData.length);
   v=new Array();
   for (i=0;i<gridobj.getRowCount();i++){v[i]=i;}
   gridobj.setRowIndices(v);
   gridobj.refresh();
 }
 
function updateDataOnBuffer(tblName,id,col,text){
	 data = document.forms[0].buffer.value;
  newData="";
   while (data.indexOf("^")>=0){
     rowValue=data.substring(0,data.indexOf("^"));
     data=data.substring(data.indexOf("^")+1);
     tablename = getColumnValue(rowValue, 1).trim();

     if(tablename==tblName) {
		if (getColumnValue(rowValue,2)==id){
			rowValue=updateColumnValue(rowValue,parseInt(col)+2,text);
		}
		
       	 
     }
	 newData=newData+rowValue+"^";
   }
   document.forms[0].buffer.value=newData;

 }
 
function getMaxIndex(){
	var idTerbesar = 0 ;
	var data = document.forms[0].buffer.value;
	while (data.indexOf("^")>=0){
		iValue=data.substring(0,data.indexOf("^"));
		data=data.substring(data.indexOf("^")+1);
		var iID = getColumnValue(iValue, 2);
		if( iID.indexOf('N') != -1 ){
		iID = iID.substring(1, iID.length);
		if(parseInt(iID) > idTerbesar) idTerbesar = parseInt(iID);
	}}//for
	return idTerbesar;
}

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.ltrim = function() {
	return this.replace(/^\s+/,"");
}
String.prototype.rtrim = function() {
	return this.replace(/\s+$/,"");
}
function formatUserInput(aTextField){
	var aText=aTextField.value;
	if (aText.length > 0){
		aText=removePeriodFromNumber(aText);
		aText=formatInputNumber("Double",aText);
		aTextField.value=aText;
	}
}
function isInteger(val) 
{
	var hasil = true;
	var digits="1234567890-";
	for (var i=0; i < val.length; i++) 
	{
		if (digits.indexOf(val.charAt(i)) == -1) 
		{ 
			hasil = false; 
		}
	}	
	return hasil ;
}

function isDouble(val) 
{
	var hasil = true;
	var digits="1234567890.-";
	var jmlTitik = 0 ;
	for (var i=0; i < val.length; i++) 
	{
		if (digits.indexOf(val.charAt(i)) == -1) 
		{ 
			hasil = false; 
		}
		if(val.charAt(i) == ".")
		{
			jmlTitik = jmlTitik + 1;
		}
		if(jmlTitik > 1)
		{
			hasil = false; 
		}
	}	
	return hasil ;
}


function formatInputNumber(formated, stringInput){ 
	var result = "" ;
	
	if(formated == "Integer")
	{		
		//check valid input
		if(!isInteger(stringInput) ){
			alert("Invalid input!\n"+ stringInput +" not Integer value");			
			return;
		}
		
		//format
		result = formatNumber(stringInput, "#,##0");
	}
	else if(formated == "Double")
	{		
		//pisahkan antara angkas sebelum titik, dengan angka setelah titik(ga perlu diformat)		
		var hightValue = "" ;
		var lowValue = "" ;
		
		var foundDot = false ;
		for(var x = 0; x < stringInput.length; x++){
			var charx = stringInput.charAt(x);
			
			if (charx == ".")
				foundDot = true;
				
			if(foundDot == false)
				hightValue = hightValue + charx ;
			else
				lowValue = lowValue + charx ;
		}
				
		//gabungkan
		stringInput = hightValue + lowValue ;
		
		//cek valid (untuk memeriksa, apakah inputnya salah)
		if(!isDouble(stringInput) ){
			alert("Invalid input!\n"+ stringInput +" not Double value");				
			return;
		}
		
		//format hight
		hightValue = formatNumber(hightValue, "#,##0");
		
		//gabungkan hasil dari formatef hight
		result = hightValue + lowValue ;		
				
	}	
	return result ;
}

function removePeriodFromNumber(stringNumber){
	var result = "" ;
	for(var i = 0; i < stringNumber.length; i++){
		var chari = stringNumber.charAt(i);		
	
		if(chari != ","){			
			result = result + chari ;
		}
	}
	return result ;
} 
     function addTrailingBlank(value,length){
     	var blankAdded = length - value.length;
     	
     	for (var i=0;i<blankAdded;i++){
     		value=value+"_";
     	}
     	return value;
     }
     function addHeadingBlank(value,length){
     	var blankAdded = length - value.length;
     	
     	for (var i=0;i<blankAdded;i++){
     		value="_"+value;
     	}
     	return value;
     }
     
     function updateColumn(row,kolomIndex,newValue,separator){
        //kolom index dimulai dari 1
     	var result="";
     	var headIndex=0;
     	var tailIndex=0;
     	var cnt=0;
     	for (var i=0;i<=row.length;i++){
     		if (row.charAt(i)==separator){
     		   if (cnt + 2 == kolomIndex){
     		   		headIndex=i;
     		   }
     		   if (cnt + 1 == kolomIndex){
     		   		tailIndex=i;
     		   }
     		   cnt++;
     		   
     		}
     	}
     	
     	var head="";
     	if (headIndex > 0){
     		head = row.substring(0,headIndex + 1);	
     	}
     	//alert("head "+head);
        var tail=row.substring(tailIndex ,row.length);
        //alert("tail "+tail);
        result = head + newValue + tail;
     	return result;
     }
     
     function getColumn(row,kolomIndex,separator){
        //row harus berupa value dari select object
        //misal document.forms[0].bahanBaku0.value
        //kolom index mulai dari 1 bukan dari nol,
        //kolom dipisahkan oleh tanda separator
        var srow=row + separator;
        var nilai="";
    	for (var i=0;i<kolomIndex;i++){
        	nilai = srow.substring(0,srow.indexOf(separator,0));
    		srow=srow.substring(srow.indexOf(separator,0) + 1,srow.length);
    	};
    	
    	return nilai;
    }
    
     function updateColumnValue(row,kolomIndex,newValue){
        //kolom index dimulai dari 1
     	var result="";
     	var headIndex=0;
     	var tailIndex=0;
     	var cnt=0;
     	for (var i=0;i<=row.length;i++){
     		if (row.charAt(i)=="|"){
     		   if (cnt + 2 == kolomIndex){
     		   		headIndex=i;
     		   }
     		   if (cnt + 1 == kolomIndex){
     		   		tailIndex=i;
     		   }
     		   cnt++;
     		   
     		}
     	}
     	
     	var head="";
     	if (headIndex > 0){
     		head = row.substring(0,headIndex + 1);	
     	}
     	//alert("head "+head);
        var tail=row.substring(tailIndex ,row.length);
        //alert("tail "+tail);
        result = head + newValue + tail;
     	return result;
     }
     function getColumnValue(row,kolomIndex){
        //row harus berupa value dari select object
        //misal document.forms[0].bahanBaku0.value
        //kolom index mulai dari 1 bukan dari nol,
        //kolom dipisahkan oleh tanda "|"
        var srow=row+"|";
        var nilai="";
    	for (var i=0;i<kolomIndex;i++){
        	nilai = srow.substring(0,srow.indexOf("|",0));
    		srow=srow.substring(srow.indexOf("|",0) + 1,srow.length);
    	};
    	
    	return nilai;
    }
    function removeSpace(nilai){
    	var result="";
    	for (var i=0;i<nilai.length;i++){
    		if (nilai.substring(i,i+1)!=" ") {
    		    result = result + nilai.substring(i,i+1);
    		}
    	}
    	return result;
    }
    function remove_(nilai){
    	var result="";
    	for (var i=0;i<nilai.length;i++){
    		if (nilai.substring(i,i+1)!="_") {
    		    result = result + nilai.substring(i,i+1);
    		}
    	}
    	return result;
    }
	function cekDateFormat(isAdate){
	    if (isAdate.indexOf("/")!=4) return false;
	    if (isAdate.lastIndexOf("/")!=7) return false;	    
		var yyyy=isAdate.substring(0,isAdate.indexOf("/",0));
		
		var mm=isAdate.substring(isAdate.indexOf("/",0)+1,isAdate.indexOf("/",0)+3);
		
		var dd=isAdate.substring(isAdate.lastIndexOf("/")+1,isAdate.lastIndexOf("/")+3);
				
		if (yyyy.length != 4) return false;
		if (parseInt(mm,10) > 12) return false;
		if (parseInt(dd,10) > 31) return false;
		return true;
	}
