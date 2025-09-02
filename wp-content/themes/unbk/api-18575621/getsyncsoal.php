<?php
	require_once('../bimadb.php');
	$sql = 
	"SELECT * FROM `".$table_prefix."posts` WHERE 
	`post_status` = 'publish' AND 
	`post_type` = 'post'" ;

	if (isset($_GET['mapel'])) {
		$sql .= " AND `post_title` = '".$_GET['mapel']."' ORDER BY `post_modified` DESC LIMIT 1";
	}

	$result = $conn->query($sql);

	$_POST['server'] = str_ireplace('https', 'http', $_POST['server']);
	$_POST['url'] 	 = str_ireplace('https', 'http', $_POST['url']);
	$_POST['server'] = str_ireplace('http://', '', $_POST['server']);
	$_POST['url'] 	 = str_ireplace('http://', '', $_POST['url']);
	
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	    	$row = str_ireplace('https', 'http', $row);
	    	$row = str_ireplace($_POST['server'], $_POST['url'], $row);
	    	$res[] = $row;
	    }
	} else {
	    //echo "0 results";
	}

	$str = json_encode($res);

	echo $str;