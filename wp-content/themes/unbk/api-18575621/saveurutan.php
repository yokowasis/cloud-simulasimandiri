<?php 
	require_once('../bimadb.php');

	$mapel = $_GET['mapel'];
	unset($_GET['mapel']);

	$userid = $_GET['siswa'];
	unset($_GET['siswa']);

	$namasiswa = $_GET['namasiswa'];
	unset($_GET['namasiswa']);

	$stamp = $_GET['stamp'];
	unset($_GET['stamp']);

	$starttime = $_GET['starttime'];
	unset($_GET['starttime']);
	
	$set = implode(";", $_GET);

	$v11sql = 
	"INSERT INTO 
			`{$table_prefix}bsfsm_hasil` (indexkey, stamp, starttime, ordersoal)
	VALUES 
			('$mapel-$userid', '$stamp', '$starttime', '$set') 
	ON DUPLICATE KEY UPDATE 
		indexkey = '$mapel-$userid',
		stamp = '$stamp',
		starttime = '$starttime',
		ordersoal= '$set'
	";
	// echo $v11sql;
	$stmt = $conn->prepare($v11sql);
	$stmt->execute();
	$stmt->close();
