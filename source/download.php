<?php 
require 'config.php';

if(!empty($_GET['limit'])){
  if($_GET['limit'] === "10"){
    $limit = 10;
  }elseif($_GET['limit'] === "30"){
    $limit = 30;
  }elseif($_GET['limit'] === "50"){
    $limit = 50;
  }  
}
if($_SESSION['login'] == true){
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename=メッセージデータ.csv');
  header('Content-Transfer-Encoding: binary');
  
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$mysqli->connect_errno){
    if(!empty($limit)){
      $sql = "SELECT * FROM nk_a_ippouji01
      ORDER BY created_at ASC LIMIT $limit";
    }else{
      $sql = "SELECT * FROM nk_a_ippouji01
      ORDER BY created_at ASC";
    }
    $res = $mysqli->query($sql);
    if($res){
      $message_array = $res->fetch_all(MYSQLI_ASSOC);
    }
    $mysqli->close();
  }
  
//  csvデータを作成
  if(!empty($message_array)){
//  1行目のラベル作成
    $csv_data .= '"ID","表示名","メッセージ","投稿日","最終更新日"'."\n";
    foreach($message_array as $value){
    
//    データを１行ずつcsvファイルに書き込む
      $csv_data .='"'.$value['id'].'","'.$value['name'].'","'.$value['message'].
      '","'.$value['created_at'].'","'.$value['updated_at']."\"\n";
    }
  }
//  ファイルを出力
  echo $csv_data;
}else{
  header("Location:./index.php");
}
return;
?>