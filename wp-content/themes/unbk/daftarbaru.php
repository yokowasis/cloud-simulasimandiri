<?php
function daftarSiwaBaru() {
    if (isset($_POST['name_baru']) && get_option("siswa-melakukan-pendaftaran-sendiri") === "Ya") {
		require_once (__DIR__ . '/bimadb.php');
		$mapel = $_POST['mapel_baru'];
		$username = $_POST['user_baru'];

		global $wpdb;
		$v11sql =
			"
			SELECT *
			from `{$wpdb->prefix}bsfsm_siswa`
			WHERE `indexkey` = '$mapel-$username' 
			";
		$rows = $wpdb->get_results($v11sql);
		if ($rows) {
			echo 'Username Sudah Ada, silakan menggunakan username yg lain';
		} else {
			$v11sql = "INSERT INTO `{$wpdb->prefix}bsfsm_siswa` (
				`indexkey`,
				`id`,
				`kode`,
				`nama`,
				`pass`,
				`nik`,
				`mapel`,
				`server`,
				`sesi`
			) VALUES (
				%s,
				%s,
				%s,
				%s,
				%s,
				%s,
				%s,
				%s,
				%s
			)";
			if ($wpdb->query( 
				$wpdb->prepare( 
						$v11sql,
						"$mapel-$username",'BARU',$_POST['user_baru'],$_POST['name_baru'],$_POST['passw_baru'],'BARU',$_POST['mapel_baru'],'BARU','1'
			        )
			)) {
				echo 'Silakan Login Dengan Username Yang Baru';
			} else {
				$lastsql = $wpdb->last_query;
				echo 'Gagal Mendaftar';
			}
		}
		exit;
	}    
}
daftarSiwaBaru();