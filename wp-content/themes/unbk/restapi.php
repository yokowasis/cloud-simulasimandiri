<?php

/**
 * 
 *  SINKRONISAI API - GET
 * 
 */

function serverchecklogin($idserver, $pass)
{
  global $wpdb;
  $table_prefix = $wpdb->prefix;

  $v11sql =
    "SELECT *
        FROM `{$table_prefix}bsfsm_server`
        WHERE id_server = %s
            AND pass_server = %s
        ";
  try {
    $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($idserver, $pass)));
  } catch (\Throwable $th) {
    return 0;
  }

  if (count($rows)) {
    return count($rows);
  } else {
    return 0;
  }
}

// http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-login/P2302020/123123
add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-login/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'GET',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
          "res" => "Login Berhasil"
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

// Request URL: https://cbt.natsg.bimasoft.web.id/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-forceselesai/SERVER-A/SIMULASI%20AKM%202021/1/null
add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-forceselesai/(?P<idserver>.+)/(?P<mapel>.+)/(?P<username>.+)/(?P<password>.+)', array(
    'methods'  => 'GET',
    'callback' => function ($request) {

      $server = $request['idserver'];
      $test = $request['mapel'];
      $test = str_replace("%20", " ", $test);
      $userid = $request['username'];

      global $wpdb;

      $updated = $wpdb->update(
        $wpdb->prefix . 'bsfsm_siswa',
        array(
          'finish' => 1,  // string
        ),
        array(
          'server' => $server,
          'mapel' => $test,
          'kode' => $userid
        )
      );

      if ($updated) {
        $res["status"] = "OK";
      } else {
        $lastquery = $wpdb->last_query;
        $res["status"] = "FAILED";
        $res["sql"] = $lastquery;
      }
      return $res;
    }
  ));
});

