var db = openDatabase('mydb', '1.0', 'cbtsync', 2 * 1024 * 1024);
var url = '';
var aktif ='';

db.transaction(function (tx) {
   tx.executeSql('CREATE TABLE IF NOT EXISTS settings (id INTEGER PRIMARY KEY AUTOINCREMENT, url, aktif, server, username, password, localfolder)');
});

db.transaction(function (tx) {
   tx.executeSql('SELECT * FROM settings', [], function (tx, results) {
      var len = results.rows.length, i;
      for (i = 0; i < len; i++){
         	url = results.rows.item(i).url;
         	$('#kartupeserta').prop({
         	    href: url+'?cetak=kartupeserta&mapel='+aktif
         	})
         	$('#absensi').prop({
         	    href: url+'?cetak=absensi&mapel='+aktif
         	})
			jQuery(document).ready(function($) {
				$('input[name=ServerId]').val(url);
				url = url + 'wp-content/themes/unbk/api-18575621/';
			});
      }
   }, null);
});

jQuery(document).ready(function($) {
	$('#btnLogin').click(function(){
		if (url=='') {
			//baru			
			url = $('input[name=ServerId]').val();
			db.transaction(function (tx) {
				tx.executeSql('INSERT INTO settings (url)  VALUES ("'+url+'")');
	            $("#frmlogin").submit();
			});
		} else {
			//sudah ada
			db.transaction(function(transaction) {
				url = $('input[name=ServerId]').val();
				var sql = `UPDATE settings SET url = "`+url+`";`;
				transaction.executeSql(sql, [], function (tx, results) {
		            $("#frmlogin").submit();
				}, null);
			});
		}
	})
});

function changepage(url){
	$('#mainpage').load(url);
}

jQuery(document).ready(function($) {
	changepage('dashboard.html');
	$('#menubar a').click(function(event) {
		if ($(this).attr('target')!='_blank') {
			changepage($(this).attr('href'));
		}
		return false;
	});
});

function update_token(){
	token = '';
	
	$.post(url + 'generatetoken.php',{

	}, function(s){
		token = s;
		$('#tokenbox').val(token);
	})

}
