<?php 
	require_once(__DIR__ . '/../bimadb.php');

	$today = date('Y-m-d');

	$server = $_POST['server'];
	$v11sql = "SELECT mapel FROM {$table_prefix}bsfsm_siswa WHERE server='$server' GROUP BY mapel";
	// echo $v11sql;
	$stmt = $conn->prepare($v11sql);
	$stmt->execute();
	$stmt->bind_result($kode);
	while ($stmt->fetch()) {
		echo "$kode|";
	}
	$stmt->close();
