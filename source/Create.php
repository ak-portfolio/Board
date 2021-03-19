<?php

require 'config.php';
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if( $mysqli->connect_errno ) {
	$error_message[] = 'データベースの接続に失敗しました。 エラー番号'.$mysqli->connect_errno.':'
  .$mysqli->connect_error;
}

$mysqli->set_charset('utf8');

// テーブルを作成するSQLを作成
$sql = 'CREATE TABLE nk_a_ippouji01 (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100),
	message TEXT,
	created_at DATETIME,
	updated_at DATETIME
) engine=innodb default charset=utf8';

// SQL実行
$res = $mysqli->query($sql);

$mysqli->close();
?>