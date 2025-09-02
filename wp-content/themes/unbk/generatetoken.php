<?php 
    require_once(__DIR__.'/bimadb.php');
    
    function RandomString()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 6; $i++) {
            $randstring = $randstring.$characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

    global $wpdb;
    $v11sql = "SELECT * FROM `{$wpdb->prefix}bsfsm_aktif`";

    $rows = $wpdb->get_results($v11sql);
    
    foreach ( $rows as $row ) 
    {
        $tokentime = $row->tokentime;
        $token = $row->token;
    }

    $token_updated = date("Y-m-d H:i",time());

    $to_time = strtotime($token_updated);
    $from_time = strtotime($tokentime);
    $minutes = round(abs($to_time - $from_time) / 60,2);

    if ($minutes>$opt_waktutoken) {
        $token = RandomString();

        global $wpdb;
        $v11sql = "DELETE FROM `{$wpdb->prefix}bsfsm_aktif`";
        $rows = $wpdb->get_results($v11sql);

        $v11sql = 
        "INSERT INTO `{$wpdb->prefix}bsfsm_aktif` 
            (`id`, `mapel`, `token`, `tokentime`, `sesi`) 
            VALUES 
            (0, 'MAPEL', '$token', '$token_updated', 0);
        ";
        $rows = $wpdb->get_results($v11sql);

        $token_updated = date("d-m-Y H:i",time());
        echo $token . ' - Updated : '. $token_updated .' - Interval : '.$opt_waktutoken.' menit';
    } else {
        echo $token . ' - Updated : '. date("d-m-Y H:i",strtotime($tokentime)) .' - Interval : '.$opt_waktutoken.' menit';
    }
