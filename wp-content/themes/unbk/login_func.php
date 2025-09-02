<?php

include 'indb.php';

function loginSiswa() {
	global $opt_autologin;
	$autologin = $opt_autologin;
	$keterangan = "";

	if ($autologin == "1") {
		$today = date('Y-m-d');

		global $wpdb, $table_prefix;
		$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_options` WHERE `tanggal` = %s ORDER BY `kode` ASC";
		$rows = $wpdb->get_results($wpdb->prepare($v11sql,array($today)));

		$mapels = [];
		foreach ( $rows as $row ) 
		{
			$datamapels[$row->kode] = $row;
			$mapels[] = $row->kode;
		}

		if ($mapels) {				
			$keterangan = 'Login Gagal, Username / Password Salah';
			foreach ($mapels as $mapel) {
				$namasiswa = checkuser($_POST['username_login'],$_POST['password'],$mapel);

				if ($namasiswa) {
					if ($namasiswa->finish == "1") {
						$keterangan = "Semua Mata Pelajaran Sudah Dikerjakan <a href='./archives/ceknilai---'>CEK NILAI</a>";
					} else {
						$keterangan = "";
						dologin($_POST['username_login'],$_POST['password'],$mapel,$namasiswa->nama,NULL,$datamapels->{$mapel});
						break;
					}
				} else {
				}
			}
		} else {
			$keterangan = 'Tidak ada Mata Pelajaran Terdaftar';
		}

	} else {

		$siswa = checkuser($_POST['username_login'],$_POST['password'],$_POST['mapel']);

		if ($siswa) {
			//Login Berhasil
			dologin($siswa->kode,$siswa->pass,$siswa->mapel,$siswa->nama,$siswa->finish);
		} else {
			$keterangan = 'Login Gagal, Username / Password Salah';
		}
	}
	if ($opt_autologin) {
		$keterangan = str_ireplace('pada Mapel : "'.$_POST['mapel'].'"', '', $keterangan);
	}

	echo $keterangan;
	exit;

}
loginSiswa();

function checkuser($username,$password,$mapel) {
	global $wpdb, $opt_pesanbanned,$opt_wajibreset, $opt_autologin, $table_prefix;

	$v11sql = 
	"SELECT `kode`, `nama`,`pass`,`mapel`,`finish` FROM `{$table_prefix}bsfsm_siswa` 
	WHERE 
	( pass=%s OR pass=%s ) AND 
	mapel=%s AND 
	kode=%s";

	$rows = $wpdb->get_results($wpdb->prepare($v11sql,array($password,"BANNED",$mapel,$username)));
	if (count($rows) > 0) {
		foreach ($rows as $row) {
			if ($row->pass == 'BANNED') {
				echo $opt_pesanbanned;
				exit;
			} else 
			if ($row->finish == '1') {
				if ($opt_autologin) {
					return $row;
				} else {
					echo "Anda Sudah Selesai Mengerjakan Mata Pelajaran ".$mapel." <a href='./archives/ceknilai---'>CEK NILAI</a>";
					exit;  
				}
			} else 
			if ($row->finish == '2' && $opt_wajibreset) {
				echo 'Login Gagal, Username "'.$username.'" sedang Login pada Mapel : "'.$mapel.'", Silakan Hubungi Pengawas/Proktor Untuk Melakukan Reset Login';
				exit;
			} else 
			{
				return ($row);
			}  		    	
		}
	} else {
		return false;
	}

}	

function dologin($username,$password,$mapel,$siswa,$finish = NULL,$datamapel = NULL) {

	global $wpdb, $opt_wajibreset, $opt_localstorage;

	$table_prefix = $wpdb->prefix;

	if ($datamapel == NULL) {
		$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_options` WHERE `kode` = %s ORDER BY `kode` ASC";
		$rows = $wpdb->get_results($wpdb->prepare($v11sql,array($mapel)));
		foreach ( $rows as $row ) 
		{
			$datamapel = $row;
		}
	}

	$siswa = str_ireplace("'","",$siswa);
	$res = new stdClass();
	$res->localstorage = $opt_localstorage;
	if ($opt_wajibreset || $opt_localstorage=='realtime') {
		$affectedrows = 
		$wpdb->update( 
			"{$table_prefix}bsfsm_siswa", 
			array( 
				'finish' => 2, 
			), 
			array( 
				'kode' => $username,
				'mapel' => $mapel
			) 
		);
		if ($finish === NULL) {
			$res->continue = 0;
		} else {
			$res->continue = 1;
		}
	} else {
		$res->continue = 1;
	}

	$res->status = "OK";
	$res->siswa = new stdClass();
	$res->siswa->username = $username;
	$res->siswa->mapel = $mapel;
	$res->siswa->namasiswa = $siswa;
	$res->mapel = new stdClass();
	$res->mapel = $datamapel;
	$keterangan =  json_encode($res);
	echo $keterangan;
}
