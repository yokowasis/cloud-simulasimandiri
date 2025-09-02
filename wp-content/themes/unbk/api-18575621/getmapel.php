<?php
    include ( __DIR__ . "/../indb.php");

    $today = date('Y-m-d');

    if ($opt_allmapel == "1") {
        $v11sql = "SELECT kode,subtest FROM {$table_prefix}bsfsm_options ORDER BY kode ASC";
    } else {
        $v11sql = "SELECT kode,subtest FROM {$table_prefix}bsfsm_options WHERE tanggal = '{$today}' ORDER BY kode ASC";
    }
    $result = $conn->query($v11sql);

    $data = [
        "waktutoken" => $opt_waktutoken,
        "timezone" => $opt_timezone,
        "allmapel" => $opt_allmapel,
        "shownilai" => $opt_shownilai,
        "bolehlogout" => $opt_bolehlogout,
        "bolehdaftar" => $opt_bolehdaftar,
        "autotoken" => $opt_autotoken,
        "autologin" => $opt_autologin,
        "welcome" => $opt_welcome,
        "pesanbanned" => $opt_pesanbanned,
        "minimalsisawaktu" => $opt_minimalsisawaktu,
        "modetimer" => $opt_modetimer,
        "localstorage" => $opt_localstorage,
    ];

    if ($opt_bolehdaftar == "1") {
        $data["html2"] = "<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#myModal'>Daftar</button>";
    } else {
        $data["html2"] = "";
    }

    $html = "";
    $html .= "<span style=\"left: 6px;\" class=\"glyphicon glyphicon-list-alt\" aria-hidden=\"true\"></span>
    <div class=\"dropdown\">
        <input type=\"text\" id=\"mapel\" data-toggle=\"dropdown\" name=\"mapel\" aria-haspopup=\"true\"
            aria-expanded=\"false\" readonly=\"\" value=\"PILIH MAPEL\">
        <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu1\">";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $html .= "<li value='".strtoupper($row['kode'])."'>".strtoupper($row['kode'])."</li>";
        }
    };
    $html .= "</ul></div>";
    
    $data["html"] = $html;
    echo json_encode($data);
