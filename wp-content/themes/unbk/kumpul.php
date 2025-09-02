<?php 
	require_once('bimadb.php');
	$id =  strtoupper($_POST['nama']);

	$mapel = $_POST['mapel'];
	$indexkey = "$mapel-$id";
	$v11sql = "";

	$v11sql = "SELECT `finish` FROM `{$table_prefix}bsfsm_siswa` WHERE kode='$id' AND mapel='$mapel'";
	$result = $conn->query($v11sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($row['finish'] == 1) {
				//Siswa sudah selesai
				echo "OK";
				exit;
				break;				
			} else {
				//Siswa belum selesai
				$jawaban = json_decode($_POST['jawaban']);

				$v11sqlpg = "DELETE FROM `{$table_prefix}bsfsm_jawabanpg` WHERE `indexkey` LIKE '$indexkey-%';INSERT INTO `{$table_prefix}bsfsm_jawabanpg` (`indexkey`, `opsi`) VALUES ";
				$addpg = "";
			
				$v11sqlessay = "DELETE FROM `{$table_prefix}bsfsm_jawabanessay` WHERE `indexkey` LIKE '$indexkey-%';INSERT INTO `{$table_prefix}bsfsm_jawabanessay` (`indexkey`, `opsi`) VALUES ";
				$addessay = "";
			
				for ($i=0; $i < count($jawaban) ; $i++) { 
					if (isset($jawaban[$i])) {
						if ( strlen($jawaban[$i]) === 1 ) {
							if ( $addpg <> "" ) {
								$addpg .= ",";
							}
							$addpg .= "('$indexkey-$i','".$jawaban[$i]."')";
						} else {
							if ( $addessay <> "" ) {
								$addessay .= ",";
							}
							if ( str_ireplace(" ","",$jawaban[$i]) ) {
								$addessay .= "('$indexkey-$i','".$jawaban[$i]."')";
							}
						}	  		
					}
				}
			
				if ($addpg <> "") {
					$v11sqlpg = $v11sqlpg.$addpg;	
					$v11sqlpg = $v11sqlpg.";";
				} else {
					$v11sqlpg = "";
				}
			
				if ($addessay <> "") {
					$v11sqlessay = $v11sqlessay.$addessay;
					$v11sqlessay = $v11sqlessay.";";
				} else {
					$v11sqlessay = "";
				}
			
				$v11sqljawaban = $v11sqlpg.$v11sqlessay;
			
				$v11sql = $v11sqljawaban;
			
				$v11sql = $v11sql."UPDATE {$table_prefix}bsfsm_siswa SET `finish` = 1 WHERE kode = '$id' AND mapel = '$mapel'";
				if ($conn->multi_query($v11sql)) {
					echo "OK";
				} else {
					echo("Error description: " . mysqli_error($conn));
					echo $v11sql;		
				}				
			}
		}
	} else {
		echo "Username $id tidak ditemukan pada mapel $mapel. Silakan Login Ulang";
		exit;
	}

