<?php
if (strpos($_SERVER['SERVER_NAME'], 'localhost') !== false) {
    $host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'koocam';
} elseif (strpos($_SERVER['SERVER_NAME'], 'demo.arkinfotec.in') !== false) {
    $host = 'localhost';
    $db_user = 'rajencba_koocam';
    $db_pass = 'N=W+.vs=7}+F';
    $db_name = 'rajencba_koocam';
}
return array(
    'connectionString' => "mysql:host=$host;dbname=$db_name",
    'emulatePrepare' => true,
    'username' => $db_user,
    'password' => $db_pass,
    'charset' => 'utf8',
    'tablePrefix' => 'koo_',
);