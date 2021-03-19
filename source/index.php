<?php 

require 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['confirm'])){
    if(!empty($_POST['name']) && !empty($_POST['message'])){
      //    セッション初期化
      $_SESSION = array();
  //    POSTをセッションに保存
      $_SESSION['name'] = $_POST['name'];
      $_SESSION['message'] = $_POST['message'];
      header("Location:./confirmation.php");
    }
    if(empty($_POST['name'])){
      $error_message[] = '表示名を入力してください。';
    }
    if(empty($_POST['message'])){
      $error_message[] = 'メッセージを入力してください。';
    }
  }
}
//  データベース接続
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

//  接続エラーの確認
if($mysqli->connect_errno){
  $error_message[] = '書き込みに失敗しました。 エラー番号'.$mysqli->connect_errno.':'
  .$mysqli->connect_error;
}else{
  $sql = "SELECT * FROM nk_a_ippouji01
  ORDER BY created_at DESC";
  $res = $mysqli->query($sql);
  if($res){
    $message_array = $res->fetch_all(MYSQLI_ASSOC);
  }
  $mysqli->close();
}

?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>簡易掲示板</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>
  </head>

  <body class="index">
    <div class="wrap">
      <div class="main_form">
        <h1><img src="img/board_text.png" alt="ロゴ"></h1>
        <?php if(!empty($error_message)): ?>
        <?php foreach($error_message as $value): ?>
        <div class="w_box">
          <p class="error"><?php echo $value; ?></p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <form action="index.php" method="post">
          <div class="box">
            <label for="name">表示名</label>
            <input id="name" type="text" name="name" value="<?php if(!empty($_SESSION['name'])){
            echo $_SESSION['name'];} ?>" >
          </div>
          <div class="box">
            <label for="message">メッセージ</label>
            <textarea id="message" name="message" cols="30" rows="10" ><?php if(!empty($_SESSION['message'])){
            echo $_SESSION['message'];} ?></textarea>
          </div>
          <input type="submit" name="confirm" id="confirm" value="投稿確認">
        </form>
      </div>
      <div class="post_list">
        <div class="post_list_title">
          <h2>投稿一覧</h2>
          <div class="icon_box">
            <a href="login.php"><img src="img/management.png" alt="歯車アイコン"></a>
          </div>
        </div>
        <?php if(!empty($message_array)): ?>
        <?php foreach($message_array as $value): ?>
        <div class="post_list_box">
          <p><?php echo nl2br($value['message']); ?></p>
          <div class="description">
            <div class="d_box">
              <span><?php echo $value['name']; ?></span>
              <div class="date">投稿日：<?php echo date('Y年m月d日 H:i', strtotime($value['created_at'])); ?></div>
            </div>              
            <?php if(!empty($value['updated_at'])): ?>
            <div class="d_box">
              <div class="last_Updated">最終更新日：<?php echo date('Y年m月d日 H:i', strtotime($value['updated_at'])); ; ?></div>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>