<?php 

Class dbClass

{
	
private $koneksi; //refrensi koneksi
private $dbType; // referense databaseType
private $host; //host database mysql
private $user; //nama user
private $port; //port
private $password; //user password
private $database; //nama database
private $query; //query yg akan dilakukan
private $result; //refrensi hasil query
private $row; //record hasil query
private $dataset; //dataset hasil query
private $numRows; //jumlah record dalam query
private $numFields;

function dbClass($host,$port,$user,$password,$database,$indexDBType){
	$this->host=$host;
	$this->port=$port;
	$this->user=$user;
	$this->password=$password;
	$this->database=$database;
	$arrayDbType=array(1=>"mysqli","pg","mssql"); 
	$this->dbType=$arrayDbType[$indexDBType];	
	$this->connect();
	}
function connect()

{
	if($this->dbType=="mysqli"){
		$this->koneksi = mysqli_connect($this->host,$this->user,$this->password,$this->database) or die("Tidak dapat menghubungi server");
		mysqli_select_db($this->koneksi,$this->database) or die("Database tidak ada");
		}
	elseif($this->dbType=="pg"){
		$this->koneksi=pg_connect("host=".$this->host." port=".$this->port." dbname=".$this->database." user=".$this->user." password=".$this->password) or die("Tidak dapat menghubungi server");
		}

}

//get HostName
function getNamaHost()
{
return $this->host;
}
function getNamaDb()
{
return $this->koneksi;
}
//membuat query kedatabase
function execute($query)
{
$this->query = $query;
if($this->dbType=='mysqli'){
	$this->result = call_user_func($this->dbType."_query",$this->koneksi,$query);
	}
else{
	$this->result = call_user_func($this->dbType."_query",$this->koneksi,$query);
	}
return $this->result;
//clear result di server
$this->clearResult($this->result);
}
function clearResult($result){
call_user_func($this->dbType."_free_result",$result);	
	}
//mengakses hasil query dalam bentuk array assosiatif
function getArray($hasil)
{
if ($this->row = call_user_func($this->dbType."_fetch_array",$hasil))
return $this->row;
else
return false;
}

//mengakses hasil query dalam bentuk row
function getRow($hasil)
{
if ($this->row = call_user_func($this->dbType."_fetch_row",$hasil))
return $this->row;
else
return false;
}

//mengakses query kedalam bentuk objek
function getObject($hasil)
{
if ($this->row = call_user_func($this->dbType."_fetch_array",$hasil,MYSQLI_ASSOC))
return $this->row;
else
return false;
}

//mengakses query kedalam bentuk dataset
function getDataset($hasil)
{
$dataset = array();
$i = 0;
while ($r=call_user_func($this->dbType."_fetch_row",$hasil));
{
$field=0;
for($field=0; $field<call_user_func($this->dbType."_num_fields",$hasil);$field++)
{
$dataset[$i][$field] = $r[$field];
}
$i++;
}
return $dataset;
}

//mengakses jumlah record hasil query
function getNumRows($hasil)
{
$this->numRows = call_user_func($this->dbType."_num_rows",$hasil);
return $this->numRows;
}
//mengakses jumlah field hasil query
function getNumFields($hasil)
{
$this->numFields = call_user_func($this->dbType."_num_fields",$hasil);
return $this->numFields;
}
//mengakses query kedalam bentuk objek
function getFieldName($hasil,$kolomNo)
{
if ($this->fieldName = call_user_func($this->dbType."_field_name",$hasil,$kolomNo))
return $this->fieldName;
else
return false;
}
//menutup koneksi
function closeConnection()
{
mysqli_close($this->koneksi);
}
}

?>