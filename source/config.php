<?php 

//データベース
define('DB_HOST', 'mysql720.db.sakura.ne.jp');
define('DB_USER', 'greatspirit');
define('DB_PASS', 'DTU6jRSy');
define('DB_NAME', 'greatspirit_student');

//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

//変数の初期化
$now_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$password = null;
$csv_data = null;
$sql = null;
$res= null;
$limit = null;
$message_id = null;
$mysqli = null;

$message = array();
$message_array = array();
$error_message = array();
$clean = array();
$message_data = array();
$success_message = array();

session_start();

?>