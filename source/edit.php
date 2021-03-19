<?php

require 'config.php';

if($_SESSION['login'] == false){
    header("Location:./index.php");
}

if(isset($_POST['cansel'])){
  header("Location:./management.php");
}


if(!empty($_GET['message_id']) && empty($_POST['message_id'])){
  $message_id = (int)htmlspecialchars($_GET['message_id'], ENT_QUOTES);
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if($mysqli->connect_errno){
    $error_message[] = 'データベースの接続に失敗しました。 エラー番号'.$mysqli->connect_errno.':'
    .$mysqli->connect_error;
  }else{
  $sql = "SELECT * FROM nk_a_ippouji01
  WHERE id = $message_id";
  $res = $mysqli->query($sql);
  if($res){
    $message_data = $res->fetch_assoc();
  }else{
    header("Location:./management.php");
  }
  $mysqli->close();
  }
}elseif(!empty($_POST['message_id'])){
  $message_id = (int)htmlspecialchars($_POST['message_id'], ENT_QUOTES);
  
  if(!empty($_POST['name']) && !empty($_POST['message'])){
    $message_data['name'] = htmlspecialchars($_POST['name'], ENT_QUOTES);
    $message_data['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);
  }
  
  if(empty($_POST['name'])){
    $error_message[] = '表示名を入力してください。';
  }
  if(empty($_POST['message'])){
    $error_message[] = 'メッセージを入力してください。';
  }
  
  if(empty($error_message) && isset($_POST['update'])){
    //  データベース接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    //  接続エラーの確認
    if($mysqli->connect_errno){
      $error_message[] = 'データベースの接続に失敗しました。 エラー番号'.$mysqli->connect_errno.':'
      .$mysqli->connect_error;
    }else{
      $now_date = date("Y-m-d H:i:s");
      $sql = "UPDATE nk_a_ippouji01 set name = '$message_data[name]',
      message = '$message_data[message]', updated_at = '$now_date' WHERE id = $message_id";
      $res = $mysqli->query($sql);
    }
    $mysqli->close();

    if($res){
      header("Location:./management.php");
      $_SESSION['success_message'] = '編集が更新されました。' ;
    }
  }
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>投稿編集</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>
  </head>

  <body class="edit">
    <div class="wrap">
      <div class="main_form">
        <div class="post_list_title">
          <h2>投稿編集</h2>
        </div>
        <?php if(!empty($error_message)): ?>
        <?php foreach($error_message as $value): ?>
        <div class="w_box">
          <p class="error"><?php echo $value; ?></p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      <form action="edit.php" method="post">
        <div class="box">
          <label for="name">表示名</label>
          <input id="name" type="text" name="name" value="<?php if(!empty($message_data['name'])){
            echo $message_data['name']; 
            } ?>">
        </div>
        <div class="box">
          <label for="message">メッセージ</label>
          <textarea id="message" name="message" cols="30" rows="10"><?php if(!empty($message_data['message'])){
          echo $message_data['message'];
          }?>
          </textarea>
        </div>
        <div class="btn_wrap">
          <input type="submit" name="update" id="update" value="更新">
          <input type="submit" name="cansel" id="cansel" value="キャンセル">
          <input type="hidden" name="message_id" value="<?php echo $message_data['id']; ?>">
        </div>
      </form>
      </div>
    </div>
  </body>
</html>