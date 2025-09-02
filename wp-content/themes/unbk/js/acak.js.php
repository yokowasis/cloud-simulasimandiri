//ACAK JS PHP

if ((typeof jQuery.fn.shuffle) === 'undefined')
{
jQuery.fn.shuffle = function() {

var allElems = this.get(),
getRandom = function(max) {
return Math.floor(Math.random() * max);
},
shuffled = $.map(allElems, function(){
var random = getRandom(allElems.length),
randEl = jQuery(allElems[random]).clone(true)[0];
allElems.splice(random, 1);
return randEl;
});

this.each(function(i){
jQuery(this).replaceWith(jQuery(shuffled[i]));
});

return jQuery(shuffled);

};
}

<?php


//Cek Apakah Sudah ada History Atau Belum

$shuffle = $_GET['shuffle'];
$kodetest = $_GET['kodetest'];

if (isset($hasil)) {
	// if (false) {
	// Ada Hasil , Retrieve

	$ordersoal = $hasil['ordersoal'];
?>
	//Kalao Ada History Ambil History
	<?php
	$saveurutansoal = 0;

	$ordersoal = explode(";", $ordersoal);
	$mapel_dikerjakan = $_GET['mapel_dikerjakan'];
	if ($mapel_dikerjakan == "null") {
		$mapel_dikerjakan = 0;
	}
	for ($i = $mapel_dikerjakan; $i >= 0; $i--) {
		if (isset($ordersoal[$i])) {
			if (is_numeric($ordersoal[$i])) {
	?>
				jQuery('#nomor-asli-<?php echo $ordersoal[$i] ?>').prependTo('#soal-body');
	<?php
			}
		}
	}
} else {
	// Ndak ada hasil. Acak
	$saveurutansoal = 1;

	?>
	//Acak
	<?php if ($shuffle > 0) : ?>
		jQuery('textarea.essay').each(function(){
		jQuery(this).closest('div.soal').addClass('soalessay');
		})
		jQuery('div.soal').shuffle();
		jQuery('.soalessay').each(function(){
		jQuery(this).appendTo(jQuery('#soal-body'));
		})
		<?php endif;

	//KD

	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_kd` WHERE indexkey LIKE  '$kodetest-%';";
	$result = $conn->query($v11sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) {
			if ($row['item']) {
				$no = str_ireplace("$kodetest-", "", $row['indexkey']);
		?>
				jQuery('#nomor-asli-<?php echo $no ?>').attr('data-jeniskd',"<?php echo $row['item'] ?>");
			<?php
			}
		}
	}

	//KDSOAL

	$v11sql = "SELECT `kd`,`alokasi` FROM `{$table_prefix}bsfsm_kdsoal` WHERE `kode` = '$kodetest' ORDER BY `kd`; ";
	$result = $conn->query($v11sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) {
			if ($row['kd']) {
			?>
				jQuery('[data-jeniskd="<?php echo $row['kd'] ?>"]').addClass('kdtbr');
				jQuery('[data-jeniskd="<?php echo $row['kd'] ?>"]').shuffle();
				jQuery('[data-jeniskd="<?php echo $row['kd'] ?>"]').slice(0,<?php echo $row['alokasi'] ?>).removeClass('kdtbr');
				jQuery('.kdtbr').remove();
			<?php
			}
		}
	}

	//Lock N
	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_locking` WHERE indexkey LIKE  '$kodetest-%';";
	$result = $conn->query($v11sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) {
			if ($row['item'] > 0) {
				$no = str_ireplace("$kodetest-", "", $row['indexkey']);
			?>
				var div1 = jQuery('#nomor-asli-<?php echo $no ?>');
				console.log (div1);
				var div2 = jQuery('.soal').eq(<?php echo $row['item'] - 1 ?>);
				console.log (div2);
				var tdiv1 = div1.clone();
				var tdiv2 = div2.clone();
				div1.replaceWith(tdiv2);
				div2.replaceWith(tdiv1);
			<?php
			}
		}
	}

	//Grouping
	$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_grouping` WHERE indexkey LIKE  '$kodetest-%';";
	$result = $conn->query($v11sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while ($row = $result->fetch_assoc()) {
			if ($row['item'] > 0) {
				$no = str_ireplace("$kodetest-", "", $row['indexkey']);
			?>
				jQuery('#nomor-asli-<?php echo $row['item'] ?>').insertAfter(jQuery('#nomor-asli-<?php echo $no ?>'));
				console.log('<?php echo $no ?>><?php echo $row['item'] ?>')
<?php
			}
		}
	}
}
?>

//END ACAK JS