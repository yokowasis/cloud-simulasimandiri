<?php

$currentPage = $_SERVER['SCRIPT_NAME'];

function cekversi()
{
  // read file and assign it to variable
  return (file_get_contents(__DIR__ . "/versi.txt"));
  // return 'Bimasoft 13.10.3';    
}

$cekversi = cekversi();

if (strpos($currentPage, 'rpc.php') !== false) {
} else {
  @include(get_stylesheet_directory() .  '/lisensi.php');
}

/*
 * example usage: $results = reset_role_WPSE_82378( 'subscriber' );
 * per add_role() (WordPress Codex), $results "Returns a WP_Role object
 * on success, null if that role already exists."
 *
 * possible $role values:
 * 'administrator'
 * 'editor'
 * 'author'
 * 'contributor'
 * 'subscriber'
 */

show_admin_bar(false);
require_once("cacheoptimized.php");

function reset_role_akrr($role)
{
  $default_roles = array(
    'administrator' => array(
      'switch_themes' => 1,
      'edit_themes' => 1,
      'activate_plugins' => 1,
      'edit_plugins' => 1,
      'edit_users' => 1,
      'edit_files' => 1,
      'manage_options' => 1,
      'manage_options_lisensi' => 1,
      'moderate_comments' => 1,
      'manage_categories' => 1,
      'manage_links' => 1,
      'upload_files' => 1,
      'import' => 1,
      'unfiltered_html' => 1,
      'edit_posts' => 1,
      'edit_others_posts' => 1,
      'edit_published_posts' => 1,
      'publish_posts' => 1,
      'edit_pages' => 1,
      'read' => 1,
      'level_10' => 1,
      'level_9' => 1,
      'level_8' => 1,
      'level_7' => 1,
      'level_6' => 1,
      'level_5' => 1,
      'level_4' => 1,
      'level_3' => 1,
      'level_2' => 1,
      'level_1' => 1,
      'level_0' => 1,
      'edit_others_pages' => 1,
      'edit_published_pages' => 1,
      'publish_pages' => 1,
      'delete_pages' => 1,
      'delete_others_pages' => 1,
      'delete_published_pages' => 1,
      'delete_posts' => 1,
      'delete_others_posts' => 1,
      'delete_published_posts' => 1,
      'delete_private_posts' => 1,
      'edit_private_posts' => 1,
      'read_private_posts' => 1,
      'delete_private_pages' => 1,
      'edit_private_pages' => 1,
      'read_private_pages' => 1,
      'delete_users' => 1,
      'create_users' => 1,
      'unfiltered_upload' => 1,
      'edit_dashboard' => 1,
      'update_plugins' => 1,
      'delete_plugins' => 1,
      'install_plugins' => 1,
      'update_themes' => 1,
      'install_themes' => 1,
      'update_core' => 1,
      'list_users' => 1,
      'remove_users' => 1,
      'add_users' => 1,
      'promote_users' => 1,
      'edit_theme_options' => 1,
      'delete_themes' => 1,
      'export' => 1,
    ),
    'editor' => array(
      'moderate_comments' => 1,
      'manage_categories' => 1,
      'manage_links' => 1,
      'upload_files' => 1,
      'unfiltered_html' => 1,
      'edit_posts' => 1,
      'edit_others_posts' => 1,
      'edit_published_posts' => 1,
      'publish_posts' => 1,
      'edit_pages' => 1,
      'read' => 1,
      'level_7' => 1,
      'level_6' => 1,
      'level_5' => 1,
      'level_4' => 1,
      'level_3' => 1,
      'level_2' => 1,
      'level_1' => 1,
      'level_0' => 1,
      'edit_others_pages' => 1,
      'edit_published_pages' => 1,
      'publish_pages' => 1,
      'delete_pages' => 1,
      'delete_others_pages' => 1,
      'delete_published_pages' => 1,
      'delete_posts' => 1,
      'delete_others_posts' => 1,
      'delete_published_posts' => 1,
      'delete_private_posts' => 1,
      'edit_private_posts' => 1,
      'read_private_posts' => 1,
      'delete_private_pages' => 1,
      'edit_private_pages' => 1,
      'read_private_pages' => 1,
    ),
    'author' => array(
      'upload_files' => 1,
      'edit_posts' => 1,
      'edit_published_posts' => 1,
      'publish_posts' => 1,
      'read' => 1,
      'level_2' => 1,
      'level_1' => 1,
      'level_0' => 1,
      'delete_posts' => 1,
      'delete_published_posts' => 1,
    ),
    'contributor' => array(
      'edit_posts' => 1,
      'read' => 1,
      'level_1' => 1,
      'level_0' => 1,
      'delete_posts' => 1,
    ),
    'subscriber' => array(
      'read' => 1,
      'level_0' => 1,
    ),
    'display_name' => array(
      'administrator' => 'Administrator',
      'editor'        => 'Editor',
      'author'        => 'Author',
      'contributor'   => 'Contributor',
      'subscriber'    => 'Subscriber',
    ),
  );
  $role = strtolower($role);
  remove_role($role);
  return add_role($role, $default_roles['display_name'][$role], $default_roles[$role]);
} // function reset_role_akrr

