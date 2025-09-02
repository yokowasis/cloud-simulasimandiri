<?php 
	require_once('../bimadb.php');

	$server = $_POST['server'];

	$v11sql = "SELECT `nik2` FROM `{$table_prefix}bsfsm_siswa`  WHERE server='$server' GROUP BY `nik2` ORDER BY `nik2` ASC";
	$stmt = $conn->prepare($v11sql);
	$stmt->execute();
	$stmt->bind_result($kode);
	while ($stmt->fetch()) {
		echo "$kode|";
	}
	$stmt->close();
