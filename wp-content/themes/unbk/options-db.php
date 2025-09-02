<?php
/*
    ===============
    Admin Page
    ===============
*/

function bimasoft_database_slug_content(){

    require_once(__DIR__.'/bimasoft-sql.php');
    include(__DIR__.'/indb.php');

    echo ('<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/dt/datatables.min.css"/>');
    echo ('<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/dt/datatables.min.js"></script>');

    $bimasql = new Bimasoft\SQL(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    global $wpdb;
    $tableoptions = $wpdb->prefix . "bsfsm_options";

    echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
    echo "<div id='dataWrapper'>";
    if (isset($opt_backend) && $opt_backend) {
        echo "Loading ...";
    } else {
        echo ($bimasql->render("SELECT * FROM $tableoptions",$tableoptions));
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
    require_once (__DIR__.'/generatetoken.php');
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

function bimasoft_database_hasil_slug_content(){
    //Sub Menu
    require_once(__DIR__.'/bimasoft-sql.php');
    include(__DIR__.'/indb.php');

    $mapel = (isset($_GET['mapel'])) ? $_GET['mapel'] : "" ;

    echo ('<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/dt/datatables.min.css"/>');
    echo ('<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/dt/datatables.min.js"></script>');

    $bimasql = new Bimasoft\SQL(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    global $wpdb;
    $tablehasil = $wpdb->prefix . "bsfsm_hasil";

    echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
    echo "<div id='dataWrapper'>";
    if (isset($opt_backend) && $opt_backend) {
        echo "Loading ...";
    } else {
        echo ($bimasql->render("SELECT indexkey,stamp,starttime FROM $tablehasil",$tablehasil));
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

function bimasoft_database_reset_siswa_slug_content(){
    //Sub Menu
    require_once(__DIR__.'/bimasoft-sql.php');
    include(__DIR__.'/indb.php');

    $mapel = (isset($_GET['mapel'])) ? $_GET['mapel'] : "" ;

    echo ('<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/dt/datatables.min.css"/>');
    echo ('<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/dt/datatables.min.js"></script>');

    $bimasql = new Bimasoft\SQL(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    global $wpdb;
    $tablehasil = $wpdb->prefix . "bsfsm_siswa";

    echo "<div align='center' style='border: solid 1px #5b9dd9;margin:10px; padding:10px;background:#fff'>";
    echo "<div id='dataWrapper'>";
    if (isset($opt_backend) && $opt_backend) {
        echo "Loading ...";
    } else {
        echo ($bimasql->render("SELECT * FROM $tablehasil",$tablehasil));
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

function bimasoft_database_add_admin_page(){
    $page_title 		= 'Database Test';
    $menu_title 		= 'Database Test';
    $menu_slug			= 'bimasoft_database_slug';
    $callback 			= 'bimasoft_database_slug_content';
    $icon				= 'dashicons-list-view';
    $position			= 110;

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
    add_menu_page( $page_title, $menu_title, 'manage_options', $menu_slug, $callback, $icon, $position );
    
    //Generate Admin Sub-Page
    $page_title 		= 'Data Siswa';
    $menu_title 		= 'Data Siswa';
    $menu_slug			= 'bimasoft_database_reset_siswa_slug';
    $callback 			= 'bimasoft_database_reset_siswa_slug_content';
    add_submenu_page( 'bimasoft_database_slug', $page_title, $menu_title, 'manage_options', $menu_slug, $callback );

    $page_title 		= 'Data Test Siswa';
    $menu_title 		= 'Data Test Siswa';
    $menu_slug			= 'bimasoft_database_hasil_slug';
    $callback 			= 'bimasoft_database_hasil_slug_content';
    add_submenu_page( 'bimasoft_database_slug', $page_title, $menu_title, 'manage_options', $menu_slug, $callback );

}

add_action( 'admin_menu', 'bimasoft_database_add_admin_page');