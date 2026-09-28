<?php

require_once ('functions.php');

// @ioncube.dk cekversi() -> 'Bimasoft 13.11.0'
function resetdatabase()
{
  global $wpdb;

  $servername = DB_HOST;
  $username = DB_USER;
  $password = DB_PASSWORD;
  $dbname = DB_NAME;

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
  }
  include (get_stylesheet_directory() . '/api-18575621/trun.php');
  $conn->multi_query($v11sql);

  include (get_stylesheet_directory() . '/indb.php');
  if (isset($opt_backend) && $opt_backend) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $opt_backend . 'wp-content/themes/unbk/api-18575621/remresetdatabase.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    global $wpdb;
    $wpdb->insert(
      $wpdb->prefix . 'bsfsm_' . 'log',
      array(
        'val' => $server_output
      )
    );

    curl_close($ch);
  }
}

function savefiledb()
{
  if ($_POST['reset-database-?'] == 'YA. HAPUS SEMUA DATA YANG ADA. Termasuk Jawaban dan Nilai Siswa') {
    resetdatabase();
  }

  global $wpdb;

  // SAVE PENTEST

  chmod(get_stylesheet_directory() . '/archives/pentest.html', '0644');
  $myfile = fopen(get_stylesheet_directory() . '/archives/pentest.html', 'w') or die('Unable to open file (0) !');
  chmod(get_stylesheet_directory() . '/archives/pentest.html', '0600');

  $autologin = 0;
  $allmapel = 0;
  $autologin = 0;
  switch ($_POST['pilihan-mapel']) {
    case 'Tampilkan':
      // code...
      break;

    case 'Sembunyikan':
      $autologin = 1;
      break;

    case 'Tampilkan Semua Mapel Walau Bukan Jadwalnya':
      $allmapel = 1;
      break;

    default:
      // code...
      break;
  }

  $lisensi = getLisensi('Tq8p9rMiQ8hpgNxd7EYOABGGUKCrJozAVIZNpUdArLCbsuvrwZ7xOTCW1aNh');

  $txt_json = [
    'pttoken' => 'ASBTTQ',
    'prefix' => $wpdb->prefix,
    'DB_HOST' => DB_HOST,
    'DB_USER' => DB_USER,
    'DB_PASSWORD' => DB_PASSWORD,
    'DB_NAME' => DB_NAME,
    'homeurl' => get_home_url() . '/',
    'examtimer' => $_POST['exam-timer'],
    'bolehdaftar' => ($_POST['siswa-melakukan-pendaftaran-sendiri'] === 'Ya' ? 1 : 0),
    'autotoken' => ($_POST['token-secara-otomatis'] === 'Ya' ? 1 : 0),
    'bolehlogout' => ($_POST['siswa-boleh-logout-sebelum-selesai'] === 'Ya' ? 1 : 0),
    'bolehkumpul' => ($_POST['tidak-wajib-menjawab-semua-soal'] === 'Ya' ? 1 : 0),
    'shownamasekolah' => ($_POST['tampilkan-nama-sekolah'] === 'Ya' ? 1 : 0),
    'cdnid' => (isset($_POST['cdnid']) ? $_POST['cdnid'] : ''),
    'backend' => (isset($_POST['backend']) ? $_POST['backend'] : ''),
    'gdrive_token' => (isset($_POST['gdrivetoken']) ? $_POST['gdrivetoken'] : ''),
    'gdrive_parent' => (isset($_POST['gdriveparent']) ? $_POST['gdriveparent'] : ''),
    'blogdescription' => $_POST['tagline'],
    // "option_page" => "section",
    // "action" => "update",
    // "_wpnonce" => "e3074852a2",
    // "_wp_http_referer" => "/cloud-simulasimandiri/wp-admin/admin.php?page=theme-panel",
    'waktutoken' => ($_POST['masa-aktif-token']),
    'excelkey' => ($_POST['excel-key'] ? $_POST['excel-key'] : ''),
    'timezone' => ($_POST['timezone']),
    'autologin' => $autologin,
    'allmapel' => $allmapel,
    'shownilai' => ($_POST['tampilkan-nilai-siswa-di-akhir-ujian'] === 'Ya' ? 1 : 0),
    'wajibreset' => ($_POST['wajib-reset-ketika-keluar-dari-ujian'] === 'Ya' ? 1 : 0),
    'welcome' => $_POST['pesan-homepage'],
    'examkey' => $_POST['examkey'],
    'useragent' => (isset($_POST['useragent']) ? trim($_POST['useragent']) : (isset($_POST['user-agent']) ? trim($_POST['user-agent']) : '')),
    'pesanbanned' => $_POST['pesan-error-siswa-diblokir'],
    'pesangagallogin' => $_POST['pesan-error-siswa-gagal-login'],
    'minimalsisawaktu' => $_POST['minimal-sisa-waktu-sebelum-boleh-mengumpulkan'],
    'modetimer' => $_POST['metode-penghitungan-waktu'],
    'localstorage' => ($_POST['metode-penyimpanan-jawaban'] === 'Realtime' ? 'realtime' : 'performance'),
    'logo' => $lisensi['logo'],
    'namasekolah' => $lisensi['namasekolah'],
  ];
  if ($_POST['login-menggunakan-account-google'] === 'Ya') {
    $txt_json['logingoogle'] = '1';
  }

  $txt = json_encode($txt_json);

  if (fwrite($myfile, $txt)) {
  } else {
    die('Gagal Menyimpan, error : 104');
  }
  fclose($myfile);

  if (isset($txt_json['backend'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $txt_json['backend'] . 'wp-content/themes/unbk/api-18575621/savepentest.php');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt(
      $ch,
      CURLOPT_POSTFIELDS,
      'fields=' . $txt
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close($ch);
  }

  $myfile = fopen(get_stylesheet_directory() . '/style.css', 'w');
  $txt =
    "/*
\tTheme Name: Bimasoft Simulasi Mandiri UNBK 2021
\tTheme URI: https://bimasoft.web.id;
\tAuthor: Bimasoft 
\tAuthor URI: https://bimasoft.web.id;
    Description: Aplikasi Bimasoft Simulasi Mandiri UNBK 2020. Jika Anda Mendapatkan Aplikasi ini Dari Pihak Lain Selain Bimasoft / Atau Reseller / Help Desk yg tertera di Website Bimasoft. Itu Artinya Anda Telah Ditipu, Dan Mengeluarkan Uang Untuk Membeli Barang Curian. Hati - Hati Terhadap Aplikasi Bajakan. Karena Anda Tidak Akan Mendapatkan Update dan Support Jika Terjadi Masalah. Pastikan hanya membeli aplikasi lewat Jalur Resmi di No. HP / WA. 08234-003-9781 atau Authorized Reseller : Seperti https://test.co.id/
\tVersion: 13.11.0
\tText Domain: unbk
\t*/";

  if (fwrite($myfile, $txt)) {
  } else {
    die('Gagal Menyimpan, error : 105');
  }
  fclose($myfile);

  // SaveDB

  $myfile = fopen(get_stylesheet_directory() . '/indb.php', 'w') or die('Unable to open file (2)!');

  bimasoft_reset_cache();

  $txt = "<?php
\t    //require_once (dirname(__FILE__).'/../../../wp-config.php'); 
\t    \$table_prefix  = \"" . $txt_json['prefix'] . "\";
\t    \$servername = \"" . $txt_json['DB_HOST'] . "\";
\t    \$username = \"" . $txt_json['DB_USER'] . "\";
\t    \$password = \"" . $txt_json['DB_PASSWORD'] . "\";
\t    \$dbname = \"" . $txt_json['DB_NAME'] . "\";
\t    set_error_handler(function() { 
\t    \t?>
\t    \t\t<script>
\t    \t\t\talert ('Gagal Terkoneksi ke database. Silakan Save, Pengaturan Test dan Reset Cache');
\t    \t\t</script>
\t    \t<?php
\t    });
\t    \$conn = new mysqli(\$servername, \$username, \$password, \$dbname);
\t    restore_error_handler();\t    
\t    if (\$conn->connect_error) {
\t    } else {
\t\t\t\$conn->set_charset('utf8'); 
\t\t\t
\t\t\t\$absolute_url\t\t= \"" . $txt_json['homeurl'] . "/\";
\t\t\t\$home_url\t\t\t= \"" . $txt_json['homeurl'] . "/\";

    \t\t\$opt_examtimer \t= \"" . (isset($txt_json['examtimer']) ? $txt_json['examtimer'] : '') . "\";
    \t\t\$opt_waktutoken \t= \"" . (isset($txt_json['waktutoken']) ? $txt_json['waktutoken'] : '') . "\";
    \t\t\$opt_bolehlogout \t= \"" . (isset($txt_json['bolehlogout']) ? $txt_json['bolehlogout'] : '') . "\";
    \t\t\$opt_excelkey \t\t= \"" . (isset($txt_json['excelkey']) ? $txt_json['excelkey'] : '') . "\";
    \t\t\$opt_autologin \t\t= \"" . (isset($txt_json['autologin']) ? $txt_json['autologin'] : '') . "\";
    \t\t\$opt_shownilai \t\t= \"" . (isset($txt_json['shownilai']) ? $txt_json['shownilai'] : '') . "\";
    \t\t\$opt_wajibreset \t\t= \"" . (isset($txt_json['wajibreset']) ? $txt_json['wajibreset'] : '') . "\";
    \t\t\$opt_bolehdaftar \t\t= \"" . (isset($txt_json['bolehdaftar']) ? $txt_json['bolehdaftar'] : '') . "\";
    \t\t\$opt_logingoogle \t\t= \"" . (isset($txt_json['logingoogle']) ? $txt_json['logingoogle'] : '') . "\";
    \t\t\$opt_autotoken \t\t= \"" . (isset($txt_json['autotoken']) ? $txt_json['autotoken'] : '') . "\";
    \t\t\$opt_top10 \t\t= \"" . (isset($txt_json['top10']) ? $txt_json['top10'] : '') . "\";
    \t\t\$opt_isonline \t\t= \"" . (isset($txt_json['isonline']) ? $txt_json['isonline'] : '') . "\";
    \t\t\$opt_allmapel \t\t= \"" . (isset($txt_json['allmapel']) ? $txt_json['allmapel'] : '') . "\";
    \t\t\$opt_iframe \t\t= \"" . (isset($txt_json['iframe']) ? $txt_json['iframe'] : '') . "\";
    \t\t\$opt_bolehkumpul \t\t= \"" . (isset($txt_json['bolehkumpul']) ? $txt_json['bolehkumpul'] : '') . "\";
    \t\t\$opt_shownamasekolah \t\t= \"" . (isset($txt_json['shownamasekolah']) ? $txt_json['shownamasekolah'] : '') . "\";
    \t\t\$opt_backend \t\t= \"" . (isset($txt_json['backend']) ? $txt_json['backend'] : '') . "\";
    \t\t\$opt_gdrive_token \t\t= \"" . (isset($txt_json['gdrive_token']) ? $txt_json['gdrive_token'] : '') . "\";
    \t\t\$opt_gdrive_parent \t\t= \"" . (isset($txt_json['gdrive_parent']) ? $txt_json['gdrive_parent'] : '') . "\";
    \t\t\$opt_blogdescription \t\t= \"" . (isset($txt_json['blogdescription']) ? $txt_json['blogdescription'] : '') . "\";

    \t\t\$opt_welcome \t\t= \"" . (isset($txt_json['welcome']) ? $txt_json['welcome'] : '') . "\";

    \t\t\$opt_waktutelat \t\t= \"" . (isset($txt_json['waktutelat']) ? $txt_json['waktutelat'] : '') . "\";

    \t\t\$opt_localstorage \t\t= \"" . (isset($txt_json['localstorage']) ? $txt_json['localstorage'] : '') . "\";
    \t\t\$opt_modetimer \t\t= \"" . (isset($txt_json['modetimer']) ? $txt_json['modetimer'] : '') . "\";
    \t\t\$opt_modemapel \t\t= \"" . (isset($txt_json['modemapel']) ? $txt_json['modemapel'] : '') . "\";

    \t\t\$opt_pesanbanned \t\t= \"" . (isset($txt_json['pesanbanned']) ? $txt_json['pesanbanned'] : '') . "\";
    \t\t\$opt_minimalsisawaktu \t\t= \"" . (isset($txt_json['minimalsisawaktu']) ? $txt_json['minimalsisawaktu'] : '') . "\";
    \t\t\$opt_examkey \t\t    = \"" . (isset($txt_json['examkey']) ? $txt_json['examkey'] : '') . "\";
    \t\t\$opt_useragent \t\t    = \"" . (isset($txt_json['useragent']) ? $txt_json['useragent'] : '') . "\";
\t\t\t\$opt_timezone \t\t    = \"" . (isset($txt_json['timezone']) ? $txt_json['timezone'] : '') . "\";

    \t\tdate_default_timezone_set(\"" . (isset($txt_json['timezone']) ? $txt_json['timezone'] : '') . "\");
\t    }

\t";

  if (fwrite($myfile, $txt)) {
  };
  fclose($myfile);
}

function savePengaturanTest()
{
  include (get_stylesheet_directory() . '/indb.php');

  $menu_pengaturan_test = new Bimasoft_Page(
    'Pengaturan Test',
    'dashicons-analytics',
    '80',
    [],
    NULL,
    function () {
      savefiledb();
    }
  );

  $menu_pengaturan_test->add_option('Pengaturan Token', '', 'title');
  $menu_pengaturan_test->add_option('Masa Aktif Token', 'Dalam Menit. Contoh : isi <b>15</b> untuk masa aktif token 15 menit', 'text');
  $menu_pengaturan_test->add_option('Token Secara Otomatis', '', 'checkbox');
  $menu_pengaturan_test->add_option('Exam Timer', 'Waktu jeda yang diperbolehkan siswa untuk keluar dari aplikasi. Dalam detik, isi di atas 0 (contoh : 2). Tidak diisi / kosong artinya siswa boleh keluar aplikasi tanpa batas.', 'text');
  $menu_pengaturan_test->add_option('', '', 'hr');
  // --------------------------------------------------
  $menu_pengaturan_test->add_option('Pengaturan Key', '', 'title');
  $menu_pengaturan_test->add_option('Excel Key', 'Samakan dengan yg ada di Template Excel (Excel Key)', 'text');
  $menu_pengaturan_test->add_option('Examkey', "Keterangan Examkey : <a href='https://wiki.bimasoft.web.id/index.php/2018/11/17/exam-key/'>Wiki Bimasoft</a>", 'text');
  $menu_pengaturan_test->add_option('Useragent', 'Hanya siswa dengan browser yang memiliki User-Agent ini yang diperbolehkan login. Kosongkan jika tidak dibatasi.', 'text');
  $menu_pengaturan_test->add_option('Timezone', '', 'select', ['Asia/Jakarta', 'Asia/Makassar', 'Asia/Jayapura']);
  $menu_pengaturan_test->add_option('Minimal Sisa Waktu Sebelum Boleh Mengumpulkan', 'Dalam Menit. Contoh : isi 10, jika ingin siswa hanya boleh mengumpulkan ketika sisa waktunya 10 menit.', 'text');
  $menu_pengaturan_test->add_option('', '', 'hr');
  // --------------------------------------------------
  $menu_pengaturan_test->add_option('Pengaturan Tampilan Homepage', '', 'title');
  $menu_pengaturan_test->add_option('Tampilkan Nama Sekolah', 'Pilih Ya, jika ingin menampilkan Nama dan Logo Sekolah. Tidak, jika hanya ingin Logo', 'checkbox');
  $menu_pengaturan_test->add_option('Tagline', 'Tulisan di bawah nama sekolah', 'text');
  $menu_pengaturan_test->add_option('Pesan Homepage', '', 'textarea');
  $menu_pengaturan_test->add_option('Pesan Error Siswa Gagal Login', '', 'textarea');
  $menu_pengaturan_test->add_option('Pesan Error Siswa Diblokir', '', 'textarea');
  $menu_pengaturan_test->add_option('', '', 'hr');
  // --------------------------------------------------
  $menu_pengaturan_test->add_option('Pengaturan Mapel', '', 'title');
  $menu_pengaturan_test->add_option('Pilihan Mapel', 'WARNING !!! : Tampilkan semua mapel akan membuat semua test bisa dikerjakan tanpa harus mengikuti jadwal', 'select', ['Tampilkan', 'Sembunyikan', 'Tampilkan Semua Mapel Walau Bukan Jadwalnya']);
  $menu_pengaturan_test->add_option('catatan', 'catatan', 'text');
  $menu_pengaturan_test->add_option('Metode Penghitungan Waktu', 'Contoh Kasus : Test Mulai Jam 08.00 dengan Alokasi 120 menit. <br/>Dynamic : Siswa bisa login di atas jam 08.00, dan akan mendapat alokasi waktu 2 jam. Jadi siswa bisa saja mulai jam 10.00 dan selesia jam 12.00. <br/> Classic : Siswa bisa login di atas jam 08.00 tapi di bawah 10.00. Siswa yg login di atas jam 10.00 langsung logout otomatis', 'select', ['Dynamic', 'Classic']);
  $menu_pengaturan_test->add_option('Metode Penyimpanan Jawaban', 'Realtime : Setiap siswa menjawab langsung di kirim ke server.<br/>Performance : Jawaban siswa dikirim hanya ketika siswa selesai. Jadi pastikan status siswa sudah selesai sebelum siswa meninggalkan ruangan. Beban ke server lebih ringan.<br/>Catatan : Tidak berpengaruh ke Pengguna Cloud Server Bimasoft', 'select', ['Realtime', 'Performance']);
  $menu_pengaturan_test->add_option('', '', 'hr');
  // --------------------------------------------------
  $menu_pengaturan_test->add_option('Pengaturan Lain - Lain', '', 'title');
  $menu_pengaturan_test->add_option('Tampilkan Nilai Siswa di Akhir Ujian', '', 'checkbox');
  $menu_pengaturan_test->add_option('Wajib Reset Ketika Keluar Dari Ujian', 'Aktifkan jika ingin mencegah siswa login menggunakan lebih dari 1 device', 'checkbox');
  $menu_pengaturan_test->add_option('Siswa Boleh Logout Sebelum Selesai', '', 'checkbox');
  $menu_pengaturan_test->add_option('Siswa Melakukan Pendaftaran Sendiri', '', 'checkbox');
  $menu_pengaturan_test->add_option('Tidak Wajib Menjawab Semua Soal', '', 'checkbox');
  $menu_pengaturan_test->add_option('Login Menggunakan Account Google', 'Khusus pengguna Cloud Bimasoft. Laporkan nama domain untuk menggunakan Feature ini', 'checkbox');
  // $menu_pengaturan_test->add_option("Wajib Exam Client Android", "Ujian Hanya bisa diakses menggunakan Bimasoft exam client. Pilih 'Tidak' jika client campuran antar HP dan PC / Laptop", "checkbox");
  $menu_pengaturan_test->add_option('', '', 'hr');
  // --------------------------------------------------
  $menu_pengaturan_test->add_option('RESET DATABASE', 'WARNING !!! : Setelah Reset Database, Jawaban akan hilang dan tidak bisa kembali lagi. Setelah Reset Database, lakukan save sekali lagi tanpa reset database', 'title');
  $menu_pengaturan_test->add_option('Reset Database ?', '', 'select', ['Tidak', 'YA. HAPUS SEMUA DATA YANG ADA. Termasuk Jawaban dan Nilai Siswa'], 'Tidak');
  $menu_pengaturan_test->add_option('', '', 'hr');
  // --------------------------------------------------
  $menu_pengaturan_test->add_option('token', '', 'hidden', []);

  if (get_option('backend')) {
    $menu_pengaturan_test->add_option('cdnid', '', 'hidden', [], get_option('cdn_ID'));
    $menu_pengaturan_test->add_option('gdrivetoken', '', 'hidden', [], get_option('gdrivetoken'));
    $menu_pengaturan_test->add_option('gdriveparent', '', 'hidden', [], get_option('gdriveparent'));
    $menu_pengaturan_test->add_option('backend', '', 'hidden');
  }

  $menu_pengaturan_test->generate();
}

savePengaturanTest();
