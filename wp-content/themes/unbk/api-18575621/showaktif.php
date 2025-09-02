<?php 
	require_once('../bimadb.php');

	$v11sql = "SELECT `mapel` FROM `{$table_prefix}bsfsm_aktif`";
	$stmt = $conn->prepare($v11sql);
	$stmt->execute();
	$stmt->bind_result($mapel);
	while ($stmt->fetch()) {
		echo "$mapel|";
	}
	$stmt->close();