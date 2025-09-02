<?php 
    require_once('../bimadb.php');

    function RandomString()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 6; $i++) {
            $randstring = $randstring.$characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

    $v11sql = "SELECT * FROM `{$table_prefix}bsfsm_aktif`";
    $result = $conn->query($v11sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $tokentime = $row['tokentime'];
            $token = $row['token'];
        }
    } else {
    }

    $token_updated = date("Y-m-d H:i",time());

    $to_time = strtotime($token_updated);
    $from_time = strtotime($tokentime);
    $minutes = round(abs($to_time - $from_time) / 60,2);

    if ($minutes>$opt_waktutoken) {
        $token = RandomString();

        $v11sql = "DELETE FROM `{$table_prefix}bsfsm_aktif`";
        $stmt = $conn->prepare($v11sql);
        $stmt->execute();

        $v11sql = 
        "INSERT INTO `{$table_prefix}bsfsm_aktif` 
            (`id`, `mapel`, `token`, `tokentime`, `sesi`) 
            VALUES 
            (NULL, 'MAPEL', '$token', '$token_updated', 0);
        ";
        // echo $v11sql;
        $stmt = $conn->prepare($v11sql);
        $stmt->execute();
        $stmt->close();

        $token_updated = date("d-m-Y H:i",time());
        echo $token . ' - Updated : '. $token_updated .' - Interval : '.$opt_waktutoken.' menit';
    } else {
        echo $token . ' - Updated : '. date("d-m-Y H:i",strtotime($tokentime)) .' - Interval : '.$opt_waktutoken.' menit';
    }
    