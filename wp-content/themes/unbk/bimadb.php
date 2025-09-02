<?php
	if (!(pathinfo(__FILE__, PATHINFO_FILENAME) == 'bimadb')) {
		exit;
	};
	function checkkey() {
		global $opt_excelkey;
		if (isset($_REQUEST['key'])) {
			if ($opt_excelkey == $_REQUEST['key']) {
				return true;
			} else {
				echo "KEY DITOLAK";
				exit;
			}	    		
		} else {
				echo "KEY IS MISSING";
				exit;
		}
	}

	if (file_exists(__DIR__ . '/indb.php')) {
		include('indb.php');
	}
	
	function save_log($s){
		global $conn;
		global $wpdb;
		$v11sql = "INSERT INTO `{$wpdb->prefix}bsfsm_log` (`val`) VALUES ('$s')";
		$result = $conn->query($v11sql);		
	}

	function url_origin( $s, $use_forwarded_host = false )

	{
	    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
	    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
		$protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
		if (isset($s['HTTPS'])) {
			$protocol = ($s['HTTPS']=='on') ? "https" : "http" ;
		} else {
			$protocol = "http";
		}
	    $port     = $s['SERVER_PORT'];
	    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
	    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
	    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
	    return $protocol . '://' . $host;
	}

	function full_url( $s, $use_forwarded_host = false )
	{
	    return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
	}
	$absolute_url = full_url( $_SERVER );