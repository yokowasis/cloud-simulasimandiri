<?php

require_once ('functions.php');

function pengaturanJudul() {

	$menu = new Bimasoft_Page(
		'Pengaturan Judul',
		'dashicons-format-aside',
		'80',
		[],
		NULL,
		NULL
	);
	
	$menu->add_option("Data Sekolah","","title");
	$menu->add_option("Logo_Kiri","","text");
	$menu->add_option("Logo_Kanan","","text");
	$menu->add_option("Nama_Sekolah","","text");
	$menu->add_option("Kota","","text");
	$menu->add_option("Propinsi","","text");
	$menu->add_option("Kop_Nama_Ujian","","text");
	$menu->add_option("Kop_Tahun_Pelajaran","","text");
	$menu->add_option("","","hr");
	// --------------------------------------------------
	$menu->add_option("Pengaturan Kop","","title");
	$menu->add_option("Kop_Daftar_Hadir","","text");
	$menu->add_option("Kop_Peserta","","text");
	$menu->add_option("Kop_Berita_Acara","","text");
	$menu->add_option("","","hr");
	// --------------------------------------------------
	$menu->add_option("Kop Laporan","","title");
	$menu->add_option("Kop_Laporan_1","","text");
	$menu->add_option("Kop_Laporan_2","","text");
	$menu->add_option("Kop_Laporan_3","","text");
	$menu->add_option("","","hr");
	// --------------------------------------------------
	$menu->add_option("Catatan Kaki Daftar Hadir","","title");
	$menu->add_option("Ket_1","","text");
	$menu->add_option("Ket_2","","text");
	$menu->add_option("Ket_3","","text");
	$menu->add_option("","","hr");
	// --------------------------------------------------
	$menu->add_option("Keterangan","","title");
	$menu->add_option("Nama_Ket_1","","text");
	$menu->add_option("Tanggal_Laporan","","text");
	$menu->add_option("Mengetahui","","text");
	$menu->add_option("","","hr");
	$menu->generate();	
}

pengaturanJudul();