reset_role_akrr('author');
get_role('author')->add_cap('manage_options');
get_role('author')->add_cap('activate_plugins');
get_role('author')->add_cap('switch_themes');
get_role('author')->add_cap('edit_theme_options');
if (defined('ARIADMINER_CAPABILITY_RUN')) {
  get_role('author')->add_cap(ARIADMINER_CAPABILITY_RUN);
}

function RandomString2()
{
  $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randstring = '';
  for ($i = 0; $i < 6; $i++) {
    $randstring = $randstring . $characters[rand(0, strlen($characters))];
  }
  return $randstring;
}

function ambiltoken()
{
  // check table exists
  global $wpdb;
  $sql  = "SHOW TABLES LIKE '{$wpdb->prefix}bsfsm_aktif'";
  $rows = $wpdb->get_results($wpdb->prepare($sql, array('string', 10)));

  if (count($rows)) {

    global $wpdb;
    $sql = "SELECT * FROM `{$wpdb->prefix}bsfsm_aktif`";
    $rows = $wpdb->get_results($wpdb->prepare($sql, array('string', 10)));

    foreach ($rows as $row) {
      $tokentime = $row->tokentime;
      $token = $row->token;
    }

    $token_updated = date("Y-m-d H:i", time());

    $to_time = strtotime($token_updated);
    $from_time = strtotime($tokentime);
    $minutes = round(abs($to_time - $from_time) / 60, 2);

    if ($minutes > get_option("waktutoken")) {
      $token = RandomString2();

      $sql = "DELETE FROM `{$wpdb->prefix}bsfsm_aktif`";
      $rows = $wpdb->get_results($wpdb->prepare($sql, array('string', 10)));

      $sql =
        "INSERT INTO `{$wpdb->prefix}bsfsm_aktif` 
                (`id`, `mapel`, `token`, `tokentime`, `sesi`) 
                VALUES 
                (0, 'MAPEL', '$token', '$token_updated', 0);
            ";
      $rows = $wpdb->get_results($wpdb->prepare($sql, array('string', 10)));
    }
  } else {
    $token = "";
  }
  return $token;
}

