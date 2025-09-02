<div align="center" class="noprint">
	<button id="printbutton" style="padding:4px 36px; margin-bottom: 20px;">Print</button>
</div>

<?php 
	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	//echo $actual_link;

	include ('kop.php');
	include ('indb.php');
	// $userid = get_current_user_id();
	$sekolah = $_GET['sekolah'];
	$mapeltemp = $_GET['mapel'];
	$namatemp  = $_GET['nama'];
	$server = ($_GET['server']) ? $_GE['server'] : "" ;
	$backend = ($opt_backend) ? $opt_backend : "" ;

	$mapel = [];

	$j=0;
	$k=0;

	for ($i=0; $i < count($namatemp) ; $i++) { 
		if ($i > 0) {
			if ( $namatemp[$i] != $namatemp[$i-1] ) {
				$nama[$j] = $namatemp[$i];
				$mapel[$j] = $mapeltemp[$i];
				$j++;
			} else {
				$j--;
				$mapel[$j] = $mapel[$j].";".$mapeltemp[$i];
				$j++;

			}
		} else {
			$nama[$j] = $namatemp[$i];
			$mapel[$j] = $mapeltemp[$i];
			$j++;
		}
		
	}

	$count=0;
	foreach ($nama as $nam) {
		if ($nam<>'') {
			$count++;
		}
	}

?>


<style type="text/css">
	@media print {
		.noprint {
			display: none;
		}
		
	}

	.left {
		float: left;
		width: 48%;
		margin-bottom: 3%;
	}
	.right {
		float: right;
		width: 300px;
	}

	#page {
		background: white;
		width: 21cm;
		display: block;
		margin: 0 auto;
		margin-bottom: 0.5cm;
	}

	#innerpage {
		padding: 20px 30px;
	}


	.clear {
		clear: both; 
	}

	.tbhd td {
	  text-align: center;
	  font-size: 16px;
	  font-weight: bold;
	}
	body,
	table
	{
		font-family: Arial;
		font-size: 12px;
	}
	p {
		line-height: 20px;
	}
	.line {
		border-bottom: solid 1px #000;
		width: 100%;
	}
	td {
		white-space: nowrap;
	}

	.datasekolah td {
		padding: 3px;
	}

	#catatan {
		margin-top: 20px;
		border: solid 1px #000;
		padding : 10px;
		width: 300px;
	}

	#catatan p {
		font-size: 12px;
		margin: 0;
		padding : 0;
		line-height: 1.3em;
	}

	@media print  
	{
		tr,td,div{
			page-break-inside: avoid;
		}
		.screen {
			display: none;
		}
	}
