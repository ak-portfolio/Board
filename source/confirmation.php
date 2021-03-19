<?php 

require 'config.php';

if(isset($_POST['cansel'])){
  header("Location:./index.php");
}

if(isset($_POST['submit'])){
//      データベースに接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

//      接続エラーの確認
    if($mysqli->connect_errno){
      $error_message[] = '書き込みに失敗しました。 エラー番号'.$mysqli->connect_errno.':'
      .$mysqli->connect_error;
    }else{
//      文字コード設定
      $mysqli->set_charset('utf8');
//      書き込み日時を取得
      $now_date = date("Y-m-d H:i:s");
      
//      表示名のサニタイムズ
      $clean['name'] = htmlspecialchars($_SESSION['name'], ENT_QUOTES);
      $clean['name'] = preg_replace('/\\r\\n|\\n|\\r/', '', $clean['name']);

//      メッセージのサニタイムズ
      $clean['message'] = htmlspecialchars($_SESSION['message'], ENT_QUOTES);
      
//      データを登録するSQL作成
      $sql = "INSERT INTO nk_a_ippouji01(name,message,created_at)VALUES
      ('$clean[name]','$clean[message]','$now_date')";
//      データを登録
      $res = $mysqli->query($sql);
      if($res){
        header("Location:./complete.php");
      }else{
        $error_message[] = '書き込みに失敗しました。';
      }

//      データベースの接続を閉じる
      $mysqli->close();
    }
  }


?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>投稿確認</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>
  </head>

  <body class="confirmation">
    <div class="wrap">
      <div class="main_form">
        <div class="post_list_title">
          <h2>投稿確認</h2>
        </div>
        <?php if(!empty($error_message)): ?>
        <?php foreach($error_message as $value): ?>
        <div class="w_box">
          <p class="error"><?php echo $value; ?></p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <form action="confirmation.php" method="post">
          <div class="box">
            <h3>表示名</h3>
            <div class="name">
              <p><?php echo $_SESSION['name']; ?></p>
            </div>
          </div>
          <div class="box">
            <h3>メッセージ</h3>
            <div class="message">
              <p><?php echo $_SESSION['message']; ?></p>
            </div>
          </div>
          <p class="confirmation_Text">この内容を投稿しますか？</p>
          <div class="btn_wrap">
            <input type="submit" name="submit" id="submit" value="投稿">
            <input type="submit" name="cansel" id="cansel" value="キャンセル">
          </div>
        </form>
      </div>
    </div>
  </body>
</html>