<?php

/*
 * ===============
 * Admin Page
 * ===============
 */

function bimasoft_database_slug_content()
{
  require_once (__DIR__ . '/bimasoft-sql.php');
  include (__DIR__ . '/indb.php');

  echo ('<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/dt/datatables.min.css"/>');
  echo ('<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/dt/datatables.min.js"></script>');

  $bimasql = new Bimasoft\SQL(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  global $wpdb;
  $tableoptions = $wpdb->prefix . 'bsfsm_options';

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "<div id='dataWrapper'>";
  if (isset($opt_backend) && $opt_backend) {
    echo 'Loading ...';
  } else {
    echo ($bimasql->render("SELECT * FROM $tableoptions", $tableoptions));
  }
  echo '</div>';
  echo "<input type='button' value='Delete' class='deleteBtn' />";
  echo '</div>';
  echo "
    <script>
        jQuery('document').ready(function(\$){
            \$('.deleteBtn').click(function(){
                \$('.rowcheck:checked').each(function(){
                    \$(this).closest('tr').find('.rowdelete').click();
                });                
            })
        })
    </script>
    ";

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo '<p><b>TOKEN :</b></p>';
  echo "<div id='token'>";
  require_once (__DIR__ . '/generatetoken.php');
  echo '</div>';
  echo "<div id='token2'>";
  echo '</div>';
  echo '</div>';
}

function bimasoft_database_hasil_slug_content()
{
  // Sub Menu
  require_once (__DIR__ . '/bimasoft-sql.php');
  include (__DIR__ . '/indb.php');

  $mapel = (isset($_GET['mapel'])) ? $_GET['mapel'] : '';

  echo ('<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/dt/datatables.min.css"/>');
  echo ('<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/dt/datatables.min.js"></script>');

  $bimasql = new Bimasoft\SQL(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  global $wpdb;
  $tablehasil = $wpdb->prefix . 'bsfsm_hasil';

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "<div id='dataWrapper'>";
  if (isset($opt_backend) && $opt_backend) {
    echo 'Loading ...';
  } else {
    echo ($bimasql->render("SELECT indexkey,stamp,starttime FROM $tablehasil", $tablehasil));
  }
  echo '</div>';
  echo '</div>';

  if (isset($opt_backend) && $opt_backend) {
    echo "
        <script>
            jQuery('document').ready(function(\$){
                \$('#dataWrapper').load('{$opt_backend}wp-content/themes/unbk/api-18575621/getdatatestsiswa.php?backend=$opt_backend&mapel=$mapel');
            })
        </script>
        ";
  }

  echo "<div style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo '
    <p>Keterangan :</p>
    <p>- Menghapus siswa <b>TIDAK AKAN</b> menghapus jawaban dengan username tersebut. Menghapus siswa, akan mereset waktu, urutan soal, dan siswa akan dianggap belum mengerjakan test</p>
    ';
  echo '</div>';
}

function bimasoft_database_reset_siswa_slug_content()
{
  // Sub Menu
  require_once (__DIR__ . '/bimasoft-sql.php');
  include (__DIR__ . '/indb.php');

  $mapel = (isset($_GET['mapel'])) ? $_GET['mapel'] : '';

  echo ('<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/dt/datatables.min.css"/>');
  echo ('<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/dt/datatables.min.js"></script>');

  $bimasql = new Bimasoft\SQL(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  global $wpdb;
  $tablehasil = $wpdb->prefix . 'bsfsm_siswa';

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "<div id='dataWrapper'>";
  if (isset($opt_backend) && $opt_backend) {
    echo 'Loading ...';
  } else {
    echo ($bimasql->render("SELECT * FROM $tablehasil", $tablehasil));
  }
  echo '</div>';
  echo "<input type='button' value='Reset Selesai' class='deleteBtn' />";
  echo "<input type='button' value='Reset Login' class='resetBtn' />";
  echo "<input type='button' value='Force Selesai' class='selesaiBtn' />";
  echo '</div>';
  echo "
    <script>
        jQuery('document').ready(function(\$){
            \$('.deleteBtn').click(function(){
                \$('.rowcheck:checked').each(function(){
                    \$(this).closest('tr').find('td').eq(11).text('null')
                    \$(this).closest('tr').find('.rowsave').click();
                });                
            })
            \$('.resetBtn').click(function(){
                \$('.rowcheck:checked').each(function(){
                    \$(this).closest('tr').find('td').eq(11).text('0')
                    \$(this).closest('tr').find('.rowsave').click();
                });                
            })
            \$('.selesaiBtn').click(function(){
                \$('.rowcheck:checked').each(function(){
                    \$(this).closest('tr').find('td').eq(11).text('1')
                    \$(this).closest('tr').find('.rowsave').click();
                });                
            })
        })
    </script>
    ";

  if (isset($opt_backend) && $opt_backend) {
    echo "
        <script>
            jQuery('document').ready(function(\$){
                \$('#dataWrapper').load('{$opt_backend}wp-content/themes/unbk/api-18575621/getdatasiswa.php?backend=$opt_backend&mapel=$mapel');
            })
        </script>
        ";
  }

  echo "<div style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo '
    <p>Status Finish / Reset Login :</p>
    <p>0 : Logout</p>
    <p>1 : Selesai</p>
    <p>2 : Mengerjakan</p>
    ';
  echo '</div>';
}

function bimasoft_database_add_admin_page()
{
  $page_title = 'Database Test';
  $menu_title = 'Database Test';
  $menu_slug = 'bimasoft_database_slug';
  $callback = 'bimasoft_database_slug_content';
  $icon = 'dashicons-list-view';
  $position = 110;

  /*
   * 2	- Dashboard
   * 4	- Separator
   * 5	- Posts
   * 10	- Media
   * 15 	- Links
   * 20	- Pages
   * 25	- Comments
   * 59	- Separator
   * 60	- Appearance
   * 65  - Plugins
   * 70	- Users
   * 75	- Tools
   * 80	- Settings
   * 99	- Separator
   */

  // Top-Level Menu: Siswa / Data Siswa
  $siswa_page_title = 'Data Siswa';
  $siswa_menu_title = 'Data Siswa';
  $siswa_menu_slug = 'bimasoft_database_reset_siswa_slug';
  $siswa_callback = 'bimasoft_database_reset_siswa_slug_content';
  $siswa_icon = 'dashicons-groups';
  $siswa_position = 108;

  add_menu_page($siswa_page_title, $siswa_menu_title, 'manage_options', $siswa_menu_slug, $siswa_callback, $siswa_icon, $siswa_position);
  add_submenu_page($siswa_menu_slug, 'Data Siswa', 'Data Siswa', 'manage_options', $siswa_menu_slug, $siswa_callback);
  add_submenu_page($siswa_menu_slug, 'Tambah Siswa', 'Tambah Siswa', 'manage_options', 'bimasoft_database_tambah_siswa_slug', 'bimasoft_database_tambah_siswa_slug_content');

  // Top-Level Menu: Database Test
  add_menu_page($page_title, $menu_title, 'manage_options', $menu_slug, $callback, $icon, $position);

  // Sub-Pages for Database Test
  add_submenu_page('bimasoft_database_slug', 'Database Test', 'Database Test', 'manage_options', 'bimasoft_database_slug', 'bimasoft_database_slug_content');
  add_submenu_page('bimasoft_database_slug', 'Tambah Test', 'Tambah Test', 'manage_options', 'bimasoft_database_tambah_test_slug', 'bimasoft_database_tambah_test_slug_content');
  add_submenu_page('bimasoft_database_slug', 'Tambah Kunci', 'Tambah Kunci', 'manage_options', 'bimasoft_database_tambah_kunci_slug', 'bimasoft_database_tambah_kunci_slug_content');
  add_submenu_page('bimasoft_database_slug', 'Data Test Siswa', 'Data Test Siswa', 'manage_options', 'bimasoft_database_hasil_slug', 'bimasoft_database_hasil_slug_content');
}

function bimasoft_database_tambah_siswa_slug_content()
{
  require_once (__DIR__ . '/bimasoft-sql.php');
  include (__DIR__ . '/indb.php');

  global $wpdb;
  $tableoptions = $wpdb->prefix . 'bsfsm_options';

  $today = date('Y-m-d');
  if ($opt_allmapel == '1') {
    $mapel_result = $conn->query("SELECT kode FROM {$tableoptions} ORDER BY kode ASC");
  } else {
    $mapel_result = $conn->query("SELECT kode FROM {$tableoptions} WHERE tanggal = '{$today}' ORDER BY kode ASC");
  }

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo '<h2>Tambah Siswa</h2>';

  echo "<form id='tambahSiswaForm'>";
  echo "<table style='width:100%;max-width:600px;margin:0 auto'>";
  echo "<tr><td style='padding:5px;text-align:left'>Mapel:</td><td style='padding:5px'>";
  echo "<select id='mapelSelect' name='mapel' style='width:100%;padding:5px'>";
  echo "<option value=''>-- Pilih Mapel --</option>";
  while ($row = $mapel_result->fetch_assoc()) {
    echo "<option value='" . strtoupper($row['kode']) . "'>" . strtoupper($row['kode']) . '</option>';
  }
  echo '</select>';
  echo '</td></tr>';

  echo "<input type='hidden' id='examKey' name='key' value='{$opt_excelkey}'>";
  echo "<tr><td style='padding:5px;text-align:left;vertical-align:top'>Data (Tab Delimited):</td><td style='padding:5px'>";
  echo "<textarea id='siswaData' name='siswaData' rows='10' style='width:100%;padding:5px' placeholder='Paste data siswa dari excel ke sini'></textarea>";
  echo "<small style='color:#666'>Format: NIS | USER | NAMA | PASS | NIK | NIK2 | SERVER | SESI</small>";
  echo '</td></tr>';

  echo "<tr><td colspan='2' style='padding:10px;text-align:center'>";
  echo "<a href='" . get_stylesheet_directory_uri() . "/sample.xlsx' download='sample.xlsx' id='downloadSampleBtn' class='button' style='padding:6px 15px;margin-right:10px;text-decoration:none;display:inline-block'>Download sample.xlsx</a>";
  echo "<button type='submit' id='uploadBtn' class='button button-primary' style='padding:6px 20px'>Upload</button>";
  echo '</td></tr>';
  echo '</table>';
  echo '</form>';

  echo "<div id='previewResult' style='margin-top:20px;padding:10px;background:#f5f5f5;border:1px solid #ddd;display:none'>";
  echo '<h3>Preview</h3>';
  echo "<p><b>Jumlah Siswa:</b> <span id='jumlahSiswa'>0</span></p>";
  echo "<div id='namaList' style='max-height:200px;overflow-y:auto;border:1px solid #ccc;padding:10px;background:#fff'></div>";
  echo '</div>';

  echo "<div id='uploadResult' style='margin-top:20px;padding:10px;display:none'></div>";
  echo '</div>';

  $backend = isset($opt_backend) && $opt_backend
    ? $opt_backend
    : get_stylesheet_directory_uri();

  echo "
    <script>
    jQuery('document').ready(function(\$){
        \$('#siswaData').on('input paste', function(){
            var data = \$(this).val().trim();
            if(!data) {
                return;
            }
            
            var lines = data.split('\\n');
            var namaList = [];
            var count = 0;
            
            for(var i=0;i<lines.length;i++) {
                var cols = lines[i].split('\\t');
                if(cols.length >= 3 && cols[0].trim() != '') {
                    count++;
                    if(cols[2] && cols[2].trim()) {
                        namaList.push(cols[2].trim());
                    }
                }
            }
            
            \$('#jumlahSiswa').text(count);
            \$('#namaList').html('<ul style=\"margin:0;padding-left:20px\">' + namaList.map(function(n){return '<li>'+n+'</li>'}).join('') + '</ul>');
            \$('#previewResult').show();
        });
        
        \$('#tambahSiswaForm').submit(function(e){
            e.preventDefault();
            
            var mapel = \$('#mapelSelect').val();
            if(!mapel) {
                alert('Mohon pilih mapel');
                return;
            }
            
            var data = \$('#siswaData').val().trim();
            if(!data) {
                alert('Mohon masukkan data siswa');
                return;
            }
            
            var lines = data.split('\\n');
            var postData = 'count=' + lines.length + '&mapel-1=' + mapel + '&key=' + \$('#examKey').val();
            
            for(var i=0;i<lines.length;i++) {
                var cols = lines[i].split('\\t');
                if(cols.length >= 3 && cols[0].trim() != '') {
                    var idx = i + 1;
                    postData += '&nis-' + idx + '=' + (cols[0] ? cols[0].trim() : '');
                    postData += '&user-' + idx + '=' + (cols[1] ? cols[1].trim().toUpperCase() : '');
                    postData += '&nama-' + idx + '=' + (cols[2] ? cols[2].trim() : '');
                    postData += '&pass-' + idx + '=' + (cols[3] ? cols[3].trim() : '');
                    postData += '&nik-' + idx + '=' + (cols[4] ? cols[4].trim() : '');
                    postData += '&nik2-' + idx + '=' + (cols[5] ? cols[5].trim() : '');
                    postData += '&server-' + idx + '=' + (cols[6] ? cols[6].trim() : '');
                    postData += '&sesi-' + idx + '=' + (cols[7] ? cols[7].trim() : '');
                    postData += '&mapel-' + idx + '=' + mapel;
                }
            }
            
            \$('#uploadBtn').prop('disabled',true).text('Mengupload...');
            
            var baseUrl = '$backend';
            \$.ajax({
                url: baseUrl + '/api-18575621/uploadsiswa.php',
                type: 'POST',
                data: postData,
                success: function(response) {
                    \$('#uploadResult').show();
                    if(response.trim() == 'OK') {
                        \$('#uploadResult').html('<div style=\"padding:10px;background:#d4edda;color:#155724;border:1px solid #c3e6cb\">Data Siswa Berhasil di Simpan</div>');
                        \$('#siswaData').val('');
                        \$('#previewResult').hide();
                    } else if(response.trim() == 'KEY DITOLAK') {
                        \$('#uploadResult').html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">KEY DITOLAK</div>');
                    } else {
                        \$('#uploadResult').html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">GAGAL TERHUBUNG KE SERVER: ' + response + '</div>');
                    }
                    \$('#uploadBtn').prop('disabled',false).text('Upload');
                },
                error: function() {
                    \$('#uploadResult').show().html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">GAGAL TERHUBUNG KE SERVER</div>');
                    \$('#uploadBtn').prop('disabled',false).text('Upload');
                }
            });
        });
    });
    </script>
    ";
}

function bimasoft_ajax_save_test()
{
  require_once (__DIR__ . '/bimasoft-sql.php');
  include (__DIR__ . '/indb.php');
  global $wpdb;
  $tableoptions = $wpdb->prefix . 'bsfsm_options';

  $kode = strtoupper(trim($_POST['kode'] ?? ''));
  $nama = trim($_POST['nama'] ?? '');
  $status = trim($_POST['status'] ?? '');
  $subtest = trim($_POST['subtest'] ?? '');
  $tanggal = trim($_POST['tanggal'] ?? date('Y-m-d'));
  $waktu = trim($_POST['waktu'] ?? '08:00');
  $alokasi = trim($_POST['alokasi'] ?? '90');
  $shuffle = intval($_POST['shuffle'] ?? 0);
  $shuffle2 = intval($_POST['shuffle2'] ?? 0);
  $jumlahsoal = intval($_POST['jumlahsoal'] ?? 40);
  $dikerjakan = intval($_POST['dikerjakan'] ?? 40);

  if (empty($kode)) {
    echo "Kode Test tidak boleh kosong";
    wp_die();
  }

  $stmt = $conn->prepare("INSERT INTO `{$tableoptions}` 
    (`kode`, `nama`, `status`, `subtest`, `tanggal`, `waktu`, `alokasi`, `shuffle`, `shuffle2`, `jumlahsoal`, `dikerjakan`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    `nama` = VALUES(`nama`),
    `status` = VALUES(`status`),
    `subtest` = VALUES(`subtest`),
    `tanggal` = VALUES(`tanggal`),
    `waktu` = VALUES(`waktu`),
    `alokasi` = VALUES(`alokasi`),
    `shuffle` = VALUES(`shuffle`),
    `shuffle2` = VALUES(`shuffle2`),
    `jumlahsoal` = VALUES(`jumlahsoal`),
    `dikerjakan` = VALUES(`dikerjakan`)");

  $stmt->bind_param("sssssssiiii", $kode, $nama, $status, $subtest, $tanggal, $waktu, $alokasi, $shuffle, $shuffle2, $jumlahsoal, $dikerjakan);
  if ($stmt->execute()) {
    $stmt->close();
    echo "OK";
  } else {
    echo "Gagal menyimpan test: " . $stmt->error;
    $stmt->close();
  }
  wp_die();
}
add_action('wp_ajax_bimasoft_save_test', 'bimasoft_ajax_save_test');

function bimasoft_ajax_save_kunci()
{
  require_once (__DIR__ . '/bimasoft-sql.php');
  include (__DIR__ . '/indb.php');
  global $wpdb;
  $tablekuncipg = $wpdb->prefix . 'bsfsm_kuncipg';
  $tablekunciessay = $wpdb->prefix . 'bsfsm_kunciessay';
  $tablebobot = $wpdb->prefix . 'bsfsm_bobot';

  $kode = strtoupper(trim($_POST['kode'] ?? ''));
  if (empty($kode)) {
    echo "Kode Test harus dipilih atau diisi";
    wp_die();
  }

  $items = [];
  $batch = trim($_POST['kunciBatch'] ?? '');
  if (!empty($batch)) {
    $lines = explode("\n", $batch);
    foreach ($lines as $line) {
      $line = trim($line, "\r\n");
      if ($line === '') continue;
      // Strictly use TAB as delimiter
      $cols = explode("\t", $line);
      if (count($cols) >= 2) {
        $no = intval(trim($cols[0]));
        $kunci = trim($cols[1]);
        if ($no > 0 && $kunci !== '') {
          $b = (isset($cols[2]) && is_numeric(trim($cols[2]))) ? floatval(trim($cols[2])) : 1.0;
          $items[] = [
            'no' => $no,
            'kunci' => $kunci,
            'bobot' => $b
          ];
        }
      }
    }
  }

  if (empty($items)) {
    echo "Mohon masukkan kunci jawaban dengan pemisah TAB (Nomor\\tKunci\\tBobot)";
    wp_die();
  }

  foreach ($items as $item) {
    $indexkey = "{$kode}-{$item['no']}";
    $kunciVal = $item['kunci'];
    $bobotVal = floatval($item['bobot']);

    if (strlen($kunciVal) > 1) {
      $stmt = $conn->prepare("INSERT INTO `{$tablekunciessay}` (`indexkey`, `item`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `item` = VALUES(`item`)");
      $stmt->bind_param("ss", $indexkey, $kunciVal);
      $stmt->execute();
      $stmt->close();
    } else {
      $stmt = $conn->prepare("INSERT INTO `{$tablekuncipg}` (`indexkey`, `item`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `item` = VALUES(`item`)");
      $stmt->bind_param("ss", $indexkey, $kunciVal);
      $stmt->execute();
      $stmt->close();
    }

    $stmtB = $conn->prepare("INSERT INTO `{$tablebobot}` (`indexkey`, `item`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `item` = VALUES(`item`)");
    $stmtB->bind_param("sd", $indexkey, $bobotVal);
    $stmtB->execute();
    $stmtB->close();
  }

  echo "OK";
  wp_die();
}
add_action('wp_ajax_bimasoft_save_kunci', 'bimasoft_ajax_save_kunci');

function bimasoft_database_tambah_test_slug_content()
{
  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo '<h2>Tambah Test</h2>';

  echo "<form id='tambahTestForm' method='POST'>";
  echo "<table style='width:100%;max-width:600px;margin:0 auto'>";
  echo "<tr><td style='padding:5px;text-align:left'>Kode Test:</td><td style='padding:5px'>";
  echo "<input type='text' id='testKode' name='kode' required placeholder='Contoh: MATEMATIKA' style='width:100%;padding:5px;text-transform:uppercase'>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Nama Test:</td><td style='padding:5px'>";
  echo "<input type='text' id='testNama' name='nama' required placeholder='Contoh: Matematika' style='width:100%;padding:5px'>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Status / Keterangan:</td><td style='padding:5px'>";
  echo "<input type='text' id='testStatus' name='status' placeholder='Contoh: Matematika Kelas 9' style='width:100%;padding:5px'>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Subtest:</td><td style='padding:5px'>";
  echo "<input type='text' id='testSubtest' name='subtest' placeholder='Contoh: Matematika Kelas 9' style='width:100%;padding:5px'>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Tanggal:</td><td style='padding:5px'>";
  echo "<input type='date' id='testTanggal' name='tanggal' value='" . date('Y-m-d') . "' style='width:100%;padding:5px'>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Waktu Mulai:</td><td style='padding:5px'>";
  echo "<input type='text' id='testWaktu' name='waktu' value='08:00' placeholder='08:00' style='width:100%;padding:5px'>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Alokasi Waktu (Menit):</td><td style='padding:5px'>";
  echo "<input type='number' id='testAlokasi' name='alokasi' value='90' style='width:100%;padding:5px'>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Acak Soal:</td><td style='padding:5px'>";
  echo "<select id='testShuffle' name='shuffle' style='width:100%;padding:5px'><option value='1' selected>Ya</option><option value='0'>Tidak</option></select>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Acak Opsi Jawaban:</td><td style='padding:5px'>";
  echo "<select id='testShuffle2' name='shuffle2' style='width:100%;padding:5px'><option value='1' selected>Ya</option><option value='0'>Tidak</option></select>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Jumlah Soal:</td><td style='padding:5px'>";
  echo "<input type='number' id='testJumlahSoal' name='jumlahsoal' value='40' style='width:100%;padding:5px'>";
  echo "</td></tr>";
  echo "<tr><td style='padding:5px;text-align:left'>Jumlah Dikerjakan:</td><td style='padding:5px'>";
  echo "<input type='number' id='testDikerjakan' name='dikerjakan' value='40' style='width:100%;padding:5px'>";
  echo "</td></tr>";
  echo "<tr><td colspan='2' style='padding:10px;text-align:center'>";
  echo "<button type='submit' id='simpanTestBtn' class='button button-primary' style='padding:6px 20px'>Simpan Test</button>";
  echo "</td></tr>";
  echo "</table>";
  echo "</form>";

  echo "<div id='testResult' style='margin-top:20px;padding:10px;display:none'></div>";
  echo "</div>";

  echo "
  <script>
  jQuery('document').ready(function(\$){
    \$('#tambahTestForm').submit(function(e){
      e.preventDefault();
      var btn = \$('#simpanTestBtn');
      btn.prop('disabled', true).text('Menyimpan...');
      var endpoint = (typeof ajaxurl !== 'undefined') ? ajaxurl : 'admin-ajax.php';
      \$.ajax({
        url: endpoint,
        type: 'POST',
        data: \$(this).serialize() + '&action=bimasoft_save_test',
        success: function(res) {
          \$('#testResult').show();
          if (res.trim() === 'OK') {
            \$('#testResult').html('<div style=\"padding:10px;background:#d4edda;color:#155724;border:1px solid #c3e6cb\">Data Test Berhasil di Simpan</div>');
            \$('#tambahTestForm')[0].reset();
          } else {
            \$('#testResult').html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">' + res + '</div>');
          }
          btn.prop('disabled', false).text('Simpan Test');
        },
        error: function(err) {
          \$('#testResult').show().html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">GAGAL TERHUBUNG KE SERVER</div>');
          btn.prop('disabled', false).text('Simpan Test');
        }
      });
    });
  });
  </script>
  ";
}

function bimasoft_database_tambah_kunci_slug_content()
{
  require_once (__DIR__ . '/bimasoft-sql.php');
  include (__DIR__ . '/indb.php');
  global $wpdb;
  $tableoptions = $wpdb->prefix . 'bsfsm_options';

  $test_result = $conn->query("SELECT kode, nama FROM `{$tableoptions}` ORDER BY kode ASC");

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo '<h2>Tambah Kunci</h2>';

  echo "<form id='tambahKunciForm' method='POST'>";
  echo "<table style='width:100%;max-width:600px;margin:0 auto'>";
  echo "<tr><td style='padding:5px;text-align:left'>Kode Test / Mapel:</td><td style='padding:5px'>";
  echo "<select id='kunciKodeSelect' name='kode' style='width:100%;padding:5px'>";
  echo "<option value=''>-- Pilih Mapel --</option>";
  if ($test_result) {
    while ($row = $test_result->fetch_assoc()) {
      echo "<option value='" . strtoupper($row['kode']) . "'>" . strtoupper($row['kode']) . " - " . htmlspecialchars($row['nama']) . "</option>";
    }
  }
  echo "</select>";
  echo "</td></tr>";

  echo "<tr><td style='padding:5px;text-align:left;vertical-align:top'>Data Kunci (Tab Delimited):</td><td style='padding:5px'>";
  echo "<textarea id='kunciBatch' name='kunciBatch' rows='10' style='width:100%;padding:5px' placeholder='Paste data kunci dari excel ke sini&#10;Contoh:&#10;1&#9;A&#9;1&#10;2&#9;B&#9;1&#10;3&#9;C&#9;1'></textarea>";
  echo "<small style='color:#666'>Format: Nomor [TAB] Kunci [TAB] Bobot (opsional, default 1). Gunakan TAB sebagai pemisah antar kolom (copy langsung dari Excel).</small>";
  echo "</td></tr>";

  echo "<tr><td colspan='2' style='padding:15px;text-align:center'>";
  echo "<a href='" . get_stylesheet_directory_uri() . "/sample_kunci.xlsx' download='sample.xlsx' id='downloadSampleKunciBtn' class='button' style='padding:6px 15px;margin-right:10px;text-decoration:none;display:inline-block'>Download sample.xlsx</a>";
  echo "<button type='submit' id='simpanKunciBtn' class='button button-primary' style='padding:6px 20px'>Simpan Kunci</button>";
  echo "</td></tr>";
  echo "</table>";
  echo "</form>";

  echo "<div id='previewKunciResult' style='margin-top:20px;padding:10px;background:#f5f5f5;border:1px solid #ddd;display:none;max-width:600px;margin-left:auto;margin-right:auto'>";
  echo "<h3>Preview</h3>";
  echo "<p><b>Jumlah Kunci:</b> <span id='jumlahKunci'>0</span></p>";
  echo "<div id='kunciPreviewList' style='max-height:200px;overflow-y:auto;border:1px solid #ccc;padding:10px;background:#fff;text-align:left'></div>";
  echo "</div>";

  echo "<div id='kunciResult' style='margin-top:20px;padding:10px;display:none'></div>";
  echo "</div>";

  echo "
  <script>
  jQuery('document').ready(function(\$){
    \$('#kunciBatch').on('input paste', function(){
      var data = \$(this).val().trim();
      if (!data) {
        \$('#previewKunciResult').hide();
        return;
      }
      var lines = data.split('\\n');
      var list = [];
      var count = 0;
      for (var i = 0; i < lines.length; i++) {
        var line = lines[i].trim();
        if (!line) continue;
        var cols = line.split('\\t');
        if (cols.length >= 2 && cols[0].trim() !== '') {
          count++;
          var no = cols[0].trim();
          var kunci = cols[1].trim().toUpperCase();
          var bobot = (cols[2] && cols[2].trim() !== '') ? cols[2].trim() : '1';
          list.push('No ' + no + ': <b>' + kunci + '</b> (Bobot: ' + bobot + ')');
        }
      }
      \$('#jumlahKunci').text(count);
      \$('#kunciPreviewList').html('<ul style=\"margin:0;padding-left:20px\">' + list.map(function(item){ return '<li>' + item + '</li>'; }).join('') + '</ul>');
      \$('#previewKunciResult').show();
    });

    \$('#tambahKunciForm').submit(function(e){
      e.preventDefault();
      var kode = \$('#kunciKodeSelect').val();
      if (!kode) {
        alert('Mohon pilih Mapel / Test');
        return;
      }
      var batchKunci = \$('#kunciBatch').val().trim();
      if (!batchKunci) {
        alert('Mohon masukkan data kunci jawaban');
        return;
      }

      var btn = \$('#simpanKunciBtn');
      btn.prop('disabled', true).text('Menyimpan...');
      var endpoint = (typeof ajaxurl !== 'undefined') ? ajaxurl : 'admin-ajax.php';
      \$.ajax({
        url: endpoint,
        type: 'POST',
        data: \$(this).serialize() + '&action=bimasoft_save_kunci',
        success: function(res) {
          \$('#kunciResult').show();
          if (res.trim() === 'OK') {
            \$('#kunciResult').html('<div style=\"padding:10px;background:#d4edda;color:#155724;border:1px solid #c3e6cb\">Kunci Jawaban Berhasil di Simpan</div>');
            \$('#kunciBatch').val('');
            \$('#previewKunciResult').hide();
          } else {
            \$('#kunciResult').html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">' + res + '</div>');
          }
          btn.prop('disabled', false).text('Simpan Kunci');
        },
        error: function(err) {
          \$('#kunciResult').show().html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">GAGAL TERHUBUNG KE SERVER</div>');
          btn.prop('disabled', false).text('Simpan Kunci');
        }
      });
    });
  });
  </script>
  ";
}

add_action('admin_menu', 'bimasoft_database_add_admin_page');
