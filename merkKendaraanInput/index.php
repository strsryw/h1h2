<?php
// session_start();

//  $session_namauser=$_SESSION["newasset_session_nama"];
//  $session_userid = $_SESSION["newasset_session_id"];
//  $session_groupId = $_SESSION["newasset_session_groupId"];
//  $session_area = $_SESSION["newasset_session_area"];
//  $session_perusahaan=$_SESSION['newasset_session_perusahaan'];
// if($session_namauser=="")
// {
// 	header("location:../index.php");
// }
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> .: Form Merk Kendaraan :. </title>
	<script type="text/javascript" src="../base/aw.js"></script>
	<script type="text/javascript" src="../base/functions.js"></script>
	<script type="text/javascript" src="../base/numericCheck.js"></script>
	<script type="text/javascript" src="../base/datetimepicker.js"></script>
	<script type="text/javascript" src="../functions/jQuery/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="../functions/jQuery/js/ajaxfileupload.js"></script>
	<script src="../functions/jQuery/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="../base/formatNumber.js"></script>
	<script type="text/javascript" src="h1.js"></script>
	<link href="../functions/jQuery/css/custom-theme/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="../base/aw.css" rel="stylesheet" />
	<link type="text/css" href="../functions/style.css" rel="stylesheet" />
	<style type="text/css">
		.tb {
			width: 950px;
			font-family: Tahoma, Arial, Helvetica, sans-serif;
			font-size: 14px;
		}

		.tr {
			width: 950px;
			float: left;
		}

		#tabdepan {
			width: 150px;
			;
			float: left;
		}

		fieldset {
			border: 1px solid rgb(255, 232, 57);
			width: 400px;
			margin: auto;
		}
	</style>
	<style type="text/css">
		div {
			font-size: 11px;
		}

		#loading {
			color: white;
			background-color: red;
			padding: 5px 10px;
			font: 11px sans-serif;
			width: 180px
		}
	</style>
	<div id="loading" style="display:none">Loading...</div>
</head>

<body style="height:18px; font-weight:bold; alignment-adjust:middle;">
	<form name="form1" method="post">
		<fieldset align="center" style="padding:20px; width:55%" class="roundIt">
			<legend>Form Merk</legend>
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>Input Merk</td>
					<td>:</td>
					<td>&nbsp;&nbsp;<input id="txtNmMerk" type="text" name="txtNmMerk" class="roundIt">
						<input id="txtIdMerk" type="text" name="txtIdMerk" class="roundIt" style="display:none">
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td>Kode Merk</td>
					<td>:</td>
					<td>&nbsp;&nbsp;<input id="txtKdMerk" type="text" name="txtKdMerk" class="roundIt"></td>
					<td>&nbsp;&nbsp;<input type="button" id='simpanBtn' name="Submit" value="Add" onClick="cekSimpan()"></td>
					<td>&nbsp;&nbsp;<input type="button" id='batalBtn' name="Submit" value="Batal" onClick="Batal()" style="display:none"></td>
				</tr>
			</table>
		</fieldset>
	</form>
	<table align="center" width="60%" border=0>
		<tr>
			<td width="180px">Search by <strong>Nama Merk</strong></td>
			<td width="5px">:</td>
			<td width="150px">
				<input type="text" id="txtNmMerkCari" name="txtNmMerkCari" class="roundIt" style="display:block">
			</td>
			<td width="40px">
				<button type="button" id="btnCari" onClick="getData('1')" style="display: block;"> Cari </button>
			</td>
			<td>
				<button type="button" id="btnAdd" onClick="addLink()" style="display: block;"> Add </button>
			</td>
		</tr>
	</table>
	<table align="center" width="60%" cellpadding="0" cellspacing="0" id="tblDetil">
		<thead></thead>
		<tbody style="padding-left:5"></tbody>
	</table>
	<table width="100%">
		<tr>
			<td>
				<div id="linkHal" style="height:18px; font-weight:bold; alignment-adjust:middle; display:none"></div>
			</td>
		</tr>
	</table>
</body>
<script>
	$(function() {
		$('#loading').ajaxStart(function() {
			$(this).fadeIn();
		}).ajaxStop(function() {
			$(this).fadeOut();
		});
	});
</script>