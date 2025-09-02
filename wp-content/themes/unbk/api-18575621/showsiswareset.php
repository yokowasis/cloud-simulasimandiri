<?php 
	require_once('../bimadb.php');

	$mapel = $_POST['aktif'];

	$server = $_POST['server'];

	$v11sql = "SELECT `kode`,`nama` FROM `{$table_prefix}bsfsm_siswa` WHERE `mapel` = '$mapel' AND server='$server' AND `finish` = '2'";
	$stmt = $conn->prepare($v11sql);
	$stmt->execute();
	$stmt->bind_result($kode,$nama);
	$i = 0;
	while ($stmt->fetch()) {
		$i++;
		//echo "$i;$kode;$nama;1;$id|";
		echo "<input class='checkreset' type='checkbox' value='$kode' />;$kode;".strtoupper($nama)."|";
	}
	echo ";;";
	$stmt->close();
