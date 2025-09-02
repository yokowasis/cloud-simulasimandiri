<?php 
  $trun = 1;
  if (file_exists(__DIR__.'/../bimadb.php')) {
    require_once (__DIR__.'/../bimadb.php');
  } else {
    require_once (__DIR__.'/bimadb.php');
  }

checkkey();

$v11sql = "DELETE FROM `{$table_prefix}bsfsm_siswa`";
$stmt = $conn->prepare($v11sql);
if ($stmt->execute()) {
	echo 'OK';
} else {
	echo 'GAGAL';
};
$stmt->close();

