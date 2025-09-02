<?php 
	require_once('../bimadb.php');
	checkkey();
	
	if (isset($_POST['first'])) {
		$mapel = $_POST['mapel-1'];
		$v11sql = "DELETE FROM `{$table_prefix}bsfsm_siswa` WHERE `mapel`='$mapel' AND finish IS NULL";
		$conn->query($v11sql);
	}

	for ($i = 1;$i<=$_POST['count'];$i++) {

		$v11sql = "INSERT INTO `{$table_prefix}bsfsm_siswa` (
		`indexkey`,
		`id`, 
		`kode`, 
		`nama`, 
		`mapel`, 
		`pass`,
		`nik`,
		`nik2`,
		`server`,
		`sesi`
		) 
		VALUES (
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?,
		?
		) ON DUPLICATE KEY UPDATE
		
		`indexkey` = ?,
		`id` = ?, 
		`kode` = ?, 
		`nama` = ?, 
		`mapel` = ?, 
		`pass` = ?,
		`nik` = ?,
		`nik2` = ?,
		`server` = ?,
		`sesi` = ?
		";


		if(!isset($_POST['nis-'.   		$i])) {$_POST['nis-'.		$i]="";}
		if(!isset($_POST['user-'.  		$i])) {$_POST['user-'.		$i]="";}
		if(!isset($_POST['nama-'.  		$i])) {$_POST['nama-'.		$i]="";}
		if(!isset($_POST['mapel-'. 		$i])) {$_POST['mapel-'.		$i]="";}
		if(!isset($_POST['pass-'.  		$i])) {$_POST['pass-'.		$i]="";}
		if(!isset($_POST['nik-'.   		$i])) {$_POST['nik-'.		$i]="";}
		if(!isset($_POST['nik2-'.  		$i])) {$_POST['nik2-'.		$i]="";}
		if(!isset($_POST['server-'.		$i])) {$_POST['server-'. 	$i]="";}
		if(!isset($_POST['sesi-'.  		$i])) {$_POST['sesi-'.		$i]="";}

		//if ($i == 100) {save_log ($_POST['nama-'.$i]);}

		$stmt = $conn->prepare($v11sql);
		$namasiswa = str_ireplace("'", "", $_POST['nama-'.$i]);
		$namasekolah = str_ireplace("'", "", $_POST['nik2-'.$i]);
		$indexkey = "{$_POST['mapel-' . $i]}-{$_POST['user-' . $i]}";
		$stmt->bind_param("ssssssssssssssssssss",
						   $indexkey,
						   $_POST['nis-'.$i],
						   $_POST['user-'.$i],
						   $namasiswa,
						   $_POST['mapel-'.$i],
						   $_POST['pass-'.$i],
						   $_POST['nik-'.$i],
						   $namasekolah,
						   $_POST['server-'.$i],
						   $_POST['sesi-'.$i],
						   $indexkey,
						   $_POST['nis-'.$i],
						   $_POST['user-'.$i],
						   $namasiswa,
						   $_POST['mapel-'.$i],
						   $_POST['pass-'.$i],
						   $_POST['nik-'.$i],
						   $namasekolah,
						   $_POST['server-'.$i],
						   $_POST['sesi-'.$i]
						);
		$stmt->execute();
		$stmt->close();
	}
	echo "OK";
