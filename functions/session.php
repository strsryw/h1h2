<?php
session_start();
if(!((isset($_SESSION['usernama'])) && (isset($_SESSION['userpass'])))){
	header ("location:../index.php?task=login");
//	header ("location:http://".$_SERVER['REMOTE_ADDR']."/absensi/index.php?task=login");
	exit;
}
$usernama	= $_SESSION["usernama"];
$userpass	= $_SESSION["userpass"];
?>