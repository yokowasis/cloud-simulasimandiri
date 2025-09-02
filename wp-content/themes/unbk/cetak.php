<?php
	switch ($_GET['cetak']) {
	case 'kartu':
			include 'kartu.php';
		break;
	
	case 'beritaacara':
			include 'berita.php';
		break;
	
	case 'absensi':
			include 'absensi.php';
		break;
	
	case 'laporan':
			include 'laporan.php';
		break;
	
	case 'kartu2':
			include 'kartu2.php';
		break;
	
	case 'beritaacara2':
			include 'berita2.php';
		break;
	
	case 'absensi2':
			include 'absensi2.php';
		break;
	
	case 'laporan2':
			include 'laporan2.php';
		break;
	
	default:
		# code...
		break;
}