// http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getsiswa/P2302020/123123
// ID SERVER JANGAN PAKE SPASI
add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getsiswa/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'GET',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        // Tarik Siswa
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_siswa`
                    WHERE `server` = %s 
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($idserver)));

        $res["res"]["rows"] = $rows;

        // Tarik Mapel Terdaftar
        $v11sql =
          "SELECT `mapel` 
                    FROM `{$table_prefix}bsfsm_siswa`
                    WHERE `server` = %s 
                    GROUP BY `mapel`
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($idserver)));

        $res["res"]["mapel"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getoptions/P2302020/123123
 *      mapels[] = "BAHASA INDONESIA"
 *      mapels[] = "BAHASA INGGRIS"
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getoptions/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      $mapels = $request['mapels'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        $s = array();
        foreach ($mapels as $key => $value) {
          $s[] = "%s";
        }

        // Tarik options
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_options`
                    WHERE `kode` IN (" . implode(",", $s) . ")
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, $mapels));
        $lastquery = $wpdb->last_query;

        $res["res"]["rows"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getlocking/P2302020/123123
 *      idmapels[] = "2"
 *      idmapels[] = "3"
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getlocking/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      $idmapels = $request['idmapels'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        $s = array();
        foreach ($idmapels as $key => $value) {
          $s[] = "%s";
        }

        // Tarik
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_locking`
                    WHERE `kode` IN (" . implode(",", $s) . ")
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, $idmapels));
        $lastquery = $wpdb->last_query;

        $res["res"]["rows"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});


/**
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getkuncipg/P2302020/123123
 *      idmapels[] = "2"
 *      idmapels[] = "3"
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getkuncipg/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      $idmapels = $request['idmapels'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        $s = array();
        foreach ($idmapels as $key => $value) {
          $s[] = "%s";
        }

        // Tarik
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_kuncipg`
                    WHERE `kode` IN (" . implode(",", $s) . ")
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, $idmapels));
        $lastquery = $wpdb->last_query;

        $res["res"]["rows"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getkunciessay/P2302020/123123
 *      idmapels[] = "2"
 *      idmapels[] = "3"
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getkunciessay/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      $idmapels = $request['idmapels'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        $s = array();
        foreach ($idmapels as $key => $value) {
          $s[] = "%s";
        }

        // Tarik
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_kunciessay`
                    WHERE `kode` IN (" . implode(",", $s) . ")
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, $idmapels));
        $lastquery = $wpdb->last_query;

        $res["res"]["rows"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getkdsoal/P2302020/123123
 *      idmapels[] = "2"
 *      idmapels[] = "3"
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getkdsoal/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      $idmapels = $request['idmapels'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        $s = array();
        foreach ($idmapels as $key => $value) {
          $s[] = "%s";
        }

        // Tarik
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_kdsoal`
                    WHERE `kode` IN (" . implode(",", $s) . ")
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, $idmapels));
        $lastquery = $wpdb->last_query;

        $res["res"]["rows"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getkd/P2302020/123123
 *      idmapels[] = "2"
 *      idmapels[] = "3"
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getkd/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      $idmapels = $request['idmapels'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        $s = array();
        foreach ($idmapels as $key => $value) {
          $s[] = "%s";
        }

        // Tarik
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_kd`
                    WHERE `kode` IN (" . implode(",", $s) . ")
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, $idmapels));
        $lastquery = $wpdb->last_query;

        $res["res"]["rows"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getgrouping/P2302020/123123
 *      idmapels[] = "2"
 *      idmapels[] = "3"
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getgrouping/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      $idmapels = $request['idmapels'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        $s = array();
        foreach ($idmapels as $key => $value) {
          $s[] = "%s";
        }

        // Tarik
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_grouping`
                    WHERE `kode` IN (" . implode(",", $s) . ")
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, $idmapels));
        $lastquery = $wpdb->last_query;

        $res["res"]["rows"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getbobot/P2302020/123123
 *      idmapels[] = "2"
 *      idmapels[] = "3"
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getbobot/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      $idmapels = $request['idmapels'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        $s = array();
        foreach ($idmapels as $key => $value) {
          $s[] = "%s";
        }

        // Tarik
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_bobot`
                    WHERE `kode` IN (" . implode(",", $s) . ")
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, $idmapels));
        $lastquery = $wpdb->last_query;

        $res["res"]["rows"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-getaktif/P2302020/123123
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getaktif/(?P<idserver>.+)/(?P<password>.+)', array(
    'methods'  => 'GET',
    'callback' => function ($request) {

      $idserver = $request['idserver'];
      $pass = $request['password'];

      if (serverchecklogin($idserver, $pass)) {
        $res = array(
          "status" => "OK",
        );

        global $wpdb;
        $table_prefix = $wpdb->prefix;

        // Tarik
        $v11sql =
          "SELECT * 
                    FROM `{$table_prefix}bsfsm_aktif`
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, array()));
        $lastquery = $wpdb->last_query;

        $res["res"]["rows"] = $rows;
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});


/**
 * 
 *  SINKRONISAI API - SET
 * 
 */

function servercheckapi($hashedexcelkey)
{

  $excelkey = get_option('excelkey');

  return (md5($excelkey) == $hashedexcelkey);
}

/**
 * 
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-setsiswa/4297f44b13955235245b2497399d7a93/
 *      res = {"rows":[{"i":"1","id":"BARU","kode":"r","nama":"r","pass":"r","nik":"BARU","nik2":"","mapel":"BAHASA INDONESIA","server":"P2302020","sesi":"1"},{"i":"2","id":"BARU","kode":"w","nama":"w","pass":"w","nik":"BARU","nik2":"","mapel":"BAHASA INDONESIA","server":"P2302020","sesi":"1"},{"i":"20","id":"BARU","kode":"q","nama":"q","pass":"q","nik":"BARU","nik2":"","mapel":"PEND","server":"P2302020","sesi":"1"}]}
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-setsiswa/(?P<hashedexcelkey>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $hashedexcelkey = $request['hashedexcelkey'];
      $postrows = json_decode($request['res']);

      if (servercheckapi($hashedexcelkey)) {
        $res = array(
          "status" => "OK",
        );

        //Delete options
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "DELETE FROM `{$table_prefix}bsfsm_siswa`
                    ";
        $wpdb->get_results($wpdb->prepare($v11sql, array()));

        $rows = $postrows->rows;
        $insertedrows = 0;

        foreach ($rows as $row) {
          $arr = array();
          foreach ($row as $key => $value) {
            $arr[$key] = $value;
          }
          $x =
            $wpdb->insert($table_prefix . "bsfsm_siswa", $arr);
          $lastquery = $wpdb->last_query;

          if ($x) {
            $insertedrows++;
          }
        }

        $res = array(
          "status" => "OK",
          "res" => array(
            "insertedrows" => $insertedrows
          )
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});


/**
 * 
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-setoptions/4297f44b13955235245b2497399d7a93/
 *      res = {"rows":[{"id":"1","kode":"BAHASA INDONESIA","nama":"BAHASA INDONESIA","status":"BAHASA INDONESIA","subtest":"BAHASA INDONESIA","tanggal":"2019-10-28","waktu":"17:00","alokasi":"60","shuffle":"1","shuffle2":"1","jumlahsoal":"10","dikerjakan":"10"},{"id":"2","kode":"BAHASA INGGRIS","nama":"BAHASA INDONESIA","status":"BAHASA INDONESIA","subtest":"BAHASA INDONESIA","tanggal":"2019-10-20","waktu":"00:00","alokasi":"60","shuffle":"1","shuffle2":"1","jumlahsoal":"20","dikerjakan":"10"}]}
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-setoptions/(?P<hashedexcelkey>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $hashedexcelkey = $request['hashedexcelkey'];
      $postrows = json_decode($request['res']);

      if (servercheckapi($hashedexcelkey)) {
        $res = array(
          "status" => "OK",
        );

        //Delete options
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "DELETE FROM `{$table_prefix}bsfsm_options`
                    ";
        $wpdb->get_results($wpdb->prepare($v11sql, array()));

        $rows = $postrows->rows;
        $insertedrows = 0;

        foreach ($rows as $row) {
          $arr = array();
          foreach ($row as $key => $value) {
            $arr[$key] = $value;
          }
          $x =
            $wpdb->insert($table_prefix . "bsfsm_options", $arr);
          $lastquery = $wpdb->last_query;

          if ($x) {
            $insertedrows++;
          }
        }

        $res = array(
          "status" => "OK",
          "res" => array(
            "insertedrows" => $insertedrows
          )
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 * 
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-setlocking/4297f44b13955235245b2497399d7a93/
 *      res = {"rows":[{"id":"9","kode":"1","no":"4","locking":"4"},{"id":"10","kode":"1","no":"5","locking":"5"},{"id":"16","kode":"2","no":"1","locking":"1"},{"id":"17","kode":"2","no":"2","locking":"2"},{"id":"18","kode":"2","no":"3","locking":"3"},{"id":"19","kode":"2","no":"4","locking":"4"},{"id":"20","kode":"2","no":"5","locking":"5"}]}
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-setlocking/(?P<hashedexcelkey>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $hashedexcelkey = $request['hashedexcelkey'];
      $postrows = json_decode($request['res']);

      if (servercheckapi($hashedexcelkey)) {
        $res = array(
          "status" => "OK",
        );

        //Delete locking
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "DELETE FROM `{$table_prefix}bsfsm_locking`
                    ";
        $wpdb->get_results($wpdb->prepare($v11sql, array()));

        $rows = $postrows->rows;
        $insertedrows = 0;

        foreach ($rows as $row) {
          $arr = array();
          foreach ($row as $key => $value) {
            $arr[$key] = $value;
          }
          $x =
            $wpdb->insert($table_prefix . "bsfsm_locking", $arr);
          $lastquery = $wpdb->last_query;

          if ($x) {
            $insertedrows++;
          }
        }

        $res = array(
          "status" => "OK",
          "res" => array(
            "insertedrows" => $insertedrows
          )
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 * 
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-setkuncipg/4297f44b13955235245b2497399d7a93/
 *      res = sda
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-setkuncipg/(?P<hashedexcelkey>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $hashedexcelkey = $request['hashedexcelkey'];
      $postrows = json_decode($request['res']);

      if (servercheckapi($hashedexcelkey)) {
        $res = array(
          "status" => "OK",
        );

        //Delete kuncipg
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "DELETE FROM `{$table_prefix}bsfsm_kuncipg`
                    ";
        $wpdb->get_results($wpdb->prepare($v11sql, array()));

        $rows = $postrows->rows;
        $insertedrows = 0;

        foreach ($rows as $row) {
          $arr = array();
          foreach ($row as $key => $value) {
            $arr[$key] = $value;
          }
          $x =
            $wpdb->insert($table_prefix . "bsfsm_kuncipg", $arr);
          $lastquery = $wpdb->last_query;

          if ($x) {
            $insertedrows++;
          }
        }

        $res = array(
          "status" => "OK",
          "res" => array(
            "insertedrows" => $insertedrows
          )
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 * 
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-setkunciessay/4297f44b13955235245b2497399d7a93/
 *      res = sda
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-setkunciessay/(?P<hashedexcelkey>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $hashedexcelkey = $request['hashedexcelkey'];
      $postrows = json_decode($request['res']);

      if (servercheckapi($hashedexcelkey)) {
        $res = array(
          "status" => "OK",
        );

        //Delete kunciessay
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "DELETE FROM `{$table_prefix}bsfsm_kunciessay`
                    ";
        $wpdb->get_results($wpdb->prepare($v11sql, array()));

        $rows = $postrows->rows;
        $insertedrows = 0;

        foreach ($rows as $row) {
          $arr = array();
          foreach ($row as $key => $value) {
            $arr[$key] = $value;
          }
          $x =
            $wpdb->insert($table_prefix . "bsfsm_kunciessay", $arr);
          $lastquery = $wpdb->last_query;

          if ($x) {
            $insertedrows++;
          }
        }

        $res = array(
          "status" => "OK",
          "res" => array(
            "insertedrows" => $insertedrows
          )
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});


/**
 * 
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-setkdsoal/4297f44b13955235245b2497399d7a93/
 *      res = sda
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-setkdsoal/(?P<hashedexcelkey>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $hashedexcelkey = $request['hashedexcelkey'];
      $postrows = json_decode($request['res']);

      if (servercheckapi($hashedexcelkey)) {
        $res = array(
          "status" => "OK",
        );

        //Delete kdsoal
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "DELETE FROM `{$table_prefix}bsfsm_kdsoal`
                    ";
        $wpdb->get_results($wpdb->prepare($v11sql, array()));

        $rows = $postrows->rows;
        $insertedrows = 0;

        foreach ($rows as $row) {
          $arr = array();
          foreach ($row as $key => $value) {
            $arr[$key] = $value;
          }
          $x =
            $wpdb->insert($table_prefix . "bsfsm_kdsoal", $arr);
          $lastquery = $wpdb->last_query;

          if ($x) {
            $insertedrows++;
          }
        }

        $res = array(
          "status" => "OK",
          "res" => array(
            "insertedrows" => $insertedrows
          )
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});


/**
 * 
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-setkd/4297f44b13955235245b2497399d7a93/
 *      res = sda
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-setkd/(?P<hashedexcelkey>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $hashedexcelkey = $request['hashedexcelkey'];
      $postrows = json_decode($request['res']);

      if (servercheckapi($hashedexcelkey)) {
        $res = array(
          "status" => "OK",
        );

        //Delete kd
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "DELETE FROM `{$table_prefix}bsfsm_kd`
                    ";
        $wpdb->get_results($wpdb->prepare($v11sql, array()));

        $rows = $postrows->rows;
        $insertedrows = 0;

        foreach ($rows as $row) {
          $arr = array();
          foreach ($row as $key => $value) {
            $arr[$key] = $value;
          }
          $x =
            $wpdb->insert($table_prefix . "bsfsm_kd", $arr);
          $lastquery = $wpdb->last_query;

          if ($x) {
            $insertedrows++;
          }
        }

        $res = array(
          "status" => "OK",
          "res" => array(
            "insertedrows" => $insertedrows
          )
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 * 
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-setgrouping/4297f44b13955235245b2497399d7a93/
 *      res = sda
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-setgrouping/(?P<hashedexcelkey>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $hashedexcelkey = $request['hashedexcelkey'];
      $postrows = json_decode($request['res']);

      if (servercheckapi($hashedexcelkey)) {
        $res = array(
          "status" => "OK",
        );

        //Delete grouping
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "DELETE FROM `{$table_prefix}bsfsm_grouping`
                    ";
        $wpdb->get_results($wpdb->prepare($v11sql, array()));

        $rows = $postrows->rows;
        $insertedrows = 0;

        foreach ($rows as $row) {
          $arr = array();
          foreach ($row as $key => $value) {
            $arr[$key] = $value;
          }
          $x =
            $wpdb->insert($table_prefix . "bsfsm_grouping", $arr);
          $lastquery = $wpdb->last_query;

          if ($x) {
            $insertedrows++;
          }
        }

        $res = array(
          "status" => "OK",
          "res" => array(
            "insertedrows" => $insertedrows
          )
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 * 
 *      http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-setbobot/4297f44b13955235245b2497399d7a93/
 *      res = sda
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-setbobot/(?P<hashedexcelkey>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $hashedexcelkey = $request['hashedexcelkey'];
      $postrows = json_decode($request['res']);

      if (servercheckapi($hashedexcelkey)) {
        $res = array(
          "status" => "OK",
        );

        //Delete bobot
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "DELETE FROM `{$table_prefix}bsfsm_bobot`
                    ";
        $wpdb->get_results($wpdb->prepare($v11sql, array()));

        $rows = $postrows->rows;
        $insertedrows = 0;

        foreach ($rows as $row) {
          $arr = array();
          foreach ($row as $key => $value) {
            $arr[$key] = $value;
          }
          $x =
            $wpdb->insert($table_prefix . "bsfsm_bobot", $arr);
          $lastquery = $wpdb->last_query;

          if ($x) {
            $insertedrows++;
          }
        }

        $res = array(
          "status" => "OK",
          "res" => array(
            "insertedrows" => $insertedrows
          )
        );
      } else {
        $res = array(
          "status" => "OK",
          "res" => "Login Gagal"
        );
      }

      return $res;
    }
  ));
});

/**
 * 
 *  UPLOAD JAWABAN
 * 
 */

// http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-rethasil/BAHASA INDONESIA/Z
add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-rethasil/(?P<test>.+)/(?P<userid>.+)', array(
    'methods'  => 'GET',
    'callback' => function ($request) {

      $test = urldecode($request['test']);
      $userid = $request['userid'];

      global $wpdb;
      $table_prefix = $wpdb->prefix;
      $v11sql =
        "SELECT *
                FROM `{$table_prefix}bsfsm_hasil`
                WHERE indexkey = %s
                ";
      $rows = $wpdb->get_results($wpdb->prepare($v11sql, array("$test-$userid")));
      $lastquery = $wpdb->last_query;
      $res = array();

      if (count($rows)) {
        $res["status"] = "OK";
      } else {
        $res["status"] = "FAILED";
        $res["sql"] = $lastquery;
        return $res;
      }

      $res["res"] = new stdClass();

      $idhasil = "$test-$userid-%";


      // Pilihan Ganda
      $v11sql =
        "SELECT *
                FROM `{$table_prefix}bsfsm_jawabanpg`
                WHERE indexkey LIKE %s
                ";
      $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($idhasil)));
      $res["res"]->jawabanpg = $rows;

      // Essay
      $v11sql =
        "SELECT *
                FROM `{$table_prefix}bsfsm_jawabanessay`
                WHERE indexkey LIKE %s
                ";
      $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($idhasil)));
      $res["res"]->jawabanessay = $rows;

      return $res;
    }
  ));
});

/**
 * 
 *  TERIMA JAWABAN
 * 
 */

// http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-puthasil/BAHASA INDONESIA/Z
// res = {"hasil":{"id":"3","test":"BAHASA INDONESIA","userid":"Z","nama":"z","stamp":"00:59:48","starttime":"2019-10-20 17:24:05","ordersoal":"8;5;13;24;30;6;23;12;27;15;22;4;7;25;16;20;21;26;14;1;11;18;17;2;3;19;28;10;9;29;BAHASA INDONESIA;z","finish":"1"},"jawabanpg":[{"id":"168","siswa":"3","no":"1","opsi":"B","userid":"","kodemapel":""},{"id":"169","siswa":"3","no":"2","opsi":"D","userid":"","kodemapel":""},{"id":"170","siswa":"3","no":"3","opsi":"C","userid":"","kodemapel":""},{"id":"171","siswa":"3","no":"4","opsi":"C","userid":"","kodemapel":""},{"id":"172","siswa":"3","no":"5","opsi":"B","userid":"","kodemapel":""},{"id":"173","siswa":"3","no":"6","opsi":"B","userid":"","kodemapel":""},{"id":"174","siswa":"3","no":"7","opsi":"A","userid":"","kodemapel":""},{"id":"175","siswa":"3","no":"8","opsi":"B","userid":"","kodemapel":""},{"id":"176","siswa":"3","no":"9","opsi":"B","userid":"","kodemapel":""},{"id":"177","siswa":"3","no":"10","opsi":"C","userid":"","kodemapel":""},{"id":"178","siswa":"3","no":"11","opsi":"C","userid":"","kodemapel":""},{"id":"179","siswa":"3","no":"12","opsi":"A","userid":"","kodemapel":""},{"id":"180","siswa":"3","no":"13","opsi":"A","userid":"","kodemapel":""},{"id":"181","siswa":"3","no":"14","opsi":"D","userid":"","kodemapel":""},{"id":"182","siswa":"3","no":"15","opsi":"D","userid":"","kodemapel":""},{"id":"183","siswa":"3","no":"16","opsi":"A","userid":"","kodemapel":""},{"id":"184","siswa":"3","no":"17","opsi":"A","userid":"","kodemapel":""},{"id":"185","siswa":"3","no":"18","opsi":"D","userid":"","kodemapel":""},{"id":"186","siswa":"3","no":"19","opsi":"D","userid":"","kodemapel":""},{"id":"187","siswa":"3","no":"20","opsi":"B","userid":"","kodemapel":""},{"id":"188","siswa":"3","no":"21","opsi":"A","userid":"","kodemapel":""},{"id":"189","siswa":"3","no":"22","opsi":"B","userid":"","kodemapel":""},{"id":"190","siswa":"3","no":"23","opsi":"A","userid":"","kodemapel":""},{"id":"191","siswa":"3","no":"24","opsi":"D","userid":"","kodemapel":""},{"id":"192","siswa":"3","no":"25","opsi":"D","userid":"","kodemapel":""},{"id":"193","siswa":"3","no":"26","opsi":"C","userid":"","kodemapel":""},{"id":"194","siswa":"3","no":"27","opsi":"C","userid":"","kodemapel":""},{"id":"195","siswa":"3","no":"28","opsi":"A","userid":"","kodemapel":""},{"id":"196","siswa":"3","no":"29","opsi":"A","userid":"","kodemapel":""},{"id":"197","siswa":"3","no":"30","opsi":"B","userid":"","kodemapel":""}],"jawabanessay":[]}
add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-puthasil/(?P<test>.+)/(?P<userid>.+)', array(
    'methods'  => 'POST',
    'callback' => function ($request) {

      $test = urldecode($request['test']);
      $userid = $request['userid'];
      $kiriman = json_decode($request['res']);



      global $wpdb;
      $table_prefix = $wpdb->prefix;
      $v11sql =
        "DELETE
                FROM `{$table_prefix}bsfsm_hasil`
                WHERE test = %s 
                    AND userid = %s
                ";
      $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($kiriman->hasil->test, $kiriman->hasil->userid)));
      $lastquery = $wpdb->last_query;
      $res = array();

      $x =
        $wpdb->insert(
          'hasil',
          array(
            "test" => $kiriman->hasil->test,
            "userid" => $kiriman->hasil->userid,
            "nama" => $kiriman->hasil->nama,
            "stamp" => $kiriman->hasil->stamp,
            "starttime" => $kiriman->hasil->starttime,
            "ordersoal" => $kiriman->hasil->ordersoal,
            "finish" => $kiriman->hasil->finish,
          )
        );
      if (!$x) {
        $res["status"] = "FAILED";
        $res["res"] = "Gagal Menambahkan Hasil";
        $res["res"] = $wpdb->last_query;
        return $res;
      }
      $insert_id = $wpdb->insert_id;

      foreach ($kiriman->jawabanpg as $row) {
        $x =
          $wpdb->insert(
            'jawabanpg',
            array(
              "siswa" => $insert_id,
              "no" => $row->no,
              "opsi" => $row->opsi,
              "userid" => $kiriman->hasil->userid,
              "kodemapel" => $kiriman->hasil->test,
            )
          );
        if (!$x) {
          $res["status"] = "FAILED";
          $res["res"] = "Gagal Mengirim Jawaban Pilihan Ganda";
          return $res;
        }
      }

      foreach ($kiriman->jawabanessay as $row) {
        $x =
          $wpdb->insert(
            'jawabanessay',
            array(
              "siswa" => $insert_id,
              "no" => $row->no,
              "opsi" => $row->opsi,
              "userid" => $kiriman->hasil->userid,
              "kodemapel" => $kiriman->hasil->test,
            )
          );
        if (!$x) {
          $res["status"] = "FAILED";
          $res["res"] = "Gagal Mengirim Jawaban Essay";
          return $res;
        }
      }

      $res["status"] = "OK";
      $res["res"] = "Success";

      return $res;
    }
  ));
});


/**
 * 
 *  UPLOAD JAWABAN
 * 
 */

// http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/login/mapel/username/password
add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'login/(?P<mapel>.+)/(?P<username>.+)/(?P<password>.+)/(?P<uniqid>.+)', array(
    'methods'  => 'GET',
    'callback' => function ($request) {
      include('./indb.php');
      $mapel = urldecode($request['mapel']);
      $username = urldecode($request['username']);
      $password = urldecode($request['password']);
      $uniqid = urldecode($request['uniqid']);

      global $wpdb, $opt_pesanbanned;
      $v11sql = "SELECT * FROM `{$table_prefix}bsfsm_siswa` WHERE 
                    ( pass = %s OR pass='BANNED' ) AND 
                    mapel = %s AND 
                    kode = %s";
      $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($password, $mapel, $username)));
      $lastquery = $wpdb->last_query;
      $res = array();
      // $res["LQ"] = $lastquery;

      // Ambil Data Siswa
      if (count($rows)) {
        $res["status"] = "OK";
        $res["res"] = new stdClass();
        foreach ($rows as $row) {
          if ($row->pass == 'BANNED') {
            $res['status'] = $opt_pesanbanned;
            return $res;
          } else {
            $res["res"]->siswa = new stdClass();
            $res["res"]->siswa->nis = $row->id;
            $res["res"]->siswa->username = $row->kode;
            $res["res"]->siswa->nama = $row->nama;
            $res["res"]->siswa->ket1 = $row->nik;
            $res["res"]->siswa->ket2 = $row->nik2;
            $res["res"]->siswa->mapel = $row->mapel;
            $res["res"]->siswa->server = $row->server;
            $res["res"]->siswa->sesi = $row->sesi;
          }
        }
      } else {
        $res["status"] = "Login Gagal. Username / Password Salah";
        return $res;
      }

      // Ambil Data Mapel
      global $wpdb;
      $table_prefix = $wpdb->prefix;
      $v11sql =
        "SELECT *
                FROM `{$table_prefix}bsfsm_options`
                WHERE kode = %s 
                ";
      $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($mapel)));

      foreach ($rows as $row) {
        $res["res"]->mapel = new stdClass();
        $res["res"]->mapel->kode = $row->kode;
        $res["res"]->mapel->nama = $row->nama;
        $res["res"]->mapel->status = $row->status;
        $res["res"]->mapel->substest = $row->subtest;
        $res["res"]->mapel->tanggal = $row->tanggal;
        $res["res"]->mapel->waktu = $row->waktu;
        $res["res"]->mapel->alokasi = $row->alokasi;
        $res["res"]->mapel->shuffle = $row->shuffle;
        $res["res"]->mapel->shuffle2 = $row->shuffle2;
        $res["res"]->mapel->jumlahsoal = $row->jumlahsoal;
        $res["res"]->mapel->dikerjakan = $row->dikerjakan;
      }

      // Ambil Data Hasil
      global $wpdb;
      $table_prefix = $wpdb->prefix;
      $v11sql =
        "SELECT *
                FROM `{$table_prefix}bsfsm_hasil`
                WHERE userid = %s 
                    AND test = %s
                ";
      $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($username, $mapel)));

      if (count($rows)) {
        $res["res"]->hasil = new stdClass();
        foreach ($rows as $row) {
          $res["res"]->hasil->id = $row->id;
          $res["res"]->hasil->test = $row->test;
          $res["res"]->hasil->userid = $row->userid;
          $res["res"]->hasil->nama = $row->nama;
          $res["res"]->hasil->stamp = $row->stamp;
          $res["res"]->hasil->starttime = $row->starttime;
          $res["res"]->hasil->ordersoal = $row->ordersoal;
          $res["res"]->hasil->finish = $row->finish;
        }

        // Check Status Login
        switch ($res["res"]->hasil->finish) {
          case "1":
            $res['status'] = "Anda Sudah Selesai Mengerjakan Soal";
            return $res;
            break;

          case "2":
            $res['status'] = "Username Sedang Aktif. Silakan Hubungi Proktor Untuk Melakukan Reset Login";
            return $res;
            break;

          default:
            break;
        }

        // Ambil Jawaban PG
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "SELECT *
                    FROM `{$table_prefix}bsfsm_jawabanpg`
                    WHERE siswa = %s 
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($res["res"]->hasil->id)));

        $res["res"]->hasil->jawaban = array();

        foreach ($rows as $row) {
          $res["res"]->hasil->jawaban[$row->no] = $row->opsi;
        }

        // Ambil Essay
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $v11sql =
          "SELECT *
                    FROM `{$table_prefix}bsfsm_jawabanessay`
                    WHERE siswa = %s 
                    ";
        $rows = $wpdb->get_results($wpdb->prepare($v11sql, array($res["res"]->hasil->id)));

        foreach ($rows as $row) {
          $res["res"]->hasil->jawaban[$row->no] = $row->opsi;
        }
      }

      return $res;
    }
  ));
});

/**
 * 
 *  RESET STATUS PESERTA
 * 
 */

// http://localhost:8888/cloud-simulasimandiri/wp-json/bimasoft-unbk/v1/server-resetstatus/mapel/username
add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-resetstatus/(?P<server>.+)/(?P<test>.+)/(?P<userid>.+)', array(
    'methods'  => 'GET',
    'callback' => function ($request) {

      $test = urldecode($request['test']);
      $server = urldecode($request['server']);
      $userid = $request['userid'];

      global $wpdb;
      $table_prefix = $wpdb->prefix;

      $updated = $wpdb->delete(
        $wpdb->prefix . 'bsfsm_hasil',
        array(
          'indexkey' => "$test-$userid"
        )
      );

      $updated = $wpdb->update(
        $wpdb->prefix . 'bsfsm_siswa',
        array(
          'finish' => null,  // string
        ),
        array(
          'server' => $server,
          'mapel' => $test,
          'kode' => $userid
        )
      );

      if ($updated) {
        $res["status"] = "OK";
      } else {
        $lastquery = $wpdb->last_query;
        $res["status"] = "FAILED";
        $res["sql"] = $lastquery;
      }
      return $res;
    }
  ));
});

/**
 * 
 * REST API - AMBIL SOAL
 * WITH SHORTCODE
 * 
 */

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'server-getsoal/(?P<kode>.+)', array(
    'methods'  => 'GET',
    'callback' => function ($request) {

      $kode = urldecode($request['kode']);

      global $wpdb;
      $table_prefix = $wpdb->prefix;

      $sql =
        "SELECT * FROM `" . $table_prefix . "posts` WHERE 
            `post_status` = 'publish' AND 
            `post_type` = 'post' AND
            `post_title` = '$kode' ORDER BY `post_modified` DESC LIMIT 1";

      $rows = $wpdb->get_results($wpdb->prepare($sql, array()));

      foreach ($rows as $row) {
        $res["id"] = $kode;
        $res["status"] = "OK";
        $soal = $row->post_content;
        $soal = do_shortcode($soal);
        $res["soal"] = $soal;
      }

      if (count($rows)) {
        $res["status"] = "OK";
      } else {
        $lastquery = $wpdb->last_query;
        $res["status"] = "FAILED";
        $res["sql"] = $lastquery;
      }
      return $res;
    }
  ));
});

add_action('rest_api_init', function () {
  register_rest_route('bimasoft-unbk/v1', 'test/(?P<userid>.+)/(?P<password>.+)', array(
    'methods'  => 'GET',
    'callback' => function ($request) {
      global $wpdb;


      $user_login = urldecode($request['userid']);
      $entered_password = urldecode($request['password']);

      $user = $wpdb->get_row($wpdb->prepare("SELECT ID, user_pass FROM $wpdb->users WHERE user_login = %s", $user_login));


      if ($user) {
        // Use wp_check_password to validate
        if (wp_check_password($entered_password, $user->user_pass, $user->ID)) {
          return ["status" => "Password is correct!"];
        } else {
          return ["status" => "Invalid password!"];
        }
      } else {
        return ["status" => "User not found!"];
      }
    }
  ));
});
