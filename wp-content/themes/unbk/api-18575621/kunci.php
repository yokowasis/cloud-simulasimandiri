<?php 

	if (file_exists('../../../../logo.png')) {
		exit;
	}

	require_once('../bimadb.php');

	checkkey();

	if (isset($_POST['first'])) {
		$v11sql  = "";
		$v11sql .= "DELETE FROM `{$table_prefix}bsfsm_kuncipg` WHERE `indexkey` LIKE '{$_POST['kode']}-%';";
		$v11sql .= "DELETE FROM `{$table_prefix}bsfsm_kunciessay` WHERE `indexkey` LIKE '{$_POST['kode']}-%';";
		$v11sql .= "DELETE FROM `{$table_prefix}bsfsm_bobot` WHERE `indexkey` LIKE '{$_POST['kode']}-%';";
		$v11sql .= "DELETE FROM `{$table_prefix}bsfsm_grouping` WHERE `indexkey` LIKE '{$_POST['kode']}-%';";
		$v11sql .= "DELETE FROM `{$table_prefix}bsfsm_locking` WHERE `indexkey` LIKE '{$_POST['kode']}-%';";
		$v11sql .= "DELETE FROM `{$table_prefix}bsfsm_kd` WHERE `indexkey` LIKE '{$_POST['kode']}-%';";
		$v11sql .= "DELETE FROM `{$table_prefix}bsfsm_kdsoal` WHERE `kode` = '{$_POST['kode']}';";
		$result = $conn->multi_query($v11sql);
		echo $v11sql;
	} else {

		// ignore_user_abort(true);
		// set_time_limit(0);

		// ob_start();
		// echo "ASD";
		// header('Connection: close');
		// header('Content-Length: '.ob_get_length());
		// ob_end_flush();
		// ob_flush();
		// flush();

		$v11sql = "";
		$i = 0;
		foreach ($_POST['kode'] as $kodemapel) {
			if ( strlen($_POST['kunci'][$i]) > 1 ) {
				//ESSAY			
				$v11sql = $v11sql . "
					INSERT INTO `{$table_prefix}bsfsm_kunciessay`
					( `indexkey`, `item` ) VALUES
					( '$kodemapel-{$_POST['no'][$i]}', '{$_POST['kunci'][$i]}' );
				";
			} else {
				//PILIHAN GANDA
				$v11sql = $v11sql . "
					INSERT INTO `{$table_prefix}bsfsm_kuncipg`
					( `indexkey`, `item` ) VALUES
					( '$kodemapel-{$_POST['no'][$i]}', '{$_POST['kunci'][$i]}' );
				";
			}


			$v11sql = $v11sql."
				INSERT INTO `{$table_prefix}bsfsm_bobot`
				( `indexkey`, `item` ) VALUES
				( '$kodemapel-{$_POST['no'][$i]}', '{$_POST['bobot'][$i]}' );

			";

			if (isset($_POST['kd']))
			$v11sql = $v11sql."
				INSERT INTO `{$table_prefix}bsfsm_kd`
				( `indexkey`, `item` ) VALUES
				( '$kodemapel-{$_POST['no'][$i]}', '{$_POST['kd'][$i]}' );

			";
			
			if (isset($_POST['namakd']))
			if ($_POST['namakd'][$i]) {
				$v11sql = $v11sql."
					INSERT INTO `{$table_prefix}bsfsm_kdsoal`
					( `kode`, `kd`, `alokasi` ) VALUES
					( '$kodemapel', '".$_POST['namakd'][$i]."' , '".$_POST['alokasikd'][$i]."' );
				";
			}

			if ($_POST['grouping'][$i]) {
				$v11sql = $v11sql."
					INSERT INTO `{$table_prefix}bsfsm_grouping`
					( `indexkey`, `item` ) VALUES
					( '$kodemapel-{$_POST['no'][$i]}', '{$_POST['grouping'][$i]}' );
				";
			}

			if ($_POST['locking'][$i]) {
				$v11sql = $v11sql."
					INSERT INTO `{$table_prefix}bsfsm_locking`
					( `indexkey`, `item` ) VALUES
					( '$kodemapel-{$_POST['no'][$i]}', '{$_POST['locking'][$i]}' );
				";			
			}			
			$i++;
		}


		if ($result = $conn->multi_query($v11sql)) {
			echo "OK";		
		} else {
			echo "GAGAL";
		}
	}

