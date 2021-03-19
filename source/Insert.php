<?php
try{
	$dbh = new PDO('mysql:host=mysql720.db.sakura.ne.jp;dbname=greatspirit_student;charset=utf8','greatspirit','DTU6jRSy');
	

	$sql = 'INSERT INTO nk_a_ippouji01 (name,message,created_at) VALUES
	("a","bb","2020-12-17 13:34:26");';
	$res = $dbh->query($sql);
}catch (PDOException $e){
	exit($e->getMessage());
}
$dbh = null;
?>