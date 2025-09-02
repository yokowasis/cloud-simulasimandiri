<?php 
	require_once('../bimadb.php');

	function RandomString()
	{
	    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZZ';
	    $randstring = '';
	    for ($i = 0; $i < 6; $i++) {
	        $randstring = $randstring.$characters[rand(0, strlen($characters))];
	    }
	    return $randstring;
	}

	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_aktif`";
	$result = $conn->query($v11sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        $tokentime = $row['tokentime'];
	        $token = $row['token'];
	    }
	} else {
	}

	$token_updated = date("Y-m-d H:i",time());

	$to_time = strtotime($token_updated);
	$from_time = strtotime($tokentime);
	$minutes = round(abs($to_time - $from_time) / 60,2);

	if ($minutes>$opt_waktutoken) {
		$token = RandomString();

		$v11sql = "UPDATE  `{$table_prefix}bsfsm_aktif` SET  `token` =  '".$token."',`tokentime` =  '".$token_updated."'";
		$stmt = $conn->prepare($v11sql);
		$stmt->execute();
		$stmt->close();

		$token_updated = date("d-m-Y H:i",time());
		echo $token;
	} else {
		echo $token;
	}
