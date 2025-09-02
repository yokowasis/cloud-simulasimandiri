<?php 
	require_once('../bimadb.php');

	$mapel  = $_GET['mapel'];
	$username = $_GET['username'];
	$debug = (isset($_GET['debug'])) ? $_GET['debug'] : 0 ;
	$siswaid = $username;
	$userid = $username;

	function str_replace_first($from, $to, $subject)
	{
	    $from = '/'.preg_quote($from, '/').'/';

	    return preg_replace($from, $to, $subject, 1);
	}

	//https://cbt.my.id/index.php?cetak=laporan&sekolah=SMAN 1 BAMBANGLIPURO&mapel[]=TEST&nama[]=ASD&mapel[]=TEST2&nama[]=ASD&mapel[]=TEST3&nama[]=ASD&nama[]=&nama[]=&nama[]=&nama[]=

	if (strpos($mapel, ";")>0) {
		$mapels = explode(";", $mapel);
		foreach ($mapels as $mapel) {
			$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_hasil` WHERE `userid` = '$username' AND `test` = '$mapel'";
			if ($debug) echo $v11sql;
			$result = $conn->query($v11sql);
			
			if ($result->num_rows > 0) {
			    break;
			} else {
			    //echo "0 results";
			}
		}
	} else {

	}

	//AMBIL KUNCI JAWABAN
	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_options` WHERE `kode`='$mapel'";
	if ($debug) echo $v11sql;
	$result = $conn->query($v11sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
	    $row = $result->fetch_assoc();

	    $kodetest = $row['kode'];
	    $jumlah = $row['dikerjakan'];

		$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_kuncipg` WHERE indexkey LIKE  '$kodetest-%';";
		if ($debug) echo $v11sql;
		$result = $conn->query($v11sql);
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$no = str_ireplace("$kodetest-","",$row['indexkey']);
				$benar[$no] = $row['item'];
			}
		}
	
		$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_kunciessay` WHERE indexkey LIKE  '$kodetest-%';";
		if ($debug) echo $v11sql;
		$result = $conn->query($v11sql);
	
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$no = str_ireplace("$kodetest-","",$row['indexkey']);
				$benar[$no] = $row['item'];
			}
		}
	
	}

	if (!isset($kodetest)) {
		echo 'Kode Mapel Tidak Boleh Kosong';
		exit;
	}

	//Ambil Bobot
	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_bobot` WHERE indexkey LIKE  '$kodetest-%';";
	if ($debug) echo $v11sql;
	$result = $conn->query($v11sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
			$no = str_ireplace("$kodetest-","",$row['indexkey']);
	    	$b[$no] = $row['item'];
	    }
	}

	//AMBIL DATA PESERTA TEST

	$v11sql = "SELECT indexkey FROM `{$table_prefix}bsfsm_siswa` where indexkey = '$mapel-$username'";
	if ($debug) echo $v11sql;
	$result = $conn->query($v11sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
	    $x = 0;
	    while($row = $result->fetch_assoc()) {
	    	$x++;

			$jmlbenar = 0;
			$jmlsalah = 0;
	    	$kode = $mapel;

			// Jawaban PG -----------------
			$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_jawabanpg` WHERE indexkey LIKE '$mapel-$siswaid-%';";
			if ($debug) echo $v11sql;
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
							error_log("Kunci No : $no tidak ada");
							echo ("Kunci No : $no tidak ada");
						} else		
	    	    		if ( ($row2['opsi'] == $benar[$no]) || ($benar[$no] == "X") ) {
							if (!isset($b[$no])) {
								error_log ("Bobot No : $no tidak ada");
								echo ("Bobot No : $no tidak ada");									
							} else {
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
			if ($debug) echo $v11sql;
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

    					$nilai = $nilai + $skoressay;

    					//----		
	    	    	}
	    	    }
	    	} 

	    	//END Essay---------------


	    	$skor = $nilai;

	    	echo $skor;
	    	unset ($answers);

	    }
	}