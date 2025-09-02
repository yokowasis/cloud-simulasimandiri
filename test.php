<?php
$stored_hash = "$P$BbyRosHdtPSjMF3hjICOldWSMXirp8.";
$entered_password = 'nihlah2010';

if (password_verify($entered_password, $stored_hash)) {
  echo "Password is valid!";
} else {
  echo "Invalid password!";
}
