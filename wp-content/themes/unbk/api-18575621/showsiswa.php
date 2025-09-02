<?php 
	require_once('../bimadb.php');

	$server = $_POST['server'];
	$v11sql = "SELECT * FROM {$table_prefix}bsfsm_siswa WHERE server='$server' GROUP BY kode ORDER BY kode";
	$stmt = $conn->prepare($v11sql);
	$stmt->execute();
	$stmt->bind_result($idx, $id,$kode,$nama,$pass,$nik,$nik2,$mapel,$server,$sesi,$finish);
	$i = 0;
	while ($stmt->fetch()) {
		$i++;
		//echo "$i;$kode;$nama;1;$id|";
		echo "$i;$kode;".strtoupper($nama).";$sesi;$nik|";
	}
	$stmt->close();
