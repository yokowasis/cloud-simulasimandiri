<?php 
	require_once('bimadb.php');
	function str_replace_first($from, $to, $subject)
	{
	    $from = '/'.preg_quote($from, '/').'/';

	    return preg_replace($from, $to, $subject, 1);
	}
	if ($opt_shownilai == 0) {
		echo '-';
		exit;
	}
	$id = strtoupper($_POST['userid']);
	if (isset($_POST['mapel'])) {
		$mapel = $_POST['mapel'];
	} else 

	if (!isset($mapel)) {
		echo "--";
		exit;
	}
	$mapels = array();

	if ($mapel == "ALL") {
		$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_siswa` WHERE finish='1' AND kode='$id'";
		$result = $conn->query($v11sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$mapels[] = $row['mapel'];
			}
		} else {
		}
	} else {
		$v11sql = "UPDATE `{$table_prefix}bsfsm_siswa` SET `finish` = 1 WHERE indexkey = '$mapel-$id'";
		$conn->query($v11sql);	
		$mapels[] = $mapel;
	}

foreach ($mapels as $mapel) {


	$kodetest = $mapel;
	$siswaid = $id;
	$jmlbenar = 0;
	$jmlsalah = 0;

	echo "<hr/>";
	echo "<h4 style='font-size : 20px'>$mapel</h4>";
	echo "<hr/>";

	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_kuncipg` WHERE indexkey LIKE '$kodetest-%';";
	$result = $conn->query($v11sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$no = str_ireplace("$kodetest-","",$row['indexkey']);
			$benar[$no] = $row['item'];
		}
	} else {
		//echo "0 results";
	}

	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_kunciessay` WHERE indexkey LIKE  '$kodetest-%';";
	$result = $conn->query($v11sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$no = str_ireplace("$kodetest-","",$row['indexkey']);
			$benar[$no] = $row['item'];
		}
	} else {
		//echo "0 results";
	}



	//Ambil KD
	$kd = array();
	$skorkd = array();
	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_kd` WHERE indexkey LIKE  '$kodetest-%';";
	$result = $conn->query($v11sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$no = str_ireplace("$kodetest-","",$row['indexkey']);
			$kd[$no] = $row['item'];
		}
	}

	//Ambil Bobot
	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_bobot` WHERE indexkey LIKE  '$kodetest-%';";
	$result = $conn->query($v11sql);

	if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$no = str_ireplace("$kodetest-","",$row['indexkey']);
					$b[$no] = $row['item'];
				}
	}


	// Jawaban PG -----------------
	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_jawabanpg` WHERE indexkey LIKE '$mapel-$siswaid-%';";
	$result2 = $conn->query($v11sql);

	$nilai = 0;

	if ($result2->num_rows > 0) {
		// output data of each row
		while($row2 = $result2->fetch_assoc()) {
			$no = ltrim(strrchr($row2['indexkey'],'-'),"-");
			if (is_numeric($no)) { (int)$no;} else { error_log($no); }
			if ($no > 0)  {
				$answers[$no] = $row2['opsi'];
				if (!isset($benar[$no])) {
					// error_log("Kunci No : $no tidak ada");
					echo ("Kunci No : $no tidak ada");
				} else
				if ( ($row2['opsi'] == $benar[$no]) || ($benar[$no] == "X") ) {
					// echo "<pre>";
					// echo "NO : {$no} - {$kd[$no]} - Bobot : {$b[$no]}";
					// echo "</pre>";
					if (isset($kd[$no])) {
						if (!isset($skorkd[$kd[$no]])) {$skorkd[$kd[$no]] = 0;}
					}
					if (!isset($b[$no])) {
						// error_log ("Bobot No : $no tidak ada");
						echo ("Bobot No : $no tidak ada");									
					} else {
						if (isset($kd[$no])) {
							$skorkd[$kd[$no]] += $b[$no];
						}
						$nilai = $nilai + $b[$no];
					}
					$jmlbenar++;
				} else {
					$jmlsalah++;
				}
			}
		}
	}

	//Essay---------------
	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_jawabanessay` WHERE indexkey LIKE '$mapel-$siswaid-%';";
	$result2 = $conn->query($v11sql);

	if ($result2->num_rows > 0) {
		// output data of each row
		while($row2 = $result2->fetch_assoc()) {
			$no = ltrim(strrchr($row2['indexkey'],'-'),"-");
			if (is_numeric($no)) { (int)$no;} else { error_log($no); }
			if ($no > 0) {
				$answers[$no] = $row2['opsi'];
				//-----------------------
				//Parsing Kunci
				$kunci = $benar[$no];
				if ($kunci=='X') { 
					$bonus = true;
				} else {
					$bonus = false;
				}

				$kunci = explode(",", $kunci);
				for ($j=0; $j <count($kunci) ; $j++) { 
					$kunci[$j] = explode(" ", $kunci[$j]);
				}

				$jawaban = $row2['opsi'];

				$bobot = $b[$no];
				$bobotperjawaban = $bobot / count($kunci);
				$skoressay = 0;

				foreach ($kunci as $_kunci) {
					$essay_result = '';
					foreach ($_kunci as $__kunci) {
						if ($__kunci == "CHECK") {
							$essay_result .= ($jawaban == "CHECK" ? "true " : "false ");
						} else 
						if (strpos(strtolower($jawaban), strtolower($__kunci)) !== false){
							$essay_result .= 'true ';
						} else {
							$essay_result .= 'false ';
						}
					}
					if (strpos($essay_result, 'false') !== false) {
					} else {
						$skoressay += $bobotperjawaban;

						foreach ($_kunci as $__kunci) {
							$jawaban = str_replace_first($__kunci, "", $jawaban);
						}
					}
				}

				if ($skoressay>$bobot) {
					$skoressay = $bobot;
				}
				if ($bonus) {
					$skoressay = $bobot;
				}

				if ($skoressay) {
					if (!isset($skorkd[$kd[$no]])) {$skorkd[$kd[$no]] = 0;}
					$skorkd[$kd[$no]] += $skoressay;	
				}
				$nilai = $nilai + $skoressay;
				// echo "<pre>";
				// echo "NO : {$no} - {$kd[$no]} - Bobot : {$b[$no]}";
				// echo "</pre>";

				//----		
			}
		}
	}

	$skor = $nilai;

	if (isset($_POST['standalone'])) {
		echo $nilai;
		exit;		
	}

	if ($skor<50){
		$pre = '<span style="color:red">';
	} else 
	if ($skor<70){
		$pre = '<span style="color:orange">';
	} else 
		$pre = '<span style="color:green">';
	
	$post = '</span>';

	// echo "<pre>";
	// print_r($skorkd);
	// echo "</pre>";

	echo $pre.$skor.$post;
	echo "<p></p>";
	$s  = "";
	$s .= "<table style='width:100%' border=1>";
	$s .= "<tr><td style='padding: 5px 10px; text-align:left;font-size:18px;'>Rincian</td>";
	$s .= "<td style='padding: 5px 10px; text-align:left;font-size:18px;'>Skor</td></tr>";
	foreach ($skorkd as $key => $value) {
		$s .= "<tr><td style='padding: 5px 10px; text-align:left;font-size:18px;font-weight:normal'>$key</td>";
		$s .= "<td style='padding: 5px 10px; text-align:left;font-size:18px;font-weight:normal'>$value</td></tr>";
	}
	$s .= "</table>";
	echo $s;
	$skor = 0;

}
