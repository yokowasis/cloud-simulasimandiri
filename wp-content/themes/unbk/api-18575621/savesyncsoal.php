<?php
	require_once ('../bimadb.php');

	$data = $_POST['data'];

	//$data = stripslashes($data);

	echo $data;
	
	$data = json_decode($data);



	// $sql = "DELETE FROM `".$table_prefix."posts`";
	// $result = $conn->query($sql);
	
	for ($i=0; $i < count($data) ; $i++) { 
		$sql = "
			INSERT INTO `".$table_prefix."posts`
			(
			`post_author`,
			`post_date`,
			`post_date_gmt`,
			`post_content`,
			`post_title`,
			`post_excerpt`,
			`post_status`,
			`comment_status`,
			`ping_status`,
			`post_password`,
			`post_name`,
			`to_ping`,
			`pinged`,
			`post_modified`,
			`post_modified_gmt`,
			`post_content_filtered`,
			`post_parent`,
			`guid`,
			`menu_order`,
			`post_type`,
			`post_mime_type`,
			`comment_count`
			) VALUES (
			'".str_ireplace("'","\'",$data[$i]->{'post_author'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_date'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_date_gmt'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_content'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_title'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_excerpt'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_status'})."',
			'".str_ireplace("'","\'",$data[$i]->{'comment_status'})."',
			'".str_ireplace("'","\'",$data[$i]->{'ping_status'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_password'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_name'})."',
			'".str_ireplace("'","\'",$data[$i]->{'to_ping'})."',
			'".str_ireplace("'","\'",$data[$i]->{'pinged'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_modified'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_modified_gmt'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_content_filtered'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_parent'})."',
			'".str_ireplace("'","\'",$data[$i]->{'guid'})."',
			'".str_ireplace("'","\'",$data[$i]->{'menu_order'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_type'})."',
			'".str_ireplace("'","\'",$data[$i]->{'post_mime_type'})."',
			'".str_ireplace("'","\'",$data[$i]->{'comment_count'})."'
			)
		";

		$sqldelete = "DELETE FROM ".$table_prefix."posts WHERE post_title = '".str_ireplace("'","\'",$data[$i]->{'post_title'})."';";
		$conn->query($sqldelete);
		echo $sqldelete;

		if ($conn->query($sql)) {

		} else {
			echo $sql;
		}
	}
