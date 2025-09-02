<?php

add_action('init', function () {
  $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
  if (strpos($url_path, 'kumpul---')) {
    $load = locate_template('template-kumpul.php', true);
    if ($load) {
      exit();
    }
  } else
    if (strpos($url_path, 'konfirmasi---')) {
    $load = locate_template('template-konfirmasi.php', true);
    if ($load) {
      exit();
    }
  } else 
    if (strpos($url_path, 'playstore---')) {
    $load = locate_template('template-playstore.php', true);
    if ($load) {
      exit();
    }
  } else 
    if (strpos($url_path, 'soalujian---')) {
    $load = locate_template('template-soal.php', true);
    if ($load) {
      exit();
    }
  } else
    if (strpos($url_path, 'ceknilai---')) {
    $load = locate_template('template-ceknilai.php', true);
    if ($load) {
      exit();
    }
  }
});