function display_hapusdatabase()
{
?>
  <button style="background: #d9534f; color : #fff;" id="deldb" type="button" class="button">Reset Database</button>
  <!-- <button style="background: #009688; color : #fff;" id="upgradedb" type="button" class="button">Upgrade Database</button> -->

  <script src="<?php echo get_stylesheet_directory_uri() ?>/archives/js/jquery.toast.min.js"></script>
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/archives/css/jquery.toast.min.css">
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#deldb').click(function(event) {
        var txt;
        var r = confirm("Ini akan menghapus semua data, termasuk data test, kode soal, dan pekerjaan siswa. Data yang hilang tidak bisa dikembalikan lagi. Yakin ?");
        if (r == true) {
          $('.loading').show();
          $.post(window.location, {
            deldb: 1,
            pttoken: "<?php echo (ambiltoken()) ?>",
          }, function(x) {
            $('.loading').hide();
            $.toast({
              heading: "Reset Database",
              text: x,
              position: "bottom-center",
              icon: "info",
              loader: true, // Change it to false to disable loader
              loaderBg: "#9EC600" // To change the background
            })
          })
        } else {}
      });

      $('#upgradedb').click(function(event) {
        var txt;
        var r = confirm("Ini akan menghapus data test, kode soal. Data yang hilang tidak bisa dikembalikan lagi. Yakin ?");
        if (r == true) {
          $('.loading').show();
          $.post(window.location, {
            upgradedb: 1
          }, function(x) {
            $('.loading').hide();
            alert('Upgrade Database Selesai');
          })
        } else {}
      });
    });
  </script>

<?php
}

function themename_customize_register($wp_customize)
{
  $wp_customize->add_section(
    'bimas_color_scheme',
    array(
      'title'             =>  'Pengaturan Tampilan',
      'description'       =>  'Pengubahan Warna'
    )
  );
  $wp_customize->add_setting(
    'background_color_header',
    array(
      'default'       =>  '#336799'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'background_color_header',
      array(
        'label'       =>  'Warna Header',
        'section'     =>  'bimas_color_scheme',
        'settings'    =>  'background_color_header'
      )
    )
  );
  $wp_customize->add_setting(
    'background_color_footer',
    array(
      'default'       =>  '#333'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'background_color_footer',
      array(
        'label'       =>  'Warna Background Footer',
        'section'     =>  'bimas_color_scheme',
        'settings'    =>  'background_color_footer'
      )
    )
  );
  $wp_customize->add_setting(
    'text_color_footer',
    array(
      'default'       =>  '#fff'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'text_color_footer',
      array(
        'label'       =>  'Warna Tulisan Footer',
        'section'     =>  'bimas_color_scheme',
        'settings'    =>  'text_color_footer'
      )
    )
  );
  $wp_customize->add_setting(
    'background_color_footer_2',
    array(
      'default'       =>  '#DCDCDC'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'background_color_footer_2',
      array(
        'label'       =>  'Warna Background Footer 2',
        'section'     =>  'bimas_color_scheme',
        'settings'    =>  'background_color_footer_2'
      )
    )
  );
  $wp_customize->add_setting(
    'text_color_footer_2',
    array(
      'default'       =>  '#333'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'text_color_footer_2',
      array(
        'label'       =>  'Warna Text Footer 2',
        'section'     =>  'bimas_color_scheme',
        'settings'    =>  'text_color_footer_2'
      )
    )
  );
  $wp_customize->add_setting(
    'warna_tombol',
    array(
      'default'       =>  '#55A958'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'warna_tombol',
      array(
        'label'       =>  'Warna Tombol Login',
        'section'     =>  'bimas_color_scheme',
        'settings'    =>  'warna_tombol'
      )
    )
  );
  $wp_customize->add_setting(
    'warna_background_0',
    array(
      'default'       =>  '#C9C9C9'
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'warna_background_0',
      array(
        'label'       =>  'Warna Background',
        'section'     =>  'bimas_color_scheme',
        'settings'    =>  'warna_background_0'
      )
    )
  );
  $wp_customize->add_setting(
    'warna_background',
    array()
  );
  $wp_customize->add_control(
    new WP_Customize_Upload_Control(
      $wp_customize,
      'warna_background',
      array(
        'label'       =>  'Background Login',
        'section'     =>  'bimas_color_scheme',
        'settings'    =>  'warna_background'
      )
    )
  );
  $wp_customize->add_setting(
    'warna_background_2',
    array()
  );
  $wp_customize->add_control(
    new WP_Customize_Upload_Control(
      $wp_customize,
      'warna_background_2',
      array(
        'label'       =>  'Background Test',
        'section'     =>  'bimas_color_scheme',
        'settings'    =>  'warna_background_2'
      )
    )
  );
}

