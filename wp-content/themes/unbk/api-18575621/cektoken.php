<?php
require_once ('../bimadb.php');
global $conn, $opt_waktutoken, $opt_autotoken, $table_prefix;

if (isset($_POST['token_check'])) {
  $submitted_token = trim($_POST['token_check']);

  // 1. Handle Proctor/System "AUTO" bypass (if applicable)
  if ($submitted_token === 'AUTO' && isset($opt_autotoken) && $opt_autotoken == '1') {
    echo 'valid';
    exit;
  }

  // 2. Fetch the current active exam token from the database
  // IMPORTANT: If you have multiple exams, add: WHERE exam_id = ?
  $stmt = $conn->prepare("SELECT `token`, `tokentime` FROM `{$table_prefix}bsfsm_aktif` LIMIT 1");
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();

  // If no token has been set by the proctor yet
  if (!$row) {
    echo 'invalid';
    exit;
  }

  $db_token = $row['token'];
  $db_tokentime = $row['tokentime'];

  // 3. Check if the student's token matches the proctor's token
  if ($submitted_token !== $db_token) {
    echo 'invalid';  // Wrong password
    exit;
  }

  // 4. Token matches! Now check if it has expired
  $current_time = time();
  $token_time = strtotime($db_tokentime);

  if ($token_time === false) {
    echo 'invalid';  // Corrupted time in database
    exit;
  }

  $minutes_elapsed = round(abs($current_time - $token_time) / 60, 2);

  if ($minutes_elapsed > $opt_waktutoken) {
    echo 'expired';  // Correct password, but time is up
    exit;
  }

  // 5. Token matches and is within the allowed time
  echo 'valid';
}
?>
