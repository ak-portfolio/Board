<?php 
unset($_SESSION['message']);
//  ５秒後ホームへ戻る
header("refresh:5;url=index.php");

?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>投稿完了</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>
  </head>

  <body class="complete">
    <div class="wrap">
      <div class="main_form">
        <div class="post_list_title">
          <h2>投稿完了</h2>
        </div>
        <p class="complete_Text">メッセージが<br class="br_sp">投稿されました。</p>
        <div class="icon_box">
          <a href="index.php"><img src="img/complete.png" alt="ホームアイコン"></a>
        </div> 
      </div>
    </div>
  </body>
</html>