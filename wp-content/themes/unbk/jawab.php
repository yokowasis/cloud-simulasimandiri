<?php 
	require_once('bimadb.php');

	if (!isset($_POST['mapel'])) {
		echo "mata pelajaran kosong";
		exit;
	}

	if (!isset($_POST['userid'])) {
		echo "username tidak boleh kosong";
		exit;
	}

	$userid 	= $_POST['userid'];
	$kodemapel 	= $_POST['kodemapel'];

	$v11sql = "SELECT finish FROM `{$table_prefix}bsfsm_siswa` WHERE kode='$userid' AND mapel='$kodemapel'";
	$result = $conn->query($v11sql);
	
	if ($result->num_rows > 0) {
		$v11sql = "";
	    // output data of each row
	    $row = $result->fetch_assoc();

	    if ($row['finish'] === "1" ) {
			echo 'logselesai';
			exit;
	    } else 
		// TOLAK MENYIMPAN JAWABAN JIKA STATUS TIDAK SEDANG LOGIN DAN STATUS MENGERJAKAN
		if ( ($row['finish'] == 2) && ( (isset($_POST['option'])) || (isset($_POST['no'])) ) ) {
			$jawaban = $conn->real_escape_string($_POST['option']);
			$time = $_POST['sisawaktu'];
			$no = $_POST['no'];

			if ( str_ireplace(" ","",$jawaban) )
			if ( strlen($jawaban) > 1 )  {
				//JAWABAN ESSAY

				$v11sql = 
				"INSERT INTO 
						{$table_prefix}bsfsm_jawabanessay (indexkey, opsi)
				VALUES 
						('$kodemapel-$userid-$no', '$jawaban')
				ON DUPLICATE KEY UPDATE 
					opsi = '$jawaban';					
				";
			} else {
				$v11sql = 
				"INSERT INTO 
						{$table_prefix}bsfsm_jawabanpg (indexkey, opsi)
				VALUES 
						('$kodemapel-$userid-$no', '$jawaban')
				ON DUPLICATE KEY UPDATE 
					opsi = '$jawaban';					
				";
			}
		} else {
			echo 'logout';
			exit;
		}
	}

	$v11sql .=
	"UPDATE {$table_prefix}bsfsm_hasil SET 
	`stamp`='$time'
		WHERE 
		indexkey = '$kodemapel-$userid';
	";

	//Konfirmasi Tersimpan
	if ($conn->multi_query($v11sql)) {
		echo 'OK';
	} else {
		echo $v11sql;
	}
