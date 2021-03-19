<?php 

require 'config.php';

if($_SESSION['login'] == true){
    header("Location:./management.php");
}
if(isset($_POST['login'])){
  if(empty($_POST['password'])){
    $error_message[] = 'パスワードが未入力です。';
  }
  
  if(!empty($_POST['password'])){
    $password = $_POST['password'];
//      データベースに接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

//      接続エラーの確認
    if($mysqli->connect_errno){
      $error_message[] = 'ログインに失敗しました。 エラー番号'.$mysqli->connect_errno.':'
      .$mysqli->connect_error;
    }else{
//      文字コード設定
      $mysqli->set_charset('utf8');

//      データを登録するSQL作成
      $sql = "SELECT * FROM nk_a_ippouji02 WHERE password = BINARY ?";
      $stmt = $mysqli->prepare($sql);
        
//      データを登録
      $stmt->bind_param('s', $password);
      $stmt->execute();
      if($row = $stmt->fetch()){
        $_SESSION['login'] = true;
        header("Location:./management.php");
      }else{
        $error_message[] = 'パスワードに誤りがあります。';
      }

//      データベースの接続を閉じる
      $mysqli->close();
    }
  }
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>
  </head>

  <body class="login">
    <div class="wrap">
      <div class="main_form">
        <div class="post_list_title">
          <h2>ログイン</h2>
          <div class="icon_box">
            <a href="index.php"><img src="img/home.png" alt="歯車アイコン"></a>
          </div>
        </div>
        <?php if(!empty($error_message)): ?>
        <?php foreach($error_message as $value): ?>
        <div class="w_box">
          <p class="error"><?php echo $value; ?></p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <form action="login.php" method="post">
          <div class="box">
            <label for="pass">管理者用パスワード</label>
            <input id="pass" type="password" name="password" value="">
          </div>
          <input type="submit" name="login" id="login" value="ログイン">
        </form>
      </div>
    </div>
  </body>
</html>