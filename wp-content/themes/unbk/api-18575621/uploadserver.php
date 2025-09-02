<?php 
	require_once('../bimadb.php');

	checkkey();

	if (isset($_POST['first'])) {
		$v11sql = "DELETE FROM `{$table_prefix}bsfsm_server`";
		$conn->query($v11sql);
	}

	for ($i = 1;$i<=$_POST['count'];$i++) {

		$v11sql = "INSERT INTO `{$table_prefix}bsfsm_server` (
		`nama_sekolah`, 
		`id_server`, 
		`pass_server`
		) 
		VALUES (
		?,
		?,
		?
		)";


		if(!isset($_POST['nama_sekolah-'.$i])) {$_POST['nama_sekolah-'.$i]="";}
		if(!isset($_POST['id_server-'.$i])) {$_POST['id_server-'.$i]="";}
		if(!isset($_POST['pass_server-'.$i])) {$_POST['pass_server-'.$i]="";}

		$stmt = $conn->prepare($v11sql);
		$stmt->bind_param(
			"sss", 
			$_POST['nama_sekolah-'.$i], 
			$_POST['id_server-'.$i], 
			$_POST['pass_server-'.$i]
		);
		
		if ($stmt->execute()) {
			echo 'OK...';
		} else {
			echo "GAGAL : $v11sql";
		}
		$stmt->close();
	}