function bimasoft_css_customizer()
{
?>
  <style type="text/css">
    #header {
      background-color: <?php echo get_theme_mod('background_color_header') ?>;
    }

    footer {
      background-color: <?php echo get_theme_mod('background_color_footer') ?>;
      color: <?php echo get_theme_mod('text_color_footer') ?>;
    }

    .summary-log {
      background-color: <?php echo get_theme_mod('background_color_footer_2') ?>;
      color: <?php echo get_theme_mod('text_color_footer_2') ?>;
    }

    input[type=submit] {
      background-color: <?php echo get_theme_mod('warna_tombol') ?>;
    }

    body {
      <?php if (get_theme_mod('warna_background') == '') : ?>background: <?php echo get_theme_mod('warna_background_0') ?>;
      <?php else : ?>background: url('<?php echo get_theme_mod('warna_background') ?>');
      <?php endif; ?>
    }

    body.logged-in {
      <?php if (get_theme_mod('warna_background_2') == '') : ?>background: <?php echo get_theme_mod('warna_background_0') ?>;
      <?php else : ?>background: url('<?php echo get_theme_mod('warna_background_2') ?>');
      <?php endif; ?>
    }
  </style>
<?php
}

add_action('wp_head', 'bimasoft_css_customizer');
add_action('customize_register', 'themename_customize_register');

if (isset($_GET['cetak'])) {
  include('cetak.php');
  exit;
}

function execute_multiline_sql($sql)
{
  global $wpdb;
  $sqlParts = array_filter(explode(";", $sql));
  foreach ($sqlParts as $part) {
    $wpdb->query($part);
    if ($wpdb->last_error != '') {
      $error = new WP_Error("dberror", __("Database query error"), $wpdb->last_error);
      $wpdb->query("rollback;");
      return $error;
    }
  }
  return true;
}

function verifikasitoken($token1)
{
  if (!count($_POST) || !isset($_POST['pttoken'])) {
    die("Gagal Terhubung");
  } else {
    global $wpdb;
    $sql  = "SHOW TABLES LIKE '{$wpdb->prefix}bsfsm_aktif'";
    $rows = $wpdb->get_results($wpdb->prepare($sql, array('string', 10)));

    if (count($rows)) {
      global $wpdb;
      $sql = "SELECT token from {$wpdb->prefix}bsfsm_aktif";
      $rows = $wpdb->get_results($wpdb->prepare($sql, array('string', 10)));

      if (count($rows)) {
        foreach ($rows as $row) {
          $token = $row->token;
        }
      } else {
        die("0 results");
      }

      if ($token != $token1) {
        die("Token Tidak Valid. Refresh Browser");
      }
      return (true);
    } else {
      return (true);
    }
  }
}

if (isset($_POST['deldb'])) {
  resetdatabase($_POST['pttoken']);
}

if (isset($_POST['username_login'])) {
  require_once('login_func.php');
}

include('options-db.php');

include('shortcode.php');

include('orangtua.php');

include('restapi.php');

//DISABLE EMOJI ---
/**
 * Disable the emoji's
 */
// function disable_emojis() {
//  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
//  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
//  remove_action( 'wp_print_styles', 'print_emoji_styles' );
//  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
//  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
//  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
//  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
//  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
//  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
// }
// add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce($plugins)
{
  if (is_array($plugins)) {
    return array_diff($plugins, array('wpemoji'));
  } else {
    return array();
  }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
  if ('dns-prefetch' == $relation_type) {
    /** This filter is documented in wp-includes/formatting.php */
    $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

    $urls = array_diff($urls, array($emoji_svg_url));
  }

  return $urls;
}

define('CONCATENATE_SCRIPTS', false);

