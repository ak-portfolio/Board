<?php 

require 'config.php';

if($_SESSION['login'] == false){
    header("Location:./index.php");
}

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($mysqli->connect_errno){
  $error_message[] = 'データベースの接続に失敗しました。 エラー番号'.$mysqli->connect_errno.':'
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
    <title>管理画面</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>
  </head>

  <body class="management">
    <div class="wrap">
      <div class="post_list">
        <div class="post_list_title">
          <h2>管理画面</h2>
          <div class="icon_box">
            <a href="index.php"><img src="img/home.png" alt="ホームアイコン"></a>
          </div>
        </div>
        <a href="logout.php" class="logout_button" value="ログアウト">ログアウト</a>
        <?php if(!empty($error_message)): ?>
        <?php foreach($error_message as $value): ?>
        <div class="w_box">
          <p class="error"><?php echo $value; ?></p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!empty($_SESSION['success_message'])): ?>
        <div class="w_box">
          <p class="success"><?php echo $_SESSION['success_message']; ?></p>
          <?php unset($_SESSION['success_message']); ?>
        </div>
        <?php endif; ?>
        <form class="download" method="get" action="download.php">
          <div class="btn_select">
            <p class="label">全て</p>
            <select class="limit" name="limit">
              <option value="">全て</option>
              <option value="10">10件</option>
              <option value="30">30件</option>
              <option value="50">50件</option>
            </select>
          </div>
          <input class="btn_download" type="submit" name="download" value="投稿データダウンロード">
        </form>
        <?php if(!empty($message_array)): ?>
        <?php foreach($message_array as $value): ?>
        <div class="post_list_box">
          <p><?php echo nl2br($value['message']); ?></p>
          <div class="description">
            <div class="d_box">
              <span><?php echo $value['name']; ?></span>
              <div class="date">投稿日：<?php echo date('Y年m月d日 H:i', strtotime($value['created_at'])); ?></div>
            </div>
            <div class="d_box">
              <?php if(!empty($value['updated_at'])): ?>
              <div class="last_Updated">最終更新日：<?php echo date('Y年m月d日 H:i', strtotime($value['updated_at'])); ?></div>
              <?php endif; ?>
              <a href="edit.php?message_id=<?php echo $value['id']; ?>" class="btn">編集</a>
              <a href="delete.php?message_id=<?php echo $value['id']; ?>" class="btn">削除</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>