<?php

require_once ('functions.php');

$user = wp_get_current_user();

function saveLisensi() {
	global $user;
	$s = stripslashes($_POST['lisensi']);
	if ( 'yokowasis' == $user->user_login ) {
		saveFile(get_stylesheet_directory(). "/lisensi.php", $s);
	}	
}

function printLisensi() {
	$menu_pengaturan_test = new Bimasoft_Page(
		'Lisensi',
		'dashicons-admin-network',
		'81',
		[],
		'',
		function(){
			saveLisensi();
		}
	);
	
	$menu_pengaturan_test->add_option("Lisensi","","textarea","");
    $menu_pengaturan_test->generate();
}
printLisensi();