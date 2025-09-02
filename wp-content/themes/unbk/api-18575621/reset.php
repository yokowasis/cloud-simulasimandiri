<?php 
	require_once('../bimadb.php');

	$mapel = $_GET['mapel'];
	$user = $_GET['user'];

	$v11sql = "UPDATE  `{$table_prefix}bsfsm_siswa` SET  `finish` = '0' WHERE indexkey = '$mapel-$user'";
	$stmt = $conn->prepare($v11sql);
	$stmt->execute();
	$stmt->close();
	echo $v11sql;
