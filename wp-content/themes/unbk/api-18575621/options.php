<?php 

	if (file_exists('../../../../logo.png')) {
		exit;
	}

	require_once('../bimadb.php');

	checkkey();

	$tanggal = str_ireplace('Januari'	,'January'	,$_POST['tanggal']);
	$tanggal = str_ireplace('Februari'	,'February'	,$_POST['tanggal']);
	$tanggal = str_ireplace('Pebruari'	,'February'	,$_POST['tanggal']);
	$tanggal = str_ireplace('Maret'		,'March'	,$_POST['tanggal']);
	$tanggal = str_ireplace('Mei'		,'May'		,$_POST['tanggal']);
	$tanggal = str_ireplace('Juni'		,'June'		,$_POST['tanggal']);
	$tanggal = str_ireplace('Juli'		,'July'		,$_POST['tanggal']);
	$tanggal = str_ireplace('Agustus'	,'August'	,$_POST['tanggal']);
	$tanggal = str_ireplace('Oktober'	,'October'	,$_POST['tanggal']);
	$tanggal = str_ireplace('Nopember'	,'November'	,$_POST['tanggal']);
	$tanggal = str_ireplace('Desember'	,'December'	,$_POST['tanggal']);

	$kode 		= $_POST['kode'];
	$nama 		= $_POST['nama'];
	$status 	= $_POST['status'];
	$subtest 	= $_POST['subtest'];
	$tanggal 	= $_POST['tanggal'];
	$waktu 		= $_POST['waktu'];
	$alokasi 	= $_POST['alokasi'];
	$shuffle 	= $_POST['shuffle'];
	$shuffle2 	= $_POST['shuffle2'];
	$jumlahsoal = $_POST['jumlahsoal'];
	$dikerjakan = $_POST['dikerjakan'];


	$v11sql = "INSERT INTO `{$table_prefix}bsfsm_options` (
		`kode`,
		`nama`,
		`status`,
		`subtest`,
		`tanggal`,
		`waktu`,
		`alokasi`,
		`shuffle`,
		`shuffle2`,
		`jumlahsoal`,
		`dikerjakan`	
	) VALUES (
		'$kode',
		'$nama',
		'$status',
		'$subtest',
		'$tanggal',
		'$waktu',
		'$alokasi',
		'$shuffle',
		'$shuffle2',
		'$jumlahsoal',
		'$dikerjakan'
	)
	ON DUPLICATE KEY UPDATE
		
		`kode` = '$kode', 
		`nama` = '$nama', 
		`status` = '$status', 
		`subtest` = '$subtest', 
		`tanggal` = '$tanggal', 
		`waktu` = '$waktu', 
		`alokasi` = '$alokasi', 
		`shuffle` = '$shuffle', 
		`shuffle2` = '$shuffle2', 
		`jumlahsoal` = '$jumlahsoal', 
		`dikerjakan` = '$dikerjakan';		
	";

	if ($conn->query($v11sql)) {
		echo 1;
	} else {
		print_r ($conn);
	}


	