</style>
<div id="page">
	<div id="innerpage">
      <table width="100%" class="tbhd">
        <tr>
          <td rowspan="3" style="text-align: left;">
          	<?php if ($logokiri) : ?>
          	<img style="height: 70px;" src="<?php echo ($logokiri) ?>" alt="">
          	<?php endif; ?>
          </td>
          <td style="font-family: 'Tahoma'; font-size: 18px; font-weight: normal;"><?php echo ($laporan1) ?></td>
          <td rowspan="3" style="text-align: right;">
          	<?php if ($logokanan) : ?>
          	<img style="height: 70px;" src="<?php echo ($logokanan) ?>" alt="">
          	<?php endif; ?>
          </td>
        </tr>
        <tr>
          <td style="font-weight: normal; font-size: 25px; font-family: 'Tahoma'"><?php echo ($laporan2) ?></td>
        </tr>
        <tr>
          <td style="font-weight: normal; font-size: 12px; font-family: 'Tahoma'"><?php echo ($laporan3) ?></td>
        </tr>
      </table>

      <hr>

      <table width="100%">
        <tr>
        	<td>Provinsi</td>
        	<td>: <?php echo ($propinsi) ?></td>
        </tr>
        <tr>
        	<td>Kota / Kab.</td>
        	<td>: <?php echo ($kotasekolah) ?></td>
        </tr>
        <tr>
        	<td>Sekolah / Rombel</td>
        	<td>: <?php echo ($sekolah) ?></td>
        </tr>
      </table>

      <div style="height: 10px;"></div>

      <style type="text/css">
      .tg  {border-collapse:collapse;border-spacing:0; width: 100%}
      .tg td{font-family:Arial, sans-serif;font-size:12px;padding:2px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
      .tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:2px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
      .tg .tg-s6z2{text-align:center}
      .tg .tg-baqh{text-align:center;}
      .tg .tg-yw4l{ padding-left: 10px; }
      </style>
      <table class="tg" id='maintable'>
        <tr>
          <th class="tg-s6z2" rowspan="2">NO</th>
          <th class="tg-baqh" rowspan="2">USERNAME</th>
          <th class="tg-baqh" rowspan="2">NAMA SISWA</th>
          <th class="tg-baqh" colspan="<?php echo ($count) ?>">MATA PELAJARAN</th>
          <th class="tg-baqh" rowspan="2">JUMLAH<br>NILAI</th>
        </tr>
        <tr>
        	<?php 
        		for ($i=0; $i < $count ; $i++) { 
	    			?>
			          <td class="tg-baqh"><?php echo ($nama[$i]) ?></td>
	    			<?php
        		}
        	?>
        </tr>
        	<?php 
				global $wpdb;
				if ($backend) {
					$rows = [];
				} else {
					$v11sql =
						"
						SELECT `kode`, `nama`
						FROM `{$table_prefix}bsfsm_siswa`
						WHERE `nik2` = '$sekolah'
						GROUP BY `kode`
						ORDER BY `nama`;
						";
					$rows = $wpdb->get_results($v11sql);	
				}        		
        		$j=0;
        		foreach ( $rows as $row ) 
        		{
        			$j++;
        			?>
			        <tr class="rowsiswa">
	        			<td class="tg-baqh"><?php echo ($j) ?></td>
	        			<td class="tg-baqh"><?php echo ($row->kode) ?></td>
	        			<td class="tg-yw4l"><?php echo ($row->nama) ?></td>
	        			<?php

	        			for ($i=0; $i < $count; $i++) { 
		        			?>
			        			<td class="nilai tg-baqh" data-username="<?php echo ($row->kode) ?>" data-mapel="<?php echo ($mapel[$i]) ?>"></td>
		        			<?php
	        			}
		        		?>
		        			<td class="tg-baqh total"></td>
			        </tr>
        			<?php
        			echo $row->post_title;
        		}
        		$semua = $j * $count;
        	?>
      </table>

      <div style="height: 20px;"></div>

      <style type="text/css">
      .tg2  {border-collapse:collapse;border-spacing:0;}
      .tg2 td{font-family:Arial, sans-serif;font-size:12px;padding:2px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
      .tg2 th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:0px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
      .tg2 .tg2-baqh{text-align:center;vertical-align:middle;}
      .tg2 .tg2-yw4l{vertical-align:top}
      </style>
      <div class="kolomkiri">
      	<table class="tg2" id="tablesum">
      	  <tr>
      	    <th class="tg2-baqh" rowspan="2">NILAI</th>
      	    <th class="tg2-baqh" colspan="<?php echo ($count) ?>">MATA PELAJARAN</th>
      	    <th class="tg2-baqh" rowspan="2">JUMLAH<br>NILAI</th>
      	  </tr>
      	  <tr>
        	<?php 
        		for ($i=0; $i < $count ; $i++) { 
	    			?>
			          <td class="tg2-baqh"><?php echo ($nama[$i]) ?></td>
	    			<?php
        		}
        	?>
      	  </tr>
      	  <tr>
      	    <td class="tg2-yw4l">Rata - Rata</td>
      	    <?php
      	    	for ( $i=0 ; $i<$count ; $i++ ) {
      	    		?>
      	    		<td class="tg2-baqh" id="mapel<?php echo ($i+1) ?>avg"></td>
      	    		<?php
      	    	}
      	    ?>
      	    <td class="tg2-baqh" id="totalavg"></td>
      	  </tr>
      	  <tr>
      	    <td class="tg2-yw4l">Terendah</td>
      	    <?php
      	    	for ( $i=0 ; $i<$count ; $i++ ) {
      	    		?>
      	    		<td class="tg2-baqh" id="mapel<?php echo ($i+1) ?>min"></td>
      	    		<?php
      	    	}
      	    ?>
      	    <td class="tg2-baqh" id="totalmin"></td>
      	  </tr>
      	  <tr>
      	    <td class="tg2-yw4l">Tertinggi</td>
      	    <?php
      	    	for ( $i=0 ; $i<$count ; $i++ ) {
      	    		?>
      	    		<td class="tg2-baqh" id="mapel<?php echo ($i+1) ?>max"></td>
      	    		<?php
      	    	}
				  ?>
      	    <td class="tg2-baqh" id="totalmax"></td>
		</tr>
	</table>
      </div>
      <div class="kolomkiri">
		  <p>&nbsp;</p>
      	<p><?php echo $_GET['ttdjabatan'] ?></p>
      	<p style="height : 50px;"></p>
      	<p style="font-weight:bold;text-decoration:underline"><?php echo $_GET['ttdnama'] ?></p>
		<p><?php echo $_GET['ttdnip'] ?></p>
	</div>
      <div class="kolomkanan">
		  <p><?php echo $_GET['tgl'] ?></p>
      	<p><?php echo $_GET['mengetahuijabatan'] ?></p>
      	<p style="height : 50px;"></p>
      	<p style="font-weight:bold;text-decoration:underline"><?php echo $_GET['mengetahuinama'] ?></p>
      	<p><?php echo $_GET['nip'] ?></p>
      </div>
      <div style="clear: both"></div>

      <style type="text/css">
  		.kolomkiri {
  			float: left;
			  margin-right : 60px;
  		}
		.kolomkiri p {
			margin : 0;
		}


  		.kolomkanan {
  			float: right;
  			margin-right: 30px;
  		}

      	.kolomkanan p {
      		margin: 0;
      	}
      </style>

	
	</div>
</div>

<script src="wp-content/themes/unbk/archives/js/jquery.min.js"></script>

<script type="text/javascript">
	var $countnilai = 0;
	var $semua;

	function maxMinAvg(arr) {
	    var max = arr[0];
	    var min = arr[0];
	    var sum = arr[0]; //changed from original post
	    for (var i = 1; i < arr.length; i++) {
	        if (arr[i] > max) {
	            max = arr[i];
	        }
	        if (arr[i] < min) {
	            min = arr[i];
	        }
	        sum = sum + arr[i];
	    }
	    return [max, min, sum/arr.length]; //changed from original post
	}

	jQuery(document).ready(function($) {		
		var count = 0;
		<?php
			for ( $i=0 ; $i<$count ; $i++ ) {
				?>
					var mapel<?php echo ($i+1) ?> 	= [];
				<?php
			}
		?>
		var nilai 	= [];

		$('#printbutton').click(function(event) {
			window.print();
		});


		$semua = $('.nilai').length;

		var $jumlahsiswa = $('.rowsiswa').length;
		var $jumlahnilai = $('.nilai').length / $jumlahsiswa;		

		var $current_row = 0;


		if ("<?php echo $backend ?>") {
			$.ajax({
				url: '<?php echo $backend ?>getLaporanSiswa.php',
				type: 'POST',
				data: {
					'sekolah' : '<?php echo $_GET['sekolah'] ?>',
					'mapel' : '<?php echo json_encode($mapel) ?>',
					'nama'  : '<?php echo json_encode($nama) ?>',
					'server' : '<?php echo $_GET['server'] ?>',
				},
			}).done(function(e) {
				var html = "";
				var i = 0;
				e.forEach(siswa => {
					i++;
			        html += '<tr class="rowsiswa">';
					html += '<td class="tg-baqh">'+i+'</td>';
	        		html += '<td class="tg-baqh">'+siswa.kode+'</td>';
	        		html += '<td class="tg-yw4l">'+siswa.nama+'</td>';
	        			<?php
	        			for ($i=0; $i < $count; $i++) { 
		        			?>
			        			html += '<td class="nilai tg-baqh" data-username="'+siswa.kode+'" data-mapel="<?php echo ($mapel[$i]) ?>"></td>';
		        			<?php
	        			}
		        		?>
		        	html += '<td class="tg-baqh total"></td>';
			        html += '</tr>';
				});
				$('#maintable').append(html);
				var $jumlahsiswa = $('.rowsiswa').length;
				var $jumlahnilai = $('.nilai').length / $jumlahsiswa;		

				var $current_row = 0;
				$semua = $('.nilai').length;

				for (var i = 0; i < $jumlahnilai; i++) {
					$kolmapel = 3 + i;
					get_nilai(
						$jumlahsiswa,
						$current_row, 
						$kolmapel,
						$('.rowsiswa').eq($current_row).find('td').eq($kolmapel).attr('data-mapel')
						);
				}				
			}).fail(function(e) {
				console.log("error");
			}).always(function(e) {
			});
		} else {
			for (var i = 0; i < $jumlahnilai; i++) {
				$kolmapel = 3 + i;
				get_nilai(
					$jumlahsiswa,
					$current_row, 
					$kolmapel,
					$('.rowsiswa').eq($current_row).find('td').eq($kolmapel).attr('data-mapel')
					);
			}
		}
	});

	function hitung_nilai(){
		var $jumlahsiswa = $('.rowsiswa').length;
		var $jumlahnilai = $('.nilai').length / $jumlahsiswa;

		console.log ($jumlahnilai);

		for (var i = 0; i < $jumlahsiswa; i++) {
			var $totalnilai = 0;
			for (var j = 0; j < $jumlahnilai; j++) {
				$totalnilai = $totalnilai + ($('.rowsiswa').eq(i).find('td').eq(3 + j).html() / 1);
				//console.log ($totalnilai);
			}
			$('.rowsiswa').eq(i).find('td').eq( ( 3 + ($jumlahnilai * 1) ) ).html(Math.round($totalnilai * 100) / 100);
			console.log ("$('.rowsiswa').eq("+i+").find('td').eq("+ ( 3 + ($jumlahnilai * 1) ) +").html("+$totalnilai+");");
		}

		var $mapel = [];

		for (var i = 0; i < $jumlahnilai; i++) {
			var $totalnilai = 0;
			$mapel[i] = [];
			for (var j = 0; j < $jumlahsiswa; j++) {
				$mapel[i][j] = $('.rowsiswa').eq(j).find('td').eq(3 + i).html() / 1;
			}
		}

		$jumlahtotalnilai = [];

		for (var i = 0; i < $jumlahsiswa; i++) {
			$jumlahtotalnilai[i] = $('.rowsiswa').eq(i).find('td').eq(3 + $jumlahnilai ).html() / 1;
		}

		console.log ($jumlahtotalnilai);

		for (var i = 0; i < $jumlahnilai; i++) {
			$('#tablesum').find('tr').eq(2).find('td').eq( i + 1 ).html( Math.round(maxMinAvg($mapel[i])[2] * 100 ) / 100  );
			$('#tablesum').find('tr').eq(3).find('td').eq( i + 1 ).html( Math.round(maxMinAvg($mapel[i])[1] * 100 ) / 100 );
			$('#tablesum').find('tr').eq(4).find('td').eq( i + 1 ).html( Math.round(maxMinAvg($mapel[i])[0] * 100 ) / 100 );
		}

		$('#tablesum').find('tr').eq(2).find('td').eq( $jumlahnilai + 1 ).html( Math.round(maxMinAvg($jumlahtotalnilai)[2] * 100 ) / 100  );
		$('#tablesum').find('tr').eq(3).find('td').eq( $jumlahnilai + 1 ).html( Math.round(maxMinAvg($jumlahtotalnilai)[1] * 100 ) / 100 );
		$('#tablesum').find('tr').eq(4).find('td').eq( $jumlahnilai + 1 ).html( Math.round(maxMinAvg($jumlahtotalnilai)[0] * 100 ) / 100 );

	}

	function get_nilai($jumlahsiswa, $current_row, $kolmapel, $mapel){
		var $username = $('.rowsiswa').eq($current_row).find('td').eq(1).html();
		<?php if ($backend) : ?>
			var $url = '<?php echo ($backend); ?>wp-content/themes/unbk/api-18575621/hitungnilai.php?mapel='+$mapel+'&username='+$username;
		<?php else : ?>
			var $url = '<?php echo (get_home_url()); ?>/wp-content/themes/unbk/api-18575621/hitungnilai.php?mapel='+$mapel+'&username='+$username;
		<?php endif; ?>

		$.post($url, {}, function(data, textStatus, xhr) {
			$('.rowsiswa').eq($current_row).find('td').eq($kolmapel).html(data);
			$countnilai++;

			if ($countnilai == $semua) {
				hitung_nilai();
			}

			if ($current_row<$jumlahsiswa-1) {
				get_nilai(
					$jumlahsiswa,
					$current_row + 1, 
					$kolmapel,
					$('.rowsiswa').eq($current_row).find('td').eq($kolmapel).attr('data-mapel')
					);
			}

		});		

	}
</script>