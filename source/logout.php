<?php 
require 'config.php';

if($_SESSION['login'] == false){
    header("Location:./index.php");
}

if(isset($_POST['logout'])){
  unset($_SESSION['login']);
  header("Location:./index.php");
}

if(isset($_POST['cansel'])){
  header("Location:./management.php");
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ログアウト</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>
  </head>

  <body class="logout">
    <div class="wrap">
      <div class="post_list">
        <div class="post_list_title">
          <h2>ログアウト</h2>
        </div>
      <div class="warning_Text">ログアウトしますか？</div>
        <form action="logout.php" method="post">
          <div class="btn_wrap">
            <input type="submit" name="logout" id="logout" value="ログアウト">
            <input type="submit" name="cansel" id="cansel" value="キャンセル">
          </div>
        </form>
      </div>
    </div>
  </body>
</html>