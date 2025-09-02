<?php

require_once ('functions.php');

function bimasoftOnlineCDN() {
    $menu_pengaturan_test = new Bimasoft_Page(
		'Online CDN',
		'dashicons-cloud',
		'84',
        NULL,
        NULL,
        NULL
	);
    $menu_pengaturan_test->add_option("Khusus Untuk Bimasoft Online Cloud","Halaman ini di khususkan untuk pengguna Cloud Online Bimasoft yang bisa di order di client.bimasoft.web.id.","title");
    $menu_pengaturan_test->add_option("Backend","URL ini untuk di masukkan ke dalam Excel dan CBTAdmin","text");
    $menu_pengaturan_test->add_option("GdriveToken","Silakan generate token Google Drive melalui <a href='https://bot.bimasoft.web.id:4020/gdrive/auth'>Link Auth</a>","text");
    $menu_pengaturan_test->add_option("GdriveParent","ID Folder tempat file akan di Upload. Petunjuk Pengisian : <a href='https://wiki.bimasoft.web.id/index.php/2021/08/29/setting-google-drive-untuk-format-jawaban-upload/'>Link</a> ","text");
    $menu_pengaturan_test->generate();
}

bimasoftOnlineCDN();