<?php
try{
	$dbh = new PDO('mysql:host=mysql720.db.sakura.ne.jp;dbname=greatspirit_student;charset=utf8','greatspirit','DTU6jRSy');
	

	$sql = 'CREATE TABLE nk_a_ippouji02(
	password varchar(100) NOT NULL
	)engine=innodb default charset=utf8mb4';
	$res = $dbh->query($sql);
}catch (PDOException $e){
	exit($e->getMessage());
}
$dbh = null;
?>