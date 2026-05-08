<?php
/*
    ===============
    Admin Page
    ===============
*/

function bimasoft_database_slug_content()
{

  require_once(__DIR__ . '/bimasoft-sql.php');
  include(__DIR__ . '/indb.php');

  echo ('<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/dt/datatables.min.css"/>');
  echo ('<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/dt/datatables.min.js"></script>');

  $bimasql = new Bimasoft\SQL(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  global $wpdb;
  $tableoptions = $wpdb->prefix . "bsfsm_options";

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "<div id='dataWrapper'>";
  if (isset($opt_backend) && $opt_backend) {
    echo "Loading ...";
  } else {
    echo ($bimasql->render("SELECT * FROM $tableoptions", $tableoptions));
  }
  echo "</div>";
  echo "<input type='button' value='Delete' class='deleteBtn' />";
  echo "</div>";
  echo "
    <script>
        jQuery('document').ready(function($){
            $('.deleteBtn').click(function(){
                $('.rowcheck:checked').each(function(){
                    $(this).closest('tr').find('.rowdelete').click();
                });                
            })
        })
    </script>
    ";


  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "<p><b>TOKEN :</b></p>";
  echo "<div id='token'>";
  require_once(__DIR__ . '/generatetoken.php');
  echo "</div>";
  echo "<div id='token2'>";
  echo "</div>";
  if (isset($opt_backend) && $opt_backend) {
    echo "<div>";
    echo "<a href='#generate' id='gantitoken'>Ganti Token</a> | <a href='#generate' id='logsiswa'>Log Siswa</a>";
    echo "</div>";
  }
  echo "</div>";
  if (isset($opt_backend) && $opt_backend) {
    if ($opt_waktutoken) {
      $timeout = (int)$opt_waktutoken * 60000;
    } else {
      $timeout = 0;
    }
    echo "
        <script>
            jQuery('document').ready(function($){

                if ({$timeout}) {
                    setTimeout(() => {
                        $('#gantitoken').click();
                    }, {$timeout});
                }

                $('#dataWrapper').load('{$opt_backend}wp-content/themes/unbk/api-18575621/getdatabase.php?backend=$opt_backend');
                $('#token').load('{$opt_backend}token');
                $('#token2').html('Interval : {$opt_waktutoken} Menit <br/> Jangan Close Window ini Agar Token Berubah Otomatis');
                $('#gantitoken').click(function(){
                    $('#token').html('Loading..');
                    $('#token').load('{$opt_backend}wp-content/themes/unbk/api-18575621/gantitoken.php');
                })
                $('#logsiswa').click(function(){
                    window.open('{$opt_backend}logSiswa');
                })
            })
        </script>
        ";
  }
}

function bimasoft_database_hasil_slug_content()
{
  //Sub Menu
  require_once(__DIR__ . '/bimasoft-sql.php');
  include(__DIR__ . '/indb.php');

  $mapel = (isset($_GET['mapel'])) ? $_GET['mapel'] : "";

  echo ('<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/dt/datatables.min.css"/>');
  echo ('<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/dt/datatables.min.js"></script>');

  $bimasql = new Bimasoft\SQL(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  global $wpdb;
  $tablehasil = $wpdb->prefix . "bsfsm_hasil";

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "<div id='dataWrapper'>";
  if (isset($opt_backend) && $opt_backend) {
    echo "Loading ...";
  } else {
    echo ($bimasql->render("SELECT indexkey,stamp,starttime FROM $tablehasil", $tablehasil));
  }
  echo "</div>";
  echo "</div>";

  if (isset($opt_backend) && $opt_backend) {
    echo "
        <script>
            jQuery('document').ready(function($){
                $('#dataWrapper').load('{$opt_backend}wp-content/themes/unbk/api-18575621/getdatatestsiswa.php?backend=$opt_backend&mapel=$mapel');
            })
        </script>
        ";
  }

  echo "<div style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "
    <p>Keterangan :</p>
    <p>- Menghapus siswa <b>TIDAK AKAN</b> menghapus jawaban dengan username tersebut. Menghapus siswa, akan mereset waktu, urutan soal, dan siswa akan dianggap belum mengerjakan test</p>
    ";
  echo "</div>";
}

function bimasoft_database_reset_siswa_slug_content()
{
  //Sub Menu
  require_once(__DIR__ . '/bimasoft-sql.php');
  include(__DIR__ . '/indb.php');

  $mapel = (isset($_GET['mapel'])) ? $_GET['mapel'] : "";

  echo ('<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/dt/datatables.min.css"/>');
  echo ('<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/dt/datatables.min.js"></script>');

  $bimasql = new Bimasoft\SQL(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  global $wpdb;
  $tablehasil = $wpdb->prefix . "bsfsm_siswa";

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "<div id='dataWrapper'>";
  if (isset($opt_backend) && $opt_backend) {
    echo "Loading ...";
  } else {
    echo ($bimasql->render("SELECT * FROM $tablehasil", $tablehasil));
  }
  echo "</div>";
  echo "<input type='button' value='Reset Selesai' class='deleteBtn' />";
  echo "<input type='button' value='Reset Login' class='resetBtn' />";
  echo "<input type='button' value='Force Selesai' class='selesaiBtn' />";
  echo "</div>";
  echo "
    <script>
        jQuery('document').ready(function($){
            $('.deleteBtn').click(function(){
                $('.rowcheck:checked').each(function(){
                    $(this).closest('tr').find('td').eq(11).text('null')
                    $(this).closest('tr').find('.rowsave').click();
                });                
            })
            $('.resetBtn').click(function(){
                $('.rowcheck:checked').each(function(){
                    $(this).closest('tr').find('td').eq(11).text('0')
                    $(this).closest('tr').find('.rowsave').click();
                });                
            })
            $('.selesaiBtn').click(function(){
                $('.rowcheck:checked').each(function(){
                    $(this).closest('tr').find('td').eq(11).text('1')
                    $(this).closest('tr').find('.rowsave').click();
                });                
            })
        })
    </script>
    ";


  if (isset($opt_backend) && $opt_backend) {
    echo "
        <script>
            jQuery('document').ready(function($){
                $('#dataWrapper').load('{$opt_backend}wp-content/themes/unbk/api-18575621/getdatasiswa.php?backend=$opt_backend&mapel=$mapel');
            })
        </script>
        ";
  }

  echo "<div style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "
    <p>Status Finish / Reset Login :</p>
    <p>0 : Logout</p>
    <p>1 : Selesai</p>
    <p>2 : Mengerjakan</p>
    ";
  echo "</div>";
}

function bimasoft_database_add_admin_page()
{
  $page_title     = 'Database Test';
  $menu_title     = 'Database Test';
  $menu_slug      = 'bimasoft_database_slug';
  $callback       = 'bimasoft_database_slug_content';
  $icon        = 'dashicons-list-view';
  $position      = 110;

  /*
    2	- Dashboard
    4	- Separator
    5	- Posts
    10	- Media
    15 	- Links
    20	- Pages
    25	- Comments
    59	- Separator
    60	- Appearance
    65  - Plugins
    70	- Users
    75	- Tools
    80	- Settings
    99	- Separator
    */

  //Generate Admin Page
  add_menu_page($page_title, $menu_title, 'manage_options', $menu_slug, $callback, $icon, $position);

  //Generate Admin Sub-Page
  $page_title     = 'Data Siswa';
  $menu_title     = 'Data Siswa';
  $menu_slug      = 'bimasoft_database_reset_siswa_slug';
  $callback       = 'bimasoft_database_reset_siswa_slug_content';
  add_submenu_page('bimasoft_database_slug', $page_title, $menu_title, 'manage_options', $menu_slug, $callback);

  $page_title     = 'Data Test Siswa';
  $menu_title     = 'Data Test Siswa';
  $menu_slug      = 'bimasoft_database_hasil_slug';
  $callback       = 'bimasoft_database_hasil_slug_content';
  add_submenu_page('bimasoft_database_slug', $page_title, $menu_title, 'manage_options', $menu_slug, $callback);

  $page_title     = 'Tambah Siswa';
  $menu_title     = 'Tambah Siswa';
  $menu_slug      = 'bimasoft_database_tambah_siswa_slug';
  $callback       = 'bimasoft_database_tambah_siswa_slug_content';
  add_submenu_page('bimasoft_database_slug', $page_title, $menu_title, 'manage_options', $menu_slug, $callback);
}

function bimasoft_database_tambah_siswa_slug_content()
{
  require_once(__DIR__ . '/bimasoft-sql.php');
  include(__DIR__ . '/indb.php');

  global $wpdb;
  $tableoptions = $wpdb->prefix . "bsfsm_options";

  $today = date('Y-m-d');
  if ($opt_allmapel == "1") {
    $mapel_result = $conn->query("SELECT kode FROM {$tableoptions} ORDER BY kode ASC");
  } else {
    $mapel_result = $conn->query("SELECT kode FROM {$tableoptions} WHERE tanggal = '{$today}' ORDER BY kode ASC");
  }

  echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
  echo "<h2>Tambah Siswa</h2>";

  echo "<form id='tambahSiswaForm'>";
  echo "<table style='width:100%;max-width:600px;margin:0 auto'>";
  echo "<tr><td style='padding:5px;text-align:left'>Mapel:</td><td style='padding:5px'>";
  echo "<select id='mapelSelect' name='mapel' style='width:100%;padding:5px'>";
  echo "<option value=''>-- Pilih Mapel --</option>";
  while ($row = $mapel_result->fetch_assoc()) {
    echo "<option value='" . strtoupper($row['kode']) . "'>" . strtoupper($row['kode']) . "</option>";
  }
  echo "</select>";
  echo "</td></tr>";

  echo "<tr><td style='padding:5px;text-align:left'>Key:</td><td style='padding:5px'>";
  echo "<input type='text' id='examKey' name='key' value='{$opt_excelkey}' style='width:100%;padding:5px' readonly>";
  echo "</td></tr>";

  echo "<tr><td style='padding:5px;text-align:left;vertical-align:top'>Data (Tab Delimited):</td><td style='padding:5px'>";
  echo "<textarea id='siswaData' name='siswaData' rows='10' style='width:100%;padding:5px' placeholder='Paste data siswa dari excel ke sini'></textarea>";
  echo "<small style='color:#666'>Format: NIS | USER | NAMA | PASS | NIK | NIK2 (Nama Sekolah) | SERVER | SESI</small>";
  echo "</td></tr>";

  echo "<tr><td colspan='2' style='padding:10px;text-align:center'>";
  echo "<button type='submit' id='uploadBtn' style='padding:8px 20px'>Upload</button>";
  echo "</td></tr>";
  echo "</table>";
  echo "</form>";

  echo "<div id='previewResult' style='margin-top:20px;padding:10px;background:#f5f5f5;border:1px solid #ddd;display:none'>";
  echo "<h3>Preview</h3>";
  echo "<p><b>Jumlah Siswa:</b> <span id='jumlahSiswa'>0</span></p>";
  echo "<div id='namaList' style='max-height:200px;overflow-y:auto;border:1px solid #ccc;padding:10px;background:#fff'></div>";
  echo "</div>";

  echo "<div id='uploadResult' style='margin-top:20px;padding:10px;display:none'></div>";
  echo "</div>";

  $backend = isset($opt_backend) && $opt_backend
    ? $opt_backend
    : get_stylesheet_directory_uri();

  echo "
    <script>
    jQuery('document').ready(function($){
        $('#siswaData').on('input paste', function(){
            var data = $(this).val().trim();
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
            
            $('#jumlahSiswa').text(count);
            $('#namaList').html('<ul style=\"margin:0;padding-left:20px\">' + namaList.map(function(n){return '<li>'+n+'</li>'}).join('') + '</ul>');
            $('#previewResult').show();
        });
        
        $('#tambahSiswaForm').submit(function(e){
            e.preventDefault();
            
            var mapel = $('#mapelSelect').val();
            if(!mapel) {
                alert('Mohon pilih mapel');
                return;
            }
            
            var data = $('#siswaData').val().trim();
            if(!data) {
                alert('Mohon masukkan data siswa');
                return;
            }
            
            var lines = data.split('\\n');
            var postData = 'first=1&count=' + lines.length + '&mapel-1=' + mapel + '&key=' + $('#examKey').val();
            
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
            
            $('#uploadBtn').prop('disabled',true).text('Mengupload...');
            
            var baseUrl = '$backend';
            $.ajax({
                url: baseUrl + '/api-18575621/uploadsiswa.php',
                type: 'POST',
                data: postData,
                success: function(response) {
                    $('#uploadResult').show();
                    if(response.trim() == 'OK') {
                        $('#uploadResult').html('<div style=\"padding:10px;background:#d4edda;color:#155724;border:1px solid #c3e6cb\">Data Siswa Berhasil di Simpan</div>');
                        $('#siswaData').val('');
                        $('#previewResult').hide();
                    } else if(response.trim() == 'KEY DITOLAK') {
                        $('#uploadResult').html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">KEY DITOLAK</div>');
                    } else {
                        $('#uploadResult').html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">GAGAL TERHUBUNG KE SERVER: ' + response + '</div>');
                    }
                    $('#uploadBtn').prop('disabled',false).text('Upload');
                },
                error: function() {
                    $('#uploadResult').show().html('<div style=\"padding:10px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb\">GAGAL TERHUBUNG KE SERVER</div>');
                    $('#uploadBtn').prop('disabled',false).text('Upload');
                }
            });
        });
    });
    </script>
    ";
}

add_action('admin_menu', 'bimasoft_database_add_admin_page');
