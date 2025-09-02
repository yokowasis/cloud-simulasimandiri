<?php 
	include ('kop.php');
	$userid = get_current_user_id();
?>


<style type="text/css">
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
		box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
	}

	#innerpage {
		padding: 10px;
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
<?php 
global $wpdb;
$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_identitas` WHERE `ID`=$userid";
$rows = $wpdb->get_results($v11sql);

$datasekolah = $rows[0];

?>
<div id="page">
	<div id="innerpage">
      <table width="100%" class="tbhd">
        <tr>
          <td rowspan="3"></td>
          <td><?php echo ($kop3) ?></td>
          <td rowspan="3"></td>
        </tr>
        <tr>
          <td><?php echo (strtoupper($acara)); ?></td>
        </tr>
        <tr>
          <td><?php echo ($tahunpelajaran); ?></td>
        </tr>
      </table>

		<p style="text-align: justify;">Pada hari ini _____________ tanggal ___________________ bulan __________________tahun <?php echo date("Y",time()) ?>, &nbsp;telah diselenggarakan <?php echo ($acara) ?> untuk Program Studi ______________, Mata Pelajaran _____________________, dari pukul _________ sampai dengan pukul _________, sesi _______.</p>
		<table class="datasekolah">
			<tbody>
				<tr>
					<td>1.</td>
					<td>Provinsi</td>
					<td>:</td>
					<td class="line"><?php echo $datasekolah->{'db-Provinsi'} ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Kabupaten</td>
					<td>:</td>
					<td class="line"><?php echo $datasekolah->{'db-Kota / Kabupaten'} ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Sekolah / Madrasah</td>
					<td>:</td>
					<td class="line"><?php echo $datasekolah->{'db-Nama Sekolah'} ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Tempat Penyelenggaraan</td>
					<td>:</td>
					<td class="line"><?php echo $datasekolah->{'db-Nama Sekolah'} ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Ruang</td>
					<td>:</td>
					<td class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jumlah Peserta Seharusnya</td>
					<td>:</td>
					<td class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jumlah Hadir (Ikut Ujian)</td>
					<td>:</td>
					<td class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Jumlah Tidak Hadir</td>
					<td>:</td>
					<td class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>No. Peserta Yang Tidak &nbsp;Hadir</td>
					<td>:</td>
					<td class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>2.</td>
					<td>Catatan Selama Pelaksanaan Ujian</td>
					<td>:</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Pengawas&nbsp;</td>
					<td>:</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3" class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3" class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Proktor</td>
					<td>:</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3" class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3" class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Teknisi</td>
					<td>:</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3" class="line">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3" class="line">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<p>Yang membuat Berita Acara</p>
		<table class="datasekolah">
			<tbody>
				<tr>
					<th colspan="2" style="width:200px;">Jabatan</th>
					<th>Nama</th>
					<th style="width:200px;">TTD</th>
				</tr>
				<tr>
					<td>1.</td>
					<td>Pengawas</td>
					<td class="line" style="width:300px;">&nbsp;</td>
					<td>1.</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>NIP.</td>
					<td class="line" style="width:300px;">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>2.</td>
					<td>Proktor</td>
					<td class="line" style="width:300px;"><?php echo $datasekolah->{'db-Nama Proktor Utama'} ?></td>
					<td>2.</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>NIP.</td>
					<td class="line" style="width:300px;"></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>3.</td>
					<td>Teknisi</td>
					<td class="line" style="width:300px;"><?php echo $datasekolah->{'db-Nama Teknisi Utama'} ?></td>
					<td>3.</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>NIP.</td>
					<td class="line" style="width:300px;">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div id="catatan">
			<p>Catatan :</p>
			<p>- 1 (satu) Eksemplar untuk Sekolah / Madrasah</p>
			<p>- 1 (satu) Eksemplar untuk&nbsp;Kabupaten / Kota</p>
			<p>- 1 (satu) Eksemplar untuk&nbsp;Pusat</p>
		</div>
	</div>
</div>
