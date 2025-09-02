<?php 
	require_once('../bimadb.php');

	if (isset($_POST['OK'])) {
		$v11sql = "UPDATE {$table_prefix}bsfsm_siswa SET `nik` = '".$_POST['keterangan']." <small class=\"uploaded\">/ Terupload</small>' WHERE `kode` = '".$_POST['kode']."' AND `mapel` = '".$_POST['mapel']."'; ";
		$v11sql = $v11sql. "UPDATE {$table_prefix}bsfsm_hasil SET `finish` = '1' WHERE `userid` = '".$_POST['kode']."' AND `test` = '".$_POST['mapel']."'; ";
		if ($conn->multi_query($v11sql)) {
			echo "OK";
		} else {
			echo "FAIL";
		};	
	} else {
		$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_hasil` WHERE `userid` = '".$_POST['kode']."' AND `test` = '".$_POST['mapel']."'";
		$result = $conn->query($v11sql);
		
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		    	$hasil[] = $row;
		    }
		} else {
		}

		$hasil = json_encode($hasil);

		echo $hasil;		
	}

