<?php 
	require_once(__DIR__ . '/../bimadb.php');

	$v11sql = "SELECT `mapel` FROM `{$table_prefix}bsfsm_siswa` GROUP BY `mapel` ORDER BY `mapel` ASC";
	$stmt = $conn->prepare($v11sql);
	$stmt->execute();
	$stmt->bind_result($kode);
	while ($stmt->fetch()) {
		echo "$kode|";
	}
	$stmt->close();