function delete_files($target)
{
  if (is_dir($target)) {
    $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

    foreach ($files as $file) {
      delete_files($file);
    }

    rmdir($target);
  } elseif (is_file($target)) {
    unlink($target);
  }
}

function bimasoft_reset_cache()
{

  $ch = curl_init();

  $cdnid = get_option("cdn_ID", false);

  if ($cdnid) {
    // error_log ("CDNID = $cdnid");
    #        curl_setopt($ch, CURLOPT_URL,"https://api.cloudflare.com/client/v4/zones/$cdnid/purge_cache");
    curl_setopt($ch, CURLOPT_URL, "https://bunnycdn.com/api/pullzone/$cdnid/purgeCache");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt(
      $ch,
      CURLOPT_POSTFIELDS,
      '{"purge_everything":true}'
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'AccessKey: c3c9066b-a9f1-4858-91f7-f3546e2bc4bef7d71bd0-a7aa-493b-ba9c-795918d9aa3b',
      'X-Auth-Email: yokowasis@gmail.com',
      'X-Auth-Key: 52115cca3a7b3a4ad11462e9b67b9876e88f6',
      'Content-Type: application/json',
      'Accept: application/json'
    ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    global $wpdb;
    $wpdb->insert(
      $wpdb->prefix . "bsfsm_" . 'log',
      array(
        'val' => $server_output
      )
    );

    curl_close($ch);
  }

  delete_files(__DIR__ . '/../../cache');
}

// VERSI 13 ----------------------

// @ioncube.dk cekversi() -> 'Bimasoft 13.10.3'
function getLisensi($variable)
{
  if ($variable == "Tq8p9rMiQ8hpgNxd7EYOABGGUKCrJozAVIZNpUdArLCbsuvrwZ7xOTCW1aNh") {
    $data = requestLisensi();
    $logo = safeDecrypt($data["asdasdasdasd"]);
    $namasekolah = safeDecrypt($data["asdasdasd"]);
    return ([
      "logo" => $logo,
      "namasekolah" => $namasekolah,
    ]);
  }
}


function saveFile($filename, $content)
{
  $myfile = fopen($filename, "w") or die("Unable to open file (0) !");
  if (fwrite($myfile, $content)) {
  } else {
    die("Gagal Menyimpan, error : 102");
  }
}

// @ioncube.dk cekversi() -> 'Bimasoft 13.10.3'
function safeEncrypt(string $message, string $key): string
{

  $simple_string = $message;
  $ciphering = "AES-128-CTR";
  $iv_length = openssl_cipher_iv_length($ciphering);
  $options = 0;
  $encryption_iv = '1234567891011121';
  $encryption_key = $key;

  $encryption = openssl_encrypt(
    $simple_string,
    $ciphering,
    $encryption_key,
    $options,
    $encryption_iv
  );

  return ($encryption);
}

/**
 * Decrypt a message
 * 
 * @param string $encrypted - message encrypted with safeEncrypt()
 * @param string $key - encryption key
 * @return string
 * @throws Exception
 */

// @ioncube.dk cekversi() -> 'Bimasoft 13.10.3'
function safeDecrypt(string $encrypted, string $key = NULL): string
{
  $decryption_iv = '1234567891011121';
  $decryption_key = "GppksforGppks";
  $ciphering = "AES-128-CTR";
  $options = 0;

  $decryption = openssl_decrypt(
    $encrypted,
    $ciphering,
    $decryption_key,
    $options,
    $decryption_iv
  );

  return ($decryption);
}

require_once('admin-pages/pengaturan-test.php');
$user = wp_get_current_user();
if (in_array('administrator', (array) $user->roles)) {
  require_once('admin-pages/halaman-lisensi.php');
}
require_once('admin-pages/bimasoft-online-cdn.php');
require_once('admin-pages/pengaturan-judul.php');

// global $wp_scripts, $wp_styles;

// // CDN
// $wp_styles->base_url = 'https://cbt-my-id.b-cdn.net';
// $wp_scripts->base_url = 'https://cbt-my-id.b-cdn.net';
