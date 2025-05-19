<?php
include('dbClass.php');
//$server= "1.1.1.250";
$server = "localhost";
//$server= "192.168.0.40";
$port = false;
$user = "root";
$password = "";
//$password="mysqlp4ssword";
//$password= "V3n3n0=pontiaC";
//$password= "pontiac";
//$database= "newasset";
$database = "absensi";
$prefix = "";
//tipe database=1.mysql,2.postgresql,3.mssql

$dbCon = new dbClass($server, $port, $user, $password, $database, 1);
// untuk membuat koneksi baru, gunakan format seperti di bawah	
/*$server2= "203.77.209.230";
	$port2= false;
    $user2= "root";
    $password2= "pontiac";
    $database2= "bernodb";
	$dbCon2=new dbClass($server2,$port2,$user2,$password2,$database2,1);
*/
