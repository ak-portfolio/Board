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
}elseif(!empty($_POST['message_id']) && isset($_POST['delete'])){
  $message_id = (int)htmlspecialchars($_POST['message_id'], ENT_QUOTES);
  
//  データベース接続
  $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  //  接続エラーの確認
  if($mysqli->connect_errno){
    $error_message[] = 'データベースの接続に失敗しました。 エラー番号'.$mysqli->connect_errno.':'
    .$mysqli->connect_error;
  }else{
    $sql = "DELETE FROM nk_a_ippouji01 WHERE id = $message_id";
    $res = $mysqli->query($sql);
  }
  $mysqli->close();

  if($res){
    header("Location:./management.php");
    $_SESSION['success_message'] = '削除が完了されました。' ;
  }
}

?>
<!doctype html>
<html>
  <head>
  <meta charset="UTF-8">
  <title>投稿削除</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="js/main.js"></script>
  </head>

  <body class="delete">
    <div class="wrap">
      <div class="post_list">
        <div class="post_list_title">
          <h2>投稿削除</h2>
        </div>
        <?php if(!empty($error_message)): ?>
        <?php foreach($error_message as $value): ?>
        <div class="w_box">
          <p class="error"><?php echo $value; ?></p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <div class="post_list_box">
          <p><?php if( !empty($message_data['message']) ){ echo $message_data['message']; } ?></p>
          <div class="description">
            <div class="d_box">
              <span><?php if( !empty($message_data['name']) ){ echo $message_data['name']; } ?></span>
              <div class="date">投稿日：<?php echo date('Y年m月d日 H:i', strtotime($message_data['created_at'])); ?></div>
            </div>	
          </div>
        </div>
        <div class="warning_Text">こちらの記事を削除しますか？</div>
        <form action="delete.php" method="post">
          <div class="btn_wrap">
            <input type="submit" name="delete" id="delete" value="削除">
            <input type="submit" name="cansel" id="cansel" value="キャンセル">
            <input type="hidden" name="message_id" value="<?php echo $message_data['id']; ?>">
          </div>
        </form>
      </div>
    </div>
  </body>
</html>