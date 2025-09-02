<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

require_once (__DIR__ . './bimadb.php');
$mapel = "MTS-VII-AGAMA-SKI";
$username = generateRandomString(15);
$password = $username;
$nama = $username;

$sql =
    "
    SELECT *
    from `siswa`
    WHERE `indexkey` = '$mapel-$username' 
    ";

$rows = $conn->query($sql);

if ($rows->num_rows) {
    echo 'Username Sudah Ada, silakan menggunakan username yg lain';
} else {
    $sql = "INSERT INTO `siswa` (
        `indexkey`,
        `id`,
        `kode`,
        `nama`,
        `pass`,
        `nik`,
        `mapel`,
        `server`,
        `sesi`
    ) VALUES (
        '$mapel-$username',
        'BARU',
        '$username',
        '$nama',
        '$password',
        'BARU',
        '$mapel',
        'BARU',
        '1'
    )";
    $result = $conn->query($sql);
}

header("Location: http://laptop-yoko:8888/cloud-simulasimandiri/");